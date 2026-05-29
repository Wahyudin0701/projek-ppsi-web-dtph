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
            'survei_selesai'  => $allProposals->whereIn('status', ['survei_selesai', 'menunggu_review_kabid'])->count(),
            'selesai'         => $allProposals->whereIn('status', ['menunggu_approval_ba', 'disetujui', 'ditolak'])->count(),
        ];

        $pendingAction = Proposal::where('kabid_id', $kabid->id)
            ->whereIn('status', ['didisposisi_kabid', 'survei_selesai', 'menunggu_review_kabid'])
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
                  ->orWhereHas('user.farmerProfile', fn($f) => $f->where('nama_kelompok', 'like', "%{$search}%"))
                  ->orWhereHas('alsintan', fn($a) => $a->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('program', fn($p) => $p->where('name', 'like', "%{$search}%"))
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $proposals = $query->latest('updated_at')->paginate(15)->withQueryString();

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
     * Show form to assign survey team.
     */
    public function showAssignTeamForm(Proposal $proposal)
    {
        $this->authorizeKabid($proposal);

        if ($proposal->status !== 'didisposisi_kabid') {
            return redirect()->route('kabid.proposals.show', $proposal)
                ->with('error', 'Proposal tidak dalam status disposisi untuk pembentukan tim survei.');
        }

        $proposal->load(['user.farmerProfile', 'program', 'alsintan']);
        $employees = \App\Models\Employee::all();

        return view('kabid.proposals.assign-team', compact('proposal', 'employees'));
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
            'nomor_surat'   => 'required|string|max:255|unique:survey_assignments,nomor_surat',
            'no_surat_pengajuan' => 'nullable|string|max:255',
            'valid_from'    => 'required|date',
            'valid_until'   => 'required|date|after_or_equal:valid_from',
            'team_members'  => 'required|array|min:1',
            'team_members.*.name' => 'required|string|distinct',
            'team_members.*.nip'  => 'nullable|string',
            'team_members.*.role' => 'required|string',
        ]);

        // Buat assignment dengan nomor surat custom dari input
        $assignment = SurveyAssignment::create([
            'proposal_id'  => $proposal->id,
            'nomor_surat'  => $request->nomor_surat,
            'no_surat_pengajuan' => $request->no_surat_pengajuan,
            'valid_from'   => $request->valid_from,
            'valid_until'  => $request->valid_until,
            'team_members' => $request->team_members,
        ]);

        // Generate TTE QR Code (Signature) for Kabid
        \App\Models\DocumentSignature::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'document_type' => 'surat_tugas',
            'document_id' => $assignment->id,
            'signed_by' => auth()->id(),
            'signed_at' => now(),
        ]);

        $proposal->update(['status' => 'surat_tugas_terbit']);

        return redirect()->route('kabid.proposals.show', $proposal)
            ->with('success', 'Tim survei berhasil dibentuk. Surat tugas akan diterbitkan oleh Admin.');
    }

    /**
     * Show form to edit a survey assignment.
     */
    public function editAssignment(Proposal $proposal, SurveyAssignment $assignment)
    {
        $this->authorizeKabid($proposal);

        if ($assignment->proposal_id !== $proposal->id) {
            abort(404);
        }

        $proposal->load(['user.farmerProfile', 'program', 'alsintan']);
        $employees = \App\Models\Employee::all();

        return view('kabid.proposals.edit-assignment', compact('proposal', 'assignment', 'employees'));
    }

    /**
     * Update a survey assignment.
     */
    public function updateAssignment(Request $request, Proposal $proposal, SurveyAssignment $assignment)
    {
        $this->authorizeKabid($proposal);

        if ($assignment->proposal_id !== $proposal->id) {
            abort(404);
        }

        $request->validate([
            'nomor_surat'   => 'required|string|max:255|unique:survey_assignments,nomor_surat,' . $assignment->id,
            'no_surat_pengajuan' => 'nullable|string|max:255',
            'valid_from'    => 'required|date',
            'valid_until'   => 'required|date|after_or_equal:valid_from',
            'team_members'  => 'required|array|min:1',
            'team_members.*.name' => 'required|string|distinct',
            'team_members.*.nip'  => 'nullable|string',
            'team_members.*.role' => 'required|string',
        ]);

        $assignment->update([
            'nomor_surat'  => $request->nomor_surat,
            'no_surat_pengajuan' => $request->no_surat_pengajuan,
            'valid_from'   => $request->valid_from,
            'valid_until'  => $request->valid_until,
            'team_members' => $request->team_members,
        ]);

        return redirect()->route('kabid.proposals.show', $proposal)
            ->with('success', 'Data tim survei berhasil diperbarui.');
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
