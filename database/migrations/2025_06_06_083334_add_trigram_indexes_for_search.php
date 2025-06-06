<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Catatan: Migrasi ini khusus untuk PostgreSQL dengan ekstensi pg_trgm.
     * Pastikan ekstensi pg_trgm sudah terinstall di server database Anda.
     */
    public function up(): void
    {
        // Aktifkan ekstensi pg_trgm jika belum aktif
        DB::statement('CREATE EXTENSION IF NOT EXISTS pg_trgm;');

        // Tambahkan indeks GIN ke tabel master_obat
        Schema::table('master_obat', function (Blueprint $table) {
            DB::statement('CREATE INDEX master_obat_nama_obat_gin_trgm_idx ON master_obat USING GIN (nama_obat gin_trgm_ops);');
        });

        // Tambahkan indeks GIN ke tabel diagnosa
        Schema::table('diagnosa', function (Blueprint $table) {
            DB::statement('CREATE INDEX diagnosa_code_gin_trgm_idx ON diagnosa USING GIN (code gin_trgm_ops);');
            DB::statement('CREATE INDEX diagnosa_name_gin_trgm_idx ON diagnosa USING GIN (name gin_trgm_ops);');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_obat', function (Blueprint $table) {
            $table->dropIndex('master_obat_nama_obat_gin_trgm_idx');
        });

        Schema::table('diagnosa', function (Blueprint $table) {
            $table->dropIndex('diagnosa_code_gin_trgm_idx');
            $table->dropIndex('diagnosa_name_gin_trgm_idx');
        });
    }
};
