<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Clients permissions
            'view clients',
            'create client',
            'update client',
            'delete client',
            'manage pppoe',
            // Services permissions
            // 'view services',
            // 'create services',
            'edit services',
            'refresh services',
            'extend services',
            'block/unblock services',
            'clear MAC address',
            // 'view service statistics',
            // 'live data services',
            'destroy services',
            // leads permissions
            'view leads',
            'create lead',
            'update lead',
            'delete lead',
            'convert lead',
            // Messages permissions
            'view messages',
            'send message',
            'send bulk message',
            // Finance permissions
            'manage finance',
            'view transactions',
            'create report',
            'view financial statistics',
            // Nas permissions
            'manage nas',
            'create nas',
            'update nas',
            'delete nas',
            'configure nas',
            // Network permissions
            'view network',
            'update network',
            // Tarrif permissions
            'view tariffs',
            'create tariff',
            'update tariff',
            'delete tariff',
            // Manage hotspot
            'manage hotspot',
            'create hotspot plan',
            'create hotspot voucher',
            'view hotspot revenue',
            'change hotspot design',
            'change hotspot settings',
            // Admin permissions
            'view admins',
            'create admin',
            'edit admin',
            'delete admin',
            // Permission and roles
            'manage roles',
            'manage permissions',
            // System config permissions
            'manage system settings',
        ];

        foreach ($permissions as $permission) {
            $existingPermission = Permission::where('name', $permission)->first();

            if (!$existingPermission) {
                Permission::create(['name' => $permission]);
            }
        }

        // Create roles and assign created permissions
        $role = Role::where('name', 'super-admin')->where('guard_name', 'web')->first();

        if (!$role) {
            // Create the role if it doesn't exist
            $role = Role::create(['name' => 'super-admin', 'guard_name' => 'web']);
            $role->givePermissionTo(Permission::all());
        }

        // Create default user if not already exists
        if (!User::where('username', 'simple')->exists()) {
            DB::table('users')->insert([
                'firstname' => 'Simple',
                'lastname' => 'ISP',
                'username' => 'simple',
                'phone' => '',
                'email' => '',
                'password' => bcrypt('@simple123!'),
            ]);

            $user = User::first();
            $user->assignRole($role);
        }
    }
}
