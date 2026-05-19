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
     * Show form to create berita acara.
     */
    public function create(Proposal $proposal)
    {
        $this->authorizeKabid($proposal);

        if ($proposal->status !== 'survei_selesai') {
            return redirect()->route('kabid.proposals.show', $proposal)
                ->with('error', 'Berita acara hanya dapat dibuat setelah survei selesai (CPCL diinput).');
        }

        if ($proposal->beritaAcara) {
            return redirect()->route('kabid.berita-acara.show', $proposal)
                ->with('info', 'Berita acara sudah dibuat sebelumnya.');
        }

        $proposal->load(['user.farmerProfile', 'program', 'alsintan', 'surveyAssignments', 'cpclVerifications', 'surveyDocumentations']);

        return view('kabid.berita-acara.create', compact('proposal'));
    }

    /**
     * Store the berita acara.
     */
    public function store(Request $request, Proposal $proposal)
    {
        $this->authorizeKabid($proposal);

        $request->validate([
            'content'        => 'required|string|min:50',
            'survey_date'    => 'required|date|before_or_equal:today',
            'location'       => 'required|string|max:255',
            'recommendation' => 'required|in:direkomendasikan,tidak_direkomendasikan,perlu_tindak_lanjut',
            'attachment'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('berita-acara', 'public');
        }

        BeritaAcara::create([
            'proposal_id'    => $proposal->id,
            'kabid_id'       => Auth::id(),
            'content'        => $request->input('content'),
            'survey_date'    => $request->input('survey_date'),
            'location'       => $request->input('location'),
            'recommendation' => $request->input('recommendation'),
            'attachment'     => $attachmentPath,
        ]);

        // Update proposal status ke menunggu approval ba pimpinan
        $proposal->update([
            'status'      => 'menunggu_approval_ba',
            'kabid_notes' => $request->input('kabid_notes'),
        ]);

        return redirect()->route('kabid.proposals.show', $proposal)
            ->with('success', 'Berita acara berhasil dibuat. Proposal diteruskan ke Pimpinan untuk keputusan akhir.');
    }

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
