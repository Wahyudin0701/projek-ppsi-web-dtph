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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['bantuan_permanen', 'pinjam_alat', 'usulan_pendanaan']);
            $table->string('jenis')->nullable();
            $table->text('description')->nullable();
            $table->text('sop_description')->nullable();
            $table->string('sasaran')->nullable();
            $table->string('kuota')->nullable();
            $table->json('requirements')->nullable();
            $table->boolean('is_open')->default(true);
            $table->date('open_date')->nullable();
            $table->date('close_date')->nullable();
            $table->timestamps();
        });

        Schema::create('alsintans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('merk')->nullable();
            $table->string('nomor_rangka')->nullable();
            $table->string('nomor_mesin')->nullable();
            $table->integer('tahun_perolehan')->nullable();
            $table->string('capacity')->nullable();
            $table->integer('stock')->default(0);
            $table->integer('borrowed_count')->default(0);
            $table->integer('broken_count')->default(0);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('juknis_file')->nullable();
            $table->string('juknis_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alsintans');
        Schema::dropIfExists('programs');
    }
};
