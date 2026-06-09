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
        // 1. Tambah kolom document_category_id (nullable sementara)
        Schema::table('documents', function (Blueprint $table) {
            $table->foreignId('document_category_id')->nullable()->constrained('document_categories')->nullOnDelete();
        });

        // 2. Konversi data lama dari category ke tabel document_categories
        $categories = \Illuminate\Support\Facades\DB::table('documents')->select('category')->distinct()->get();
        foreach ($categories as $cat) {
            if ($cat->category) {
                // Cek apakah kategori sudah ada
                $existingCat = \Illuminate\Support\Facades\DB::table('document_categories')->where('name', $cat->category)->first();
                if ($existingCat) {
                    $id = $existingCat->id;
                } else {
                    $id = \Illuminate\Support\Facades\DB::table('document_categories')->insertGetId([
                        'name' => $cat->category,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                
                // Update dokumen yang memiliki category lama
                \Illuminate\Support\Facades\DB::table('documents')
                    ->where('category', $cat->category)
                    ->update(['document_category_id' => $id]);
            }
        }

        // 3. Drop kolom category lama
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('category')->nullable();
        });

        // Kembalikan data (jika memungkinkan)
        $docs = \Illuminate\Support\Facades\DB::table('documents')
            ->join('document_categories', 'documents.document_category_id', '=', 'document_categories.id')
            ->select('documents.id', 'document_categories.name')
            ->get();
            
        foreach ($docs as $doc) {
            \Illuminate\Support\Facades\DB::table('documents')
                ->where('id', $doc->id)
                ->update(['category' => $doc->name]);
        }

        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['document_category_id']);
            $table->dropColumn('document_category_id');
        });
    }
};
