<?php

namespace App\Http\Controllers;


use App\Models\Order;
use App\Models\Product;
use App\Models\Howyouse;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\Request;
use App\Models\Prescription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;
class OrderController extends Controller
{
   public function send(Request $request)
{
    $request->validate([
        'prescription_id' => 'required|exists:prescriptions,id',
        'pharmacy_name' => 'required|string|in:pharmacy1,pharmacy2',
    ]);

    $prescription = Prescription::findOrFail($request->prescription_id);
    
    $raw = $prescription->details; // e.g. "{1,2},{1,2}"

    // 1. Convert "{1,2},{1,2}" → [["product_id" => 1, "quantity" => 2], ...]
    $formatted = collect(explode('},{', trim($raw, '{}')))
        ->map(function ($item) {
            [$product_id, $quantity] = explode(',', $item);
            return [
                'product_id' => (int) trim($product_id),
                'quantity' => (int) trim($quantity),
            ];
        });

    // 2. Get total price
    $totalPrice = 0;
    foreach ($formatted as $item) {
        $product = Product::find($item['product_id']);
        if ($product) {
            $totalPrice += $product->price * $item['quantity'];
        }
    }

    Order::create([
        'user_id' => $prescription->patient_id,
        'product_ids' => $prescription->details,
        'payment_status' => 'pending',
        'prescription_id' => $prescription->id,
        'pharmacy_name' => $request->pharmacy_name,
        'status' => 'pending',
        'notes' => null,
        'total_price' => $totalPrice,
    ]);

    return response()->json(['message' => 'Order sent successfully']);
}

}
