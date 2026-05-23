<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmerProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->farmerProfile;

        if (!$profile || !in_array($profile->status, ['revisi'])) {
            return redirect()->route('dashboard')->with('error', 'Anda hanya dapat mengedit profil jika status pendaftaran dalam tahap revisi.');
        }

        return view('farmer.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->farmerProfile;

        if (!$profile || !in_array($profile->status, ['revisi'])) {
            return redirect()->route('dashboard')->with('error', 'Anda hanya dapat mengedit profil jika status pendaftaran dalam tahap revisi.');
        }

        $rules = [
            'nama_kelompok' => ['required', 'string', 'max:255'],
            'ketua' => ['required', 'string', 'max:255'],
            'nik_ketua' => ['required', 'string', 'size:16'],
            'kontak' => ['required', 'string', 'max:20'],
            'grade' => ['required', 'string', 'in:Pemula,Madya,Utama'],
            'luas_lahan' => ['required', 'numeric', 'min:0'],
            'komoditi' => ['required', 'array', 'min:1'],
            'komoditi.*' => ['string', 'in:Padi Sawah,Padi Gogo,Jagung,Cabai,Sayuran,Kelapa Sawit'],
            'komoditi_utama' => ['required', 'string', 'in:Padi Sawah,Padi Gogo,Jagung,Cabai,Sayuran,Kelapa Sawit'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'anggota' => ['required', 'array', 'min:1'],
            'anggota.*' => ['required', 'string', 'max:255'],
        ];

        $validated = $request->validate($rules);

        $validated['komoditi'] = implode(', ', $validated['komoditi']);
        $validated['status'] = 'menunggu';

        $profile->update($validated);

        // Sync user name
        if ($user->name !== $validated['nama_kelompok']) {
            $user->update(['name' => $validated['nama_kelompok']]);
        }

        // Update members: delete all and recreate
        $profile->members()->delete();
        if ($request->has('anggota') && is_array($request->anggota)) {
            foreach ($request->anggota as $namaAnggota) {
                $profile->members()->create(['nama' => $namaAnggota]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui dan telah dikirim kembali untuk diverifikasi.');
    }

    public function requestChange(Request $request)
    {
        $user = Auth::user();
        $profile = $user->farmerProfile;

        if (!$profile || $profile->status !== 'approved') {
            return redirect()->route('dashboard')->with('error', 'Anda hanya dapat mengajukan perubahan data jika profil sudah disetujui.');
        }

        $validated = $request->validate([
            'change_request_reason' => 'required|string|max:1000',
        ]);

        $profile->update([
            'status' => 'pengajuan_revisi',
            'change_request_reason' => $validated['change_request_reason'],
        ]);

        // Catat ke log verifikasi bahwa petani mengajukan perubahan
        $profile->verificationLogs()->create([
            'admin_id' => null, // sistem / oleh petani sendiri
            'status' => 'pengajuan_revisi',
            'notes' => 'Alasan: ' . $validated['change_request_reason'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Permohonan perubahan data berhasil dikirim. Silakan tunggu persetujuan dari Admin.');
    }
}
