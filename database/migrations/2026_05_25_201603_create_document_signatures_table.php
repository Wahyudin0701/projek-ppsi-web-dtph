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
        Schema::create('document_signatures', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('document_type'); // 'surat_tugas', 'berita_acara'
            $table->unsignedBigInteger('document_id');
            $table->foreignId('signed_by')->constrained('users')->cascadeOnDelete();
            $table->timestamp('signed_at')->useCurrent();       
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_signatures');
    }
};
