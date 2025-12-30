<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only create the admin if none exists
        if (User::where('role', 'admin')->exists()) {
            return;
        }

        // Create the default admin user. Update the credentials as needed.
        $adminEmail = env('DEFAULT_ADMIN_EMAIL', 'admin@example.com');
        $adminPassword = env('DEFAULT_ADMIN_PASSWORD', 'changeme123');

        $user = User::create([
            'name' => 'Administrator',
            'email' => $adminEmail,
            'password' => Hash::make($adminPassword),
            'role' => 'admin',
            'balance' => 0.00,
            'is_active' => true,
        ]);

        // Optionally create an access token for the admin for testing
        try {
            $user->createToken('seed-admin-token');
        } catch (\Throwable $e) {
            // If token creation fails (e.g., missing collections), ignore in seeder
        }
    }
}
