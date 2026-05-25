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
     * Show berita acara detail.
     */
    public function show(Proposal $proposal)
    {
        $this->authorizeKabid($proposal);
        $proposal->load(['user.farmerProfile', 'program', 'alsintan', 'beritaAcara.kabid', 'cpclVerifications', 'surveyDocumentations']);
        $beritaAcara = $proposal->beritaAcara;

        if (!$beritaAcara) {
            return redirect()->route('kabid.proposals.show', $proposal)
                ->with('error', 'Berita acara belum dibuat.');
        }

        return view('kabid.berita-acara.show', compact('proposal', 'beritaAcara'));
    }

    private function authorizeKabid(Proposal $proposal): void
    {
        if ($proposal->kabid_id !== Auth::id()) {
            abort(403, 'Anda tidak berwenang mengelola proposal ini.');
        }
    }
}
