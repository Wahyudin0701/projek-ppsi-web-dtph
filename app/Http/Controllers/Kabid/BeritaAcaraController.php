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

        // Generate TTE QR Code (Signature) for Kabid
        \App\Models\DocumentSignature::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'document_type' => 'berita_acara_kabid',
            'document_id' => $beritaAcara->id,
            'signed_by' => auth()->id(),
            'signed_at' => now(),
        ]);

        $proposal->update(['status' => 'menunggu_approval_ba']);

        return redirect()->route('kabid.proposals.show', $proposal)
            ->with('success', 'Berita Acara berhasil disetujui. TTE telah disematkan. Proposal diteruskan ke Pimpinan untuk keputusan akhir.');
    }

    private function authorizeKabid(Proposal $proposal): void
    {
        if ($proposal->kabid_id !== Auth::id()) {
            abort(403, 'Anda tidak berwenang mengelola proposal ini.');
        }
    }
}
