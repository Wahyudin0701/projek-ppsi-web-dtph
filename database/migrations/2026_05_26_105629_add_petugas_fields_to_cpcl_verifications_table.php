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
            $table->string('petugas_dokumentasi')->nullable()->after('catatan');
            $table->string('petugas_pemetaan')->nullable()->after('petugas_dokumentasi');
            $table->string('no_hp_pemetaan')->nullable()->after('petugas_pemetaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cpcl_verifications', function (Blueprint $table) {
            $table->dropColumn([
                'petugas_dokumentasi',
                'petugas_pemetaan',
                'no_hp_pemetaan',
            ]);
        });
    }
};
