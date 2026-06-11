<?php
/**
 * Polyfill untuk class finfo jika ekstensi fileinfo tidak tersedia di server.
 * File ini di-include sebelum autoloader agar FinfoMimeTypeDetector tidak crash.
 */
if (!class_exists('finfo')) {
    class finfo
    {
        public function __construct(int $flags = 0, ?string $magic_database = null) {}

        public function buffer(string $string, int $flags = 0, $context = null): string|false
        {
            return false;
        }

        public function file(string $filename, int $flags = 0, $context = null): string|false
        {
            return false;
        }
    }
}
