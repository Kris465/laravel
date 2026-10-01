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
        // Use .env for admin credentials (local development only)
        // NEVER commit real production credentials!
        $email = env('ADMIN_EMAIL', 'helamin.admin@technology-holding.internal');
        $ [REDACTED]= env('ADMIN_PASSWORD', '%f9j6mJ2F20b03b');

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
