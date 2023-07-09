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
    'list-superAdmin',
    'add-superAdmin',
    'update-superAdmin',
    'delete-superAdmin',
    'list-admin',
    'add-admin',
    'update-admin',
    'delete-admin',
    'list-employee',
    'add-employee',
    'update-employee',
    'delete-employee',
    'list-book',
    'add-book',
    'update-book',
    'delete-book',
    'list-category',
    'add-category',
    'update-category',
    'delete-category',
    'list-member',
    'add-member',
    'update-member',
    'delete-member',
    'list-author',
    'add-author',
    'update-author',
    'delete-author',
    'role-list',
    'role-create',
    'role-edit',
    'role-delete',
];

    // Create permissions
    foreach ($permissions as $permissionName) {
        Permission::create(['name' => $permissionName, 'guard_name' => 'web']);
    }

    // Assign permissions to roles
    $roles = [
        'super admin' => [
            'list-superAdmin',
            'add-superAdmin',
            'update-superAdmin',
            'delete-superAdmin',
            'list-admin',
            'add-admin',
            'update-admin',
            'delete-admin',
            'list-employee',
            'add-employee',
            'update-employee',
            'delete-employee',
            'list-book',
            'add-book',
            'update-book',
            'delete-book',
            'list-category',
            'add-category',
            'update-category',
            'delete-category',
            'list-member',
            'add-member',
            'update-member',
            'delete-member',
            'list-author',
            'add-author',
            'update-author',
            'delete-author',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
        ],
        'admin' => [
            'list-admin',
            'add-admin',
            'update-admin',
            'list-employee',
            'add-employee',
            'update-employee',
            'delete-employee',
            'list-book',
            'add-book',
            'update-book',
            'delete-book',
            'list-category',
            'add-category',
            'update-category',
            'delete-category',
            'list-member',
            'add-member',
            'update-member',
            'delete-member',
            'list-author',
            'add-author',
            'update-author',
            'delete-author',
        ],
        
        'employee' => [
            'list-employee',
            'add-employee',
            'update-employee',
            'list-book',
            'add-book',
            'update-book',
            'delete-book',
            'list-category',
            'add-category',
            'update-category',
            'delete-category',
            'list-member',
            'add-member',
            'update-member',
            'delete-member',
            'list-author',
            'add-author',
            'update-author',
            'delete-author',
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


