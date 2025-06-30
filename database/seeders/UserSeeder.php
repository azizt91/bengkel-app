<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '0800000000',
            ]
        );
        $admin->assignRole('admin');

        // Technician
        $tech = User::firstOrCreate(
            ['email' => 'tech@example.com'],
            [
                'name' => 'Technician User',
                'password' => Hash::make('password'),
                'role' => 'teknisi',
                'phone' => '0800000001',
            ]
        );
        $tech->assignRole('teknisi');

        Technician::firstOrCreate([
            'user_id' => $tech->id,
        ], [
            'employee_id' => 'EMP001',
            'specialization' => 'General Service',
            'experience_years' => 3,
            'hire_date' => now()->subYears(1),
            'is_available' => true,
        ]);

        // Customer
        $customerUser = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Customer User',
                'password' => Hash::make('password'),
                'role' => 'pelanggan',
                'phone' => '0800000002',
            ]
        );
        $customerUser->assignRole('pelanggan');

        Customer::firstOrCreate([
            'user_id' => $customerUser->id,
        ], [
            'customer_code' => 'CUST'.Str::random(4),
            'birth_date' => now()->subYears(25),
            'gender' => 'male',
        ]);
    }
}
