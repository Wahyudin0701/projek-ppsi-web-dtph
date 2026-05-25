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
     * Show selection page for proposal type.
     */
    public function selectType()
    {
        return view('farmer.proposals.selection');
    }

    /**
     * List available Alsintan for borrowing proposal.
     */
    public function alsintanList()
    {
        // IDs alsintan yang sudah memiliki proposal aktif (belum selesai diverifikasi)
        $activeAlsintanIds = Proposal::where('user_id', Auth::id())
            ->whereNotNull('alsintan_id')
            ->whereIn('status', ['pending_verifikasi', 'disetujui'])
            ->pluck('alsintan_id')
            ->toArray();

        $all = \App\Models\Alsintan::latest()->get();

        // Tersedia: stok ada & belum ada proposal aktif
        $alsintans = $all->filter(fn($a) => $a->available_stock > 0 && !in_array($a->id, $activeAlsintanIds))->values();

        // Tidak tersedia: stok habis ATAU sudah ada proposal aktif
        $unavailableAlsintans = $all->filter(fn($a) => $a->available_stock <= 0 || in_array($a->id, $activeAlsintanIds))->values();

        return view('farmer.proposals.alsintan.list', compact('alsintans', 'unavailableAlsintans', 'activeAlsintanIds'));
    }

    /**
     * Show Alsintan detail page.
     */
    public function alsintanShow(\App\Models\Alsintan $alsintan)
    {
        return view('farmer.proposals.alsintan.show', compact('alsintan'));
    }

    /**
     * Show form to submit Alsintan borrowing proposal.
     */
    public function alsintanCreate(\App\Models\Alsintan $alsintan)
    {
        if ($alsintan->available_stock <= 0) {
            return back()->with('error', 'Stok alat ini sedang habis atau tidak tersedia untuk dipinjam.');
        }

        // Cek apakah user sudah punya proposal aktif untuk alat ini
        $existingProposal = Proposal::where('user_id', Auth::id())
            ->where('alsintan_id', $alsintan->id)
            ->whereIn('status', ['pending_verifikasi', 'disetujui'])
            ->first();

        if ($existingProposal) {
            return redirect()->route('farmer.proposals.alsintan')
                ->with('error', 'Anda sudah memiliki proposal aktif untuk alat "' . $alsintan->name . '". Silakan tunggu proses verifikasi selesai.');
        }

        return view('farmer.proposals.alsintan.create', compact('alsintan'));
    }

    /**
     * Store Alsintan borrowing proposal.
     */
    public function alsintanStore(Request $request, \App\Models\Alsintan $alsintan)
    {
        $user = Auth::user();

        if ($alsintan->available_stock <= 0) {
            return back()->with('error', 'Stok alat ini sedang habis atau tidak tersedia untuk dipinjam.');
        }

        // Blokir jika sudah ada proposal aktif untuk alat yang sama
        $existingProposal = Proposal::where('user_id', $user->id)
            ->where('alsintan_id', $alsintan->id)
            ->whereIn('status', ['pending_verifikasi', 'disetujui'])
            ->first();

        if ($existingProposal) {
            return redirect()->route('farmer.proposals.alsintan')
                ->with('error', 'Anda sudah memiliki proposal aktif untuk alat "' . $alsintan->name . '". Silakan tunggu proses verifikasi selesai.');
        }

        $request->validate([
            'rencana_durasi_hari' => 'required|integer|min:1|max:365',
            'file_proposal'       => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $filePath = $request->file('file_proposal')->store('proposals', 'public');

        $proposal = Proposal::create([
            'user_id'             => $user->id,
            'alsintan_id'         => $alsintan->id,
            'rencana_durasi_hari' => $request->rencana_durasi_hari,
            'file_proposal'       => $filePath,
            'status'              => 'pending_verifikasi',
            'submission_date'     => now(),
        ]);

        return redirect()->route('farmer.proposals.success', $proposal->id);
    }

    /**
     * List open programs for bantuan proposal.
     */
    public function bantuanList()
    {
        $all = Program::withCount('proposals')
            ->orderBy('close_date', 'asc')
            ->get();

        // Program yang masih bisa diajukan
        $programs = $all->filter(fn($p) => $p->is_open)->values();

        // Program yang sudah tutup
        $closedPrograms = $all->filter(fn($p) => !$p->is_open)->values();

        return view('farmer.proposals.bantuan.list', compact('programs', 'closedPrograms'));
    }

    /**
     * Display the unified proposal submission form (legacy).
     */
    public function form()
    {
        $alsintans = \App\Models\Alsintan::latest()->get()
            ->filter(fn($a) => $a->available_stock > 0)
            ->values();
        $programs = Program::orderBy('close_date', 'asc')
            ->get()
            ->filter(function($p) {
                return $p->status === 'berjalan';
            });

        return view('farmer.proposals.unified-create', compact('alsintans', 'programs'));
    }



    /**
     * Show the details of a proposal.
     */
    public function show(Proposal $proposal)
    {
        if ($proposal->user_id !== Auth::id()) {
            abort(403);
        }

        $proposal->load(['program', 'alsintan', 'user.farmerProfile', 'latestDispositionLog', 'surveyAssignments', 'cpclVerifications', 'surveyDocumentations', 'beritaAcara']);

        return view('farmer.proposals.show', compact('proposal'));
    }

    /**
     * Show the details of a program.
     */
    public function bantuanShow(Program $program)
    {
        return view('farmer.proposals.bantuan.show', compact('program'));
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

        return view('farmer.proposals.bantuan.create', compact('program'));
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
            'rencana_durasi_hari' => 'nullable|integer|min:1|max:365',
            'file_proposal' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $filePath = $request->file('file_proposal')->store('proposals', 'public');

        $proposal = Proposal::create([
            'user_id' => $user->id,
            'program_id' => $program->id,
            'rencana_durasi_hari' => $request->rencana_durasi_hari,
            'file_proposal' => $filePath,
            'status' => 'pending_verifikasi',
            'submission_date' => now(),
        ]);

        return redirect()->route('farmer.proposals.success', $proposal->id);
    }
    /**
     * Store a newly created unified proposal in storage.
     */
    public function storeUnified(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'kategori_pengajuan' => 'required|in:alsintan,bantuan',
            'rencana_durasi_hari' => 'nullable|integer|min:1|max:365',
            'file_proposal' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $filePath = $request->file('file_proposal')->store('proposals', 'public');

        if ($request->kategori_pengajuan === 'alsintan') {
            $request->validate([
                'alsintan_id' => 'required|exists:alsintans,id',
                'rencana_durasi_hari' => 'required|integer|min:1|max:365',
            ]);

            $proposal = Proposal::create([
                'user_id' => $user->id,
                'alsintan_id' => $request->alsintan_id,
                'rencana_durasi_hari' => $request->rencana_durasi_hari,
                'file_proposal' => $filePath,
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

            $proposal = Proposal::create([
                'user_id' => $user->id,
                'program_id' => $program->id,
                'rencana_durasi_hari' => $request->rencana_durasi_hari,
                'file_proposal' => $filePath,
                'status' => 'pending_verifikasi',
                'submission_date' => now(),
            ]);
        }

        return redirect()->route('farmer.proposals.success', $proposal->id);
    }

    /**
     * Show the success confirmation page.
     */
    public function success(Proposal $proposal)
    {
        // Ensure the user owns this proposal
        if ($proposal->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('farmer.proposals.success', compact('proposal'));
    }

    /**
     * Download the PDF receipt.
     */
    public function downloadReceipt(Proposal $proposal)
    {
        if ($proposal->user_id !== Auth::id()) {
            abort(403);
        }

        $proposal->load(['program', 'alsintan', 'user.farmerProfile']);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('farmer.proposals.pdf-receipt', compact('proposal'));
        
        return $pdf->download('Bukti_Pengajuan_Proposal_' . $proposal->id . '.pdf');
    }
}
