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
        $role = Role::create(['name' => 'admin']);
        $role->syncPermissions(Permission::pluck('id','id')->all());

        User::find(1)->assignRole([$role->id]);
    }
}
