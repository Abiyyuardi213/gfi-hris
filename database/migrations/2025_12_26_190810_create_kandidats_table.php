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
        Schema::create('kandidats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();

            // Biodata
            $table->string('nik', 16)->nullable()->unique();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->text('alamat')->nullable();
            $table->string('pendidikan_terakhir')->nullable(); // SMA, D3, S1, S2

            // Files (Paths)
            $table->string('file_foto')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('file_ijazah')->nullable();
            $table->string('file_transkrip')->nullable();
            $table->string('file_cv')->nullable();
            $table->string('file_pendukung')->nullable();

            $table->string('status_lamaran')->default('Baru'); // Baru, Interview, Diterima, Ditolak

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kandidats');
    }
};
