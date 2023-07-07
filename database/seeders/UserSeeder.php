<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create Super Admin
        $superAdmin = User::create([
            'first_name' => 'Super',
            'last_name' => 'admin',
            'email' => 'superadmin@superadmin.com',
            'gender' => 'male',
            'hire_date' => now(),
            'salary' => 3500,
            'birth_date' => null,
            'image' => null,
            'password' => Hash::make('password'),
        ]);

        $superAdminRole = Role::where('name', 'super admin')->first();
        $superAdmin->assignRole($superAdminRole);

        // Create Admin
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'gender' => 'male',
            'hire_date' => now(),
            'salary' => 3500,
            'birth_date' => null,
            'image' => null,
            'password' => Hash::make('password'),
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $admin->assignRole($adminRole);

        // Create Employee
        $employee = User::create([
            'first_name' => 'Employee',
            'last_name' => 'employee',
            'email' => 'employee@employee.com',
            'gender' => 'male',
            'hire_date' => now(),
            'salary' => 3500,
            'birth_date' => null,
            'image' => null,
            'password' => Hash::make('password'),
        ]);

        $employeeRole = Role::where('name', 'employee')->first();
        $employee->assignRole($employeeRole);
    }
}
