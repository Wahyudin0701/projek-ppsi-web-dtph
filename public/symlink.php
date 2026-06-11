<?php
$targetFolder = $_SERVER['DOCUMENT_ROOT'] . '/../dtph_app/storage/app/public';
$linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';

// Hapus link lama jika ada, agar tidak error
if(file_exists($linkFolder)){
    if(is_link($linkFolder)) {
        unlink($linkFolder);
    } else {
        echo "Error: folder 'storage' sudah ada dan bukan link. Harap hapus folder public_html/storage secara manual terlebih dahulu.";
        exit;
    }
}

// Buat Symlink
if(symlink($targetFolder, $linkFolder)) {
    echo "Symlink berhasil dibuat! Gambar sekarang akan muncul.";
} else {
    echo "Gagal membuat symlink. Kemungkinan fitur ini didisable oleh hosting.";
}
?>
