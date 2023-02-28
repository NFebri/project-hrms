<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveRequest;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Services\LeaveService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LeaveController extends Controller
{
    private $leaveService;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        // initialize service
        $this->leaveService = new LeaveService();
        // initialze middleware
        $this->middleware('permission:leaves-list', ['only' => ['index','show']]);
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
            return $this->leaveService->getDatatables();
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
    public function store(LeaveRequest $request)
    {
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
        $leave->setApprove();

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
        $leave->setReject();

        return redirect()->route('leaves.index')->with('success', __('Leave was rejected!'));
    }
}
