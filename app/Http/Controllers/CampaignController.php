<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class CampaignController extends Controller
{
    public function index()
    {
        return Inertia::render('Campaign/Index');
    }

   public function getData()
{
    $campaigns = Campaign::all();

    return DataTables::of($campaigns)
        ->addColumn('check', fn ($row) => '
            <div class="custom-control custom-checkbox item-check">
                <input type="checkbox" class="form-check-input" id="campaign_' . $row->id . '" value="' . $row->id . '">
                <label class="form-check-label" for="campaign_' . $row->id . '"></label>
            </div>
        ')
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
        ->rawColumns(['check', 'action'])
        ->make(true);
}

    public function create()
    {
        return Inertia::render('Campaign/CreateUpdate');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'      => 'required|string|max:255',
            'date'      => 'required|date',
            'details'   => 'required|string',
            'image'     => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename  = time() . '.' . $extension;
            $file->move(public_path('uploads/campaigns'), $filename);
            $validatedData['photopath'] = 'uploads/campaigns/' . $filename;
        }

        try {
            Campaign::create([              
                'name'      => $validatedData['name'],
                'date'      => $validatedData['date'],
                'details'   => $validatedData['details'],
                'photopath' => $validatedData['photopath'] ?? null,
            ]);

            return redirect()->route('campaign.index')
                             ->with('success', 'Campaign created.');
        } catch (Exception $e) {
            return back()->withErrors('Error creating campaign.');
        }
    }

    public function edit($id)
    {
        $campaign = Campaign::findOrFail($id);
        return Inertia::render('Campaign/CreateUpdate', compact('campaign'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id'        => 'required|exists:campaigns,id',
            'name'      => 'required|string|max:255',
            'date'      => 'required|date',
            'details'   => 'required|string',
            'image'     => 'nullable|image|max:2048',
        ]);

        $campaign = Campaign::findOrFail($validatedData['id']);

        if ($request->hasFile('image')) {
            if ($campaign->photopath && file_exists(public_path($campaign->photopath))) {
                unlink(public_path($campaign->photopath));
            }
            $file      = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename  = time() . '.' . $extension;
            $file->move(public_path('uploads/campaigns'), $filename);
            $validatedData['photopath'] = 'uploads/campaigns/' . $filename;
        }

        try {
            $campaign->update([
                'name'      => $validatedData['name'],
                'date'      => $validatedData['date'],
                'details'   => $validatedData['details'],
                'photopath' => $validatedData['photopath'] ?? $campaign->photopath,
            ]);

            return redirect()->route('campaign.index')
                             ->with('success', 'Campaign updated.');
        } catch (Exception $e) {
            return back()->withErrors('Error updating campaign.');
        }
    }

    public function destroy(Request $request)
    {
        $request->validate(['id' => 'required|exists:campaigns,id']);

        try {
            $campaign = Campaign::findOrFail($request->id);
            if ($campaign->photopath && file_exists(public_path($campaign->photopath))) {
                unlink(public_path($campaign->photopath));
            }
            $campaign->delete();

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting campaign.'
            ], 500);
        }
    }
}
