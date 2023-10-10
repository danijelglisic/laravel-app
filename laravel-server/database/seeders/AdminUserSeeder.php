<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => "admin",
            'lastname' => "admin",
            'phone_number' => "+38766123456",
            'email' => "admin@test.app",
            'password' => Hash::make('Admin@2023'),
            'role' => 'admin', 
        ]);
    }
}
