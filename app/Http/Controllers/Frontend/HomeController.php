<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LiveAuctionManufacturer;
use App\Models\Manufacture;
use App\Models\Settings;
use App\Models\Type;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use App\Services\ApiClient\ApiClient;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function maintain(){
        return Inertia::render('Home/maintain');
    }
    public function index(Request $request)
    {

        $requestData = $request->all();

        // dd('fffffff');
        $vehicleTypes = Type::where(['status' => 1])->with('media')->get();
        $manufactures = Manufacture::where(['status' => 1])->with('media')->get();

        if($request->brand){
            $models = VehicleModel::where(['manufacture_id' => $request->brand ,'status' => 1 ])->get();
        }else{

            $models = VehicleModel::where(['status' => 1])->get();
        }

        $vehicles = Vehicle::where(['status' => 1]);
        $vehicles = $vehicles->with('media', 'vehicleType', 'manufacture', 'vehicleModel')->get();

        // dd($manufactures);
        return Inertia::render('Home/index', [
            'requestQuery' => $requestData,
            'vehicleTypes' => $vehicleTypes,
            'manufactures' => $manufactures,
            'vehicles' => $vehicles,
            'models' => $models,
          

        ]);    }

    public function getVehicleList(Request $request)
    {
        $query = "SELECT * FROM main WHERE 1=1 ";

        if ($request->search == 'true') {
            if ($request->manufacturer) {
                $query .= "AND marka_name = '" . $request->manufacturer . "' ";
            }

            if ($request->model) {
                $query .= "AND model_name = '" . $request->model . "' ";
            }

            // if ($request->year_to == 0 && $request->year_from != 0) {
            //     $query .= "AND year >= '" . $request->year_from . "' ";
            // } else if ($request->year_from == 0 && $request->year_to != 0) {
            //     $query .= "AND year <= '" . $request->year_to . "' ";
            // } else if ($request->year_from != 0 && $request->year_to != 0) {
            //     $query .= "AND year >= '" . $request->year_from . "' AND year <= '" . $request->year_to . "' ";
            // }

            // if ($request->chassis) {
            //     $query .= "AND kuzov = '" . $request->chassis . "' ";
            // }

            // if ($request->engine) {
            //     $query .= "AND eng_v = '" . $request->engine . "' ";
            // }

            // if ($request->color) {
            //     $query .= "AND COLOR = '" . $request->color . "' ";
            // }

            // if ($request->lot_no) {
            //     $query .= "AND LOT = '" . $request->lot_no . "' ";
            // }

            // if ($request->available_days) {
            //     $query .= "AND AUCTION_DATE LIKE = '%" . $request->available_days . "%' ";
            //     // TODO: filter auctio for multiple available dates
            // }
        }

        $page = $request->page ?? 1;
        $pageOffset = ($page - 1) * 10;

        $query .= ' ORDER BY year DESC LIMIT ' . $pageOffset . ',10';

        $vehiclesList = ApiClient::callAuctionApi($query);

        return $vehiclesList;
    }
}
