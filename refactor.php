<?php
$dir = __DIR__ . '/resources/views';

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

$replacements = [
    '->nama_kelompok' => '->farmerProfile->nama_kelompok',
    '->ketua' => '->farmerProfile->ketua',
    '->nik_ketua' => '->farmerProfile->nik_ketua',
    '->kontak' => '->farmerProfile->kontak',
    '->luas_lahan' => '->farmerProfile->luas_lahan',
    '->grade' => '->farmerProfile->grade',
    '->alamat' => '->farmerProfile->alamat',
    '->status' => '->farmerProfile->status',
    '->rejection_reason' => '->farmerProfile->rejection_reason',
    '->is_verified_acknowledged' => '->farmerProfile->is_verified_acknowledged',
];

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getRealPath();
        $content = file_get_contents($path);
        $original = $content;

        foreach ($replacements as $search => $replace) {
            // To prevent replacing already replaced strings (e.g. ->farmerProfile->nama_kelompok)
            // we should use regex or careful replacement
            $content = preg_replace('/(?<!farmerProfile)->' . substr($search, 2) . '/', $replace, $content);
        }

        if ($content !== $original) {
            file_put_contents($path, $content);
            echo "Updated: $path\n";
        }
    }
}
