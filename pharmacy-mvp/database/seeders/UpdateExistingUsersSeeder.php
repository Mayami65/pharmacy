<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UpdateExistingUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update any existing users without roles to be managers
        User::whereNull('role')->orWhere('role', '')->update([
            'role' => 'manager',
            'is_active' => true,
        ]);

        $this->command->info('Updated existing users with default manager role');
    }
}
