<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Howyouse;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;
class ProductController extends Controller
{
    public $pagename = 'Products';

    public function index()
    {
        return Inertia::render('Products/Index');
    }

    public function getData()
{
    $products = Product::all(); // Removed with('howyouse')

    return DataTables::of($products)
        ->addColumn('check', function ($row) {
            return '<div class="custom-control custom-checkbox item-check">
                <input type="checkbox" class="form-check-input" id="' . $row->id . '" value="' . $row->id . '">
                <label class="form-check-label" for="' . $row->id . '"></label>
            </div>';
        })
        ->addColumn('action', function ($row) {
            return '<div class="btn-group">
                <button type="button" class="btn btn-main btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                <div class="dropdown-menu" style="min-width: 10rem;">
                    <a class="dropdown-item action_edit" data-item-id="' . $row->id . '" href="javascript:void(0)"><i class="fas fa-edit mr-2"></i> View / Edit</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger action_delete" data-item-id="' . $row->id . '" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#deleteConfirm"><i class="fas fa-trash mr-2"></i> Delete</a>
                </div>
            </div>';
        })
        ->addColumn('status', function ($row) {
            return $row->stock_count > 0
                ? '<span class="badge bg-success">In Stock</span>'
                : '<span class="badge bg-danger">Out of Stock</span>';
        })
        ->addColumn('image', function ($row) {
            if ($row->photopath) {
                return '<img src="' . asset($row->photopath) . '" height="50"/>';
            }
            return 'No Image';
        })
        ->rawColumns(['check', 'action', 'status', 'image'])
        ->make(true);
}
    public function create()
    {
        return Inertia::render('Products/CreateUpdate');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name' => ['required'],
            'details' => ['nullable'],
            'photopath' => ['nullable',],
            'stock_count' => ['nullable', 'integer'],

            'dosage_instructions' => ['nullable', 'string'],
            'side_effects' => ['nullable', 'string'],
            'precaution' => ['nullable', 'string'],
            'interaction' => ['nullable', 'string'],
            'storage' => ['nullable', 'string'],
            'brand_names' => ['nullable', 'string'],
        ]);

        try {
            DB::beginTransaction();

           
            $product = new Product();
            $product->name = $request->name;
             $product->price = $request->price;
            
            $product->details = $request->details;
            $product->stock_count = $request->stock_count;

            if ($request->hasFile('photopath')) {
    $file      = $request->file('photopath');
    $extension = $file->getClientOriginalExtension();
    $filename  = time() . '.' . $extension;
    $file->move(public_path('uploads/products'), $filename);
    $product->photopath = 'uploads/products/' . $filename;
}
            $product->save();

            $howyouse = new Howyouse();
            $howyouse->product_id = $product->id;
            $howyouse->dosage_instructions = $request->dosage_instructions;
            $howyouse->side_effects = $request->side_effects;
            $howyouse->precaution = $request->precaution;
            $howyouse->interaction = $request->interaction;
            $howyouse->storage = $request->storage;
            $howyouse->brand_names = $request->brand_names;
            $howyouse->save();

            DB::commit();

           
            return redirect()->route('product.index');
        } catch (Exception $ex) {
            DB::rollBack();
           
            return abort(500);
        }
    }

    public function edit($id)
    {
        $product = Product::with('howyouse')->findOrFail($id);
        return Inertia::render('Products/CreateUpdate', ['product' => $product]);
    }

   public function update(Request $request)
{
    $request->validate([
        'id' => ['required', 'exists:products,id'],
        'name' => ['required'],
        'details' => ['nullable'],
        'stock_count' => ['nullable', 'integer'],
        'image' => ['nullable', 'max:2000'],

        'dosage_instructions' => ['nullable', 'string'],
        'side_effects' => ['nullable', 'string'],
        'precaution' => ['nullable', 'string'],
        'interaction' => ['nullable', 'string'],
        'storage' => ['nullable', 'string'],
        'brand_names' => ['nullable', 'string'],
    ]);

    try {
        DB::beginTransaction();

        $product = Product::findOrFail($request->id);

        // Update base fields
        $product->name = $request->name;
        $product->details = $request->details;
        $product->stock_count = $request->stock_count;
         $product->price = $request->price;

        // Handle image upload
                   if ($request->hasFile('photopath')) {
    $file      = $request->file('photopath');
    $extension = $file->getClientOriginalExtension();
    $filename  = time() . '.' . $extension;
    $file->move(public_path('uploads/products'), $filename);
    $product->photopath = 'uploads/products/' . $filename;
}

        $product->save();

        // Handle howyouse
        $howyouse = Howyouse::where('product_id', $product->id)->first();
        if (!$howyouse) {
            $howyouse = new Howyouse(['product_id' => $product->id]);
        }

        $howyouse->dosage_instructions = $request->dosage_instructions;
        $howyouse->side_effects = $request->side_effects;
        $howyouse->precaution = $request->precaution;
        $howyouse->interaction = $request->interaction;
        $howyouse->storage = $request->storage;
        $howyouse->brand_names = $request->brand_names;
        $howyouse->save();

        DB::commit();

        return redirect()->route('product.index');
    } catch (Exception $ex) {
        DB::rollBack();
        return abort(500, $ex->getMessage());
    }
}


    public function destroy(Request $request)
    {
        //dd($request->all());
        try {
            Product::destroy($request->ids);

           
            return redirect()->route('product.index');
        } catch (Exception $ex) {
            DB::rollBack();
           
            return abort(500);
        }
    }

    
}
