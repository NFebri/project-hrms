<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cahced roles and permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            ['name' => 'employees-list', 'guard_name' => 'web', 'general_name' => 'View the list of employees'],
            ['name' => 'employees-create', 'guard_name' => 'web', 'general_name' => 'Create employees'],
            ['name' => 'employees-edit', 'guard_name' => 'web', 'general_name' => 'Edit employees'],
            ['name' => 'employees-delete', 'guard_name' => 'web', 'general_name' => 'Delete employees'],
            ['name' => 'departments-list', 'guard_name' => 'web', 'general_name' => 'View the list of departments'],
            ['name' => 'departments-create', 'guard_name' => 'web', 'general_name' => 'Create departments'],
            ['name' => 'departments-edit', 'guard_name' => 'web', 'general_name' => 'Edit departments'],
            ['name' => 'departments-delete', 'guard_name' => 'web', 'general_name' => 'Delete departments'],
            ['name' => 'roles-list', 'guard_name' => 'web', 'general_name' => 'View the list of roles'],
            ['name' => 'roles-create', 'guard_name' => 'web', 'general_name' => 'Create roles'],
            ['name' => 'roles-edit', 'guard_name' => 'web', 'general_name' => 'Edit roles'],
            ['name' => 'roles-delete', 'guard_name' => 'web', 'general_name' => 'Delete roles'],
            ['name' => 'designations-list', 'guard_name' => 'web', 'general_name' => 'View the list of designations'],
            ['name' => 'designations-create', 'guard_name' => 'web', 'general_name' => 'Create designations'],
            ['name' => 'designations-edit', 'guard_name' => 'web', 'general_name' => 'Edit designations'],
            ['name' => 'designations-delete', 'guard_name' => 'web', 'general_name' => 'Delete designations'],
            ['name' => 'holidays-list', 'guard_name' => 'web', 'general_name' => 'View the list of holidays'],
            ['name' => 'holidays-create', 'guard_name' => 'web', 'general_name' => 'Create holidays'],
            ['name' => 'holidays-edit', 'guard_name' => 'web', 'general_name' => 'Edit holidays'],
            ['name' => 'holidays-delete', 'guard_name' => 'web', 'general_name' => 'Delete holidays'],
            ['name' => 'attendance-list', 'guard_name' => 'web', 'general_name' => 'View the list of Attendances'],
            ['name' => 'attendance-setting', 'guard_name' => 'web', 'general_name' => 'Setting attendance'],
            ['name' => 'leaves-list', 'guard_name' => 'web', 'general_name' => 'View the list of leaves'],
            ['name' => 'leaves-create', 'guard_name' => 'web', 'general_name' => 'Create leaves'],
            ['name' => 'leaves-approve-reject', 'guard_name' => 'web', 'general_name' => 'Approve or reject leaves'],
        ];

        // create permissions
        Permission::insert($permissions);

        //create roles and assign existing permissions
        $admin_role = Role::create(['name' => 'admin']);
        $employee_role = Role::create(['name' => 'employee']);

        $admin_role->syncPermissions(Permission::pluck('id','id')->all());

        $employee_role->givePermissionTo([
            'holidays-list',
            'attendance-list',
            'leaves-list',
            'leaves-create',
        ]);

        User::find(1)->assignRole([$admin_role->id]);

        User::find(2)->assignRole([$employee_role->id]);
    }
}
