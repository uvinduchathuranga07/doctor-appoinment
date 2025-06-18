<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\ManufactureResource;
use App\Mail\EnrollToAffiliate;
use App\Models\Customer;
use App\Models\Manufacture;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $customer = Customer::where('status', 1)->get();
            $customer = CustomerResource::collection($customer);

            return $this->successResponse($customer, 'success');
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->errorResponse($th, 500);
        }
    }

    public function enrollToAffiliate(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = Customer::find(request()->user()->id);
            $user->enrolled_affiliate = 1;
            $user->save();

            Mail::to($user->email)->cc(['info@nikoba.com', 'wijitha@nikoba.com'])->bcc('hushantha@weblook.com', 'chathuranga@weblook.com')->send(new EnrollToAffiliate($user));
            
            DB::commit();
            return $this->successResponse(true, 'Enroll to affilliate');
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
            return $this->errorResponse($th->getMessage(), 500);
        }
    } 
}
