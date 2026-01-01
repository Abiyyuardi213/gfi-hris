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
        Schema::create('wawancaras', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('lamaran_id')->constrained('lamarans')->cascadeOnDelete();

            $table->dateTime('tanggal_waktu');
            $table->enum('tipe', ['Online', 'Offline']);
            $table->string('lokasi_link')->nullable(); // Alamat or Meeting Link
            $table->text('catatan')->nullable();
            $table->enum('status', ['Terjadwal', 'Selesai', 'Batal'])->default('Terjadwal');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wawancaras');
    }
};
