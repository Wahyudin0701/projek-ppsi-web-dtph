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
        $activeStatuses = ['sedang_diverifikasi_admin', 'sedang_diverifikasi_pimpinan', 'persiapan_survei', 'sedang_survei', 'verifikasi_cpcl', 'menunggu_keputusan_akhir', 'disetujui'];
        
        // Dapatkan status aktif per alsintan_id
        $activeAlsintans = Proposal::where('user_id', Auth::id())
            ->whereNotNull('alsintan_id')
            ->whereIn('status', $activeStatuses)
            ->pluck('status', 'alsintan_id')
            ->toArray();

        $all = \App\Models\Alsintan::with('inventories')->latest()->get();

        // Tersedia: stok ada & belum ada proposal aktif
        $alsintans = $all->filter(fn($a) => $a->available_stock > 0 && !array_key_exists($a->id, $activeAlsintans))->values();

        // Tidak tersedia: stok habis ATAU sudah ada proposal aktif
        $unavailableAlsintans = $all->filter(fn($a) => $a->available_stock <= 0 || array_key_exists($a->id, $activeAlsintans))->values();

        return view('farmer.proposals.alsintan.list', compact('alsintans', 'unavailableAlsintans', 'activeAlsintans'));
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

        $activeStatuses = ['sedang_diverifikasi_admin', 'sedang_diverifikasi_pimpinan', 'persiapan_survei', 'sedang_survei', 'verifikasi_cpcl', 'menunggu_keputusan_akhir', 'disetujui'];
        $existingProposal = Proposal::where('user_id', Auth::id())
            ->where('alsintan_id', $alsintan->id)
            ->whereIn('status', $activeStatuses)
            ->first();

        if ($existingProposal) {
            $msg = $existingProposal->status === 'disetujui' 
                ? 'Anda sedang meminjam alat "' . $alsintan->name . '". Silakan kembalikan terlebih dahulu sebelum mengajukan peminjaman baru.'
                : 'Anda sudah memiliki proposal yang sedang diproses untuk alat "' . $alsintan->name . '". Silakan tunggu prosesnya selesai.';
            return redirect()->route('farmer.proposals.alsintan')->with('error', $msg);
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

        $activeStatuses = ['sedang_diverifikasi_admin', 'sedang_diverifikasi_pimpinan', 'persiapan_survei', 'sedang_survei', 'verifikasi_cpcl', 'menunggu_keputusan_akhir', 'disetujui'];
        $existingProposal = Proposal::where('user_id', $user->id)
            ->where('alsintan_id', $alsintan->id)
            ->whereIn('status', $activeStatuses)
            ->first();

        if ($existingProposal) {
            $msg = $existingProposal->status === 'disetujui' 
                ? 'Anda sedang meminjam alat "' . $alsintan->name . '". Silakan kembalikan terlebih dahulu sebelum mengajukan peminjaman baru.'
                : 'Anda sudah memiliki proposal yang sedang diproses untuk alat "' . $alsintan->name . '". Silakan tunggu prosesnya selesai.';
            return redirect()->route('farmer.proposals.alsintan')->with('error', $msg);
        }

        $request->validate([
            'no_surat_pengajuan'  => 'nullable|string|max:255',
            'rencana_durasi_hari' => 'required|integer|min:1|max:365',
            'file_proposal'       => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $filePath = $request->file('file_proposal')->store('proposals', 'public');

        $proposal = Proposal::create([
            'user_id'             => $user->id,
            'alsintan_id'         => $alsintan->id,
            'no_surat_pengajuan'  => $request->no_surat_pengajuan,
            'rencana_durasi_hari' => $request->rencana_durasi_hari,
            'file_proposal'       => $filePath,
            'status'              => 'sedang_diverifikasi_admin',
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

        $activeStatuses = ['sedang_diverifikasi_admin', 'sedang_diverifikasi_pimpinan', 'persiapan_survei', 'sedang_survei', 'verifikasi_cpcl', 'menunggu_keputusan_akhir', 'disetujui'];
        $existingProposal = Proposal::where('user_id', $user->id)
            ->whereHas('program', function ($query) use ($program) {
                $query->where('program_category_id', $program->program_category_id);
            })
            ->whereIn('status', $activeStatuses)
            ->first();

        if ($existingProposal) {
            $categoryName = $program->category ? $program->category->name : 'ini';
            return back()->with('error', "Anda sudah memiliki pengajuan aktif untuk kategori program {$categoryName}. Silakan tunggu proses selesai sebelum mengajukan kembali untuk kategori yang sama.");
        }

        $request->validate([
            'no_surat_pengajuan' => 'nullable|string|max:255',
            'file_proposal' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $filePath = $request->file('file_proposal')->store('proposals', 'public');

        $proposal = Proposal::create([
            'user_id' => $user->id,
            'program_id' => $program->id,
            'no_surat_pengajuan' => $request->no_surat_pengajuan,
            'file_proposal' => $filePath,
            'status' => 'sedang_diverifikasi_admin',
            'submission_date' => now(),
        ]);

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
        
        return $pdf->stream('Bukti_Pengajuan_Proposal_' . $proposal->id . '.pdf');
    }
}
