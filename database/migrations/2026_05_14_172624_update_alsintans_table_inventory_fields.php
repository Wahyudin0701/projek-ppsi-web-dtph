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
        Schema::table('alsintans', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->integer('borrowed_count')->default(0)->after('stock');
            $table->integer('broken_count')->default(0)->after('borrowed_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alsintans', function (Blueprint $table) {
            $table->enum('status', ['tersedia', 'tidak_tersedia', 'rusak'])->default('tersedia')->after('stock');
            $table->dropColumn(['borrowed_count', 'broken_count']);
        });
    }
};
