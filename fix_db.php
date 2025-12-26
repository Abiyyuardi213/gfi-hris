<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

// In Laravel 11, we might need to handle booting differently if just using app.php return.
// Usually app.php returns the Application instance.
// But let's try to make the kernel to bootstrap everything properly.
try {
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
} catch (\Exception $e) {
    // If make fails (likely if app.php doesn't return app or structure is different)
    echo "Bootstrap error: " . $e->getMessage();
    exit(1);
}

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

echo "Fixing database...\n";

// Create lowongans
if (!Schema::hasTable('lowongans')) {
    Schema::create('lowongans', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('judul');
        $table->text('deskripsi')->nullable();
        $table->text('kualifikasi')->nullable();
        $table->string('lokasi_penempatan')->nullable();
        $table->string('tipe_pekerjaan')->default('Full Time'); // Full Time, Part Time, Contract, Internship
        $table->decimal('gaji_min', 15, 2)->nullable();
        $table->decimal('gaji_max', 15, 2)->nullable();
        $table->date('tanggal_mulai')->nullable();
        $table->date('tanggal_akhir')->nullable(); // Batas Pendaftaran
        $table->boolean('is_active')->default(true);
        $table->timestamps();
        $table->softDeletes();
    });
    echo "Table lowongans created.\n";
} else {
    echo "Table lowongans already exists.\n";
}

// Create lamarans
if (!Schema::hasTable('lamarans')) {
    Schema::create('lamarans', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignUuid('lowongan_id')->constrained('lowongans')->cascadeOnDelete();
        $table->foreignUuid('kandidat_id')->constrained('kandidats')->cascadeOnDelete();

        // Status Lamaran per Lowongan
        $table->string('status')->default('Pending'); // Pending, Review, Interview, Diterima, Ditolak
        $table->text('catatan_admin')->nullable();

        $table->timestamps();
        $table->softDeletes();
    });
    echo "Table lamarans created.\n";
} else {
    echo "Table lamarans already exists.\n";
}

// Register in migrations table if not present
$m1 = '2025_12_26_202618_create_lowongans_table';
if (!DB::table('migrations')->where('migration', $m1)->exists()) {
    DB::table('migrations')->insert(['migration' => $m1, 'batch' => 99]);
}

$m2 = '2025_12_27_000000_create_lamarans_table';
if (!DB::table('migrations')->where('migration', $m2)->exists()) {
    DB::table('migrations')->insert(['migration' => $m2, 'batch' => 99]);
}

echo "Migrations registered.\n";
