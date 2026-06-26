<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix: Kolom 'secret_key ' (dengan spasi) direname menjadi 'secret_key' (tanpa spasi)
        DB::statement('ALTER TABLE master_bridgings RENAME COLUMN "secret_key " TO "secret_key"');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE master_bridgings RENAME COLUMN "secret_key" TO "secret_key "');
    }
};