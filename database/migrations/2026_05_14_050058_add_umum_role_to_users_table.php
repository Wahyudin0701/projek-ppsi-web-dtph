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
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            DB::unprepared('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
            DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('user', 'admin', 'umum'))");
        } else {
            try {
                DB::unprepared("ALTER TABLE users DROP CONSTRAINT users_role_check");
            } catch (\Exception $e) { }
            DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('user', 'admin', 'umum'))");
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            DB::unprepared('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
            DB::unprepared("UPDATE users SET role = 'user' WHERE role = 'umum'");
            DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('user', 'admin'))");
        } else {
            try {
                DB::unprepared("ALTER TABLE users DROP CONSTRAINT users_role_check");
            } catch (\Exception $e) { }
            DB::unprepared("UPDATE users SET role = 'user' WHERE role = 'umum'");
            DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('user', 'admin'))");
        }
    }
};
