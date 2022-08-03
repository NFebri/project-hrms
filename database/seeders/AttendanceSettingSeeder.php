<?php

namespace Database\Seeders;

use App\Models\AttendanceSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AttendanceSetting::create([
            'office_start_time' => '09:00:00',
            'office_end_time' => '18:00:00'
        ]);
    }
}
