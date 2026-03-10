<?php

namespace Database\Seeders;

use App\Models\PaymentMode;
use Illuminate\Database\Seeder;

class PaymentModeSeeder extends Seeder
{
    public function run(): void
    {
        $modes = [
            [
                'name' => 'Bank Transfer',
                'description' => 'Direct bank transfer to our corporate account.',
                'enabled' => true,
            ],
            [
                'name' => 'Cash',
                'description' => 'Physical currency payment.',
                'enabled' => true,
            ],
            [
                'name' => 'PayPal',
                'description' => 'Online payment via PayPal.',
                'enabled' => true,
            ],
            [
                'name' => 'Stripe',
                'description' => 'Credit/Debit card payment via Stripe.',
                'enabled' => true,
            ],
        ];

        foreach ($modes as $mode) {
            PaymentMode::updateOrCreate(['name' => $mode['name']], $mode);
        }
    }
}
