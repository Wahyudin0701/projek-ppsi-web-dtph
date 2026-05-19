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
        // 1. Create farmer_profiles table
        Schema::create('farmer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_kelompok')->nullable();
            $table->string('ketua')->nullable();
            $table->string('nik_ketua')->nullable();
            $table->string('kontak')->nullable();
            $table->string('grade')->nullable();
            $table->decimal('luas_lahan', 10, 2)->nullable();
            $table->text('alamat')->nullable();
            $table->string('status')->default('menunggu');
            $table->text('rejection_reason')->nullable();
            $table->boolean('is_verified_acknowledged')->default(false);
            $table->timestamps();
        });

        // 2. Migrate existing data from users to farmer_profiles
        // We do this by chunks to avoid memory exhaustion if there are many users
        DB::table('users')->where('role', 'user')->orderBy('id')->chunk(100, function ($users) {
            $profiles = [];
            foreach ($users as $user) {
                // Ensure columns exist before accessing them, in case someone runs this from a fresh state
                // where the migrations were squashed or different.
                $profiles[] = [
                    'user_id' => $user->id,
                    'nama_kelompok' => $user->nama_kelompok ?? null,
                    'ketua' => $user->ketua ?? null,
                    'nik_ketua' => $user->nik_ketua ?? null,
                    'kontak' => $user->kontak ?? null,
                    'grade' => $user->grade ?? null,
                    'luas_lahan' => $user->luas_lahan ?? 0,
                    'alamat' => $user->alamat ?? null,
                    'status' => $user->status ?? 'menunggu',
                    'rejection_reason' => $user->rejection_reason ?? null,
                    'is_verified_acknowledged' => $user->is_verified_acknowledged ?? false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            if (!empty($profiles)) {
                DB::table('farmer_profiles')->insert($profiles);
            }
        });

        // 3. Drop constraints on users table related to status
        try {
            if (DB::getDriverName() === 'pgsql') {
                DB::unprepared("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_status_check");
            } else {
                DB::unprepared("ALTER TABLE users DROP CONSTRAINT users_status_check");
            }
        } catch (\Exception $e) {}

        // 4. Drop the columns from users table
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'nama_kelompok')) $table->dropColumn('nama_kelompok');
            if (Schema::hasColumn('users', 'ketua')) $table->dropColumn('ketua');
            if (Schema::hasColumn('users', 'nik_ketua')) $table->dropColumn('nik_ketua');
            if (Schema::hasColumn('users', 'kontak')) $table->dropColumn('kontak');
            if (Schema::hasColumn('users', 'grade')) $table->dropColumn('grade');
            if (Schema::hasColumn('users', 'luas_lahan')) $table->dropColumn('luas_lahan');
            if (Schema::hasColumn('users', 'alamat')) $table->dropColumn('alamat');
            if (Schema::hasColumn('users', 'status')) $table->dropColumn('status');
            if (Schema::hasColumn('users', 'rejection_reason')) $table->dropColumn('rejection_reason');
            if (Schema::hasColumn('users', 'is_verified_acknowledged')) $table->dropColumn('is_verified_acknowledged');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Add columns back to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama_kelompok')->nullable();
            $table->string('ketua')->nullable();
            $table->string('nik_ketua')->nullable();
            $table->string('kontak')->nullable();
            $table->string('grade')->nullable();
            $table->decimal('luas_lahan', 10, 2)->nullable();
            $table->text('alamat')->nullable();
            $table->string('status')->default('menunggu');
            $table->text('rejection_reason')->nullable();
            $table->boolean('is_verified_acknowledged')->default(false);
        });

        // 2. Migrate data back
        DB::table('farmer_profiles')->orderBy('id')->chunk(100, function ($profiles) {
            foreach ($profiles as $profile) {
                DB::table('users')->where('id', $profile->user_id)->update([
                    'nama_kelompok' => $profile->nama_kelompok,
                    'ketua' => $profile->ketua,
                    'nik_ketua' => $profile->nik_ketua,
                    'kontak' => $profile->kontak,
                    'grade' => $profile->grade,
                    'luas_lahan' => $profile->luas_lahan,
                    'alamat' => $profile->alamat,
                    'status' => $profile->status,
                    'rejection_reason' => $profile->rejection_reason,
                    'is_verified_acknowledged' => $profile->is_verified_acknowledged,
                ]);
            }
        });

        // 3. Drop farmer_profiles table
        Schema::dropIfExists('farmer_profiles');
    }
};
