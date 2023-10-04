<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $adminRole = Role::create(['name' => 'Admin']);
        $professionalRole = Role::create(['name' => 'Professional']);
        $RegularUserRole = Role::create(['name' => 'Regular User']);
        
        $editPersonalData = Permission::create(['name' => 'editPersonalData']);
        $editPhoneNumber = Permission::create(['name' => 'editPhoneNumber']);
        $editPassword = Permission::create(['name' => 'editPassword']);

        $newService = Permission::create(['name' => 'newService']);
        $editService = Permission::create(['name' => 'editService']);
        $deleteService = Permission::create(['name' => 'deleteService']);

        $createOrder = Permission::create(['name' => 'createOrder']);
        $editOrder = Permission::create(['name' => 'editOrder']);
        $deleteOrder = Permission::create(['name' => 'deleteOrder']);

        $createContract = Permission::create(['name' => 'createContract']);

        $createCategories = Permission::create(['name' => 'createCategories']);
        $editCategories = Permission::create(['name' => 'editCategories']);
        $deleteCategories = Permission::create(['name' => 'deleteCategories']);

       /* $professionalRole->givePermisssionTo([
            'newService',
            'editService',
            'deleteService',
            'editPersonalData',
            'editPhoneNumber',
            'editPassword',
        ]);

        $RegularUserRole->givePermisssionTo([
            'editPersonalData',
            'editPhoneNumber',
            'editPassword',
        ]);

        $adminRole->givePermisssionTo([
            'createCategories',
            'editCategories',
            'deleteCategories',
        ]);*/
    }
}
