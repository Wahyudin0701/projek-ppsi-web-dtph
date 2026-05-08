<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
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
        $proposals = Auth::user()->proposals()->with(['program', 'alsintan'])->latest()->get();
        return view('farmer.proposals.index', compact('proposals'));
    }

    /**
     * Display the unified proposal submission form.
     */
    public function form()
    {
        $alsintans = \App\Models\Alsintan::where('status', 'tersedia')->get();
        $programs = Program::where('jenis', '!=', 'alsintan')
            ->orderBy('close_date', 'asc')
            ->get()
            ->filter(function($p) {
                return $p->status === 'berjalan';
            });

        return view('farmer.proposals.unified-create', compact('alsintans', 'programs'));
    }

    /**
     * Display programs based on category.
     */
    public function listByCategory(Request $request)
    {
        $category = $request->query('category', 'alsintan');
        
        $query = Program::orderBy('close_date', 'asc');

        if ($category === 'alsintan') {
            $query->where('jenis', 'alsintan');
            $title = 'Program Bantuan Alsintan';
        } else {
            $query->where('jenis', '!=', 'alsintan');
            $title = 'Program Bantuan Lainnya';
        }

        $programs = $query->get()->filter(function($p) {
            return $p->status === 'berjalan';
        });

        return view('farmer.proposals.programs', compact('programs', 'title', 'category'));
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

        return view('farmer.proposals.create', compact('program'));
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
    /**
     * Store a newly created unified proposal in storage.
     */
    public function storeUnified(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'kategori_pengajuan' => 'required|in:alsintan,bantuan',
            'lokasi_lahan' => 'required|string|max:255',
        ]);

        if ($request->kategori_pengajuan === 'alsintan') {
            $request->validate([
                'alsintan_id' => 'required|exists:alsintans,id',
            ]);

            Proposal::create([
                'user_id' => $user->id,
                'alsintan_id' => $request->alsintan_id,
                'lokasi_lahan' => $request->lokasi_lahan,
                'status' => 'pending_verifikasi',
                'submission_date' => now(),
            ]);

        } else {
            $request->validate([
                'program_id' => 'required|exists:programs,id',
            ]);

            $program = Program::findOrFail($request->program_id);

            if (!$program->is_open) {
                return back()->with('error', 'Maaf, pendaftaran untuk program ini sudah ditutup.')->withInput();
            }

            // Check if user already has an active proposal for this TYPE of program
            $existingProposal = Proposal::where('user_id', $user->id)
                ->whereHas('program', function ($query) use ($program) {
                    $query->where('type', $program->type);
                })
                ->whereIn('status', ['pending_verifikasi', 'disetujui'])
                ->first();

            if ($existingProposal) {
                $typeName = str_replace('_', ' ', $program->type);
                return back()->with('error', "Anda sudah memiliki pengajuan aktif untuk jenis program {$typeName}. Silakan tunggu proses selesai sebelum mengajukan kembali untuk jenis yang sama.")->withInput();
            }

            Proposal::create([
                'user_id' => $user->id,
                'program_id' => $program->id,
                'lokasi_lahan' => $request->lokasi_lahan,
                'status' => 'pending_verifikasi',
                'submission_date' => now(),
            ]);
        }

        return redirect()->route('farmer.proposals.index')->with('success', 'Proposal Anda berhasil diajukan dan sedang dalam proses verifikasi.');
    }
}
