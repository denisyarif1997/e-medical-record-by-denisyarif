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
        Schema::table('pasiens', function (Blueprint $table) {
            $table->string('tempat_lahir')->nullable()->after('tanggal_lahir');
            $table->string('agama')->nullable()->after('tempat_lahir');
            $table->string('pendidikan')->nullable()->after('agama');
            $table->string('pekerjaan')->nullable()->after('pendidikan');
            $table->string('status_pernikahan')->nullable()->after('pekerjaan');
            $table->string('golongan_darah', 5)->nullable()->after('status_pernikahan');
            $table->string('kewarganegaraan')->default('WNI')->after('golongan_darah');
            $table->string('suku')->nullable()->after('kewarganegaraan');
            $table->string('bahasa')->nullable()->after('suku');
            
            // Family
            $table->string('nama_ayah')->nullable()->after('bahasa');
            $table->string('nama_ibu')->nullable()->after('nama_ayah');
            $table->string('nama_pasangan')->nullable()->after('nama_ibu');
            
            // Emergency Contact
            $table->string('kontak_darurat_nama')->nullable()->after('nama_pasangan');
            $table->string('kontak_darurat_hubungan')->nullable()->after('kontak_darurat_nama');
            $table->string('kontak_darurat_hp')->nullable()->after('kontak_darurat_hubungan');
            
            // Additional Contact
            $table->string('email')->nullable()->after('no_hp');
            
            // Detailed Address
            $table->string('rt', 10)->nullable()->after('alamat');
            $table->string('rw', 10)->nullable()->after('rt');
            $table->string('kelurahan')->nullable()->after('rw');
            $table->string('kecamatan')->nullable()->after('kelurahan');
            $table->string('kota')->nullable()->after('kecamatan');
            $table->string('provinsi')->nullable()->after('kota');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_lahir', 'agama', 'pendidikan', 'pekerjaan', 'status_pernikahan', 
                'golongan_darah', 'kewarganegaraan', 'suku', 'bahasa',
                'nama_ayah', 'nama_ibu', 'nama_pasangan',
                'kontak_darurat_nama', 'kontak_darurat_hubungan', 'kontak_darurat_hp',
                'email', 'rt', 'rw', 'kelurahan', 'kecamatan', 'kota', 'provinsi'
            ]);
        });
    }
};
