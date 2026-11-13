<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Креды читаются через config(), чтобы сидер работал при config:cache.
        $adminEmail = config('helamin.admin_email');
        $adminPassword = config('helamin.admin_password');

        // Ensure credentials are set
        if (!$adminEmail || !$adminPassword) {
            throw new \InvalidArgumentException(
                'ADMIN_EMAIL and ADMIN_PASSWORD must be set in .env'
            );
        }

        // Use firstOrCreate to avoid duplicate entries on re-seed
        User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Helamin Admin',
                'email' => $adminEmail,
                'password' => Hash::make($adminPassword),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
