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
        // Drop the existing constraint
        DB::unprepared('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_status_check');

        // Add the updated constraint including 'reviewed' and 'rejected'
        DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_status_check CHECK (status IN ('pending', 'reviewed', 'verifying', 'approved', 'rejected'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_status_check');
        DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_status_check CHECK (status IN ('pending', 'approved'))");
    }
};
