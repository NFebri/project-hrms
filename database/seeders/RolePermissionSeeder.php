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
            'employees-view',
            'employees-create',
            'employees-edit',
            'employees-delete',
            'departments-view',
            'departments-create',
            'departments-edit',
            'departments-delete',
            'roles-permissions-view',
            'roles-permissions-create',
            'roles-permissions-edit',
            'roles-permissions-delete',
            'designations-view',
            'designations-create',
            'designations-edit',
            'designations-delete',
            'holidays-view',
            'holidays-create',
            'holidays-edit',
            'holidays-delete',
            'attendance-view',
            'leaves-view',
            'leaves-create',
            'leaves-approve-reject',
        ];

        // create permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        //create roles and assign existing permissions
        $admin_role = Role::create(['name' => 'admin']);
        $employee_role = Role::create(['name' => 'employee']);

        $admin_role->syncPermissions(Permission::pluck('id','id')->all());

        $employee_role->givePermissionTo([
            'holidays-view',
            'attendance-view',
            'leaves-view',
            'leaves-create',
        ]);

        User::find(1)->assignRole([$admin_role->id]);

        User::find(2)->assignRole([$employee_role->id]);
    }
}
