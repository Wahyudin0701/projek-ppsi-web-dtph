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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('program_id')->nullable()->constrained('programs')->nullOnDelete();
            $table->foreignId('alsintan_id')->nullable()->constrained('alsintans')->nullOnDelete();
            $table->integer('jumlah_unit')->default(1);
            $table->integer('durasi_sewa_hari')->nullable();
            $table->integer('rencana_durasi_hari')->nullable();
            $table->decimal('target_luas_ha', 8, 2)->nullable();
            $table->string('status')->default('sedang_diverifikasi_admin'); // Was pending_verifikasi/menunggu
            $table->string('foto_lahan')->nullable();
            $table->string('foto_pemetaan')->nullable();
            $table->string('file_proposal')->nullable();
            $table->string('no_surat_pengajuan')->nullable();
            $table->string('nomor_dokumen_final')->nullable();
            $table->timestamp('submission_date')->useCurrent();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('decided_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->text('pimpinan_notes')->nullable();
            $table->foreignId('kabid_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('disposition_notes')->nullable();
            $table->text('kabid_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('proposal_dispositions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposals')->cascadeOnDelete();
            $table->foreignId('disposed_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('disposed_to')->constrained('users')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->timestamp('disposed_at')->useCurrent();
            $table->timestamps();
        });

        Schema::create('survey_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposals')->cascadeOnDelete();
            $table->foreignId('kabid_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('surveyor_id')->constrained('users')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamps();
        });

        Schema::create('survey_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposals')->cascadeOnDelete();
            $table->string('nomor_surat')->unique();
            $table->date('valid_from');
            $table->date('valid_until');
            $table->json('team_members')->nullable();
            $table->string('surat_pengajuan')->nullable();
            $table->string('surat_sk')->nullable();
            $table->boolean('is_approved_by_pimpinan')->default(false);
            $table->timestamps();
        });

        Schema::create('survey_checklist_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposals')->cascadeOnDelete();
            $table->foreignId('surveyor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('item');
            $table->string('category')->default('administrasi');
            $table->boolean('is_met')->nullable();
            $table->text('notes')->nullable();
            $table->string('photo')->nullable();
            $table->timestamp('checked_at')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('survey_documentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposals')->cascadeOnDelete();
            $table->string('file_path');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('berita_acara', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposals')->cascadeOnDelete();
            $table->foreignId('kabid_id')->constrained('users')->cascadeOnDelete();
            $table->text('content')->nullable();
            $table->date('survey_date')->nullable();
            $table->string('location')->nullable();
            $table->string('recommendation')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
        });

        Schema::create('cpcl_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_assignment_id')->constrained('survey_assignments')->cascadeOnDelete();
            $table->foreignId('surveyor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('surveyor_name')->nullable();
            $table->string('surveyor_nip')->nullable();
            $table->decimal('luas_lahan', 8, 2)->nullable();
            $table->string('kondisi_lahan')->nullable();
            $table->boolean('kesesuaian_komoditas')->default(false);
            $table->string('rekomendasi_surveyor')->nullable();
            $table->string('status_kepemilikan')->nullable();
            $table->json('administrative_checklist')->nullable();
            $table->json('technical_checklist')->nullable();
            $table->text('catatan')->nullable();
            $table->string('signature_path')->nullable();
            $table->string('farmer_signature_path')->nullable();
            $table->string('farmer_photo_path')->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->string('dokumen_fisik_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpcl_verifications');
        Schema::dropIfExists('berita_acara');
        Schema::dropIfExists('survey_documentations');
        Schema::dropIfExists('survey_checklist_items');
        Schema::dropIfExists('survey_assignments');
        Schema::dropIfExists('survey_teams');
        Schema::dropIfExists('proposal_dispositions');
        Schema::dropIfExists('proposals');
    }
};
