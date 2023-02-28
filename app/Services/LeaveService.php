<?php

namespace App\Services;

use App\Models\Leave;
use Yajra\DataTables\DataTables;

class LeaveService
{
    public function getDatatables()
    {
        $leaves = in_array('admin', auth()->user()->getRoleNames()->toArray())
        ? Leave::latest()->get()
        : Leave::where('user_id', auth()->user()->id)->get();

        return DataTables::of($leaves)
            ->addIndexColumn()
            ->addColumn('employee', function($row) {
                return $row->user->name;
            })
            ->addColumn('leave_type', function($row) {
                return $row->leaveType->name;
            })
            ->addColumn('action', function($row) {
                $action = '';
                if (auth()->user()->can('leaves-approve-reject')) {
                    if ($row->status == 'pending') {
                        $action .= '
                        <a href="' . route("leaves.approve", $row->id) . '" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom" title="' . __("Approve") . '">
                            <i class="fas fa-check"></i>
                        </a>

                        <a href="' . route("leaves.reject", $row->id) . '" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="' . __("Reject") . '">
                            <i class="fas fa-times"></i>
                        </a>
                        ';
                    }
                } else {
                    $action .= $row->status;
                }

                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}