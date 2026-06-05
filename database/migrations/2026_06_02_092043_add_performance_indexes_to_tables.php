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
        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
        });

        Schema::table('proposals', function (Blueprint $table) {
            $table->index('status');
            // kabid_id is a foreign key, Laravel might already have an index on it due to constrained(), but adding it explicitly if missing is fine. Actually, foreignId()->constrained() in MySQL creates an index automatically.
            // Let's just index status.
        });

        Schema::table('farmer_profiles', function (Blueprint $table) {
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farmer_profiles', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('proposals', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
        });
    }
};
