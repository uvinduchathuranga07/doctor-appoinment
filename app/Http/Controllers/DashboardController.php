<?php

namespace App\Http\Controllers;


use App\Models\Customer;

use App\Models\Inquiry;

use App\Models\Testimonial;

use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\Campaign;
use App\Models\User;

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
        $backend_user_count = User::count();
        $prescription_count = Prescription::count();
        $active_campaign_count = Campaign::count();
    $appointments = Appointment::select(
        DB::raw('DAYNAME(appointment_date) as day'),
        DB::raw('count(*) as count')
    )
    ->groupBy('day')
    ->get();

    // Prescriptions by weekday
    $prescriptions = Prescription::select(
        DB::raw('DAYNAME(created_at) as day'),
        DB::raw('count(*) as count')
    )
    ->groupBy('day')
    ->get();
//dd($appointments, $prescriptions);

        // Render the dashboard view with the counts
    return Inertia::render('Dashboard/Index', [
        'backend_user_count' => $backend_user_count,
        'prescription_count' => $prescription_count,
        'active_campaign_count' => $active_campaign_count,
        'appointmentData' => $appointments,
        'prescriptionData' => $prescriptions,
    ]);
    }
}
