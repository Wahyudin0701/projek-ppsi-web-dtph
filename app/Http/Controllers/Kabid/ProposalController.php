<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\SurveyAssignment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProposalController extends Controller
{
    /**
     * Dashboard Kepala Bidang.
     */
    public function dashboard()
    {
        $kabid = Auth::user();

        $allProposals = Proposal::where('kabid_id', $kabid->id)->get();

        $stats = [
            'total'           => $allProposals->count(),
            'menunggu_survei' => $allProposals->whereIn('status', ['didisposisi_kabid'])->count(),
            'dalam_survei'    => $allProposals->where('status', 'surat_tugas_terbit')->count(),
            'survei_selesai'  => $allProposals->where('status', 'survei_selesai')->count(),
            'selesai'         => $allProposals->whereIn('status', ['menunggu_approval_ba', 'disetujui', 'ditolak'])->count(),
        ];

        $pendingAction = Proposal::where('kabid_id', $kabid->id)
            ->whereIn('status', ['didisposisi_kabid', 'survei_selesai'])
            ->with(['user.farmerProfile', 'program', 'alsintan'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('kabid.dashboard', compact('stats', 'pendingAction', 'kabid'));
    }

    /**
     * List all proposals assigned to this kabid.
     */
    public function index(Request $request)
    {
        $kabid = Auth::user();
        $query = Proposal::where('kabid_id', $kabid->id)
            ->with(['user.farmerProfile', 'program', 'alsintan']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $proposals = $query->latest('updated_at')->get();

        return view('kabid.proposals.index', compact('proposals'));
    }

    /**
     * Show proposal detail + assign team form.
     */
    public function show(Proposal $proposal)
    {
        $this->authorizeKabid($proposal);

        $proposal->load([
            'user.farmerProfile', 'program', 'alsintan',
            'surveyAssignments', 'latestDispositionLog.fromUser', 'beritaAcara.kabid',
            'cpclVerifications', 'surveyDocumentations',
        ]);

        return view('kabid.proposals.show', compact('proposal'));
    }

    /**
     * Assign tim survei ke proposal.
     */
    public function assignTeam(Request $request, Proposal $proposal)
    {
        $this->authorizeKabid($proposal);

        if ($proposal->status !== 'didisposisi_kabid') {
            return back()->with('error', 'Proposal tidak dalam status disposisi.');
        }

        $request->validate([
            'valid_from'    => 'required|date',
            'valid_until'   => 'required|date|after_or_equal:valid_from',
            'team_members'  => 'required|array|min:1',
            'team_members.*.name' => 'required|string',
            'team_members.*.role' => 'required|string',
        ]);

        // Generate nomor surat
        $nomorSurat = $this->generateNomorSurat();

        // Buat assignment
        SurveyAssignment::create([
            'proposal_id'  => $proposal->id,
            'nomor_surat'  => $nomorSurat,
            'valid_from'   => $request->valid_from,
            'valid_until'  => $request->valid_until,
            'team_members' => $request->team_members,
        ]);

        $proposal->update(['status' => 'surat_tugas_terbit']);

        return redirect()->route('kabid.proposals.show', $proposal)
            ->with('success', 'Tim survei berhasil dibentuk. Surat tugas akan diterbitkan oleh Admin.');
    }

    private function generateNomorSurat(): string
    {
        $year = date('Y');
        $month = date('m');
        $count = SurveyAssignment::whereYear('created_at', $year)->count() + 1;
        $paddedCount = str_pad($count, 3, '0', STR_PAD_LEFT);
        
        // Contoh format: 001/80.a/Kep-PPK/DTPH/2026
        return "{$paddedCount}/80.a/Kep-PPK/DTPH/{$year}";
    }

    /**
     * Authorize that the logged-in kabid owns this proposal.
     */
    private function authorizeKabid(Proposal $proposal): void
    {
        if ($proposal->kabid_id !== Auth::id()) {
            abort(403, 'Anda tidak berwenang mengelola proposal ini.');
        }
    }
}
