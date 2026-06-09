<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        Document::truncate();

        $categories = [
            'Juknis' => \App\Models\DocumentCategory::updateOrCreate(
                ['name' => 'Juknis'],
                ['description' => 'Kumpulan Petunjuk Teknis pelaksanaan program dan kegiatan.']
            )->id,
            'Formulir' => \App\Models\DocumentCategory::updateOrCreate(
                ['name' => 'Formulir'],
                ['description' => 'Berbagai formulir standar untuk pengajuan bantuan dan keperluan administratif lainnya.']
            )->id,
            'SOP' => \App\Models\DocumentCategory::updateOrCreate(
                ['name' => 'SOP'],
                ['description' => 'Standar Operasional Prosedur untuk layanan publik dan tata laksana internal.']
            )->id,
        ];

        $documents = [
            [
                'title' => 'Juknis Bantuan Benih Padi Inbrida',
                'description' => 'Petunjuk teknis pelaksanaan program bantuan benih padi inbrida tahun berjalan.',
                'document_category_id' => $categories['Juknis'],
                'file_path' => 'documents/juknis-benih-padi.pdf',
                'file_size' => '2 MB',
                'file_format' => 'pdf',
                'is_public' => true,
            ],
            [
                'title' => 'Formulir CPCL Kosong',
                'description' => 'Formulir Calon Petani dan Calon Lokasi (CPCL) untuk pengajuan bantuan.',
                'document_category_id' => $categories['Formulir'],
                'file_path' => 'documents/formulir-cpcl.docx',
                'file_size' => '1 MB',
                'file_format' => 'docx',
                'is_public' => true,
            ],
            [
                'title' => 'SOP Peminjaman Alsintan',
                'description' => 'Standar Operasional Prosedur untuk peminjaman Alat dan Mesin Pertanian.',
                'document_category_id' => $categories['SOP'],
                'file_path' => 'documents/sop-alsintan.pdf',
                'file_size' => '1.5 MB',
                'file_format' => 'pdf',
                'is_public' => true,
            ],
        ];

        foreach ($documents as $doc) {
            Document::create($doc);
        }
    }
}
