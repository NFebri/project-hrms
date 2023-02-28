<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\Leave;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class AttendanceService
{
    public function getDatatables($request)
    {
        $date_range = explode(' ', $request->date_range);
        $user_id = in_array('admin', auth()->user()->getRoleNames()->toArray())
            ? $request->user_id
            : auth()->user()->id;

        $atendances = [];
        $start_date = Carbon::parse($date_range[0]);
        $end_date = Carbon::parse($date_range[2] . ' 23:59:59');

        $attendance_temp_data = Attendance::getAttendanceByDate($start_date, $end_date, $user_id)
            ->keyBy(fn ($item) => Carbon::create($item->clock_in)
            ->toDateString())
            ->toArray();
        $holidays = Holiday::getHolidayByDate($start_date, $end_date)->keyBy('date')->toArray();
        $leaves = Leave::getLeaveByDate($start_date, $end_date, $user_id)->keyBy('date')->toArray();

        for ($date = $start_date; $date <= $end_date; $date->addDay(1)) { 
            $atendances[$date->toDateString()] = [
                'holiday' => false,
                'leave' => false,
                'attendance' => false,
                'date' => $date->toDateString()
            ];

            if (array_key_exists($date->toDateString(), $holidays)) {
                $atendances[$date->toDateString()]['holiday'] = $holidays[$date->toDateString()];
            }

            if (array_key_exists($date->toDateString(), $leaves)) {
                $atendances[$date->toDateString()]['leave'] = $leaves[$date->toDateString()];
            }

            if (array_key_exists($date->toDateString(), $attendance_temp_data)) {
                $atendances[$date->toDateString()]['attendance'] = $attendance_temp_data[$date->toDateString()];
            }
        }

        return DataTables::of($atendances)
            ->addColumn('date', function($row) {
                return $row['date'];
            })
            ->addColumn('status', function($row) {
                $status = '';
                if ($row['holiday']) {
                    $status = '<span class="badge badge-info">' . __('holiday') . '</span>';
                } elseif ($row['leave']) {
                    $status = '<span class="badge badge-warning">' . __('leave') . '</span>';
                } elseif ($row['attendance']) {
                    $status = '<span class="badge badge-primary">' . __('present') . '</span>';
                } else {
                    $status = '<span class="badge badge-danger">' . __('absent') . '</span>';
                }
                return $status;
            })
            ->rawColumns(['status'])
            ->make(true);
    }
}