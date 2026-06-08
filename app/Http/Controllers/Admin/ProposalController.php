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
            SUM(CASE WHEN status = 'sedang_diverifikasi_admin' THEN 1 ELSE 0 END) as pending,
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
            'status'      => 'sedang_diverifikasi_pimpinan',
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

    /**
     * Input the official document number (Surat Perjanjian / SK Bantuan) for approved proposals.
     */
    public function inputNomor(Request $request, Proposal $proposal)
    {
        // Generate number: SP/{Year}/{Month}/PRP-{ID}
        $year = date('Y');
        $month = date('m');
        $id = str_pad($proposal->id, 3, '0', STR_PAD_LEFT);
        $nomor = "SP/{$year}/{$month}/PRP-{$id}";

        $proposal->update([
            'nomor_dokumen_final' => $nomor,
        ]);

        return redirect()->route('admin.proposals.show', $proposal)
            ->with('success', "Nomor dokumen resmi ($nomor) berhasil diterbitkan secara otomatis.");
    }

    /**
     * Mark a borrowed Alsintan as returned.
     */
    public function markAsReturned(Request $request, Proposal $proposal)
    {
        if ($proposal->status !== 'disetujui' || !$proposal->alsintan_id) {
            abort(400, 'Hanya proposal alsintan yang sudah disetujui yang dapat dikembalikan.');
        }

        // 1. Update proposal status
        $proposal->update([
            'status' => 'dikembalikan',
            'returned_at' => now(),
        ]);

        // 2. Free up the inventory item if any
        if ($proposal->alsintan_inventory_id) {
            \App\Models\AlsintanInventory::where('id', $proposal->alsintan_inventory_id)
                ->update(['status_ketersediaan' => 'Tersedia']);
        }

        return redirect()->route('admin.proposals.show', $proposal)
            ->with('success', 'Alat berat untuk proposal #PRP-' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . ' telah berhasil ditandai sebagai dikembalikan. Stok alat telah kembali tersedia.');
    }
}
