<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:leaves-view', ['only' => ['index','show']]);
        $this->middleware('permission:leaves-create', ['only' => ['create','store']]);
        $this->middleware('permission:leaves-approve-reject', ['only' => ['approve','reject']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $leaves = Leave::latest()->get();

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
                    if ($row->status == 'pending') {
                        $action .= '
                        <a href="' . route("leaves.approve", $row->id) . '" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom" title="' . __("Approve") . '">
                            <i class="fas fa-check"></i>
                        </a>

                        <a href="' . route("leaves.reject", $row->id) . '" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="' . __("Reject") . '">
                            <i class="fas fa-times"></i>
                        </a>
                        ';
                    } else {
                        $action .= $row->status;
                    }

                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('leaves.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leaves.create', [
            'leave_types' => LeaveType::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'leave_type_id' => 'required',
            'date' => 'required',
            'reason' => 'required'
        ]);

        Leave::create([
            'user_id' => auth()->user()->id,
            'leave_type_id' => $request->leave_type_id,
            'status' => 'pending',
            'date' => $request->date,
            'reason' => $request->reason
        ]);

        return redirect()->route('leaves.index')->with('success', __('Leave was created!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Leave $leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leave)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function approve(Leave $leave)
    {
        $leave->update([
            'status' => 'approved'
        ]);

        return redirect()->route('leaves.index')->with('success', __('Leave was approved!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function reject(Leave $leave)
    {
        $leave->update([
            'status' => 'rejected'
        ]);

        return redirect()->route('leaves.index')->with('success', __('Leave was rejected!'));
    }
}
