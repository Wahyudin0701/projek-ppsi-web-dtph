<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First ensure any existing 'pinjam_alat' records are handled (none exist based on previous check)
        DB::statement("ALTER TABLE programs MODIFY COLUMN type ENUM('bantuan_permanen', 'usulan_pendanaan') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE programs MODIFY COLUMN type ENUM('bantuan_permanen', 'pinjam_alat', 'usulan_pendanaan') NOT NULL");
    }
};
