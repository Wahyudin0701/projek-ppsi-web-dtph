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
        Schema::table('proposals', function (Blueprint $table) {
            $table->string('no_surat_pengajuan')->nullable()->after('status');
        });

        Schema::table('survey_assignments', function (Blueprint $table) {
            if (Schema::hasColumn('survey_assignments', 'no_surat_pengajuan')) {
                $table->dropColumn('no_surat_pengajuan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_assignments', function (Blueprint $table) {
            $table->string('no_surat_pengajuan')->nullable();
        });

        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn('no_surat_pengajuan');
        });
    }
};
