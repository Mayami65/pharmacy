<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default manager if no managers exist
        if (User::where('role', 'manager')->count() === 0) {
            User::create([
                'name' => 'Pharmacy Manager',
                'email' => 'manager@pharmacy.com',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'is_active' => true,
                'phone' => '+233 20 123 4567',
                'address' => '123 Main Street, Accra, Ghana',
                'email_verified_at' => now(),
            ]);

            $this->command->info('Default manager created: manager@pharmacy.com / password');
        }

        // Create default pharmacist if no users exist
        if (User::count() === 0) {
            User::create([
                'name' => 'Pharmacist',
                'email' => 'pharmacist@pharmacy.com',
                'password' => Hash::make('password'),
                'role' => 'pharmacist',
                'is_active' => true,
                'phone' => '+233 20 123 4568',
                'address' => '123 Main Street, Accra, Ghana',
                'email_verified_at' => now(),
            ]);

            $this->command->info('Default pharmacist created: pharmacist@pharmacy.com / password');
        }
    }
}
