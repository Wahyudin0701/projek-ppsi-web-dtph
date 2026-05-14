<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;

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
        $stats = [
            'total'    => Proposal::count(),
            'pending'  => Proposal::where('status', 'pending_verifikasi')->count(),
            'approved' => Proposal::where('status', 'disetujui')->count(),
            'rejected' => Proposal::where('status', 'ditolak')->count(),
        ];

        return view('admin.proposals.index', compact('proposals', 'stats'));
    }

    /**
     * Display the specified proposal detail.
     */
    public function show(Proposal $proposal)
    {
        $proposal->load(['user.farmerProfile', 'program', 'alsintan']);
        return view('admin.proposals.show', compact('proposal'));
    }

    /**
     * Approve a proposal.
     */
    public function approve(Proposal $proposal)
    {
        $proposal->update(['status' => 'disetujui']);

        return redirect()->route('admin.proposals.show', $proposal)
            ->with('success', 'Proposal #PRP-' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . ' berhasil disetujui.');
    }

    /**
     * Reject a proposal.
     */
    public function reject(Proposal $proposal)
    {
        $proposal->update(['status' => 'ditolak']);

        return redirect()->route('admin.proposals.show', $proposal)
            ->with('success', 'Proposal #PRP-' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . ' telah ditolak.');
    }
}
