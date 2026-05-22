<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update all users with role 'personal' or 'instansi' to 'umum'
        DB::table('users')->whereIn('role', ['personal', 'instansi'])->update(['role' => 'umum']);

        // 2. Drop the old constraint and add the new constraint that excludes personal and instansi
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'user', 'umum', 'pimpinan', 'kabid_psp', 'kabid_tp', 'tim_survei'))");
        } else {
            try {
                DB::statement("ALTER TABLE users DROP CONSTRAINT users_role_check");
            } catch (\Exception $e) { }
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'user', 'umum', 'pimpinan', 'kabid_psp', 'kabid_tp', 'tim_survei'))");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back personal and instansi to the constraint check
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'user', 'personal', 'instansi', 'pimpinan', 'kabid_psp', 'kabid_tp', 'tim_survei', 'umum'))");
        } else {
            try {
                DB::statement("ALTER TABLE users DROP CONSTRAINT users_role_check");
            } catch (\Exception $e) { }
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'user', 'personal', 'instansi', 'pimpinan', 'kabid_psp', 'kabid_tp', 'tim_survei', 'umum'))");
        }
    }
};
