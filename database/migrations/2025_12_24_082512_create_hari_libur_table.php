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
        Schema::dropIfExists('hari_libur');
        Schema::create('hari_libur', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_libur');
            $table->date('tanggal');
            $table->boolean('is_cuti_bersama')->default(false);
            $table->uuid('kantor_id')->nullable()->comment('Jika null berarti libur nasional/semua kantor');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('kantor_id')->references('id')->on('kantor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hari_libur');
    }
};
