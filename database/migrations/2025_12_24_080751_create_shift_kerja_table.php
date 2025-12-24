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
        Schema::create('shift_kerja', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_shift')->unique();
            $table->string('nama_shift');
            $table->time('jam_masuk');
            $table->time('jam_keluar');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_kerja');
    }
};
