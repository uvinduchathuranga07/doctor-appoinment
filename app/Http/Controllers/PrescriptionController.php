<?php


namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\DoctorSchedule;
use App\Models\Customer;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class PrescriptionController extends Controller
{
    public function index()
{
    $patients = Customer::all();

    return Inertia::render('Prescription/Index', [
        'patients' => $patients,
    ]);
}

  public function getData()
{
    $prescriptions = Prescription::with(['appointment.doctor', 'patient'])->latest();

    return DataTables::of($prescriptions)
        ->addColumn('doctor', fn($p) => $p->appointment?->doctor?->name ?? '—')
        ->addColumn('patient', fn($p) => $p->patient?->name ?? '—')
        ->addColumn('date', fn($p) => optional($p->appointment)->appointment_date)
        ->addColumn('status', fn($p) => ucfirst($p->status))
        ->addColumn('pharmacy', fn($p) => $p->pharmacy_name ?? '-')
        ->addColumn('action', fn($p) => '
            <a href="' . route('prescription.edit', [$p->appointment_id, $p->id]) . '" class="btn btn-sm btn-outline-primary">Edit</a>
        ')
        ->rawColumns(['action'])
        ->make(true);
}
       public function create($appointmentId)
    {
        $appointment = Appointment::with('doctor')->findOrFail($appointmentId);
        $patients = Customer::all();

        return Inertia::render('Prescription/CreateUpdate', [
            'appointment' => $appointment,
            'patients' => $patients,
            'products' => Product::all(),

        ]);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'patient_id' => 'required|exists:customers,id',
            'details' => 'required|array',
            'status' => 'required|string',
            'pharmacy_name' => 'nullable|string',
        ]);

        $rawDetails = $request->input('details'); // This is already an array
        $detailsString = collect($rawDetails)
        ->map(fn ($item) => '{' . $item['product_id'] . ',' . $item['quantity'] . '}')
        ->implode(',');

        try {
            Prescription::create([
                'appointment_id' => $request->appointment_id,
                'patient_id' => $request->patient_id,
                'details' => $detailsString, // Laravel will cast to JSON
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
            'products' => Product::all(),

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

        $rawDetails = $request->input('details'); // This is already an array
        $detailsString = collect($rawDetails)
         ->map(fn ($item) => '{' . $item['product_id'] . ',' . $item['quantity'] . '}')
         ->implode(',');
        try {
            Prescription::where('id', $request->id)->update([
                'appointment_id' => $request->appointment_id,
                'patient_id' => $request->patient_id,
                'details' => $detailsString,
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
