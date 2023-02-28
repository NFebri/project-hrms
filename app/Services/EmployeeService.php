<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class EmployeeService
{
    public function getDatatables()
    {
        $employees = Employee::all();

        return DataTables::of($employees)
            ->addIndexColumn()
            ->addColumn('name', function($row) {
                return $row->user->name;
            })
            ->addColumn('action', function($row) {
                $action = '';
                if (auth()->user()->can('employees-edit')) {
                    $action .= '
                    <a href="' . route("employees.edit", $row->id) . '" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="{{ __("Edit") }}">
                        <i class="fas fa-pen"></i>
                    </a>';
                }

                if (auth()->user()->can('employees-delete')) {
                    $action .= '
                    <form class="d-inline" action="' . route("employees.destroy", $row->id) . '" method="POST" onsubmit="return confirm(\'Are you sure?\')">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="{{ __("Delete") }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    ';
                }

                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function createNewEmployee($request)
    {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
    
            $user->assignRole($request->role);
    
            $user->employee()->create($request->all());

            return $user;
    }

    public function updateEmployee($request, $employee)
    {
        try {
            $employee->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $employee->user->password
            ]);
    
            $employee->user->syncRoles($request->role);
    
            $employee->update([
                'department_id' => $request->department_id,
                'designation_id' => $request->designation_id,
                'employee_code' => $request->employee_code,
                'gender' => $request->gender,
                'address' => $request->address,
                'salary' => $request->salary,
                'join_date' => $request->join_date,
                'exit_date' => $request->exit_date
            ]);

            return $employee;
        } catch (\Throwable $th) {
            Log::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
            throw abort(500);
        }
    }
}