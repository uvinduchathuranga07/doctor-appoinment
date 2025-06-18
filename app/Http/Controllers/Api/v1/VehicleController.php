<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Models\Manufacture;
use App\Models\Settings;
use App\Models\Vehicle;
use App\Services\ApiClient\ApiClient;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VehicleController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // $vehicles = Vehicle::where(['status'=>1]);

            // if($request->featured) {
            //     $vehicles= $vehicles->where('featured', $request->featured);
            // }

            // if($request->limit) {
            //     $vehicles= $vehicles->limit($request->limit);
            // }

            // if($request->brand){
    
            //     if(is_array($request->brand)) {
            //         $vehicles = $vehicles->whereIn('manufacture_id',$request->brand);
            //     }else {
            //         $vehicles = $vehicles->where('manufacture_id',$request->brand);
            //     }
            // }
            // if($request->type) {
            //     if(is_array($request->type)) {
            //         $vehicles = $vehicles->whereIn('vehicle_type_id',$request->type);
            //     } else {
            //         $vehicles = $vehicles->where('vehicle_type_id',$request->type);
            //     }
            // }
            // if($request->min_mileage && $request->max_mileage) {
            //     $vehicles = $vehicles->whereBetween('mileage', [$request->min_mileage, $request->max_mileage]);
            // }
            // if($request->year && (!$request->form_year && !$request->to_year)) {
            //     $vehicles = $vehicles->where('year', $request->year);
            // }
            // if($request->form_year && $request->to_year) {
            //     $vehicles = $vehicles->whereBetween('year', [$request->form_year, $request->to_year]);
            // }

            // $vehicles = $vehicles->with('media','vehicleType', 'manufacture', 'vehicleModel')->get();

            // $vehicles = VehicleResource::collection($vehicles);

            $manufactures = json_decode((Settings::where('key', 'manufactures')->first())->value);
            $models = json_decode((Settings::where('key', 'models')->first())->value);
    
            $year_from = (Settings::where('key', 'year_from')->first())->value;
            $year_to = (Settings::where('key', 'year_to')->first())->value;

            $query = "SELECT * FROM main WHERE 1=1 ";

            if (count($manufactures) > 0) {
                foreach ($manufactures as $key => $value) {
                    if ($key == 0) {
                        $query .= "AND marka_name = '" . $value . "' ";
                    } else {
                        $query .= "OR marka_name = '" . $value . "' ";
                    }
                }
            }
    
            if (count($models) > 0) {
                if ($key == 0) {
                    $query .= "AND model_name = '" . $value . "' ";
                } else {
                    $query .= "OR model_name = '" . $value . "' ";
                }
            }
    
            if ($year_from && $year_to) {
                $query .= "AND year >= '" . $year_from . "' AND year <= '" . $year_to . "' ";
            }
    
            $query .= ' ORDER BY year DESC LIMIT 4';
    
            $live_auction_vehicles_list = ApiClient::callAuctionApi($query);

            return $this->successResponse($live_auction_vehicles_list, 'success');
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->errorResponse($th, 500);
        }
    }

    public function details($id) {
        try {
            $vehicle = Vehicle::with('manufacture', 'vehicleModel','vehicleType','exColor','inColor', 'media')->find($id);
            $vehicle = new VehicleResource($vehicle);

            return $this->successResponse($vehicle, 'success');
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->errorResponse($th, 500);
        }
    }
}
