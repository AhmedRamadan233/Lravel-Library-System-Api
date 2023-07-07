<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run()
    // {
    //     $permissions = [
    //         'add-admin',
    //         'remove-admin',
    //         'monitor-system-data',
    //         'update-system-data',
    //         'manage-admins',
    //         'manage-employees',
    //         'manage-books',
    //         'manage-members',
    //         'view-system-data',
    //         'generate-reports',
    //         'view-profile',
    //         'update-profile',
    //         'search-employees',
    //         'add-member',
    //         'list-members',
    //         'search-members',
    //         'list-books',
    //         'search-books',
    //         'borrow-books',
    //         'give-books-for-reading',
    //         'return-borrowed-books',
    //         'view-late-returns',
    //         'list-reading-books',
    //         'filter-reading-books',
    //         'list-borrowed-books',
    //         'filter-borrowed-books',
    //         'view-new-arrived-books',
    //         'view-borrowed-books',
    //         'search-available-books',
    //         'view-new-arrived-books-stats',
    //     ];

    //     // Create permissions
    //     foreach ($permissions as $permissionName) {
    //         Permission::create(['name' => $permissionName, 'guard_name' => 'web']);
    //     }

    //     // Create role and assign permissions
    //     $role = Role::firstOrCreate(['name' => 'super admin', 'guard_name' => 'web']);
    //     $permissions = Permission::whereIn('name', $permissions)->get();
    //     $role->syncPermissions($permissions);
    // }



    public function run()
{
    $permissions = [
        'add-admin',
        'remove-admin',
        'monitor-system-data',
        'update-system-data',
        'manage-admins',
        'manage-employees',
        'manage-books',
        'manage-members',
        'view-system-data',
        'generate-reports',
        'view-profile',
        'update-profile',
        'search-employees',
        'add-member',
        'list-members',
        'search-members',
        'list-books',
        'search-books',
        'borrow-books',
        'give-books-for-reading',
        'return-borrowed-books',
        'view-late-returns',
    ];

    // Create permissions
    foreach ($permissions as $permissionName) {
        Permission::create(['name' => $permissionName, 'guard_name' => 'web']);
    }

    // Assign permissions to roles
    $roles = [
        'super admin' => [
            'add-admin',
            'remove-admin',
            'monitor-system-data',
            'update-system-data',
            'manage-admins',
            'manage-employees',
            'manage-books',
            'manage-members',
            'view-system-data',
            'generate-reports',
        ],
        'admin' => [
            'manage-employees',
            'view-profile',
            'update-profile',
            'search-employees',
            'manage-books',
            'view-system-data',
        ],
        'employee' => [
            'add-member',
            'view-profile',
            'update-profile',
            'list-members',
            'manage-members',
            'search-members',
            'list-books',
            'search-books',
            'borrow-books',
            'give-books-for-reading',
            'return-borrowed-books',
            'view-late-returns',
        ],
    ];

    // Assign permissions to roles
    foreach ($roles as $roleName => $rolePermissions) {
        $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        $permissions = Permission::whereIn('name', $rolePermissions)->get();
        $role->syncPermissions($permissions);
    }
}

}


