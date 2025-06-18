<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\AuctionInqiryDetails;
use App\Models\Customer;
use App\Models\Inquiry;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    use ApiResponse;
    
    public function submit(Request $request) {
        $request->validate([
            "vehicle_name" => "required",
            "vehicle_url" => "required",
            "vehicle_id" => "required",
            "stock_type" => "required",
            "name" => "required",
            "email" => "required|email",
            "mobile" => "required",
            "purchase_time" => "required",
            "payment_method" => "required",
            "address" => "required",
            "message" => "nullable",
        ]);

        DB::beginTransaction();
        try {
            $inquiry = new Inquiry();
            $inquiry->name = $request->name;
            $inquiry->email = $request->email;
            $inquiry->phone = $request->mobile;
            $inquiry->address = $request->address;
            $inquiry->message = $request->message;
            $inquiry->purchase_time = $request->purchase_time;
            $inquiry->payment_method = $request->payment_method;
            $inquiry->url = $request->vehicle_url;
            $inquiry->vehicle_id = $request->vehicle_id;
            $inquiry->type = $request->stock_type;
            $inquiry->status = "pending";
            $inquiry->save();

            DB::commit();

            Mail::to($request->email)->cc(['info@nikoba.com', 'wijitha@nikoba.com'])->bcc('hushantha@weblook.com', 'chathuranga@weblook.com')->send(new AuctionInqiryDetails($inquiry));

            return redirect()->back();
        } catch (\Throwable $th) {
           Log::error($th);
           DB::rollBack();

           return redirect()->back();
        }

    }
    public function submitAppInquiry(Request $request) {
        $request->validate([
            "vehicle_name" => "required",
            "vehicle_url" => "required",
            "vehicle_id" => "required",
            "stock_type" => "required",
            "name" => "required",
            "email" => "required|email",
            "mobile" => "required",
            "purchase_time" => "required",
            "payment_method" => "required",
            "address" => "required",
            "message" => "nullable",
        ]);

        DB::beginTransaction();
        try {
            $inquiry = new Inquiry();
            $inquiry->name = $request->name;
            $inquiry->email = $request->email;
            $inquiry->phone = $request->mobile;
            $inquiry->address = $request->address;
            $inquiry->message = $request->message;
            $inquiry->purchase_time = $request->purchase_time;
            $inquiry->payment_method = $request->payment_method;
            $inquiry->url = $request->vehicle_url;
            $inquiry->vehicle_id = $request->vehicle_id;
            $inquiry->type = $request->stock_type;
            $inquiry->status = "pending";
            $inquiry->save();

            DB::commit();

            Mail::to($request->email)->cc(['info@nikoba.com', 'wijitha@nikoba.com'])->bcc('hushantha@weblook.com', 'chathuranga@weblook.com')->send(new AuctionInqiryDetails($inquiry));
            
            return $this->successResponse([], 'success');

        } catch (\Throwable $th) {
           Log::error($th);
           DB::rollBack();
           return $this->errorResponse($th, 500);
        }

    }

    public function getInquires(Request $request) {
        try {
            $inquies = [];
            if($request->email) {
                $inquies = Inquiry::where('email', $request->email)->get();
    
            }
            return $this->successResponse( $inquies, 'success');
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->errorResponse($th, 500);
        }
    }
}
