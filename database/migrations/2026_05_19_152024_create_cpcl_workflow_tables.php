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
        Schema::create('disposition_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('from_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('to_user_id')->constrained('users')->cascadeOnDelete();
            $table->text('instruction');
            $table->timestamps();
        });

        Schema::create('survey_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained()->cascadeOnDelete();
            $table->string('nomor_surat')->unique();
            $table->date('valid_from');
            $table->date('valid_until');
            $table->json('team_members')->nullable();
            $table->timestamps();
        });

        Schema::create('cpcl_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_assignment_id')->constrained()->cascadeOnDelete();
            $table->string('status_kepemilikan')->nullable();
            $table->decimal('luas_lahan', 8, 2)->nullable();
            $table->string('kondisi_lahan')->nullable();
            $table->boolean('kesesuaian_komoditas')->default(false);
            $table->string('rekomendasi_surveyor')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('survey_documentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained()->cascadeOnDelete();
            $table->string('file_path');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_documentations');
        Schema::dropIfExists('cpcl_verifications');
        Schema::dropIfExists('survey_assignments');
        Schema::dropIfExists('disposition_logs');
    }
};
