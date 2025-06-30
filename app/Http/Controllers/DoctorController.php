<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Inertia\Inertia;
use DataTables;
use DB;
use Exception;

class DoctorController extends Controller
{
    public function index()
    {
        return Inertia::render('Doctor/Index');
    }

    public function getData()
    {
        $doctors = Doctor::with('specialization')->get();
        return DataTables::of($doctors)
            ->addColumn('check', fn ($row) => '<input type="checkbox" value="'.$row->id.'"/>')
            ->addColumn('specialization', fn ($row) => $row->specialization?->name ?? '—')
            ->addColumn('action', function ($row) {
                return '<a class="dropdown-item action_edit" data-item-id="' . $row->id . '" href="#">Edit</a>';
            })
            ->rawColumns(['check', 'specialization', 'action'])
            ->make(true);
    }

    public function create()
    {
        $specializations = Specialization::all();
        return Inertia::render('Doctor/CreateUpdate', ['specializations' => $specializations]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:doctors,email',
            'phone' => 'nullable',
            'specialization_id' => 'required|exists:specializations,id',
        ]);

        try {
            Doctor::create($request->only('name', 'email', 'phone', 'specialization_id'));
            return redirect()->route('doctor.index')->with('success', 'Doctor added.');
        } catch (Exception $e) {
            return back()->withErrors('Error occurred.');
        }
    }

    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        $specializations = Specialization::all();
        return Inertia::render('Doctor/CreateUpdate', compact('doctor', 'specializations'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:doctors,id',
            'name' => 'required',
            'email' => 'required|email|unique:doctors,email,'.$request->id,
            'phone' => 'nullable',
            'specialization_id' => 'required|exists:specializations,id',
        ]);

        Doctor::where('id', $request->id)->update($request->only('name', 'email', 'phone', 'specialization_id'));

        return redirect()->route('doctor.index')->with('success', 'Doctor updated.');
    }
}
