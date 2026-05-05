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
        Schema::table('programs', function (Blueprint $table) {
            $table->string('jenis')->nullable()->after('type'); // alsintan, benih, pupuk, infrastruktur, pelatihan
            $table->text('description')->nullable()->after('jenis');
            $table->string('sasaran')->nullable()->after('description');
            $table->string('kuota')->nullable()->after('sasaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn(['jenis', 'description', 'sasaran', 'kuota']);
        });
    }
};
