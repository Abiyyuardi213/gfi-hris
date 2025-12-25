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
        Schema::create('assets', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('kode_aset')->unique(); // e.g. INV/2025/001
            $table->string('nama_aset');
            $table->string('kategori'); // Elektronik, Kendaraan, Furniture
            $table->string('merk_model')->nullable();
            $table->string('nomor_seri')->nullable();

            $table->date('tanggal_pembelian')->nullable();
            $table->decimal('harga_perolehan', 15, 2)->nullable();

            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Dalam Perbaikan']);
            $table->enum('status', ['Tersedia', 'Digunakan', 'Dipinjamkan', 'Hilang', 'Dijual/Musnah']);

            // Relasi ke Pegawai (Siapa yang pegang sekarang)
            $table->foreignUuid('pegawai_id')->nullable()->constrained('pegawais')->nullOnDelete();

            $table->text('keterangan')->nullable();
            $table->string('foto')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
