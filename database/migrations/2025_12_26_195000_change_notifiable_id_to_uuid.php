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
        Schema::table('notifications', function (Blueprint $table) {
            // Drop the existing index and column to recreate them correctly for UUID
            // Note: DB::statement might be needed for some DBs, but Laravel has change support.
            // However, morphs creates 2 columns: notifiable_id and notifiable_type.
            // Changing id from int to string/uuid on existing table with data might be tricky if not careful,
            // but here we likely have little data or it's a dev environment.

            // We use raw SQL to avoid dependency issues with doctrine/dbal if not installed,
            // though Laravel usually requires it for modifying columns.
            // But standard way:
            $table->string('notifiable_id', 36)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Reverting is hard if data is mixed, but assuming we want to go back to int (which would fail for UUIDs)
            // $table->unsignedBigInteger('notifiable_id')->change();
        });
    }
};
