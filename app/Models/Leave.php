<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'leave_type_id',
        'status',
        'date',
        'reason'
    ];

    public function setApprove()
    {
        $this->attributes['status'] = 'approved';
        self::save();
    }

    public function setReject()
    {
        $this->attributes['status'] = 'rejected';
        self::save();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }

    public static function getLeaveByDate($start_date, $end_date, $user_id)
    {
        return self::whereBetween('date', [$start_date, $end_date])
            ->where('user_id', $user_id)
            ->where('status', 'approved')
            ->get();
    }
}
