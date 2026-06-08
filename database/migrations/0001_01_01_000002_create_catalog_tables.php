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
            $table->enum('type', ['bantuan_permanen', 'usulan_pendanaan']);
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

        Schema::create('alsintan_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('alsintans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('alsintan_category_id')->nullable()->constrained('alsintan_categories')->onDelete('restrict');
            $table->string('merk')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('juknis_file')->nullable();
            $table->string('juknis_url')->nullable();
            $table->timestamps();
        });

        Schema::create('alsintan_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alsintan_id')->constrained('alsintans')->cascadeOnDelete();
            $table->string('nomor_rangka')->nullable();
            $table->string('nomor_mesin')->nullable();
            $table->string('sumber_dana')->nullable();
            $table->integer('tahun_pengadaan')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('status_ketersediaan', ['Tersedia', 'Dipinjam', 'Sedang Rusak'])->default('Tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alsintan_inventories');
        Schema::dropIfExists('alsintans');
        Schema::dropIfExists('alsintan_categories');
        Schema::dropIfExists('programs');
    }
};
