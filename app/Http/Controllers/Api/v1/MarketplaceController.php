<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Howyouse;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class MarketplaceController extends Controller
{
    use ApiResponse;

    public function getProducts(Request $request){
        try{

            $products = Products::with('howyouse')->get();
            return $this -> successResponse($products,"Product list");
            
        }catch(\Throwable $th){
            return $this -> errorResponse('Something went wrong.Please Try again.', 500);
        }
        
    }
}
