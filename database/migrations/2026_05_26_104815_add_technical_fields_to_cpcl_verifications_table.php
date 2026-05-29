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
        Schema::table('cpcl_verifications', function (Blueprint $table) {
            $table->string('jenis_tanah')->nullable()->after('luas_lahan');
            $table->string('sumber_air')->nullable()->after('jenis_tanah');
            $table->string('rawan_bencana')->nullable()->after('kondisi_lahan');
            $table->string('pemanfaatan_lahan_sebelumnya')->nullable()->after('rawan_bencana');
            $table->string('pengalaman_budidaya')->nullable()->after('pemanfaatan_lahan_sebelumnya');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cpcl_verifications', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_tanah',
                'sumber_air',
                'rawan_bencana',
                'pemanfaatan_lahan_sebelumnya',
                'pengalaman_budidaya',
            ]);
        });
    }
};
