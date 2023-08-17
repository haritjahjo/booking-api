<?php

namespace Database\Seeders;

use App\Models\Role;
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
        User::create([
            'name' => 'Administrator',
            'email' => 'superadmin@booking.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role_id' => Role::ROLE_ADMINISTRATOR, // Administrator
        ]);

        User::create([
            'name' => 'Nadya Owner',
            'email' => 'nadya.owner@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role_id' => Role::ROLE_OWNER, // Owner
        ]);

        // User::create([
        //     'name' => 'Rizki User',
        //     'email' => 'rizki.user@example.com',
        //     'password' => bcrypt('password'),
        //     'email_verified_at' => now(),
        //     'role_id' => Role::ROLE_USER, // Simply User
            
        // ]);
    }
}
