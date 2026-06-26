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
        Schema::rename('dokters', 'tenaga_medis');

        Schema::table('tenaga_medis', function (Blueprint $table) {
            $table->string('type', 50)->nullable()->after('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenaga_medis', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::rename('tenaga_medis', 'dokters');
    }
};