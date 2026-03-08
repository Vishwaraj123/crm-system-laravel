<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->integer('year');
            $table->text('content')->nullable();
            $table->date('date');
            $table->date('expired_date');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('sub_total', 15, 2)->default(0);
            $table->decimal('tax_total', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            $table->string('currency')->default('USD');
            $table->decimal('discount', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->enum('status', ['draft', 'pending', 'sent', 'accepted', 'declined', 'cancelled', 'on hold'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
