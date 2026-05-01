<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // Disable wrapping in a transaction — PostgreSQL DDL needs this
    public $withinTransaction = false;

    public function up(): void
    {
        // 1. Drop old constraint (allows petani/admin)
        DB::unprepared('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');

        // 2. Update existing 'petani' rows to 'user'
        DB::unprepared("UPDATE users SET role = 'user' WHERE role = 'petani'");

        // 3. Add new constraint (allows user/admin)
        DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('user', 'admin'))");
    }

    public function down(): void
    {
        DB::unprepared('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
        DB::unprepared("UPDATE users SET role = 'petani' WHERE role = 'user'");
        DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('petani', 'admin'))");
    }
};
