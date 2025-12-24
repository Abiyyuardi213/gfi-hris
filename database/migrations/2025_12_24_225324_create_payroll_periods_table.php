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
        Schema::create('payroll_periods', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_periode'); // e.g. "Gaji Januari 2025"
            $table->string('bulan'); // 01-12
            $table->year('tahun');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_closed')->default(false); // Draft or Closed
            $table->date('tanggal_gajian')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_periods');
    }
};
