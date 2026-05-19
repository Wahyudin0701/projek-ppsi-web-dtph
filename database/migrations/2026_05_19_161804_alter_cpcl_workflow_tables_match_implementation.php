<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Alter cpcl_verifications: drop old columns, add new ones matching implementation.
     * Alter survey_documentations: change FK from cpcl_verification_id to proposal_id,
     *   rename photo_path to file_path, add keterangan.
     */
    public function up(): void
    {
        // ── cpcl_verifications ──────────────────────────────────────────────
        Schema::table('cpcl_verifications', function (Blueprint $table) {
            // Drop old columns that no longer exist in implementation
            $columnsToDrop = [
                'latitude', 'longitude', 'legalitas_tanah', 'sumber_air',
                'topografi', 'jenis_tanah', 'ip_saat_ini', 'ip_potensi',
                'risiko_bencana', 'jml_anggota_aktif', 'alat_eksisting', 'status_kelayakan',
            ];
            foreach ($columnsToDrop as $col) {
                if (Schema::hasColumn('cpcl_verifications', $col)) {
                    $table->dropColumn($col);
                }
            }

            // Fix status_kepemilikan: was enum, now string (more flexible)
            if (Schema::hasColumn('cpcl_verifications', 'status_kepemilikan')) {
                // SQLite doesn't support change(), so we handle gracefully
                try {
                    $table->string('status_kepemilikan')->nullable()->change();
                } catch (\Exception $e) { /* silently ignore on SQLite */ }
            }

            // Add new columns if they don't exist
            if (!Schema::hasColumn('cpcl_verifications', 'kondisi_lahan')) {
                $table->string('kondisi_lahan')->nullable()->after('luas_lahan');
            }
            if (!Schema::hasColumn('cpcl_verifications', 'kesesuaian_komoditas')) {
                $table->boolean('kesesuaian_komoditas')->default(false)->after('kondisi_lahan');
            }
            if (!Schema::hasColumn('cpcl_verifications', 'rekomendasi_surveyor')) {
                $table->string('rekomendasi_surveyor')->nullable()->after('kesesuaian_komoditas');
            }
        });

        // ── survey_documentations ────────────────────────────────────────────
        Schema::table('survey_documentations', function (Blueprint $table) {
            // Drop old FK and column
            if (Schema::hasColumn('survey_documentations', 'cpcl_verification_id')) {
                try { $table->dropForeign(['cpcl_verification_id']); } catch (\Exception $e) {}
                $table->dropColumn('cpcl_verification_id');
            }
            if (Schema::hasColumn('survey_documentations', 'photo_path')) {
                $table->dropColumn('photo_path');
            }

            // Add new columns
            if (!Schema::hasColumn('survey_documentations', 'proposal_id')) {
                $table->foreignId('proposal_id')->after('id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('survey_documentations', 'file_path')) {
                $table->string('file_path')->after('proposal_id');
            }
            if (!Schema::hasColumn('survey_documentations', 'keterangan')) {
                $table->string('keterangan')->nullable()->after('file_path');
            }
        });
    }

    public function down(): void
    {
        // Reverse: restore old structure (simplified)
        Schema::table('survey_documentations', function (Blueprint $table) {
            if (Schema::hasColumn('survey_documentations', 'proposal_id')) {
                try { $table->dropForeign(['proposal_id']); } catch (\Exception $e) {}
                $table->dropColumn(['proposal_id', 'file_path', 'keterangan']);
            }
            $table->foreignId('cpcl_verification_id')->constrained()->cascadeOnDelete();
            $table->string('photo_path');
        });
    }
};
