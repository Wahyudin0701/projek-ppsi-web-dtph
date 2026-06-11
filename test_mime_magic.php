<?php
require 'vendor/autoload.php';
use Symfony\Component\Mime\MimeTypes;

$mimeTypes = MimeTypes::getDefault();
$mimeTypes->registerGuesser(new class implements \Symfony\Component\Mime\MimeTypesInterface {
    public function isGuesserSupported(): bool { return true; }
    public function getMimeTypes(string $ext): array { return []; }
    public function getExtensions(string $mimeType): array {
        $map = [
            'image/jpeg' => ['jpeg', 'jpg'],
            'image/png'  => ['png'],
            'image/gif'  => ['gif'],
            'image/webp' => ['webp'],
            'application/pdf' => ['pdf'],
        ];
        return $map[$mimeType] ?? [];
    }
    public function guessMimeType(string $path): ?string {
        if (is_file($path)) {
            $f = @fopen($path, 'rb');
            if ($f) {
                $bytes = fread($f, 12);
                fclose($f);
                if (str_starts_with($bytes, "\xFF\xD8\xFF")) return 'image/jpeg';
                if (str_starts_with($bytes, "\x89PNG\x0D\x0A\x1A\x0A")) return 'image/png';
                if (str_starts_with($bytes, "GIF87a") || str_starts_with($bytes, "GIF89a")) return 'image/gif';
                if (str_starts_with($bytes, "RIFF") && substr($bytes, 8, 4) === 'WEBP') return 'image/webp';
                if (str_starts_with($bytes, "%PDF-")) return 'application/pdf';
            }
        }

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $map = [
            'jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png',
            'gif'=>'image/gif','webp'=>'image/webp',
            'pdf'=>'application/pdf',
        ];
        return $map[$ext] ?? null;
    }
});

file_put_contents('test.tmp', "\xFF\xD8\xFF\xE0\x00\x10JFIF");
echo "Guessed test.tmp: " . $mimeTypes->guessMimeType('test.tmp') . PHP_EOL;
unlink('test.tmp');

file_put_contents('test.png.tmp', "\x89PNG\x0D\x0A\x1A\x0A");
echo "Guessed test.png.tmp: " . $mimeTypes->guessMimeType('test.png.tmp') . PHP_EOL;
unlink('test.png.tmp');
