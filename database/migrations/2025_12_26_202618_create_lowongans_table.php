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
        Schema::create('lowongans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->text('kualifikasi')->nullable();
            $table->string('lokasi_penempatan')->nullable();
            $table->string('tipe_pekerjaan')->default('Full Time'); // Full Time, Part Time, Contract, Internship
            $table->decimal('gaji_min', 15, 2)->nullable();
            $table->decimal('gaji_max', 15, 2)->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_akhir')->nullable(); // Batas Pendaftaran
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongans');
    }
};
