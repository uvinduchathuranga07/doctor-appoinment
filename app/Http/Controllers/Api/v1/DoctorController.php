<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Doctor;
use App\Models\Specialization;
use App\Traits\ApiResponse;

class DoctorController extends Controller
{
    use ApiResponse;

    public function index(Request $request){
       try {
            $specializationId = $request->specialization_id;
            $query = Doctor::with('specialization')->with('schedules');

            Log::alert($specializationId);

            if($specializationId && $specializationId>0){
                $query = $query->where('specialization_id',$specializationId);
            }

            $doctors = $query->get();

            return $this->successResponse($doctors, 'Doctors List');
        }
        catch(\Throwable $th){
            Log::error($th);
            return $this->errorResponse('Something went wrong.Please Try again.', 500);
        }
    }

    public function getSpeciallity(Request $request){
        try{
            $speciallity = Specialization::get();
            return $this->successResponse($speciallity, 'Speciality List');
        }
        catch(\Throwable $th){
            Log::error($th);
            return $this->errorResponse('Something went wrong.Please Try again.', 500);
        }
    }

}
