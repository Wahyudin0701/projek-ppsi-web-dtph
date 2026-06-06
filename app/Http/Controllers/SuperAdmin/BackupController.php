<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    /**
     * Display a listing of backups.
     */
    public function index()
    {
        $disk = Storage::disk('local');
        $files = $disk->files(env('APP_NAME', 'laravel-backup'));

        $backups = [];
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'zip') {
                $basename = basename($file);
                $dateString = str_replace('.zip', '', $basename);
                
                try {
                    // Ekstrak tanggal langsung dari nama file (Y-m-d-H-i-s) yang digenerate oleh Spatie
                    $date = \Carbon\Carbon::createFromFormat('Y-m-d-H-i-s', $dateString);
                } catch (\Exception $e) {
                    // Fallback jika format nama file tidak sesuai
                    $date = \Carbon\Carbon::createFromTimestamp($disk->lastModified($file));
                }

                $backups[] = [
                    'name' => $basename,
                    'path' => $file,
                    'size' => $this->formatSizeUnits($disk->size($file)),
                    'date' => $date,
                ];
            }
        }

        // Sort by newest first
        usort($backups, function ($a, $b) {
            return $b['date']->timestamp <=> $a['date']->timestamp;
        });

        return view('super-admin.backups.index', compact('backups'));
    }

    /**
     * Trigger a new backup process.
     */
    public function store(Request $request)
    {
        try {
            // Fix for Windows mysqldump socket error 10106 when run via Web Server
            putenv('SystemRoot=C:\Windows');
            putenv('SYSTEMROOT=C:\Windows');
            $_ENV['SystemRoot'] = 'C:\Windows';
            $_SERVER['SystemRoot'] = 'C:\Windows';
            $_ENV['SYSTEMROOT'] = 'C:\Windows';
            $_SERVER['SYSTEMROOT'] = 'C:\Windows';
            $_ENV['SystemDrive'] = 'C:';
            $_SERVER['SystemDrive'] = 'C:';
            $_ENV['COMSPEC'] = 'C:\Windows\System32\cmd.exe';
            $_SERVER['COMSPEC'] = 'C:\Windows\System32\cmd.exe';
            
            // Increase limits for backup process
            set_time_limit(300); // 5 minutes
            ini_set('memory_limit', '512M');
            
            $type = $request->input('type', 'db'); // db or full
            
            if ($type === 'full') {
                $exitCode = Artisan::call('backup:run');
            } else {
                $exitCode = Artisan::call('backup:run', ['--only-db' => true]);
            }
            
            $output = Artisan::output();
            
            if ($exitCode !== 0) {
                throw new \Exception("Proses backup gagal (Exit Code: {$exitCode}). Pesan: " . substr($output, 0, 500));
            }

            return redirect()->route('super-admin.backups.index')
                ->with('success', 'Backup berhasil digenerate. Silakan refresh halaman jika file belum muncul.');
        } catch (\Exception $e) {
            return redirect()->route('super-admin.backups.index')
                ->with('error', 'Gagal melakukan backup: ' . $e->getMessage());
        }
    }

    /**
     * Download a specific backup file.
     */
    public function download($fileName)
    {
        $disk = Storage::disk('local');
        $file = env('APP_NAME', 'laravel-backup') . '/' . $fileName;

        if ($disk->exists($file)) {
            return $disk->download($file);
        }

        return redirect()->route('super-admin.backups.index')->with('error', 'File backup tidak ditemukan.');
    }

    /**
     * Delete a specific backup file.
     */
    public function destroy($fileName)
    {
        $disk = Storage::disk('local');
        $file = env('APP_NAME', 'laravel-backup') . '/' . $fileName;

        if ($disk->exists($file)) {
            $disk->delete($file);
            return redirect()->route('super-admin.backups.index')->with('success', 'File backup berhasil dihapus.');
        }

        return redirect()->route('super-admin.backups.index')->with('error', 'File backup tidak ditemukan.');
    }

    /**
     * Format bytes to human readable format.
     */
    private function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}
