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
        Schema::create('lamarans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('lowongan_id')->constrained('lowongans')->cascadeOnDelete();
            $table->foreignUuid('kandidat_id')->constrained('kandidats')->cascadeOnDelete();

            // Status Lamaran per Lowongan
            $table->string('status')->default('Pending'); // Pending, Review, Interview, Diterima, Ditolak
            $table->text('catatan_admin')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lamarans');
    }
};
