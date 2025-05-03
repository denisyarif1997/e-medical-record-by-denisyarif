<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pasien extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('no_rekam_medis')->unique();
            $table->string('nik')->nullable();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('penanggung')->nullable();
            $table->unsignedBigInteger('asuransi_id')->nullable();
            $table->string('no_asuransi')->nullable();


            $table->unsignedBigInteger('inserted_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign key example (optional, if related tables exist)
            // $table->foreign('asuransi_id')->references('id')->on('asuransis')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
}
