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
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

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

        $all_tables_role = Role::create(['name' => 'all_tables']);

        foreach ($tables as $table) {
            Permission::create(['name' => $table]);
        }

        $all_tables_role->givePermissionTo($tables);

        // create roles and assign existing permissions
        $guest_role = Role::create(['name' => 'guest']);

        $user_role = Role::create(['name' => 'user']);
        $user_role->givePermissionTo([
            'user',
            'read',
            'create'
        ]);

        $admin_role = Role::create(['name' => 'admin']);
        $admin_role->givePermissionTo([
            'user',
            'absence',
            'read',
            'create',
            'update'
        ]);

        $super_admin_role = Role::create(['name' => 'super-admin']);
        $super_admin_role->givePermissionTo([
            'user',
            'absence',
            'company',
            'read',
            'create',
            'update',
            'delete'
        ]);

        $user = User::factory()->create([
            'login' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => 'superadmin',
        ]);
        $user->assignRole($super_admin_role);
        $user->assignRole($all_tables_role);

        $user = User::factory()->create([
            'login' => 'guest',
            'email' => 'guest@example.com',
            'password' => 'guest',
        ]);
        $user->assignRole($guest_role);

        $user = User::factory()->create([
            'login' => 'user',
            'email' => 'user@example.com',
            'password' => 'user',
        ]);
        $user->assignRole($user_role);

        $user = User::factory()->create([
            'login' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'admin',
        ]);
        $user->assignRole($admin_role);
    }
}
