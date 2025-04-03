<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Role::count() != 0) {
            return;
        }
        $manager = Role::create(['name' => 'manager']);
        $moderator = Role::create(['name' => 'moderator']);

        $deleteTasksPermission = Permission::create(['name' => 'delete tasks']);
        $deleteAnswersPermission = Permission::create(['name' => 'delete answers']);
        $manageRolesPermission = Permission::create(['name' => 'manage roles']);

        $manager->givePermissionTo([$deleteTasksPermission, $deleteAnswersPermission, $manageRolesPermission]);
        $moderator->givePermissionTo([$deleteTasksPermission, $deleteAnswersPermission]);
    }
}
