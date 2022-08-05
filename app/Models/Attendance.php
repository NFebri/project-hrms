<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'clock_in_time',
        'work_from',
        'is_late'
    ];

    public static function getAttendanceByDate($start_date, $end_date, $user_id)
    {
        return self::where('user_id', $user_id)
            ->whereBetween('clock_in_time', [$start_date, $end_date])
            ->get();
    }
}
