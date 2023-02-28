<?php

namespace App\Services;

use App\Models\Leave;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RolePermissionService
{
    public function getDatatables()
    {
        $roles = Role::all();

        return DataTables::of($roles)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $action = '';
                if (auth()->user()->can('roles-edit')) {
                    $action .= '
                    <a href="' . route("roles-permissions.edit", $row->id) . '" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="{{ __("Edit") }}">
                        <i class="fas fa-pen"></i>
                    </a>';
                }

                if (auth()->user()->can('roles-delete')) {
                    $action .= '
                    <form class="d-inline" action="' . route("roles-permissions.destroy", $row->id) . '" method="POST" onsubmit="return confirm(\'Are you sure?\')">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="{{ __("Delete") }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    ';
                }

                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}