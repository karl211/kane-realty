<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class="Database\\Seeders\\PermissionSeeder"

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'dashboard_access',
            'user_management_access',
            'permission_create',
            'permission_edit',
            'permission_show',
            'permission_delete',
            'permission_access',
            'role_create',
            'role_edit',
            'role_show',
            'role_delete',
            'role_access',
            'user_create',
            'user_edit',
            'user_show',
            'user_delete',
            'user_access',
            'calendar_create',
            'calendar_show',
            'calendar_access',
            'reservation_create',
            'reservation_edit',
            'reservation_show',
            'reservation_delete',
            'reservation_access',
            'receipt_create',
            'receipt_edit',
            'receipt_show',
            'receipt_delete',
            'receipt_access',
            'location_create',
            'location_edit',
            'location_show',
            'location_delete',
            'location_access',
            'invoice_access',
            'invoice_create',
            'invoice_show',
            'invoice_edit',
            'invoice_delete',
            'report_access',
            'report_create',
            'report_show',
            'report_edit',
            'report_delete',
        ];

        foreach ($permissions as $permission)   {
            Permission::create([
                'name' => $permission
            ]);
        }

        // gets all permissions via Gate::before rule; see AuthServiceProvider
        Role::create(['name' => 'Super Admin']);
        $admin = User::where('email', 'kane@admin.com')->first();
        $admin->assignRole('Super Admin');

        
        $bookepper_role = Role::create(['name' => 'bookepper']);

        $bookepper = User::where('email', 'honeybeb@admin.com')->first();
        $bookepper->givePermissionTo(['report_access', 'report_show']);
        $bookepper->assignRole('bookepper');

        $business_admin_role = Role::create(['name' => 'business administrator']);
        $business_ad = User::where('email', 'rose@admin.com')->first();
        $business_ad->givePermissionTo([
            'calendar_access',
            'calendar_create',
            'calendar_show',

            'reservation_access',
            'reservation_create',
            'reservation_show',

            'receipt_access',
            'receipt_create',
            'receipt_show',
            
            'location_access',
            'location_create',
            'location_show',

            'invoice_access',
            'invoice_create',
            'invoice_show',
        ]);
        $business_ad->assignRole('business administrator');

        $roles = [
            ['name' => 'sales manager'],
            ['name' => 'sales agent'],
            ['name' => 'buyer'],
        ];

        foreach ($roles as $new_role) {
            Role::create($new_role);
        }
    }
}