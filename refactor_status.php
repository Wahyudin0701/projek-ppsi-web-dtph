<?php

$searchReplace = [
    "'pending_verifikasi'" => "'sedang_diverifikasi_admin'",
    "\"pending_verifikasi\"" => "\"sedang_diverifikasi_admin\"",
    
    "'diteruskan_ke_pimpinan'" => "'sedang_diverifikasi_pimpinan'",
    "\"diteruskan_ke_pimpinan\"" => "\"sedang_diverifikasi_pimpinan\"",
    
    "'didisposisi_kabid'" => "'persiapan_survei'",
    "\"didisposisi_kabid\"" => "\"persiapan_survei\"",
    
    "'surat_tugas_terbit'" => "'sedang_survei'",
    "\"surat_tugas_terbit\"" => "\"sedang_survei\"",
    
    "'menunggu_review_kabid'" => "'verifikasi_cpcl'",
    "\"menunggu_review_kabid\"" => "\"verifikasi_cpcl\"",
    
    "'menunggu_approval_ba'" => "'menunggu_keputusan_akhir'",
    "\"menunggu_approval_ba\"" => "\"menunggu_keputusan_akhir\"",
];

function processDirectory($dir, $searchReplace) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            processDirectory($path, $searchReplace);
        } else {
            if (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                $content = file_get_contents($path);
                $newContent = str_replace(array_keys($searchReplace), array_values($searchReplace), $content);
                
                // Special handling for the doc block in Proposal.php without quotes
                if (basename($path) === 'Proposal.php') {
                    $newContent = str_replace(
                        ['pending_verifikasi', 'diteruskan_ke_pimpinan', 'didisposisi_kabid', 'surat_tugas_terbit', 'menunggu_review_kabid', 'menunggu_approval_ba'],
                        ['sedang_diverifikasi_admin', 'sedang_diverifikasi_pimpinan', 'persiapan_survei', 'sedang_survei', 'verifikasi_cpcl', 'menunggu_keputusan_akhir'],
                        $newContent
                    );
                }

                if ($content !== $newContent) {
                    file_put_contents($path, $newContent);
                    echo "Updated: $path\n";
                }
            }
        }
    }
}

// Target directories
processDirectory(__DIR__ . '/app/Http/Controllers', $searchReplace);
processDirectory(__DIR__ . '/resources/views', $searchReplace);
processDirectory(__DIR__ . '/database/seeders', $searchReplace);
processDirectory(__DIR__ . '/app/Models', $searchReplace);

echo "Done.\n";
