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
        ->addColumn('check', fn ($row) => '
            <div class="custom-control custom-checkbox item-check">
                <input type="checkbox" class="form-check-input" id="schedule_' . $row->id . '" value="' . $row->id . '">
                <label class="form-check-label" for="schedule_' . $row->id . '"></label>
            </div>
        ')
        ->addColumn('doctor', fn ($row) => $row->doctor->name)
        ->addColumn('action', function ($row) {
            return '
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-main dropdown-toggle" data-bs-toggle="dropdown">Action</button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item action_edit" href="#" data-item-id="' . $row->id . '"><i class="fas fa-edit me-2"></i> Edit</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger action_delete" href="#" data-item-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#deleteConfirm"><i class="fas fa-trash me-2"></i> Delete</a></li>
                    </ul>
                </div>
            ';
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
