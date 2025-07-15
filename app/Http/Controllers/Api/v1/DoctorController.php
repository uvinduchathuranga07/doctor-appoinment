<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Specialization;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

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

    public function saveAppointment(Request $request){
        try {
            Log::alert($request);
            DB::beginTransaction();

            $appointment = new Appointment();
            $appointment-> doctor_id = $request -> doctor_id;
            $appointment-> patient_id = $request -> patient_id;
            $appointment-> appointment_date = $request -> appointment_date;
            $appointment-> start_time = $request -> start_time;
            
            $appointment->save();
            DB::commit();
            
            return $this->successResponse($appointment, 'Appointment Saved');
        }
        catch(\Throwable $th){
            DB::rollBack();
            Log::error($th);
            return $this->errorResponse('Something went wrong.Please Try again.', 500);
        }
    }
    
    public function getAppointmentByCustomer(Request $request){
        try{
            $appointment = Appointment::with('doctor')->where('patient_id',$request->patient_id)->get();
            return $this->successResponse($appointment, 'Apointment List');
        }
        catch(\Throwable $th){
            Log::error($th);
            return $this->errorResponse('Something went wrong.Please Try again.', 500);
        }
    }
}
