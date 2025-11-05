<?php

// database/seeders/UserSeeder.php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating users...');

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@esports.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+254712345678',
            'bio' => 'System Administrator',
            'avatar' => 'avatars/default.png',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create organizer users
        User::factory()->count(5)->create([
            'role' => 'organizer',
            'email_verified_at' => now(),
        ]);

        // Create player users
        User::factory()->count(10)->create([
            'role' => 'player',
            'email_verified_at' => now(),
        ]);

        // Create spectator users
        User::factory()->count(10)->create([
            'role' => 'spectator',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✓ Users created: ' . User::count() . ' total');
    }
}
