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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi User (Optional, jika pegawai memiliki akses login)
            $table->foreignUuid('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Relasi Master Data
            $table->foreignUuid('status_pegawai_id')->nullable()->constrained('status_pegawai')->nullOnDelete();
            $table->foreignUuid('divisi_id')->nullable()->constrained('divisi')->nullOnDelete();
            $table->foreignUuid('jabatan_id')->nullable()->constrained('jabatan')->nullOnDelete();
            $table->foreignUuid('kantor_id')->nullable()->constrained('kantor')->nullOnDelete();
            // Kota Domisili?? Optional.

            // Identitas Utama
            $table->string('nip')->unique()->comment('Nomor Induk Pegawai');
            $table->string('nik', 16)->unique()->comment('Nomor Induk Kependudukan');
            $table->string('nama_lengkap');

            // Data Pribadi
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('agama')->nullable();
            $table->string('status_pernikahan')->nullable(); // Menikah, Belum Menikah, Janda/Duda

            // Kontak & Alamat
            $table->text('alamat_ktp')->nullable();
            $table->text('alamat_domisili')->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->string('email_pribadi')->nullable();

            // Data Kepegawaian
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();
            $table->string('foto')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
