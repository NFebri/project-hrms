<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:roles-permissions-view', ['only' => ['index','show']]);
        $this->middleware('permission:roles-permissions-create', ['only' => ['create','store']]);
        $this->middleware('permission:roles-permissions-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:roles-permissions-delete', ['only' => ['destroy']]);

        $this->permissions_groups = [
            'department' => [
                'name' => __('Departments'),
                'permissions' => ['departments-view', 'departments-create', 'departments-edit', 'departments-delete']
            ],
            'designation' => [
                'name' => __('Designations'),
                'permissions' => ['designations-view', 'designations-create', 'designations-edit', 'designations-delete']
            ],
            'employee' => [
                'name' => __('Employees'),
                'permissions' => ['employees-view', 'employees-create', 'employees-edit', 'employees-delete']
            ],
            'holiday' => [
                'name' => __('Holidays'),
                'permissions' => ['holidays-view', 'holidays-create', 'holidays-edit', 'holidays-delete']
            ],
            'leave' => [
                'name' => __('Leaves'),
                'permissions' => ['leaves-view', 'leaves-create', 'leaves-approve-reject']
            ],
            'role' => [
                'name' => __('Roles Permissions'),
                'permissions' => ['roles-permissions-view', 'roles-permissions-create', 'roles-permissions-edit', 'roles-permissions-delete']
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
            $roles = Role::all();

            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return '
                    <a href="' . route("roles-permissions.edit", $row->id) . '" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="{{ __("Edit") }}">
                        <i class="fas fa-pen"></i>
                    </a>

                    <form class="d-inline" action="' . route("roles-permissions.destroy", $row->id) . '" method="POST" onsubmit="return confirm(\'Are you sure?\')">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="{{ __("Delete") }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
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
