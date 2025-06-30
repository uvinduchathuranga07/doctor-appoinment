<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class EmployeeController extends Controller
{
    public function index()
    {
        return Inertia::render('Employee/Index');
    }

    public function getData()
    {
        $employees = Employee::all();

        return DataTables::of($employees)
            ->addColumn('check', fn($row) => '<input type="checkbox" value="'.$row->id.'" />')
            ->addColumn('action', function ($row) {
                return '<a class="dropdown-item action_edit" data-item-id="'.$row->id.'" href="#">Edit</a>';
            })
            ->rawColumns(['check', 'action'])
            ->make(true);
    }

    public function create()
    {
        return Inertia::render('Employee/CreateUpdate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'emp_id' => 'required|unique:employees,emp_id',
            'name' => 'required|string',
            'age' => 'nullable|integer',
            'gender' => 'nullable|in:Male,Female,Other',
            'birthday' => 'nullable|date',
            'blood_type' => 'nullable|string',
        ]);

        try {
            Employee::create($request->only('emp_id', 'name', 'age', 'gender', 'birthday', 'blood_type'));
            return redirect()->route('employee.index')->with('success', 'Employee added.');
        } catch (Exception $ex) {
            return back()->withErrors('Failed to add employee.');
        }
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return Inertia::render('Employee/CreateUpdate', ['employee' => $employee]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:employees,id',
            'emp_id' => 'required|unique:employees,emp_id,' . $request->id,
            'name' => 'required|string',
            'age' => 'nullable|integer',
            'gender' => 'nullable|in:Male,Female,Other',
            'birthday' => 'nullable|date',
            'blood_type' => 'nullable|string',
        ]);

        try {
            Employee::where('id', $request->id)->update($request->only('emp_id', 'name', 'age', 'gender', 'birthday', 'blood_type'));
            return redirect()->route('employee.index')->with('success', 'Employee updated.');
        } catch (Exception $ex) {
            return back()->withErrors('Failed to update employee.');
        }
    }
}
