<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'occassion'
    ];

    public static function getHolidayByDate($start_date, $end_date)
    {
        return self::whereBetween('date', [$start_date, $end_date])
            ->get();
    }
}
