<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin User',
                'password' => 'password',
                'role' => 'owner',
                'enabled' => true,
                'email_verified_at' => now(),
            ]
        );

        $user = User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
                'role' => 'employee',
                'enabled' => true,
                'email_verified_at' => now(),
            ]
        );

        // Seed 15 clients assigned to the admin user
        if (\App\Models\Client::count() === 0) {
            \App\Models\Client::factory(15)->create([
                'created_by' => $admin->id,
            ]);
        }

        if (\App\Models\Lead::count() === 0) {
            \App\Models\Lead::factory(10)->create();
        }
    }
}
