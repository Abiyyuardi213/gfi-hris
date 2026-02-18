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
        Schema::table('kantor', function (Blueprint $table) {
            $table->uuid('kota_id')->nullable()->after('alamat');
            $table->string('no_telp')->nullable()->after('nama_kantor');
            $table->string('email')->nullable()->after('no_telp');
            $table->string('tipe_kantor')->default('Cabang')->after('nama_kantor'); // Pusat, Cabang
            $table->decimal('latitude', 10, 8)->nullable()->after('alamat');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->integer('radius')->default(100)->after('longitude'); // Radius absensi in meters
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kantor', function (Blueprint $table) {
            $table->dropColumn(['kota_id', 'no_telp', 'email', 'tipe_kantor', 'latitude', 'longitude', 'radius']);
        });
    }
};
