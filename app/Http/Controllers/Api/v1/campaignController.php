<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Campaign;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class campaignController extends Controller
{
    use ApiResponse;
    
    public function getCampaigns(Request $request){
        try{
            $campaings = Campaign::get();
            return $this->successResponse($campaings, 'Campangs List');
        }
        catch(\Throwable $th){
            Log::error($th);
            return $this->errorResponse('Something went wrong.Please Try again.', 500);
        }
    }
}
