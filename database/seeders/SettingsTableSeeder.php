<?php

namespace Database\Seeders;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('settings')->insert([
            ['key' => 'patient_id', 'value' => '0001'],
            // Add more initial settings if needed
        ]);
    }
}
