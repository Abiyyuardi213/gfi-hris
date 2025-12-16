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
        Schema::table('divisi', function (Blueprint $table) {
            $table->string('kode_divisi')
                  ->unique()
                  ->after('kantor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('divisi', function (Blueprint $table) {
            $table->dropUnique(['kode_divisi']);
            $table->dropColumn('kode_divisi');
        });
    }
};
