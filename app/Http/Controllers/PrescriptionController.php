<?php


namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\DoctorSchedule;
use App\Models\Customer;
use App\Models\Appointment;
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

       public function create($appointmentId)
    {
        $appointment = Appointment::with('doctor')->findOrFail($appointmentId);
        $patients = Customer::all();

        return Inertia::render('Prescription/CreateUpdate', [
            'appointment' => $appointment,
            'patients' => $patients,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'patient_id' => 'required|exists:customers,id',
            'details' => 'required|array',
            'status' => 'required|string',
            'pharmacy_name' => 'nullable|string',
        ]);

        try {
            Prescription::create([
                'appointment_id' => $request->appointment_id,
                'patient_id' => $request->patient_id,
                'details' => $request->details, // Laravel will cast to JSON
                'status' => $request->status,
                'pharmacy_name' => $request->pharmacy_name,
            ]);

            return redirect()
                ->route('prescription.index', $request->appointment_id)
                ->with('success', 'Prescription added.');
        } catch (Exception $ex) {
            return back()->withErrors('An error occurred while adding the prescription.');
        }
    }

    public function edit($appointmentId, $id)
    {
        $appointment = Appointment::with('doctor')->findOrFail($appointmentId);
        $prescription = Prescription::findOrFail($id);
        $patients = Customer::all();

        return Inertia::render('Prescription/CreateUpdate', [
            'appointment' => $appointment,
            'patients' => $patients,
            'prescription' => $prescription,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:prescriptions,id',
            'appointment_id' => 'required|exists:appointments,id',
            'patient_id' => 'required|exists:customers,id',
            'details' => 'required|array',
            'status' => 'required|string',
            'pharmacy_name' => 'nullable|string',
        ]);

        try {
            Prescription::where('id', $request->id)->update([
                'appointment_id' => $request->appointment_id,
                'patient_id' => $request->patient_id,
                'details' => $request->details,
                'status' => $request->status,
                'pharmacy_name' => $request->pharmacy_name,
            ]);

            return redirect()
                ->route('prescription.index', $request->appointment_id)
                ->with('success', 'Prescription updated.');
        } catch (Exception $ex) {
            return back()->withErrors('An error occurred while updating the prescription.');
        }
    }

}
