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

            'calendar_access',

            'reservation_create',
            'reservation_edit',
            'reservation_delete',
            'reservation_access',

            'document_access',
            'document_edit',
            'document_delete',
            
            'receipt_create',
            'receipt_edit',
            'receipt_delete',
            'receipt_access',

            'location_create',
            'location_edit',
            'location_delete',
            'location_access',

            'invoice_access',
            'invoice_create',
            'invoice_edit',
            'invoice_delete',

            'report_access',
            'report_create',
            'report_edit',
            'report_delete',

            'user_create',
            'user_edit',
            'user_delete',
            'user_access',

            'permission_create',
            'permission_edit',
            'permission_delete',
            'permission_access',
            'role_create',
            'role_edit',
            'role_delete',
            'role_access',
        ];

        foreach ($permissions as $permission)   {
            Permission::create([
                'name' => $permission
            ]);
        }

        // gets all permissions via Gate::before rule; see AuthServiceProvider
        Role::updateOrCreate(['name' => 'Super Admin']);
        $admin = User::where('email', 'kane@admin.com')->first();
        $admin->assignRole('Super Admin');

        
        $bookepper_role = Role::updateOrCreate(['name' => 'bookepper']);

        $bookepper = User::where('email', 'honeybeb@admin.com')->withTrashed()->first();
        $bookepper->givePermissionTo(['report_access']);
        $bookepper->assignRole('bookepper');

        $business_admin_role = Role::updateOrCreate(['name' => 'business administrator']);
        $business_ad = User::where('email', 'rose@admin.com')->withTrashed()->first();
        $business_ad->givePermissionTo([
            'calendar_access',

            'reservation_access',
            'reservation_create',

            'receipt_access',
            'receipt_create',
            
            'location_access',
            'location_create',

            'invoice_access',
            'invoice_create',
        ]);
        $business_ad->assignRole('business administrator');

        $roles = [
            ['name' => 'sales manager'],
            ['name' => 'sales agent'],
            ['name' => 'buyer'],
        ];

        foreach ($roles as $new_role) {
            Role::updateOrCreate($new_role);
        }

        $this->updateBuyersRole();
    }

    protected function updateBuyersRole()
    {
        $buyers = User::doesntHave('roles')->get();

        foreach ($buyers as $buyer) {
            $buyer->assignRole('buyer');
        }
    }
}