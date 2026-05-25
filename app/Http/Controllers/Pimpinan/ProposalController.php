<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\DispositionLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    /**
     * Dashboard pimpinan.
     */
    public function dashboard()
    {
        $statsRaw = Proposal::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'diteruskan_ke_pimpinan' THEN 1 ELSE 0 END) as menunggu,
            SUM(CASE WHEN status = 'didisposisi_kabid' THEN 1 ELSE 0 END) as disposisi,
            SUM(CASE WHEN status IN ('surat_tugas_terbit', 'survei_selesai', 'menunggu_review_kabid') THEN 1 ELSE 0 END) as survei,
            SUM(CASE WHEN status = 'menunggu_approval_ba' THEN 1 ELSE 0 END) as menunggu_akhir,
            SUM(CASE WHEN status = 'disetujui' THEN 1 ELSE 0 END) as disetujui,
            SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) as ditolak
        ")->first();

        $stats = [
            'menunggu'       => (int) ($statsRaw->menunggu ?? 0),
            'disposisi'      => (int) ($statsRaw->disposisi ?? 0),
            'survei'         => (int) ($statsRaw->survei ?? 0),
            'menunggu_akhir' => (int) ($statsRaw->menunggu_akhir ?? 0),
            'disetujui'      => (int) ($statsRaw->disetujui ?? 0),
            'ditolak'        => (int) ($statsRaw->ditolak ?? 0),
            'total'          => (int) ($statsRaw->total ?? 0),
        ];

        $pendingProposals = Proposal::with(['user.farmerProfile', 'program', 'alsintan'])
            ->whereIn('status', ['diteruskan_ke_pimpinan', 'menunggu_approval_ba'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('pimpinan.dashboard', compact('stats', 'pendingProposals'));
    }

    /**
     * Daftar semua proposal.
     */
    public function index(Request $request)
    {
        $query = Proposal::with(['user.farmerProfile', 'program', 'alsintan', 'kabid'])
            ->latest('submission_date');

        $query->whereIn('status', [
            'diteruskan_ke_pimpinan', 
            'didisposisi_kabid', 
            'surat_tugas_terbit', 
            'survei_selesai', 
            'menunggu_review_kabid',
            'menunggu_approval_ba'
        ]);

        if ($request->filled('type')) {
            if ($request->type === 'alsintan') {
                $query->whereNotNull('alsintan_id');
            } else {
                $query->whereNotNull('program_id');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('alsintan', fn($a) => $a->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('program', fn($p) => $p->where('name', 'like', "%{$search}%"));
            });
        }

        $proposals = $query->paginate(15)->withQueryString();

        $statsRaw = Proposal::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'diteruskan_ke_pimpinan' THEN 1 ELSE 0 END) as menunggu,
            SUM(CASE WHEN status = 'menunggu_approval_ba' THEN 1 ELSE 0 END) as menunggu_akhir,
            SUM(CASE WHEN status = 'disetujui' THEN 1 ELSE 0 END) as disetujui,
            SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) as ditolak
        ")->first();

        $stats = [
            'menunggu'       => (int) ($statsRaw->menunggu ?? 0),
            'menunggu_akhir' => (int) ($statsRaw->menunggu_akhir ?? 0),
            'disetujui'      => (int) ($statsRaw->disetujui ?? 0),
            'ditolak'        => (int) ($statsRaw->ditolak ?? 0),
            'total'          => (int) ($statsRaw->total ?? 0),
        ];

        $isArchive = false;
        return view('pimpinan.proposals.index', compact('proposals', 'stats', 'isArchive'));
    }

    /**
     * Daftar arsip keputusan proposal.
     */
    public function archives(Request $request)
    {
        $query = Proposal::with(['user.farmerProfile', 'program', 'alsintan', 'kabid'])
            ->latest('submission_date');

        $query->whereIn('status', ['disetujui', 'ditolak']);

        if ($request->filled('type')) {
            if ($request->type === 'alsintan') {
                $query->whereNotNull('alsintan_id');
            } else {
                $query->whereNotNull('program_id');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('alsintan', fn($a) => $a->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('program', fn($p) => $p->where('name', 'like', "%{$search}%"));
            });
        }

        $proposals = $query->paginate(15)->withQueryString();

        $isArchive = true;

        return view('pimpinan.proposals.index', compact('proposals', 'isArchive'));
    }

    /**
     * Detail proposal.
     */
    public function show(Proposal $proposal)
    {
        $proposal->load([
            'user.farmerProfile', 'program', 'alsintan',
            'kabid', 'latestDispositionLog.toUser', 'beritaAcara.kabid',
            'surveyAssignments', 'cpclVerifications', 'surveyDocumentations',
        ]);

        // Kabid yang tersedia untuk disposisi
        $kabidList = User::whereIn('role', ['kabid_psp', 'kabid_tp', 'kabid_hortikultura'])->get();

        return view('pimpinan.proposals.show', compact('proposal', 'kabidList'));
    }

    /**
     * Disposisi proposal ke kabid.
     */
    public function dispose(Request $request, Proposal $proposal)
    {
        if ($proposal->status !== 'diteruskan_ke_pimpinan') {
            return back()->with('error', 'Hanya proposal berstatus "Diteruskan ke Pimpinan" yang dapat didisposisi.');
        }

        $request->validate([
            'kabid_id'          => 'required|exists:users,id',
            'disposition_notes' => 'nullable|string|max:1000',
        ]);

        $kabid = User::findOrFail($request->kabid_id);
        if (!$kabid->isKabid()) {
            return back()->with('error', 'User yang dipilih bukan Kepala Bidang.');
        }

        // Simpan disposisi
        DispositionLog::create([
            'proposal_id' => $proposal->id,
            'disposed_by' => Auth::id(),
            'disposed_to' => $kabid->id,
            'notes'       => $request->disposition_notes,
        ]);

        // Update proposal
        $proposal->update([
            'status'            => 'didisposisi_kabid',
            'kabid_id'          => $kabid->id,
            'disposition_notes' => $request->disposition_notes,
        ]);

        return redirect()->route('pimpinan.proposals.show', $proposal)
            ->with('success', "Proposal berhasil didisposisi ke {$kabid->name}.");
    }

    /**
     * Setujui proposal (keputusan akhir).
     */
    public function approve(Request $request, Proposal $proposal)
    {
        if (!in_array($proposal->status, ['diteruskan_ke_pimpinan', 'menunggu_approval_ba'])) {
            return back()->with('error', 'Proposal tidak dapat disetujui pada status ini.');
        }

        $request->validate([
            'pimpinan_notes' => 'nullable|string|max:1000',
        ]);

        $proposal->update([
            'status'         => 'disetujui',
            'decided_at'     => now(),
            'pimpinan_notes' => $request->pimpinan_notes,
        ]);

        return redirect()->route('pimpinan.proposals.show', $proposal)
            ->with('success', 'Proposal #PRP-' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . ' telah disetujui.');
    }

    /**
     * Tolak proposal (keputusan akhir).
     */
    public function reject(Request $request, Proposal $proposal)
    {
        if (!in_array($proposal->status, ['diteruskan_ke_pimpinan', 'menunggu_approval_ba'])) {
            return back()->with('error', 'Proposal tidak dapat ditolak pada status ini.');
        }

        $request->validate([
            'pimpinan_notes' => 'required|string|max:1000',
        ]);

        $proposal->update([
            'status'         => 'ditolak',
            'decided_at'     => now(),
            'pimpinan_notes' => $request->pimpinan_notes,
        ]);

        return redirect()->route('pimpinan.proposals.show', $proposal)
            ->with('success', 'Proposal #PRP-' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . ' telah ditolak.');
    }
}
