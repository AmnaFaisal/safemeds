<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //admin 
        $admin = User::create([
            'first_name' => 'System',
            'last_name' => 'Admin',
            'email' => 'admin@safemed.com',
            'password' => Hash::make('12345678'),
            'user_type' => 'admin',
        ]);
        $admin->assignRole('admin');
    }
}