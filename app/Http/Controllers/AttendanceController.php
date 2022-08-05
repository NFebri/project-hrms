<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date_range = explode(' ', $request->date_range);
        $user_id = $request->user_id;

        $atendances = [];
        $attendance_temp_data = [];
        $start_date = Carbon::parse($date_range[0]);
        $end_date = Carbon::parse($date_range[2]);

        $attendances_temp = Attendance::getAttendanceByDate($start_date, $end_date, $user_id);
        $holidays = Holiday::getHolidayByDate($start_date, $end_date)->keyBy('date')->toArray();

        foreach ($attendances_temp as $attendance) {
            $attendance_temp_data[Carbon::create($attendance->clock_in_time)->toDateString()] = $attendance->toArray();
        }

        for ($date = $end_date; $date->diffInDays($start_date) > 0; $date->subDay()) { 
            $atendances[$date->toDateString()] = [
                'holiday' => false,
                'attendance' => false,
                'date' => $date->toDateString()
            ];

            if (array_key_exists($date->toDateString(), $holidays)) {
                $atendances[$date->toDateString()]['holiday'] = $holidays[$date->toDateString()];
            }

            if (array_key_exists($date->toDateString(), $attendance_temp_data)) {
                $atendances[$date->toDateString()]['attendance'] = $attendance_temp_data[$date->toDateString()];
            }
        }

        return view('attendances.index', [
            'employees' => Employee::all(),
            'attendances' => $atendances
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Attendance::create([
            'user_id' => auth()->user()->id,
            'clock_in_time' => Carbon::now(),
            'work_from' => $request->work_from,
            'is_late' => false
        ]);

        return redirect()->back()->with('success', __('Clock-in successfully!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
