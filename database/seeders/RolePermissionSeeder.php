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
            // Permissin and roles
            'manage roles',
            'manage permissions',
            // System config permissions
            'manage system settings',

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // create roles and assign created permissions
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        // Create default user
        DB::table('users')->insert([
            'firstname' => 'Kelvin',
            'lastname' => 'Murithi',
            'username' => 'kelvmuriuki',
            'phone' => '0729366601',
            'email' => 'kelvmuriuki@gmail.com',
            'password' => bcrypt('kelv1991'),
        ]);
        $user = User::first();
        $user->assignRole('super-admin');
        
    }
}
