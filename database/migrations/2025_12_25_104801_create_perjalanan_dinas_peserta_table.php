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
        Schema::create('perjalanan_dinas_peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('perjalanan_dinas_id')->constrained('perjalanan_dinas')->onDelete('cascade');
            $table->foreignUuid('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perjalanan_dinas_peserta');
    }
};
