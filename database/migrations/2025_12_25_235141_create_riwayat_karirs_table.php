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
        Schema::create('riwayat_karirs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pegawai_id')->constrained('pegawais')->onDelete('cascade');

            $table->enum('jenis_perubahan', ['Promosi', 'Mutasi', 'Demosi', 'Rotasi', 'Penyesuaian']);

            // Data Lama (Nullable karena bisa jadi pegawai baru belum punya jabatan)
            $table->foreignUuid('jabatan_awal_id')->nullable()->constrained('jabatan')->nullOnDelete();
            $table->foreignUuid('divisi_awal_id')->nullable()->constrained('divisi')->nullOnDelete();
            $table->foreignUuid('kantor_awal_id')->nullable()->constrained('kantor')->nullOnDelete();

            // Data Baru
            $table->foreignUuid('jabatan_tujuan_id')->constrained('jabatan')->onDelete('cascade');
            $table->foreignUuid('divisi_tujuan_id')->constrained('divisi')->onDelete('cascade');
            $table->foreignUuid('kantor_tujuan_id')->constrained('kantor')->onDelete('cascade');

            $table->date('tanggal_efektif');
            $table->string('no_sk')->nullable(); // Surat Keputusan
            $table->string('file_sk')->nullable();
            $table->text('keterangan')->nullable();

            $table->foreignUuid('dibuat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_karirs');
    }
};
