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
        Schema::table('survey_checklist_items', function (Blueprint $table) {
            $table->string('category')->default('administrasi')->after('item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_checklist_items', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
