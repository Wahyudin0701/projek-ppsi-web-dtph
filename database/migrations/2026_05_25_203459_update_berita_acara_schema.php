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
        Schema::table('berita_acara', function (Blueprint $table) {
            $table->dropColumn(['nomor_ba', 'status_rekomendasi', 'catatan_kabid', 'file_path', 'is_approved_by_pimpinan']);
            
            $table->text('content')->nullable();
            $table->date('survey_date')->nullable();
            $table->string('location')->nullable();
            $table->string('recommendation')->nullable();
            $table->string('attachment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berita_acara', function (Blueprint $table) {
            $table->string('nomor_ba')->unique()->nullable();
            $table->string('status_rekomendasi')->nullable();
            $table->text('catatan_kabid')->nullable();
            $table->string('file_path')->nullable();
            $table->boolean('is_approved_by_pimpinan')->default(false);

            $table->dropColumn(['content', 'survey_date', 'location', 'recommendation', 'attachment']);
        });
    }
};
