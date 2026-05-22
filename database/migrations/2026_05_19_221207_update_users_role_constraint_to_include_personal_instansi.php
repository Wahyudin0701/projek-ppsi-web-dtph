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

        // Now safe to convert
        DB::table('users')->where('role', 'umum')->update(['role' => 'personal']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->where('role', 'personal')->update(['role' => 'umum']);
        DB::table('users')->where('role', 'instansi')->update(['role' => 'umum']);
        
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
};
