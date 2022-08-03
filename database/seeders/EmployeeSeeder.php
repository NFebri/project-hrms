<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        $department = Department::find(1);
        $designation = Designation::find(1);

        Employee::create([
            'user_id' => $user->id,
            'department_id' => $department->id,
            'designation_id' => $designation->id,
            'employee_code' => 'EMP-001',
            'gender' => 'male',
            'address' => 'Karanganyar',
            'salary' => 3500000,
            'join_date' => '2022-01-01',
            'exit_date' => null
        ]);
    }
}
