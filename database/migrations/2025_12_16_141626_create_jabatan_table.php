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
        Schema::create('jabatan', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('divisi_id');
            $table->string('kode_jabatan')->unique();
            $table->string('nama_jabatan');
            $table->text('deskripsi')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->foreign('divisi_id')
                  ->references('id')
                  ->on('divisi')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatan');
    }
};
