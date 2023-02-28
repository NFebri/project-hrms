<?php

namespace App\Services;

use App\Models\Designation;
use Yajra\DataTables\DataTables;

class DesignationService
{
    public function getDatatables()
    {
        $designations = Designation::all();

        return DataTables::of($designations)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $action = '';
                if (auth()->user()->can('designations-edit')) {
                    $action .= '
                    <a href="' . route("designations.edit", $row->id) . '" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="{{ __("Edit") }}">
                        <i class="fas fa-pen"></i>
                    </a>';
                }

                if (auth()->user()->can('designations-delete')) {
                    $action .= '
                    <form class="d-inline" action="' . route("designations.destroy", $row->id) . '" method="POST" onsubmit="return confirm(\'Are you sure?\')">
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