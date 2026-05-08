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
            $table->foreignId('program_id')->nullable()->change();
            $table->foreignId('alsintan_id')->nullable()->after('program_id')->constrained('alsintans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropForeign(['alsintan_id']);
            $table->dropColumn('alsintan_id');
            $table->foreignId('program_id')->nullable(false)->change();
        });
    }
};
