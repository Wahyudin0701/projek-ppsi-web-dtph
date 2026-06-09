<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        Article::truncate();

        $articles = [
            [
                'title' => 'Program Bantuan Benih Padi Hibrida Tersalurkan',
                'summary' => 'Pemerintah Kabupaten Muaro Jambi telah sukses menyalurkan benih padi hibrida ke puluhan kelompok tani.',
                'content' => '<p>Pemerintah Kabupaten Muaro Jambi melalui Dinas Tanaman Pangan dan Hortikultura telah berhasil menyalurkan bantuan benih padi hibrida ke puluhan kelompok tani yang tersebar di berbagai kecamatan.</p><p>Program ini diharapkan dapat meningkatkan produktivitas panen petani di musim tanam berikutnya.</p>',
                'category' => 'berita',
                'author_name' => 'Admin DTPH',
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'views' => 150,
            ],
            [
                'title' => 'Cara Merawat Alsintan Traktor Roda 4',
                'summary' => 'Panduan lengkap merawat traktor roda 4 agar awet dan tidak mudah rusak.',
                'content' => '<p>Perawatan traktor roda 4 sangat penting untuk menjaga performa mesin dan umur alat. Berikut adalah panduan perawatannya:</p><ul><li>Selalu cek oli sebelum digunakan.</li><li>Bersihkan filter udara secara berkala.</li><li>Cek tekanan angin ban.</li></ul>',
                'category' => 'artikel',
                'author_name' => 'Penyuluh Pertanian',
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'views' => 320,
            ],
            [
                'title' => 'Pendaftaran Bantuan Pupuk Subsidi 2027 Segera Dibuka',
                'summary' => 'Informasi pendaftaran bantuan pupuk subsidi untuk tahun 2027.',
                'content' => '<p>Bagi kelompok tani yang ingin mendapatkan kuota pupuk bersubsidi tahun 2027, persiapkan berkas pendaftaran mulai sekarang. Pendaftaran akan dibuka pada bulan depan melalui sistem e-Alokasi dan bisa juga dibantu oleh penyuluh lapangan.</p>',
                'category' => 'berita',
                'author_name' => 'Admin DTPH',
                'is_published' => true,
                'published_at' => now(),
                'views' => 45,
            ]
        ];

        foreach ($articles as $article) {
            $article['slug'] = Str::slug($article['title']);
            Article::create($article);
        }
    }
}
