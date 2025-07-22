<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
class PharmacyController extends Controller
{
     public function index()
    {
        return Inertia::render('Pharmacy/Index');
    }

    public function getData()
{
    $user= auth()->user();
    //Log::info($user->pharmacy_name);
    if($user->pharmacy_name == null){
       $orders = Order::with(['prescription.patient'])->latest();
    }else{
       $orders = Order::where('pharmacy_name', $user->pharmacy_name)->with(['prescription.patient'])->latest();
    }
   
    return DataTables::of($orders)
        ->addColumn('check', fn($row) => '
            <div class="custom-control custom-checkbox item-check">
                <input type="checkbox" class="form-check-input" id="order-' . $row->id . '" value="' . $row->id . '">
                <label class="form-check-label" for="order-' . $row->id . '"></label>
            </div>
        ')
        ->addColumn('patient', fn($row) => $row->prescription?->patient?->name ?? '—')
        ->addColumn('pharmacy', fn($row) => ucfirst($row->pharmacy_name ?? '—'))
        ->addColumn('status', fn($row) => match ($row->status) {
            'completed' => '<span class="badge bg-success">Completed</span>',
            'cancelled' => '<span class="badge bg-danger">Cancelled</span>',
            default => '<span class="badge bg-warning text-dark">Pending</span>',
        })
        ->addColumn('total', fn($row) => 'Rs. ' . number_format($row->total_price, 2))
        ->addColumn('action', fn($row) => '
            <button class="btn btn-sm btn-outline-primary action_view" data-id="' . $row->id . '">
                <i class="bx bx-show"></i> View
            </button>
        ')
        ->rawColumns(['check', 'status', 'action'])
        ->make(true);
}
public function view($id)
{
    $order = Order::with([
        'prescription.patient',
        'prescription.appointment.doctor',
    ])->findOrFail($id);

    // Fix details decoding
    $details = $order->prescription->details;

    // Convert to array of arrays (e.g., [['product_id' => 1, 'quantity' => 2], ...])
    $parsedDetails = [];

    // Handle non-JSON fallback like: {1,2},{1,2}
    if (is_string($details)) {
        $details = str_replace(['{', '}'], ['[', ']'], $details); // Make it like [1,2],[1,2]
        $details = "[$details]"; // Wrap in full array
        $parsedDetails = json_decode($details, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            $parsedDetails = collect($parsedDetails)->map(function ($pair) {
                return [
                    'product_id' => $pair[0] ?? null,
                    'quantity' => $pair[1] ?? 1,
                ];
            })->filter(fn($item) => $item['product_id'])->values()->toArray();
        } else {
            $parsedDetails = [];
        }
    } elseif (is_array($details)) {
        $parsedDetails = $details;
    } elseif (is_string($details) && json_decode($details, true)) {
        $parsedDetails = json_decode($details, true);
    }

    // Extract product IDs
    $productIds = collect($parsedDetails)->pluck('product_id')->filter()->unique()->toArray();

    // Get product info with quantities
    $productDetails = Product::whereIn('id', $productIds)
        ->get(['id', 'name', 'price'])
        ->map(function ($product) use ($parsedDetails) {
            $qty = collect($parsedDetails)
                ->firstWhere('product_id', $product->id)['quantity'] ?? 1;

            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $qty,
                'total' => $qty * $product->price,
            ];
        })
        ->values()
        ->toArray();

    return Inertia::render('Pharmacy/View', [
        'order' => $order,
        'products' => $productDetails,
    ]);
}

   public function statusUpdate(Request $request, $id){

        $request->validate([
            'status' => 'required',
        ]);

        try {
            $order = Order::findOrFail($id);
            $order->status = $request->status;
            $order->save();

            return redirect()->route('pharmacy.index')->with('success', 'Order status updated successfully.');
        } catch (Exception $e) {
            Log::error($e);
            return back()->withErrors('Failed to update order status.');
        }

   }


}
