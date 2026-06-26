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
         Schema::create('master_bridgings', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_bridging')->nullable();
            $table->string('tipe_url')->nullable();
            $table->string('url')->nullable();
            $table->string('constid')->nullable();
            $table->string('secret_key')->nullable();
            $table->string('user_key')->nullable();
            $table->string('token')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master__bridgings');
    }
};



