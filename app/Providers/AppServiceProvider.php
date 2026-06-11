<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Mime\MimeTypes;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Workaround: bypass fileinfo (League) extension requirement
        $this->app->bind(
            \League\MimeTypeDetection\MimeTypeDetector::class,
            \League\MimeTypeDetection\ExtensionMimeTypeDetector::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Workaround: Register extension-based MIME guesser (Symfony)
        // for servers without the php_fileinfo extension
        if (!extension_loaded('fileinfo')) {
            $mimeTypes = MimeTypes::getDefault();
            $mimeTypes->registerGuesser(new class implements \Symfony\Component\Mime\MimeTypesInterface {
                public function isGuesserSupported(): bool { return true; }
                
                public function getMimeTypes(string $ext): array { return []; }
                
                public function getExtensions(string $mimeType): array
                {
                    $map = [
                        'image/jpeg' => ['jpeg', 'jpg'],
                        'image/png'  => ['png'],
                        'image/gif'  => ['gif'],
                        'image/webp' => ['webp'],
                        'application/pdf' => ['pdf'],
                    ];
                    return $map[$mimeType] ?? [];
                }

                public function guessMimeType(string $path): ?string
                {
                    // Deteksi magic bytes untuk SEMUA file (termasuk file upload sementara)
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
                        'gif'=>'image/gif','webp'=>'image/webp','bmp'=>'image/bmp',
                        'svg'=>'image/svg+xml','pdf'=>'application/pdf',
                        'doc'=>'application/msword',
                        'docx'=>'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'xls'=>'application/vnd.ms-excel',
                        'xlsx'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'zip'=>'application/zip','txt'=>'text/plain',
                        'mp4'=>'video/mp4','mp3'=>'audio/mpeg',
                    ];
                    return $map[$ext] ?? null;
                }
            });
        }

        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });
    }
}
