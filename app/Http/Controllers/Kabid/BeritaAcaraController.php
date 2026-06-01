<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BeritaAcaraController extends Controller
{


    /**
     * Approve berita acara dan generate TTE.
     */
    public function approve(Proposal $proposal)
    {
        $this->authorizeKabid($proposal);
        $beritaAcara = $proposal->beritaAcara;

        if (!$beritaAcara) {
            return back()->with('error', 'Berita Acara belum dibuat.');
        }

        $cpcl = $proposal->cpclVerifications()->latest()->first();
        if (!$cpcl || empty($cpcl->dokumen_fisik_path)) {
            return back()->with('error', 'Dokumen fisik scan Berita Acara (yang telah ditandatangani) wajib diunggah sebelum dapat diteruskan ke Pimpinan.');
        }

        // Generate TTE QR Code (Signature) for Kabid
        \App\Models\DocumentSignature::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'document_type' => 'berita_acara_kabid',
            'document_id' => $beritaAcara->id,
            'signed_by' => auth()->id(),
            'signed_at' => now(),
        ]);

        $proposal->update(['status' => 'menunggu_keputusan_akhir']);

        return redirect()->route('kabid.proposals.show', $proposal)
            ->with('success', 'Berita Acara berhasil disetujui. Proposal diteruskan ke Pimpinan untuk keputusan akhir.');
    }

    private function authorizeKabid(Proposal $proposal): void
    {
        if ($proposal->kabid_id !== Auth::id()) {
            abort(403, 'Anda tidak berwenang mengelola proposal ini.');
        }
    }
}
