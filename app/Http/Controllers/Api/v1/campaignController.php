<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Campaign;
use App\Models\JoinEvent;
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

        public function saveCampaigns(Request $request){
        try {
            Log::alert($request);
            DB::beginTransaction();

            $joinEvent = new JoinEvent();
            $joinEvent-> event_id = $request -> event_id;
            $joinEvent-> user_id = $request -> user_id;
            
            $joinEvent->save();
            DB::commit();
            
            $campaings = Campaign::where('id',$request -> event_id)->first();
            return $this->successResponse([$campaings],'Appointment Saved');
        }
        catch(\Throwable $th){
            DB::rollBack();
            Log::error($th);
            return $this->errorResponse('Something went wrong.Please Try again.', 500);
        }
    }
}
