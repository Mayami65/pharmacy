<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test admin user
        User::factory()->create([
            'name' => 'Pharmacy Admin',
            'email' => 'admin@ikehorn.com',
        ]);

        // Seed drug data
        $this->call([
            DrugSeeder::class,
        ]);
    }
}
