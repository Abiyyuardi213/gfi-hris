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
        Schema::create('divisi_jabatan', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('divisi_id');
            $table->uuid('jabatan_id');

            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->foreign('divisi_id')
                  ->references('id')
                  ->on('divisi')
                  ->onDelete('cascade');

            $table->foreign('jabatan_id')
                  ->references('id')
                  ->on('jabatan')
                  ->onDelete('cascade');

            $table->unique(['divisi_id', 'jabatan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisi_jabatan');
    }
};
