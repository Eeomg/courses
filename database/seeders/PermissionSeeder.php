<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = ['roles','categories','users'];
        foreach ($permissions as $permission) {
            $createRoles[] = ['name' => $permission.'-create', 'guard_name'=> 'web'];
            $showRoles[]   = ['name' => $permission.'-show'  , 'guard_name'=> 'web'];
            $updateRoles[] = ['name' => $permission.'-update', 'guard_name'=> 'web'];
            $deleteRoles[] = ['name' => $permission.'-delete', 'guard_name'=> 'web'];
        }

        Permission::insert($createRoles);
        Permission::insert($showRoles);
        Permission::insert($updateRoles);
        Permission::insert($deleteRoles);
    }
}
