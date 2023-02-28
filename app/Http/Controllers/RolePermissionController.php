<?php

namespace App\Http\Controllers;

use App\Services\RolePermissionService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class RolePermissionController extends Controller
{
    private $permissions_groups, $rolePermissionService;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->rolePermissionService = new RolePermissionService();
        $this->middleware('permission:roles-list', ['only' => ['index','show']]);
        $this->middleware('permission:roles-create', ['only' => ['create','store']]);
        $this->middleware('permission:roles-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:roles-delete', ['only' => ['destroy']]);

        $this->permissions_groups = [
            'department' => [
                'name' => __('Departments'),
                'permissions' => ['departments-list', 'departments-create', 'departments-edit', 'departments-delete']
            ],
            'designation' => [
                'name' => __('Designations'),
                'permissions' => ['designations-list', 'designations-create', 'designations-edit', 'designations-delete']
            ],
            'employee' => [
                'name' => __('Employees'),
                'permissions' => ['employees-list', 'employees-create', 'employees-edit', 'employees-delete']
            ],
            'holiday' => [
                'name' => __('Holidays'),
                'permissions' => ['holidays-list', 'holidays-create', 'holidays-edit', 'holidays-delete']
            ],
            
            'attendance' => [
                'name' => __('Attendace'),
                'permissions' => ['attendance-list']
            ],
            'leave' => [
                'name' => __('Leaves'),
                'permissions' => ['leaves-list', 'leaves-create', 'leaves-approve-reject']
            ],
            'role' => [
                'name' => __('Roles Permissions'),
                'permissions' => ['roles-list', 'roles-create', 'roles-edit', 'roles-delete']
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->rolePermissionService->getDatatables();
        }

        return view('roles-permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles-permissions.create',[
            'permissions' => Permission::all(),
            'permissions_groups' => $this->permissions_groups
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
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles-permissions.index')
            ->with('success',__('Roles Permissions was created!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        return view('roles-permissions.edit',[
            'role' => $role,
            'permissions' => Permission::all(),
            'rolePermissions' => $role->permissions->pluck('id')->toArray(),
            'permissions_groups' => $this->permissions_groups
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('roles-permissions.index')
            ->with('success', __('Roles Permissions was updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::find($id)->delete();

        return redirect()->route('roles-permissions.index')
            ->with('success', __('Roles Permissions was deleted!'));
    }
}
