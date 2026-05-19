<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // Disable wrapping in a transaction — PostgreSQL DDL needs this
    public $withinTransaction = false;

    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            // Drop old constraint (allows petani/admin)
            DB::unprepared('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
            // Update existing 'petani' rows to 'user'
            DB::unprepared("UPDATE users SET role = 'user' WHERE role = 'petani'");
            // Add new constraint (allows user/admin)
            DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('user', 'admin'))");
        } else {
            // MySQL or others
            DB::unprepared("UPDATE users SET role = 'user' WHERE role = 'petani'");
            // MySQL 8.0.16+ supports CHECK constraints but syntax for dropping is different
            // For fresh local DB, we might not even need to drop it if it doesn't exist
            try {
                DB::unprepared("ALTER TABLE users DROP CONSTRAINT users_role_check");
            } catch (\Exception $e) {
                // Ignore if not exists
            }
            DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('user', 'admin'))");
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'pgsql') {
            DB::unprepared('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
            DB::unprepared("UPDATE users SET role = 'petani' WHERE role = 'user'");
            DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('petani', 'admin'))");
        } else {
            try {
                DB::unprepared("ALTER TABLE users DROP CONSTRAINT users_role_check");
            } catch (\Exception $e) { }
            DB::unprepared("UPDATE users SET role = 'petani' WHERE role = 'user'");
            DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('petani', 'admin'))");
        }
    }
};
