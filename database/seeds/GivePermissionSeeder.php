<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class GivePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $staff = Role::where('name', 'Staff')->first();
        $permission = Permission::where('name','!=','users.destroy')->get();

        $staff->syncPermissions($permission);
    }
}
