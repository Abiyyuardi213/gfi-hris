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
        Schema::create('presensis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->foreignUuid('shift_kerja_id')->nullable()->constrained('shift_kerja')->nullOnDelete();

            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();

            $table->string('foto_masuk')->nullable();
            $table->string('foto_pulang')->nullable();
            $table->string('lokasi_masuk')->nullable(); // Lat,Long
            $table->string('lokasi_pulang')->nullable(); // Lat,Long

            $table->string('status')->default('Alpa'); // Hadir, Sakit, Izin, Alpa, Cuti, Libur

            $table->integer('terlambat')->default(0); // dalam menit
            $table->integer('pulang_cepat')->default(0); // dalam menit

            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
