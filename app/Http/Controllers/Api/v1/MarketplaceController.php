<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Order;
use App\Models\Howyouse;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class MarketplaceController extends Controller
{
    use ApiResponse;

    public function getProducts(Request $request){
        try{

            $products = Product::with('howyouse')->get();
            return $this -> successResponse($products,"Product list");

        }catch(\Throwable $th){
            Log::error($th);
            return $this -> errorResponse('Something went wrong.Please Try again.', 500);
        }
        
    }

    public function setProducts(Request $request){
        try{
            Log::info($request);
            DB::beginTransaction();
            $order = New Order();

            $order->user_id = $request->user_id;
            $order->product_ids	 = $request->product_ids;
            $order->payment_status	 = $request->payment_status;
            $order->pharmacy_name	 = $request->pharmacy_name;
            $order->status	 = "pending";
            $order->notes		 = $request->address;
            $order->total_price	 = $request->total_price;
            $order->Save();

            DB::commit();
            return $this -> successResponse($order,"successfull");

        }catch(\Throwable $th){
            DB::rollBack();
            Log::error($th);
            return $this -> errorResponse('Something went wrong.Please Try again.', 500);
        }
        
    }

    public function getOrdersByUser(Request $request){
        try{
            $orders = Order::with('prescription')->where('user_id',request()->user()->id)->get();
            return $this -> successResponse($orders,"Orders list");

        }catch(\Throwable $th){
            Log::error($th);
            return $this -> errorResponse('Something went wrong.Please Try again.', 500);
        }
        
    }
}
