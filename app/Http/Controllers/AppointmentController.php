<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Log;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class AppointmentController extends Controller
{
    /**
     * Show booking form.
     */
    public function index()
    {
        $doctors = Doctor::with('specialization')->get();
        return Inertia::render('Appointment/Book', [
            'doctors' => $doctors,
        ]);
    }

    /**
     * Return available 15-min slots for a doctor on a date.
     */
    public function getAvailableSlots(Request $request, $doctorId)
    {
        $request->validate(['date' => 'required|date']);
        $date    = $request->input('date');
        $dayName = Carbon::parse($date)->format('l');

        $doctor = Doctor::with(['schedules' => function ($q) use ($dayName) {
            $q->where('day', $dayName);
        }])->findOrFail($doctorId);

        $booked = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $date)
            ->pluck('start_time')
            ->map(fn($t) => Carbon::parse($t)->format('H:i'))
            ->toArray();

        $slots = [];
        foreach ($doctor->schedules as $sch) {
            $start = Carbon::parse($sch->start_time);
            $end   = Carbon::parse($sch->end_time);

            while ($start < $end) {
                $slot = $start->format('H:i');
                if (!in_array($slot, $booked)) {
                    $slots[] = $slot;
                }
                $start->addMinutes(15);
            }
        }

        return response()->json($slots);
    }

  
    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'appointment_date'=> 'required',
            'start_time'      => 'required',
        ]);

        // prevent double-booking
        // $exists = Appointment::where('doctor_id', $request['doctor_id'])
        //     ->whereDate('appointment_date', $validated['appointment_date'])
        //     ->where('start_time', $validated['start_time'])
        //     ->exists();

        // if ($exists) {
        //     return back()->withErrors([
        //         'start_time' => 'This time slot is already booked.',
        //     ]);
        // }

        try {
            Appointment::create([
                'doctor_id'       => $request['doctor_id'],
                'patient_id'      => 1,
                'appointment_date'=> $validated['appointment_date'],
                'start_time'      => $validated['start_time'],
                'status'          => 'booked',
            ]);
             Log::info('Appointment booked');
            return redirect()->route('appointments.list')
                             ->with('success', 'Appointment booked.');
        } catch (Exception $e) {
            
            return back()->withErrors('Error booking appointment.');
        }
    }

    /**
     * Show DataTable listing.
     */
    public function list()
    {
        return Inertia::render('Appointment/Index');
    }

    /**
     * JSON for DataTables.
     */
public function getData()
{
    $appointments = Appointment::with(['doctor', 'patient'])->get();

    return DataTables::of($appointments)
        ->addColumn('check', function ($row) {
            return '<div class="custom-control custom-checkbox item-check">
                <input type="checkbox" class="form-check-input" id="' . $row->id . '" value="' . $row->id . '">
                <label class="form-check-label" for="' . $row->id . '"></label>
            </div>';
        })
        ->addColumn('doctor', function ($row) {
            return $row->doctor?->name ?? '—';
        })
        ->addColumn('patient', function ($row) {
            return $row->patient?->name ?? '—';
        })
        ->addColumn('date', function ($row) {
            return $row->appointment_date;
        })
        ->addColumn('time', function ($row) {
            return $row->start_time;
        })
        ->addColumn('status', function ($row) {
            $status = ucfirst($row->status);
            $badgeClass = match ($row->status) {
                'pending' => 'bg-warning',
                'completed' => 'bg-success',
                'cancelled' => 'bg-danger',
                default => 'bg-secondary',
            };
            return '<span class="badge ' . $badgeClass . '">' . $status . '</span>';
        })
        ->addColumn('action', function ($row) {
            $prescriptionUrl = route('prescription.create', $row->id);

            return '<div class="btn-group">
                <button type="button" class="btn btn-main btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Action
                </button>
                <div class="dropdown-menu" style="min-width: 10rem;">
                    <a class="dropdown-item text-primary" href="' . $prescriptionUrl . '">
                        <i class="fas fa-notes-medical mr-2"></i> Prescription
                    </a>
                </div>
            </div>';
        })
        ->rawColumns(['check', 'status', 'action'])
        ->make(true);
}


}
