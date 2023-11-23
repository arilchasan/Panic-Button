<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
            $role_admin = Role::create(['name' => 'admin' , 'guard_name' => 'admin']);
            $role_superadmin = Role::create(['name' => 'superadmin' , 'guard_name' => 'admin']);

            $admin = Admin::create(array_merge([
                'name' => 'admin',
                'password' => Hash::make('admin123'),
                'role_id' => 1
            ]));
            $superadmin = Admin::create(array_merge([
                'name' => 'superadmin',
                'password' => Hash::make('superadmin123'),
                'role_id' => 2
            ]));


            $permission1 = Permission::create(['name' => 'create data' , 'guard_name' => 'admin']);
            $permission2 = Permission::create(['name' => 'update data' , 'guard_name' => 'admin']);
            $permission3 = Permission::create(['name' => 'read data' , 'guard_name' => 'admin']);
            $permission4 = Permission::create(['name' => 'delete data'   , 'guard_name' => 'admin']);
            $permission_admin = Permission::create(['name' => 'list users'   , 'guard_name' => 'admin']);

            $admin->assignRole($role_admin);
            $superadmin->assignRole($role_superadmin);
            $role_admin->givePermissionTo($permission_admin);
            $role_superadmin->givePermissionTo($permission1 ,  $permission2 , $permission3 , $permission4);
    }
}
