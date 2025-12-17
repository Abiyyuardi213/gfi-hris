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
        Schema::create('status_pegawai', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('kode_status')->unique();
            $table->string('nama_status');
            $table->text('keterangan')->nullable();

            $table->boolean('is_aktif')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_pegawai');
    }
};
