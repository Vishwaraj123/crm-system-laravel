<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('offer_items') && Schema::hasColumn('offer_items', 'offer_id')) {
            Schema::table('offer_items', function (Blueprint $table) {
                $table->renameColumn('offer_id', 'proposal_id');
            });
        }

        if (Schema::hasTable('proposal_items') && Schema::hasColumn('proposal_items', 'offer_id')) {
            Schema::table('proposal_items', function (Blueprint $table) {
                $table->renameColumn('offer_id', 'proposal_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal_items', function (Blueprint $table) {
            if (Schema::hasColumn('proposal_items', 'proposal_id')) { // Fixed check
                $table->renameColumn('proposal_id', 'offer_id');
            }
        });
    }
};
