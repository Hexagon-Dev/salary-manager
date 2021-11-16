<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit']);
        Permission::create(['name' => 'delete']);
        Permission::create(['name' => 'view']);
        Permission::create(['name' => 'create']);

        Permission::create(['name' => 'users']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'user']);
        $role1->givePermissionTo('view entry');
        $role1->givePermissionTo('create entry');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('view entry');
        $role2->givePermissionTo('create entry');
        $role2->givePermissionTo('edit entry');

        $role3 = Role::create(['name' => 'super-admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        $user = User::factory()->create([
            'login' => 'User',
            'email' => 'test@example.com',
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'login' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        $user->assignRole($role2);

        $user = User::factory()->create([
            'login' => 'SuperAdmin',
            'email' => 'superadmin@example.com',
        ]);
        $user->assignRole($role3);
    }
}
