<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    /**
     * Display a listing of the user's proposals.
     */
    public function index()
    {
        $proposals = Auth::user()->proposals()->with('program')->latest()->get();
        return view('pages.farmer.proposals.index', compact('proposals'));
    }

    /**
     * Show the form for creating a new proposal.
     */
    public function create(Program $program)
    {
        // Check if program is open
        if (!$program->is_open) {
            return back()->with('error', 'Maaf, pendaftaran untuk program ini sudah ditutup.');
        }

        return view('pages.farmer.proposals.create', compact('program'));
    }

    /**
     * Store a newly created proposal in storage.
     */
    public function store(Request $request, Program $program)
    {
        $user = Auth::user();

        // 1. Check if program is open
        if (!$program->is_open) {
            return back()->with('error', 'Maaf, pendaftaran untuk program ini sudah ditutup.');
        }

        // 2. Business Rule: Check if user already has an active proposal for this TYPE of program
        $existingProposal = Proposal::where('user_id', $user->id)
            ->whereHas('program', function ($query) use ($program) {
                $query->where('type', $program->type);
            })
            ->whereIn('status', ['pending_verifikasi', 'disetujui']) // Assuming 'disetujui' means it's still "active"
            ->first();

        if ($existingProposal) {
            $typeName = str_replace('_', ' ', $program->type);
            return back()->with('error', "Anda sudah memiliki pengajuan aktif untuk jenis program {$typeName}. Silakan tunggu proses selesai sebelum mengajukan kembali untuk jenis yang sama.");
        }

        $request->validate([
            'lokasi_lahan' => 'required|string|max:255',
        ]);

        Proposal::create([
            'user_id' => $user->id,
            'program_id' => $program->id,
            'lokasi_lahan' => $request->lokasi_lahan,
            'status' => 'pending_verifikasi',
            'submission_date' => now(),
        ]);

        return redirect()->route('farmer.proposals.index')->with('success', 'Proposal Anda berhasil diajukan dan sedang dalam proses verifikasi.');
    }
}
