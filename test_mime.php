<?php
require 'vendor/autoload.php';
use Symfony\Component\Mime\MimeTypes;

$mimeTypes = MimeTypes::getDefault();
$mimeTypes->registerGuesser(new class implements \Symfony\Component\Mime\MimeTypesInterface {
    public function isGuesserSupported(): bool { return true; }
    public function getMimeTypes(string $ext): array { return []; }
    public function getExtensions(string $mimeType): array {
        $map = ['image/jpeg' => ['jpeg', 'jpg']];
        return $map[$mimeType] ?? [];
    }
    public function guessMimeType(string $path): ?string {
        return 'image/jpeg';
    }
});

echo "Guessed: " . $mimeTypes->guessMimeType('artisan') . PHP_EOL;
echo "Extensions: " . implode(',', $mimeTypes->getExtensions('image/jpeg')) . PHP_EOL;
