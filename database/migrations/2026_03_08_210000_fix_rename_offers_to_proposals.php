<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // The rename migration stub (2026_03_08_150347) was empty and never
        // actually renamed tables. This migration does the real rename.

        if (Schema::hasTable('offers') && !Schema::hasTable('proposals')) {
            Schema::rename('offers', 'proposals');
        }

        if (Schema::hasTable('offer_items') && !Schema::hasTable('proposal_items')) {
            Schema::rename('offer_items', 'proposal_items');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('proposals') && !Schema::hasTable('offers')) {
            Schema::rename('proposals', 'offers');
        }

        if (Schema::hasTable('proposal_items') && !Schema::hasTable('offer_items')) {
            Schema::rename('proposal_items', 'offer_items');
        }
    }
};
