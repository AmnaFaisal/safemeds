<?php

namespace Database\Seeders;

use App\Models\Medication;
use Illuminate\Database\Seeder;

class MedicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medications = [
            [
                'name' => 'Atorvastatin',
                'route' => 'Oral',
                'frequency' => 'Once daily, usually in the evening',
                'indication' => 'High cholesterol and triglyceride levels',
                'resolution_plan' => 'Monitor lipid levels, adjust dose accordingly, lifestyle modifications'
            ],
            [
                'name' => 'Losartan',
                'route' => 'Oral',
                'frequency' => 'Once daily or divided into two doses',
                'indication' => 'High blood pressure, diabetic nephropathy',
                'resolution_plan' => 'Blood pressure monitoring, dosage adjustments based on response, assess renal function'
            ],
            [
                'name' => 'Metformin',
                'route' => 'Oral',
                'frequency' => '2-3 times daily for immediate-release; once daily for extended-release',
                'indication' => 'Type 2 diabetes',
                'resolution_plan' => 'Monitor blood glucose, A1C; adjust dose as needed; lifestyle and dietary advice'
            ],
            [
                'name' => 'Amlodipine',
                'route' => 'Oral',
                'frequency' => 'Once daily',
                'indication' => 'Hypertension, angina',
                'resolution_plan' => 'Monitor blood pressure and heart rate, adjust dose if necessary'
            ],
            [
                'name' => 'Paracetamol (Acetaminophen)',
                'route' => 'Oral, rectal',
                'frequency' => 'Every 4-6 hours as needed',
                'indication' => 'Fever, mild to moderate pain',
                'resolution_plan' => 'Pain or fever monitoring, ensure not to exceed the maximum daily dose, hydration'
            ],
            [
                'name' => 'Amoxicillin',
                'route' => 'Oral',
                'frequency' => 'Every 8 hours',
                'indication' => 'Bacterial infections',
                'resolution_plan' => 'Complete full prescribed course, monitor for signs of allergic reaction, follow-up if symptoms persist'
            ],
            [
                'name' => 'Salbutamol (Albuterol)',
                'route' => 'Inhalation',
                'frequency' => 'As needed for asthma/COPD exacerbations; up to every 4-6 hours',
                'indication' => 'Asthma, COPD',
                'resolution_plan' => 'Asthma/COPD management plan review, monitor for overuse'
            ],
            [
                'name' => 'Simvastatin',
                'route' => 'Oral',
                'frequency' => 'Once in the evening',
                'indication' => 'High cholesterol',
                'resolution_plan' => 'Monitor lipid profile, liver function tests; lifestyle counseling'
            ],
            [
                'name' => 'Omeprazole',
                'route' => 'Oral',
                'frequency' => 'Once daily before breakfast',
                'indication' => 'GERD, ulcers',
                'resolution_plan' => 'Assess symptom improvement, potential step-down therapy, lifestyle modifications'
            ],
            [
                'name' => 'Captopril',
                'route' => 'Oral',
                'frequency' => '2-3 times daily',
                'indication' => 'Hypertension, heart failure',
                'resolution_plan' => 'Blood pressure and renal function monitoring, adjust dosage as needed, dietary sodium restriction'
            ]
        ];

        foreach ($medications as $medication) {
            Medication::create([
                'name' => $medication['name'],
                'dose' => null,
                'route' => $medication['route'],
                'frequency' => $medication['frequency'],
                'indication' => $medication['indication'],
                'discrepancy' => null,
                'resolution_plane' => $medication['resolution_plan'],
                'status' => 'active',
            ]);
        }
    }
}
