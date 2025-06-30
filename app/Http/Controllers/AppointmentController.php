<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('specialization')->get();
        return Inertia::render('Appointment/Index', [
            'doctors' => $doctors,
        ]);
    }

    public function getAvailableSlots(Request $request, $doctorId)
    {
        $request->validate(['date' => 'required|date']);
        $date = $request->input('date');
        $dayName = Carbon::parse($date)->format('l'); // e.g., Monday

        $doctor = Doctor::with(['schedules' => function ($q) use ($dayName) {
            $q->where('day', $dayName);
        }])->findOrFail($doctorId);

        $bookedSlots = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $date)
            ->pluck('start_time')
            ->map(fn($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        $slots = [];

        foreach ($doctor->schedules as $schedule) {
            $start = Carbon::parse($schedule->start_time);
            $end = Carbon::parse($schedule->end_time);

            while ($start < $end) {
                $slot = $start->format('H:i');
                if (!in_array($slot, $bookedSlots)) {
                    $slots[] = $slot;
                }
                $start->addMinutes(15);
            }
        }

        return response()->json($slots);
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required',
        ]);

        $exists = Appointment::where('doctor_id', $request->doctor_id)
            ->whereDate('appointment_date', $request->appointment_date)
            ->whereTime('start_time', $request->start_time)
            ->exists();

        if ($exists) {
            return back()->withErrors(['start_time' => 'This time slot is already booked.']);
        }

        $endTime = Carbon::parse($request->start_time)->addMinutes(15)->format('H:i:s');

        Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => auth()->id(), // assuming authenticated customer
            'appointment_date' => $request->appointment_date,
            'start_time' => $request->start_time,
            'end_time' => $endTime,
            'status' => 'booked'
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment booked.');
    }
}
