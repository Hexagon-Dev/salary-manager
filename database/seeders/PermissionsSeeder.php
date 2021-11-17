<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Basic permissions
        Permission::create(['name' => 'create']);
        Permission::create(['name' => 'read']);
        Permission::create(['name' => 'update']);
        Permission::create(['name' => 'delete']);


        // Table access permissions
        $tables = [
            'user',
            'absence',
            'skill',
            'company',
            'salary',
            'currency',
            'currency_record',
            'note',
            'role',
            'permission',
            ];

        foreach ($tables as $table) {
            Permission::create(['name' => $table]);
        }

        // create roles and assign existing permissions
        $user_role = Role::create(['name' => 'user']);
        $user_role->givePermissionTo(['user', 'read', 'create']);

        $admin_role = Role::create(['name' => 'admin']);
        $admin_role->givePermissionTo(['user', 'absence', 'read', 'create', 'update']);

        $super_admin_role = Role::create(['name' => 'super-admin']);
        $super_admin_role->givePermissionTo(['user', 'absence', 'read', 'create', 'update', 'delete']);

        $user = User::factory()->create([
            'login' => 'user',
            'email' => 'user@example.com',
            'password' => Hash::make('user'),
        ]);
        $user->assignRole($user_role);

        $user = User::factory()->create([
            'login' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole($admin_role);

        $user = User::factory()->create([
            'login' => 'super-admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('super-admin'),
        ]);
        $user->assignRole($super_admin_role);
    }
}
