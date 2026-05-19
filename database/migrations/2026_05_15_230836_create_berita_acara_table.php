<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_acara', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kabid_id')->references('id')->on('users')->cascadeOnDelete();
            $table->longText('content');
            $table->date('survey_date');
            $table->string('location');
            $table->string('recommendation'); // direkomendasikan | tidak_direkomendasikan | perlu_tindak_lanjut
            $table->string('attachment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_acara');
    }
};
