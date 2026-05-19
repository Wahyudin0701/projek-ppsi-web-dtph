<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposal_dispositions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('disposed_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('disposed_to')->references('id')->on('users')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->timestamp('disposed_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposal_dispositions');
    }
};
