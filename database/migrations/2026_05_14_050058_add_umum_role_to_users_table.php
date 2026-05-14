<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // Disable wrapping in a transaction — PostgreSQL DDL needs this
    public $withinTransaction = false;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
        DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('user', 'admin', 'umum'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
        // Revert 'umum' users to 'user' or just delete them, here we just revert the constraint
        // If there are 'umum' users, we might want to change them to 'user' first
        DB::unprepared("UPDATE users SET role = 'user' WHERE role = 'umum'");
        DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('user', 'admin'))");
    }
};
