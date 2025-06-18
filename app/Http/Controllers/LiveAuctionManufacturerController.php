<?php

namespace App\Http\Controllers;

use App\Models\LiveAuctionManufacturer;
use App\Services\ApiClient\ApiClient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Yajra\DataTables\DataTables;

class LiveAuctionManufacturerController extends Controller
{
    public function index()
    {
        return Inertia::render('VehicleCMS/LiveAuctionManufacturer/Index');
    }

    public function getData()
    {
        $users = LiveAuctionManufacturer::with('media')->get();
        // dd($users);
        return DataTables::of($users)
            ->addColumn('check', function ($row) {
                return '<div class="custom-control custom-checkbox item-check">
            <input type="checkbox" class="form-check-input" id="' . $row->id . '" value="' . $row->id . '">
            <label class="form-check-label form-check-label" for="' . $row->id . '"></label>
          </div>';
            })

            ->addColumn('action',  function ($row) {



                $action_html = '';
                if (auth()->user()->can('backend-user.view backend-user.edit')) {
                    $action_html .= '<a class="dropdown-item action_edit" style="font-size: 14px;padding: 5px 13px;" data-item-id="' . $row->id . '" href="javascript:void(0)"><i class="fas fa-edit mr-2"></i> View / Edit</a>';
                }
                if (auth()->user()->can('backend-user.edit')) {
                    $action_html .= '<a class="dropdown-item ' . ($row->status == 1 ? 'text-warning' : 'text-success') . ' action_status_change" style="font-size: 14px;padding: 5px 13px;" data-item-id="' . $row->id . '" data-status="' . $row->status . '" href="javascript:void(0)"><i class="fas fa-power-off mr-2"></i>' . ($row->status == 1 ? ' Deactivate' : ' Activate') . '</a> ';
                }
                $action_html .= '<div class="dropdown-divider"></div>';
                if (auth()->user()->can('backend-user.delete')) {
                    $action_html .= '<a class="dropdown-item text-danger action_delete" data-bs-toggle="modal" data-bs-target="#deleteConfirm" style="font-size: 14px;padding: 5px 13px;" data-item-id="' . $row->id . '" href="javascript:void(0)"><i class="fas fa-trash mr-2"></i> Delete</a> ';
                }
                return '<div class="btn-group">
                                <button type="button" class="btn btn-main btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" style="min-width: 10rem;">
                                ' . $action_html . '
                                </div>
                            </div>';
            })->addColumn('status', function ($row) {
                if ($row->status == 1 && !$row->deleted_at) {
                    return '<span class="badge bg-success">Active</span>';
                } else if ($row->status == 0 && !$row->deleted_at) {
                    return '<span class="badge bg-warning">Inactive</span>';
                } else if ($row->deleted_at) {
                    return '<span class="badge bg-danger">Suspended</span>';
                }
            })
            ->addColumn('image', function ($row) {
                if (count($row->media) > 0) {
                    $image = '<img src="' . $row->media[0]->original_url . '" height="25"/>';
                } else {
                    $image = "No Image";
                }

                return $image;
            })
            ->rawColumns(['check', 'action', 'status', 'image'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $manufcturesQuery = "SELECT DISTINCT marka_name FROM main ORDER BY marka_name ASC";;
        $all_manufactures = ApiClient::callAuctionApi($manufcturesQuery, true);

        $manufactures = [];
        foreach ($all_manufactures as $k => $value) {
            $m['id'] = $value['MARKA_NAME'];
            $m['name'] = $value['MARKA_NAME']; 

            array_push($manufactures, $m);
        }

        // dd($manufactures);

        return Inertia::render('VehicleCMS/LiveAuctionManufacturer/CreateUpdate', ['manufactures' => $manufactures]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            "status" => ['required'],
            'image' => ['nullable', 'mimes:jpeg,jpg,png,webp', 'max:10000']
        ]);
        // dd($request->all());
        try {
            DB::beginTransaction();

            $manufacture = new LiveAuctionManufacturer();
            $manufacture->name = $request->name;
            $manufacture->status = $request->status;
            $manufacture->save();


            if ($request->hasFile('image')) {
                $manufacture->addMedia($request->file('image'))->toMediaCollection('Live Auction Manufacture');
                $manufacture->save();
            }

            DB::commit();




            return redirect()->route('vehicle_manufacture.live.index');
        } catch (Exception $ex) {
            dd($ex);
            DB::rollBack();
            return abort(500);
        }
    }

    public function updateStatus(Request $request)
    {
        // dd($request->all());
        try {
            $user = LiveAuctionManufacturer::find($request->id);
            if ($request->status == 0) {
                $user->status = 1;
            } else {
                $user->status = 0;
            }
            $user->save();

            return redirect()->route('vehicle_manufacture.live.index');
        } catch (Exception $ex) {
            Log::error($ex);
            return abort(500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LiveAuctionManufacturer $manufacture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $manufcturesQuery = "SELECT DISTINCT marka_name FROM main ORDER BY marka_name ASC";;
        $all_manufactures = ApiClient::callAuctionApi($manufcturesQuery, true);
        $vehicle_manufacture = LiveAuctionManufacturer::with('media')->find($id);

        $manufactures = [];
        foreach ($all_manufactures as $k => $value) {
            $m['id'] = $value['MARKA_NAME'];
            $m['name'] = $value['MARKA_NAME']; 

            array_push($manufactures, $m);
        }

        // dd($vehicle_manufacture);
        return Inertia::render('VehicleCMS/LiveAuctionManufacturer/CreateUpdate', ['vehicle_manufacture' => $vehicle_manufacture, 'manufactures' => $manufactures]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //  dd($request->all());
        try {
            DB::beginTransaction();
            $manufacture = LiveAuctionManufacturer::find($request->id);
            $manufacture->name = $request->name;
            $manufacture->status = $request->status;
            $manufacture->save();
            DB::commit();



            if ($request->hasFile('image')) {
                if ($manufacture->media) {
                    Storage::disk('public')->delete($manufacture->media);
                    $manufacture->clearMediaCollection('Live Auction Manufacture');
                }
                $manufacture->addMedia($request->file('image'))->toMediaCollection('Live Auction Manufacture');
                $manufacture->save();
            }

            return redirect()->route('vehicle_manufacture.live.index');
        } catch (Exception $ex) {
            // dd($ex);
            DB::rollBack();
            Log::error($ex);
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // dd($request->all());
        try {
            LiveAuctionManufacturer::destroy([$request->ids]);
            return redirect()->route('vehicle_manufacture.live.index');
        } catch (Exception $ex) {
            Log::error($ex);
            return abort(500);
        }
    }
}
