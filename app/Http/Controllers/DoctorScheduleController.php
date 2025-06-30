<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use DataTables;
use DB;
use Exception;

class DoctorScheduleController extends Controller
{
    public function index()
    {
        return Inertia::render('DoctorSchedule/Index');
    }

    public function getData()
    {
        $schedules = DoctorSchedule::with('doctor')->get();
        return DataTables::of($schedules)
            ->addColumn('check', fn($row) => '<input type="checkbox" value="'.$row->id.'" />')
            ->addColumn('doctor', fn($row) => $row->doctor->name)
            ->addColumn('action', function ($row) {
                return '<a class="dropdown-item action_edit" data-item-id="' . $row->id . '" href="#">Edit</a>';
            })
            ->rawColumns(['check', 'doctor', 'action'])
            ->make(true);
    }

    public function create()
    {
        $doctors = Doctor::select('id', 'name')->get();
        return Inertia::render('DoctorSchedule/CreateUpdate', ['doctors' => $doctors]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        try {
            DoctorSchedule::create($request->only('doctor_id', 'day', 'start_time', 'end_time'));
            return redirect()->route('doctor-schedule.index')->with('success', 'Schedule created.');
        } catch (Exception $e) {
            return back()->withErrors('Failed to create schedule.');
        }
    }

    public function edit($id)
    {
        $schedule = DoctorSchedule::findOrFail($id);
        $doctors = Doctor::select('id', 'name')->get();
        return Inertia::render('DoctorSchedule/CreateUpdate', compact('schedule', 'doctors'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:doctor_schedules,id',
            'doctor_id' => 'required|exists:doctors,id',
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        DoctorSchedule::where('id', $request->id)->update($request->only('doctor_id', 'day', 'start_time', 'end_time'));

        return redirect()->route('doctor-schedule.index')->with('success', 'Schedule updated.');
    }
}
