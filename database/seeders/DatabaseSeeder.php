<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = \App\Models\User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin User',
                'password' => 'password',
                'role' => 'owner',
                'enabled' => true,
                'email_verified_at' => now(),
            ]
        );

        // Seed Company Settings
        Setting::set('company_name', 'Vishwaraj CRM');
        Setting::set('company_address', 'Mumbai, India');
        Setting::set('company_email', 'contact@vishwaraj.com');
        Setting::set('company_phone', '+91-1234567890');
        Setting::set('default_currency', 'INR');
        Setting::set('currency_symbol', 'INR');
        Setting::set('date_format', 'd/m/Y');

        // Seed 15 clients assigned to the admin user
        if (\App\Models\Client::count() === 0) {
            \App\Models\Client::factory(15)->create([
                'created_by' => $admin->id,
            ]);
        }


        $this->call([
            PaymentModeSeeder::class,
            ProposalSeeder::class,
            InvoiceSeeder::class,
        ]);
    }
}
