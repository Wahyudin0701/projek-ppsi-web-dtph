<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('farmer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nama_kelompok')->nullable();
            $table->string('ketua')->nullable();
            $table->string('nik_ketua')->nullable();
            $table->string('kontak')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->enum('afiliasi_lembaga', ['Individu', 'Kelompok Tani', 'Gapoktan', 'UPJA', 'Lainnya'])->default('Kelompok Tani');
            $table->string('grade')->nullable();
            $table->decimal('luas_lahan', 10, 2)->nullable();
            $table->string('komoditi')->nullable();
            $table->string('komoditi_utama')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('id_poktan')->nullable();
            $table->string('no_sk')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('sk_pengukuhan_path')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->boolean('is_verified_acknowledged')->default(false);
            $table->text('change_request_reason')->nullable();
            $table->timestamps();
        });

        Schema::create('farmer_group_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_profile_id')->constrained()->cascadeOnDelete();
            $table->string('nik')->nullable();
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->decimal('luas_lahan', 8, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('farmer_verification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_profile_id')->constrained('farmer_profiles')->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmer_verification_logs');
        Schema::dropIfExists('farmer_group_members');
        Schema::dropIfExists('farmer_profiles');
    }
};
