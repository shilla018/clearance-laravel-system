<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add Admin User
        User::updateOrCreate(
            ['email' => 'admin@clearance.test'],
            [
                'name' => 'Clearance Admin',
                'full_name' => 'Clearance Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Add Developer User
        User::updateOrCreate(
            ['email' => 'dev@clearance.test'],
            [
                'name' => 'Hagai Dev',
                'full_name' => 'Lead Developer',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Add a few more generic users for stats
        for ($i = 1; $i <= 5; $i++) {
            User::updateOrCreate(
                ['email' => "user{$i}@example.test"],
                [
                    'name' => "Starter User {$i}",
                    'full_name' => "Generic Starter User {$i}",
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
