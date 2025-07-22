<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionSeeder extends Seeder
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

        $superAdmin = User::where('email', 'admin@admin.com')->first();

        $roles = [
            'Super Admin',
            // 'Property Group Admin',
            // 'Property Admin',
            'System Admin',
            'Admin',
            'Staff',
        ];

        foreach ($roles as $role) {
            $has_roles = Role::where(['name'=>$role])->first();
            if(!isset($has_roles)) {
                Role::create(['name' => $role]);
            }
        }

        $superAdmin->syncRoles('Super Admin');

        $permission_array = [
            ['section_name' => 'profile', 'name' => 'profile.updatePhoto'],
            ['section_name' => 'profile', 'name' => 'profile.updateInfo'],
            ['section_name' => 'profile', 'name' => 'profile.updatePassword'],
            ['section_name' => 'profile', 'name' => 'profile.2faAuth'],
            ['section_name' => 'profile', 'name' => 'profile.deactivate'],
            ['section_name' => 'profile', 'name' => 'profile.delete'],

            ['section_name' => 'dashboard', 'name' => 'property.view'],

            ['section_name' => 'admin-dashboard', 'name' => 'admin-dashboard.view'],
            ['section_name' => 'property-dashboard', 'name' => 'property-dashboard.view'],

            ['section_name' => 'media', 'name' => 'media.view'],
            ['section_name' => 'media', 'name' => 'media.create'],
            ['section_name' => 'media', 'name' => 'media.edit'],
            ['section_name' => 'media', 'name' => 'media.delete'],

            ['section_name' => 'backend-user', 'name' => 'backend-user.view'],
            ['section_name' => 'backend-user', 'name' => 'backend-user.create'],
            ['section_name' => 'backend-user', 'name' => 'backend-user.edit'],
            ['section_name' => 'backend-user', 'name' => 'backend-user.delete'],

            ['section_name' => 'roles-permissions', 'name' => 'roles-permissions.view'],
            ['section_name' => 'roles-permissions', 'name' => 'roles-permissions.create'],
            ['section_name' => 'roles-permissions', 'name' => 'roles-permissions.edit'],
            ['section_name' => 'roles-permissions', 'name' => 'roles-permissions.delete'],

            ['section_name' => 'system-setting', 'name' => 'system-setting.view'],
            ['section_name' => 'system-setting', 'name' => 'system-setting.create'],
            ['section_name' => 'system-setting', 'name' => 'system-setting.edit'],
            ['section_name' => 'system-setting', 'name' => 'system-setting.delete'],
            
            ['section_name' => 'product', 'name' => 'product.view'],
            ['section_name' => 'product', 'name' => 'product.create'],
            ['section_name' => 'product', 'name' => 'product.edit'],
            ['section_name' => 'product', 'name' => 'product.delete'],
            //vehicle cms
            // ['section_name' => 'vehicle_cms', 'name' => 'vehicle_cms.view'],
            // ['section_name' => 'vehicle_cms', 'name' => 'vehicle_cms.create'],
            // ['section_name' => 'vehicle_cms', 'name' => 'vehicle_cms.edit'],
            // ['section_name' => 'vehicle_cms', 'name' => 'vehicle_cms.delete'],
            ['section_name' => 'doctor', 'name' => 'doctor.view'],
            ['section_name' => 'doctor', 'name' => 'doctor.create'],
            ['section_name' => 'doctor', 'name' => 'doctor.edit'],
            ['section_name' => 'doctor', 'name' => 'doctor.delete'],
           
            ['section_name' => 'specialization', 'name' => 'specialization.view'],
            ['section_name' => 'specialization', 'name' => 'specialization.create'],
            ['section_name' => 'specialization', 'name' => 'specialization.edit'],
            ['section_name' => 'specialization', 'name' => 'specialization.delete'],

            ['section_name' => 'shedules', 'name' => 'doctorshedule.view'],
            ['section_name' => 'shedules', 'name' => 'doctorshedule.create'],
            ['section_name' => 'shedules', 'name' => 'doctorshedule.edit'],
            ['section_name' => 'shedules', 'name' => 'doctorshedule.delete'],
           

            ['section_name' => 'pharmacy', 'name' => 'pharmacy.view'],
            ['section_name' => 'order', 'name' => 'order.create'],

            ['section_name' => 'appointments', 'name' => 'appointments.view'],
            ['section_name' => 'appointments', 'name' => 'appointments.create'],
            ['section_name' => 'appointments', 'name' => 'appointments.edit'],
            ['section_name' => 'appointments', 'name' => 'appointments.delete'],

            ['section_name' => 'prescription', 'name' => 'prescription.view'],
            ['section_name' => 'prescription', 'name' => 'prescription.create'],
            ['section_name' => 'prescription', 'name' => 'prescription.edit'],
            ['section_name' => 'prescription', 'name' => 'prescription.delete'],

            ['section_name' => 'campaign', 'name' => 'campaign.view'],
            ['section_name' => 'campaign', 'name' => 'campaign.create'],
            ['section_name' => 'campaign', 'name' => 'campaign.edit'],
            ['section_name' => 'campaign', 'name' => 'campaign.delete'],


            ['section_name' => 'employees', 'name' => 'employees.view'],
            ['section_name' => 'employees', 'name' => 'employees.create'],
            ['section_name' => 'employees', 'name' => 'employees.edit'],
            ['section_name' => 'employees', 'name' => 'employees.delete'],

            ['section_name' => 'pharmacy', 'name' => 'pharmacy.view'],
            ['section_name' => 'pharmacy', 'name' => 'pharmacy.create'],
            ['section_name' => 'pharmacy', 'name' => 'pharmacy.edit'],
            ['section_name' => 'pharmacy', 'name' => 'pharmacy.delete'],
            //Newsletter
            //Newsletter
            ['section_name' => 'newsletter', 'name' => 'newsletter.view'],
            ['section_name' => 'newsletter', 'name' => 'newsletter.create'],
            ['section_name' => 'newsletter', 'name' => 'newsletter.edit'],
            ['section_name' => 'newsletter', 'name' => 'newsletter.delete'],

            //Homebanner
            ['section_name' => 'homebanner', 'name' => 'homebanner.view'],
            ['section_name' => 'homebanner', 'name' => 'homebanner.create'],
            ['section_name' => 'homebanner', 'name' => 'homebanner.edit'],
            ['section_name' => 'homebanner', 'name' => 'homebanner.delete'],

            //Advertisements
            ['section_name' => 'advertisements', 'name' => 'advertisements.view'],
            ['section_name' => 'advertisements', 'name' => 'advertisements.create'],
            ['section_name' => 'advertisements', 'name' => 'advertisements.edit'],
            ['section_name' => 'advertisements', 'name' => 'advertisements.delete'],

            //News And Events
            ['section_name' => 'events', 'name' => 'events.view'],
            ['section_name' => 'events', 'name' => 'events.create'],
            ['section_name' => 'events', 'name' => 'events.edit'],
            ['section_name' => 'events', 'name' => 'events.delete'],

            //Customer
            ['section_name' => 'customer', 'name' => 'customer.view'],
            ['section_name' => 'customer', 'name' => 'customer.create'],
            ['section_name' => 'customer', 'name' => 'customer.edit'],
            ['section_name' => 'customer', 'name' => 'customer.delete'],

              //inquiry
              ['section_name' => 'inquiry', 'name' => 'inquiry.view'],
              ['section_name' => 'inquiry', 'name' => 'inquiry.create'],
              ['section_name' => 'inquiry', 'name' => 'inquiry.edit'],
              ['section_name' => 'inquiry', 'name' => 'inquiry.delete'],

        ];

        foreach ($permission_array as $permission) {

            $check_has_permission = Permission::where('name', $permission['name'])->first();
            if (!isset($check_has_permission)) {
                Permission::create($permission);
            }
        }
    }
}