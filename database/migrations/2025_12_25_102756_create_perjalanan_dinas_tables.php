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
        Schema::create('perjalanan_dinas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pegawai_id')->constrained('pegawais')->onDelete('cascade');

            $table->string('no_surat_tugas')->nullable()->unique(); // Auto-generated later
            $table->string('tujuan'); // City or Company or Location
            $table->text('keperluan');

            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->string('jenis_transportasi')->nullable(); // Pesawat, Kereta, Mobil Dinas, Pribadi
            $table->decimal('estimasi_biaya', 15, 2)->default(0);
            $table->decimal('realisasi_biaya', 15, 2)->nullable(); // After trip

            $table->enum('status', ['Pengajuan', 'Disetujui', 'Ditolak', 'Sedang Berjalan', 'Selesai', 'Dibatalkan'])->default('Pengajuan');

            $table->text('catatan_persetujuan')->nullable(); // Reason for rejection or notes
            $table->foreignUuid('disetujui_oleh')->nullable()->constrained('pegawais'); // Link to approver

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('biaya_dinas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('perjalanan_dinas_id')->constrained('perjalanan_dinas')->onDelete('cascade');

            $table->string('nama_biaya'); // Tiket, Hotel, Uang Saku, Transport Lokal
            $table->decimal('jumlah', 15, 2);
            $table->string('bukti_pendukung')->nullable(); // File path
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biaya_dinas');
        Schema::dropIfExists('perjalanan_dinas');
    }
};
