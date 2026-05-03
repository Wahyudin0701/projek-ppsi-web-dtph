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
        // 1. Drop existing constraint first to avoid violation during update
        try {
            DB::unprepared("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_status_check");
        } catch (\Exception $e) {}

        // 2. Update existing records
        DB::table('users')->where('status', 'pending')->update(['status' => 'menunggu']);

        // 3. Change default value
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->default('menunggu')->change();
        });

        // 4. Add NEW constraint
        try {
            DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_status_check CHECK (status IN ('menunggu', 'reviewed', 'verifying', 'approved', 'rejected'))");
        } catch (\Exception $e) {}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::unprepared("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_status_check");
        } catch (\Exception $e) {}

        DB::table('users')->where('status', 'menunggu')->update(['status' => 'pending']);

        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });

        try {
            DB::unprepared("ALTER TABLE users ADD CONSTRAINT users_status_check CHECK (status IN ('pending', 'reviewed', 'verifying', 'approved', 'rejected'))");
        } catch (\Exception $e) {}
    }
};
