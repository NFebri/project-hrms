<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user_clock_in = Attendance::where('user_id', auth()->user()->id)
            ->whereDate('clock_in_time', Carbon::now()->format('Y-m-d'))
            ->first();

        return view('dashboard', [
            'user_clock_in' => $user_clock_in,
            'total_employee' => Employee::count(),
            'total_department' => Department::count()
        ]);
    }
}
