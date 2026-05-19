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
        $driver = DB::getDriverName();
        if ($driver === 'pgsql') {
            DB::unprepared('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_status_check');
            DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_status_check CHECK (status IN ('pending', 'reviewed', 'verifying', 'approved', 'rejected'))");
        } else {
            try {
                DB::unprepared('ALTER TABLE users DROP CONSTRAINT users_status_check');
            } catch (\Exception $e) { }
            DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_status_check CHECK (status IN ('pending', 'reviewed', 'verifying', 'approved', 'rejected'))");
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'pgsql') {
            DB::unprepared('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_status_check');
            DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_status_check CHECK (status IN ('pending', 'approved'))");
        } else {
            try {
                DB::unprepared('ALTER TABLE users DROP CONSTRAINT users_status_check');
            } catch (\Exception $e) { }
            DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_status_check CHECK (status IN ('pending', 'approved'))");
        }
    }
};
