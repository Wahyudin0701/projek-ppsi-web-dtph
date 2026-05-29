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
            $table->string('dokumen_fisik_path')->nullable()->after('nip_ppl');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cpcl_verifications', function (Blueprint $table) {
            $table->dropColumn('dokumen_fisik_path');
        });
    }
};
