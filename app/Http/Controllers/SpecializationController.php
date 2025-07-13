<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use Illuminate\Http\Request;
use Inertia\Inertia;
use DataTables;
use Exception;

class SpecializationController extends Controller
{
    /**
     * Show the list page.
     */
    public function index()
    {
        return Inertia::render('Specialization/Index');
    }

    /**
     * Return JSON for DataTables.
     */
    public function getData()
    {
        $specializations = Specialization::all();

        return DataTables::of($specializations)
            ->addColumn('check', fn($row) => '<input type="checkbox" value="'.$row->id.'"/>')
            ->addColumn('action', function($row) {
                return '
                  <a class="dropdown-item action_edit" data-item-id="'.$row->id.'" href="#">Edit</a>
                  <a class="dropdown-item action_delete" data-item-id="'.$row->id.'" href="#">Delete</a>
                ';
            })
            ->rawColumns(['check','action'])
            ->make(true);
    }

    /**
     * Show the create form.
     */
    public function create()
    {
        return Inertia::render('Specialization/CreateUpdate');
    }

    /**
     * Validate & store a new specialization.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:specializations,name',
        ]);

        try {
            Specialization::create($request->only('name'));
            return redirect()->route('specialization.index')
                             ->with('success', 'Specialization added.');
        } catch (Exception $e) {
            return back()->withErrors('An error occurred while saving.');
        }
    }

    /**
     * Show the edit form.
     */
    public function edit($id)
    {
        $specialization = Specialization::findOrFail($id);

        return Inertia::render('Specialization/CreateUpdate', [
            'specialization' => $specialization,
        ]);
    }

    /**
     * Validate & update an existing specialization.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id'   => 'required|exists:specializations,id',
            'name' => 'required|unique:specializations,name,'.$request->id,
        ]);

        try {
            Specialization::where('id', $request->id)
                ->update(['name' => $request->name]);

            return redirect()->route('specialization.index')
                             ->with('success', 'Specialization updated.');
        } catch (Exception $e) {
            return back()->withErrors('An error occurred while updating.');
        }
    }

    /**
     * Delete a specialization.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:specializations,id',
        ]);

        try {
            Specialization::destroy($request->id);
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not delete specialization.'
            ], 500);
        }
    }
}
