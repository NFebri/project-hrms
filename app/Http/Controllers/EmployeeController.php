<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:employees-view', ['only' => ['index','show']]);
        $this->middleware('permission:employees-create', ['only' => ['create','store']]);
        $this->middleware('permission:employees-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:employees-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('employees.index', [
            'employees' => Employee::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.create', [
            'departments' => Department::all(),
            'designations' => Designation::all(),
            'roles' => Role::pluck('name','name')->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_code' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'gender' => 'required',
            'department_id' => 'required',
            'designation_id' => 'required',
            'role' => 'required',
            'address' => 'required',
            'join_date' => 'required',
            'salary' => 'required|numeric',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->assignRole($request->role);

        Employee::create([
            'user_id' => $user->id,
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
            'employee_code' => $request->employee_code,
            'gender' => $request->gender,
            'address' => $request->address,
            'salary' => $request->salary,
            'join_date' => $request->join_date,
            'exit_date' => $request->exit_date
        ]);

        return redirect()->route('employees.index')
            ->with('success', __('Employee was created!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit', [
            'employee' => $employee,
            'departments' => Department::all(),
            'designations' => Designation::all(),
            'user_role' => $employee->user->roles->pluck('name','name')->first(),
            'roles' => Role::pluck('name','name')->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'employee_code' => 'required',
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'department_id' => 'required',
            'designation_id' => 'required',
            'role' => 'required',
            'address' => 'required',
            'join_date' => 'required',
            'salary' => 'required|numeric',
        ]);

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

        return redirect()->route('employees.index')
            ->with('success', __('Employee was updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $user = $employee->user;

        $employee->delete();

        $user->delete();

        return redirect()->route('employees.index')
            ->with('success', __('Employee was deleted!'));
    }
}
