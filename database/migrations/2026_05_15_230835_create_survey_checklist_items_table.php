<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survey_checklist_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('surveyor_id')->nullable();
            $table->foreign('surveyor_id')->references('id')->on('users')->nullOnDelete();
            $table->string('item');
            $table->boolean('is_met')->nullable();
            $table->text('notes')->nullable();
            $table->string('photo')->nullable();
            $table->timestamp('checked_at')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_checklist_items');
    }
};
