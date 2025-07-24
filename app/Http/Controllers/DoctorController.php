<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Specialization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use App\Mail\NewDoctorCredentialMail; 
use Illuminate\Support\Facades\Mail;
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
        ->addColumn('check', fn ($row) => '
            <div class="custom-control custom-checkbox item-check">
                <input type="checkbox" class="form-check-input" id="doc_' . $row->id . '" value="' . $row->id . '">
                <label class="form-check-label" for="doc_' . $row->id . '"></label>
            </div>
        ')
        ->addColumn('specialization', fn ($row) => $row->specialization?->name ?? '—')
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
        ->rawColumns(['check', 'specialization', 'action'])
        ->make(true);
}


    public function create()
    {
        $allRoles = Role::all();
        $specializations = Specialization::all();
        return Inertia::render('Doctor/CreateUpdate', ['specializations' => $specializations ,'allRoles' => $allRoles]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:doctors,email',
            'phone' => 'nullable',
            'specialization_id' => 'required|exists:specializations,id',
            'price' => 'nullable',
        ]);

        try {
            Doctor::create($request->only('name', 'email', 'phone', 'specialization_id', 'price'));
            DB::beginTransaction();

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile_no = $request->phone;
            // $user->branch = $request->branch;
            $user->email_verified_at = now();
            $user->password = Hash::make($request->password);
            $user->status = 1;
            $user->save();

            
            DB::commit();
            
            $role = Role::find('5');
             
            $user->assignRole($role->name);
            Mail::to($user->email)->send(new NewDoctorCredentialMail($user->email, $request->password));
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

    public function destroy(Request $request)
{
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'exists:doctors,id',
    ]);

    try {
        Doctor::whereIn('id', $request->ids)->delete();
        return response()->json(['message' => 'Doctor(s) deleted successfully.']);
    } catch (Exception $e) {
        return response()->json(['message' => 'Failed to delete doctor(s).'], 500);
    }
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

    public function bulkupdate(){
         return Inertia::render('BulkUser/CreateUpdate');
    }
}
