<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FarmerProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        if (!in_array($user->status, ['revisi'])) {
            return redirect()->route('dashboard')->with('error', 'Anda hanya dapat mengedit profil jika status pendaftaran dalam tahap revisi.');
        }

        if ($user->role === 'umum') {
            $profile = $user->umumProfile;
            if (!$profile) {
                return redirect()->route('dashboard')->with('error', 'Profil tidak ditemukan.');
            }
            return view('umum.profile.edit', compact('profile'));
        }

        $profile = $user->farmerProfile;
        if (!$profile) {
            return redirect()->route('dashboard')->with('error', 'Profil tidak ditemukan.');
        }

        return view('farmer.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if (!in_array($user->status, ['revisi'])) {
            return redirect()->route('dashboard')->with('error', 'Anda hanya dapat mengedit profil jika status pendaftaran dalam tahap revisi.');
        }

        // Handle Umum user update
        if ($user->role === 'umum') {
            $profile = $user->umumProfile;
            if (!$profile) {
                return redirect()->route('dashboard')->with('error', 'Profil tidak ditemukan.');
            }

            $validated = $request->validate([
                'nik'      => ['required', 'string', 'size:16'],
                'no_wa'    => ['required', 'string', 'max:20'],
                'alamat'   => ['required', 'string', 'max:500'],
                'foto_ktp' => ['nullable', 'file', 'extensions:jpg,jpeg,png', 'max:5120'],
            ]);

            if ($request->hasFile('foto_ktp')) {
                if ($profile->foto_ktp) {
                    Storage::disk('public')->delete($profile->foto_ktp);
                }
                $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp_umum', 'public');
            }

            $profile->update($validated);
            $user->update(['status' => 'menunggu']);

            return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui dan telah dikirim kembali untuk diverifikasi.');
        }

        // Handle Petani user update
        $profile = $user->farmerProfile;
        if (!$profile) {
            return redirect()->route('dashboard')->with('error', 'Profil tidak ditemukan.');
        }

        $rules = [
            'nama_kelompok' => ['required', 'string', 'max:255'],
            'id_poktan' => ['required', 'string', 'max:255'],
            'no_sk' => ['nullable', 'string', 'max:255'],
            'file_sk' => ['nullable', 'file', 'extensions:pdf,jpg,jpeg,png', 'max:5120'],
            'ketua' => ['required', 'string', 'max:255'],
            'nik_ketua' => ['required', 'string', 'size:16'],
            'foto_ktp' => ['nullable', 'file', 'extensions:jpg,jpeg,png', 'max:5120'],
            'kontak' => ['required', 'string', 'max:20'],
            'grade' => ['required', 'string', 'in:Pemula,Madya,Utama'],
            'luas_lahan' => ['required', 'numeric', 'min:0'],
            'komoditi' => ['required', 'array', 'min:1'],
            'komoditi.*' => ['string', 'max:255'],
            'komoditi_utama' => ['required', 'string', 'in:Padi Sawah,Padi Gogo,Jagung Hibrida,Kedelai,Kacang Tanah,Sayuran,Buah-buahan,Biofarmaka'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'anggota_nama' => ['required', 'array', 'min:1'],
            'anggota_nama.*' => ['required', 'string', 'max:255'],
            'anggota_nik' => ['required', 'array', 'min:1'],
            'anggota_nik.*' => ['required', 'string', 'size:16'],
        ];

        $validated = $request->validate($rules);

        $validated['komoditi'] = implode(', ', $validated['komoditi']);
        $user->update(['status' => 'menunggu']);

        if ($request->hasFile('file_sk')) {
            if ($profile->sk_pengukuhan_path) {
                Storage::disk('public')->delete($profile->sk_pengukuhan_path);
            }
            $validated['sk_pengukuhan_path'] = $request->file('file_sk')->store('sk_kelompok', 'public');
        }

        if ($request->hasFile('foto_ktp')) {
            if ($profile->foto_ktp) {
                Storage::disk('public')->delete($profile->foto_ktp);
            }
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp_ketua', 'public');
        }

        unset($validated['file_sk']);

        $profile->update($validated);

        // Sync user name
        if ($user->name !== $validated['nama_kelompok']) {
            $user->update(['name' => $validated['nama_kelompok']]);
        }

        // Update members: delete all and recreate
        $profile->members()->delete();
        if ($request->has('anggota_nama') && is_array($request->anggota_nama)) {
            foreach ($request->anggota_nama as $index => $namaAnggota) {
                $nikAnggota = $request->anggota_nik[$index] ?? null;
                $profile->members()->create([
                    'nama' => $namaAnggota,
                    'nik' => $nikAnggota,
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui dan telah dikirim kembali untuk diverifikasi.');
    }

    public function requestChange(Request $request)
    {
        $user = Auth::user();

        if ($user->status !== 'approved') {
            return redirect()->route('dashboard')->with('error', 'Anda hanya dapat mengajukan perubahan data jika profil sudah disetujui.');
        }

        $validated = $request->validate([
            'change_request_reason' => 'required|string|max:1000',
        ]);

        $profile = $user->role === 'umum' ? $user->umumProfile : $user->farmerProfile;

        $profile->update([
            'change_request_reason' => $validated['change_request_reason'],
        ]);
        
        $user->update(['status' => 'pengajuan_revisi']);

        // Catat ke log verifikasi jika petani
        if ($user->role === 'petani') {
            $profile->verificationLogs()->create([
                'admin_id' => null, // sistem / oleh petani sendiri
                'status' => 'pengajuan_revisi',
                'notes' => 'Alasan: ' . $validated['change_request_reason'],
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Permohonan perubahan data berhasil dikirim. Silakan tunggu persetujuan dari Admin.');
    }
}
