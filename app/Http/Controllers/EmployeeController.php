<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\User;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    private $employeeService;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        // initialize service
        $this->employeeService = new EmployeeService();
        // initialze middleware
        $this->middleware('permission:employees-list', ['only' => ['index','show']]);
        $this->middleware('permission:employees-create', ['only' => ['create','store']]);
        $this->middleware('permission:employees-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:employees-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->employeeService->getDatatables();
        }
        return view('employees.index');
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
    public function store(EmployeeRequest $request)
    {
        $this->employeeService->createNewEmployee($request);

        return to_route('employees.index')
            ->withSuccess(__('Employee was created!'));
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
    public function update(EmployeeRequest $request, Employee $employee)
    {
        $this->employeeService->updateEmployee($request, $employee);

        return to_route('employees.index')
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
