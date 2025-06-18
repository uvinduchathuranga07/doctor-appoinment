<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;

class VehicleManufacture extends Controller
{
    public function index(){

        return Inertia::render('VehicleCMS/VehicleManufacture/Index');
    }

    public function getData()
    {
        $users = User::withTrashed()->get();

        return DataTables::of($users)
            ->addColumn('check', function ($row) {
                return '<div class="custom-control custom-checkbox item-check">
            <input type="checkbox" class="form-check-input" id="' . $row->id . '" value="' . $row->id . '">
            <label class="form-check-label form-check-label" for="' . $row->id . '"></label>
          </div>';
            })
            ->addColumn('role', function ($row) {
                return '<span class="badge bg-label-info">' . (count($row->getRoleNames()) > 0 ? $row->getRoleNames()[0] : "") . '</span>';
            })
            ->addColumn('action',  function ($row) {

                if ($row->hasRole('Super Admin')) {
                    return '';
                }

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
                } else if($row->deleted_at) {
                    return '<span class="badge bg-danger">Suspended</span>';
                }
            })
            ->rawColumns(['check', 'action', 'role', 'status'])
            ->make(true);
    }

    public function create()
    {
        return Inertia::render('VehicleCMS/VehicleManufacture/CreateUpdate');
    }
}
