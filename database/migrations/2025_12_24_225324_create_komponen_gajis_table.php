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
        Schema::create('komponen_gajis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_komponen');
            $table->enum('tipe', ['pendapatan', 'potongan']);
            $table->boolean('is_variable')->default(false); // If true, requires input every month
            $table->decimal('jumlah_default', 15, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komponen_gajis');
    }
};
