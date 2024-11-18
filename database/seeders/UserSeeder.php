<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create default roles
        $superadminRole = Role::create(['name' => 'superadmin', 'guard_name' => 'web']);

        // create default permissions and assign to role
        $superadminPermission = [
            'manage web identity',
            'manage user',
            'all activities',
            'manage role',
        ];

        foreach ($superadminPermission as $permit) {
            $permit = Permission::create(['name' => $permit, 'guard_name' => 'web']);
            $superadminRole->givePermissionTo($permit);
        }

        // create default accounts
        $superadmin = User::factory()->create([
            'name' => 'Administrator',
            'email' => 'superadmin@pratama.net'
        ]);
        $superadmin->assignRole('superadmin');
    }
}
