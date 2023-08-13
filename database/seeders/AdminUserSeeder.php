<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Administrator',
            'email' => 'superadmin@booking.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role_id' => 1, // Administrator
        ]);
    }
}
