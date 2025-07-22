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
      

        // New counts
        $backend_user_count = User::where('is_backend', true)->count();
        $prescription_count = Prescription::count();
        $active_campaign_count = Campaign::where('status', 'active')->count();

        return Inertia::render('Dashboard/Index', [
         
            'backend_user_count' => $backend_user_count,
            'prescription_count' => $prescription_count,
            'active_campaign_count' => $active_campaign_count,
        ]);
    }
}
