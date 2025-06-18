<?php

namespace App\Http\Controllers;


use App\Models\Customer;

use App\Models\Inquiry;

use App\Models\Testimonial;


use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicle_count = '5';
        $customer_count = '6';
        $inquiry_count = '8';
        $testimonial_count = '6';

        // dd($customer_count);
        return Inertia::render('Dashboard/Index',['vehicle_count' => $vehicle_count, 'customer_count' => $customer_count, 'inquiry_count' => $inquiry_count, 'testimonial_count' => $testimonial_count]);

    }
}
