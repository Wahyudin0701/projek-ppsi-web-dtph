<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Show the form for editing the settings.
     */
    public function edit()
    {
        $homepageBackground = Setting::get('homepage_background');

        return view('super-admin.settings.edit', compact('homepageBackground'));
    }

    /**
     * Update the settings in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'homepage_background' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:20480'], // 20MB max
        ], [
            'homepage_background.image' => 'File harus berupa gambar.',
            'homepage_background.mimes' => 'Format gambar yang diizinkan adalah jpeg, png, jpg, webp.',
            'homepage_background.max' => 'Ukuran gambar maksimal adalah 20MB.',
        ]);

        if ($request->hasFile('homepage_background')) {
            // Hapus file lama jika ada
            $oldImage = Setting::get('homepage_background');
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }

            // Simpan file baru
            $path = $request->file('homepage_background')->store('settings', 'public');
            
            // Simpan ke database
            Setting::updateOrCreate(
                ['key' => 'homepage_background'],
                ['value' => $path]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan web berhasil diperbarui.');
    }
}
