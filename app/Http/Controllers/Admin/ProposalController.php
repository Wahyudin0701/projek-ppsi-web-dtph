<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ProposalController extends Controller
{
    /**
     * Display a listing of all proposals with optional filters.
     */
    public function index(Request $request)
    {
        $query = Proposal::with(['user.farmerProfile', 'program', 'alsintan'])
            ->latest('submission_date');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type (alsintan or bantuan)
        if ($request->filled('type')) {
            if ($request->type === 'alsintan') {
                $query->whereNotNull('alsintan_id');
            } else {
                $query->whereNotNull('program_id');
            }
        }

        // Filter by search (user name or proposal item name)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('alsintan', fn($a) => $a->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('program', fn($p) => $p->where('name', 'like', "%{$search}%"));
            });
        }

        $proposals = $query->paginate(15)->withQueryString();

        // Stats
        $statsRaw = Proposal::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'pending_verifikasi' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'disetujui' THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) as rejected
        ")->first();

        $stats = [
            'total'    => (int) ($statsRaw->total ?? 0),
            'pending'  => (int) ($statsRaw->pending ?? 0),
            'approved' => (int) ($statsRaw->approved ?? 0),
            'rejected' => (int) ($statsRaw->rejected ?? 0),
        ];

        return view('admin.proposals.index', compact('proposals', 'stats'));
    }

    /**
     * Display the specified proposal detail.
     */
    public function show(Proposal $proposal)
    {
        $proposal->load([
            'user.farmerProfile', 'program', 'alsintan', 
            'dispositionLogs', 'surveyAssignments', 'beritaAcara', 'cpclVerifications'
        ]);
        return view('admin.proposals.show', compact('proposal'));
    }

    /**
     * Forward proposal to pimpinan for final approval.
     */
    public function approve(Request $request, Proposal $proposal)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $proposal->update([
            'status'      => 'diteruskan_ke_pimpinan',
            'reviewed_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.proposals.show', $proposal)
            ->with('success', 'Proposal #PRP-' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . ' telah diteruskan ke Pimpinan untuk persetujuan akhir.');
    }

    /**
     * Reject a proposal (admin decision).
     */
    public function reject(Request $request, Proposal $proposal)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $proposal->update([
            'status'      => 'ditolak',
            'reviewed_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.proposals.show', $proposal)
            ->with('success', 'Proposal #PRP-' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . ' telah ditolak.');
    }


}
