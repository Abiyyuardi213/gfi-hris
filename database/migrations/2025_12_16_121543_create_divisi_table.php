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
        Schema::create('divisi', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('kantor_id');
            $table->string('nama_divisi');
            $table->text('deskripsi')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();

            // $table->foreign('kantor_id')
            //       ->references('id')
            //       ->on('kantor')
            //       ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisi');
    }
};
