<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'user', 'umum', 'pimpinan', 'kabid_psp', 'kabid_tp', 'tim_survei'))");
        } else {
            try {
                DB::statement("ALTER TABLE users DROP CONSTRAINT users_role_check");
            } catch (\Exception $e) {}
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'user', 'umum', 'pimpinan', 'kabid_psp', 'kabid_tp', 'tim_survei'))");
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'user', 'umum', 'pimpinan'))");
        } else {
            try {
                DB::statement("ALTER TABLE users DROP CONSTRAINT users_role_check");
            } catch (\Exception $e) {}
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'user', 'umum', 'pimpinan'))");
        }
    }
};
