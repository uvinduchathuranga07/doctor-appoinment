<?php


namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\DoctorSchedule;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class PrescriptionController extends Controller
{
    public function index($scheduleId)
    {
        $schedule = DoctorSchedule::with('doctor')->findOrFail($scheduleId);
        return Inertia::render('Prescription/Index', [
            'schedule' => $schedule,
        ]);
    }

    public function getData($scheduleId)
    {
        $prescriptions = Prescription::with('patient')
            ->where('doctor_schedule_id', $scheduleId)
            ->get();

        return DataTables::of($prescriptions)
            ->addColumn('check', fn($row) => '<input type="checkbox" value="'.$row->id.'" />')
            ->addColumn('patient', fn($row) => $row->patient->name ?? '-')
            ->addColumn('action', function ($row) use ($scheduleId) {
                return '<a class="dropdown-item action_edit" data-item-id="'.$row->id.'" href="#">Edit</a>';
            })
            ->rawColumns(['check', 'action'])
            ->make(true);
    }

    public function create($scheduleId)
    {
        $schedule = DoctorSchedule::with('doctor')->findOrFail($scheduleId);
        $patients = Customer::all();

        return Inertia::render('Prescription/CreateUpdate', [
            'schedule' => $schedule,
            'patients' => $patients,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_schedule_id' => 'required|exists:doctor_schedules,id',
            'patient_id' => 'required|exists:customers,id',
            'details' => 'required|string',
        ]);

        try {
            Prescription::create($request->only('doctor_schedule_id', 'patient_id', 'details'));
            return redirect()->route('prescription.index', $request->doctor_schedule_id)->with('success', 'Prescription added.');
        } catch (Exception $ex) {
            return back()->withErrors('An error occurred while adding the prescription.');
        }
    }

    public function edit($scheduleId, $id)
    {
        $schedule = DoctorSchedule::with('doctor')->findOrFail($scheduleId);
        $prescription = Prescription::findOrFail($id);
        $patients = Customer::all();

        return Inertia::render('Prescription/CreateUpdate', [
            'schedule' => $schedule,
            'patients' => $patients,
            'prescription' => $prescription,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:prescriptions,id',
            'doctor_schedule_id' => 'required|exists:doctor_schedules,id',
            'patient_id' => 'required|exists:customers,id',
            'details' => 'required|string',
        ]);

        try {
            Prescription::where('id', $request->id)->update($request->only('doctor_schedule_id', 'patient_id', 'details'));
            return redirect()->route('prescription.index', $request->doctor_schedule_id)->with('success', 'Prescription updated.');
        } catch (Exception $ex) {
            return back()->withErrors('An error occurred while updating the prescription.');
        }
    }
}
