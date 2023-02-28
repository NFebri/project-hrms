<?php

namespace App\Services;

use App\Models\Holiday;
use Yajra\DataTables\DataTables;

class HolidayService
{
    public function getDatatables()
    {
        $holidays = Holiday::all();

        return DataTables::of($holidays)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $action = '';
                if (auth()->user()->can('holidays-delete')) {
                    $action .= '
                    <form class="d-inline" action="' . route("holidays.destroy", $row->id) . '" method="POST" onsubmit="return confirm(\'Are you sure?\')">
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