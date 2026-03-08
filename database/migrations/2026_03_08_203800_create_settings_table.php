<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed default settings
        $defaults = [
            ['key' => 'company_name',    'value' => ''],
            ['key' => 'company_address', 'value' => ''],
            ['key' => 'company_state',   'value' => ''],
            ['key' => 'company_country', 'value' => ''],
            ['key' => 'company_email',   'value' => ''],
            ['key' => 'company_phone',   'value' => ''],
            ['key' => 'company_website', 'value' => ''],
            ['key' => 'company_tax_number', 'value' => ''],
            ['key' => 'company_logo',    'value' => ''],
            ['key' => 'default_currency','value' => 'USD'],
            ['key' => 'date_format',     'value' => 'd/m/Y'],
            ['key' => 'currency_symbol', 'value' => '$'],
        ];

        foreach ($defaults as $setting) {
            DB::table('settings')->insert(array_merge($setting, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
