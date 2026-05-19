<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->unsignedBigInteger('kabid_id')->nullable()->after('pimpinan_notes');
            $table->text('disposition_notes')->nullable()->after('kabid_id');
            $table->text('kabid_notes')->nullable()->after('disposition_notes');

            $table->foreign('kabid_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropForeign(['kabid_id']);
            $table->dropColumn(['kabid_id', 'disposition_notes', 'kabid_notes']);
        });
    }
};
