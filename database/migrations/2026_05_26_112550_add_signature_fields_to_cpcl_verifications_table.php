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
        Schema::table('cpcl_verifications', function (Blueprint $table) {
            $table->string('penandatangan_poktan_nama')->nullable();
            $table->string('penandatangan_poktan_jabatan')->nullable();
            $table->string('nama_ppl')->nullable();
            $table->string('nip_ppl')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cpcl_verifications', function (Blueprint $table) {
            $table->dropColumn([
                'penandatangan_poktan_nama',
                'penandatangan_poktan_jabatan',
                'nama_ppl',
                'nip_ppl'
            ]);
        });
    }
};
