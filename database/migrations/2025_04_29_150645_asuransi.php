<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Asuransi extends Migration
{
    public function up()
    {
        Schema::create('asuransi', callback: function (Blueprint $table) {
            $table->id(); // Kolom 'id'
            $table->string('nama'); // Kolom 'nama'
            $table->string('no_tlp')->nullable(); // Kolom 'no_tlp'
            $table->text('deskripsi')->nullable(); // Kolom 'deskripsi'
            $table->string('jenis')->nullable(); // Kolom 'jenis'
            $table->string('inserted_user')->nullable(); // Kolom 'inserted_user'
            $table->string('updated_user')->nullable(); // Kolom 'updated_user'
            $table->timestamps(); // Kolom 'created_at' dan 'updated_at'
            $table->softDeletes(); // Kolom 'deleted_at'
        });
    }

    public function down()
    {
        Schema::dropIfExists('asuransi');
    }
};
