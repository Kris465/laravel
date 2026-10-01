<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin credentials from .env ONLY
        // NEVER commit real credentials to version control!
        $email = env('ADMIN_EMAIL');
        $ [REDACTED]= env('ADMIN_PASSWORD');

        // Ensure credentials are set
        if (!$email || !$password) {
            throw new \InvalidArgumentException(
                'ADMIN_EMAIL and ADMIN_PASSWORD must be set in .env'
            );
        }

        // Use firstOrCreate to avoid duplicate entries on re-seed
        User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Helamin Admin',
                'email' => $email,
                'password' => Hash::make($password),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
