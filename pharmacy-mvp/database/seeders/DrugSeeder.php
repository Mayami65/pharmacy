<?php

namespace Database\Seeders;

use App\Models\Drug;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DrugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drugs = [
            [
                'name' => 'Paracetamol 500mg',
                'description' => 'Pain reliever and fever reducer',
                'quantity' => 150,
                'unit_price' => 2.50,
                'expiry_date' => now()->addMonths(6),
                'low_stock_threshold' => 20,
                'batch_number' => 'PC2024001',
                'manufacturer' => 'PharmaCorp Ltd'
            ],
            [
                'name' => 'Amoxicillin 250mg',
                'description' => 'Antibiotic for bacterial infections',
                'quantity' => 8, // Low stock
                'unit_price' => 5.75,
                'expiry_date' => now()->addMonths(8),
                'low_stock_threshold' => 15,
                'batch_number' => 'AMX2024002',
                'manufacturer' => 'MediGen Inc'
            ],
            [
                'name' => 'Ibuprofen 400mg',
                'description' => 'Anti-inflammatory pain reliever',
                'quantity' => 75,
                'unit_price' => 3.25,
                'expiry_date' => now()->addDays(20), // Expiring soon
                'low_stock_threshold' => 10,
                'batch_number' => 'IBU2024003',
                'manufacturer' => 'HealthPlus'
            ],
            [
                'name' => 'Aspirin 75mg',
                'description' => 'Blood thinner and pain reliever',
                'quantity' => 200,
                'unit_price' => 1.80,
                'expiry_date' => now()->subDays(10), // Expired
                'low_stock_threshold' => 25,
                'batch_number' => 'ASP2023012',
                'manufacturer' => 'CardioMed'
            ],
            [
                'name' => 'Vitamin D3 1000IU',
                'description' => 'Vitamin D supplement',
                'quantity' => 120,
                'unit_price' => 4.50,
                'expiry_date' => now()->addYear(),
                'low_stock_threshold' => 15,
                'batch_number' => 'VD32024004',
                'manufacturer' => 'NutriVita'
            ],
            [
                'name' => 'Omeprazole 20mg',
                'description' => 'Proton pump inhibitor for acid reflux',
                'quantity' => 5, // Low stock
                'unit_price' => 8.90,
                'expiry_date' => now()->addMonths(4),
                'low_stock_threshold' => 12,
                'batch_number' => 'OME2024005',
                'manufacturer' => 'GastroTech'
            ],
            [
                'name' => 'Metformin 500mg',
                'description' => 'Diabetes medication',
                'quantity' => 90,
                'unit_price' => 6.25,
                'expiry_date' => now()->addMonths(10),
                'low_stock_threshold' => 20,
                'batch_number' => 'MET2024006',
                'manufacturer' => 'DiabetesGuard'
            ],
            [
                'name' => 'Cetirizine 10mg',
                'description' => 'Antihistamine for allergies',
                'quantity' => 3, // Low stock
                'unit_price' => 3.75,
                'expiry_date' => now()->addDays(25), // Expiring soon
                'low_stock_threshold' => 10,
                'batch_number' => 'CET2024007',
                'manufacturer' => 'AllergyFree'
            ],
            [
                'name' => 'Atorvastatin 20mg',
                'description' => 'Cholesterol-lowering medication',
                'quantity' => 65,
                'unit_price' => 12.40,
                'expiry_date' => now()->addMonths(7),
                'low_stock_threshold' => 15,
                'batch_number' => 'ATO2024008',
                'manufacturer' => 'CardioHealth'
            ],
            [
                'name' => 'Cough Syrup 100ml',
                'description' => 'Dextromethorphan-based cough suppressant',
                'quantity' => 45,
                'unit_price' => 7.80,
                'expiry_date' => now()->subDays(5), // Expired
                'low_stock_threshold' => 8,
                'batch_number' => 'CS2023015',
                'manufacturer' => 'RespiCare'
            ]
        ];

        foreach ($drugs as $drug) {
            Drug::create($drug);
        }
    }
}
