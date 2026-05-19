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

    /**
     * Cetak Surat Tugas.
     */
    public function cetakSuratTugas(Proposal $proposal)
    {
        if ($proposal->status !== 'surat_tugas_terbit') {
            abort(403, 'Surat tugas belum diterbitkan.');
        }

        $proposal->load(['user.farmerProfile', 'program', 'alsintan', 'surveyAssignments']);
        $assignment = $proposal->surveyAssignments->last();
        if (!$assignment) abort(404, 'Data surat tugas tidak ditemukan.');

        return view('admin.proposals.cetak-surat-tugas', compact('proposal', 'assignment'));
    }

    /**
     * Tampilkan form input hasil verifikasi CPCL.
     */
    public function createCpcl(Proposal $proposal)
    {
        if ($proposal->status !== 'surat_tugas_terbit') {
            return back()->with('error', 'Hanya proposal berstatus "Surat Tugas Terbit" yang dapat diinput CPCL-nya.');
        }

        return view('admin.proposals.cpcl.create', compact('proposal'));
    }

    /**
     * Simpan hasil verifikasi CPCL.
     */
    public function storeCpcl(Request $request, Proposal $proposal)
    {
        if ($proposal->status !== 'surat_tugas_terbit') {
            return back()->with('error', 'Hanya proposal berstatus "Surat Tugas Terbit" yang dapat diinput CPCL-nya.');
        }

        $request->validate([
            'status_kepemilikan'  => 'required|string',
            'luas_lahan'          => 'required|numeric',
            'kondisi_lahan'       => 'required|string',
            'kesesuaian_komoditas'=> 'required|boolean',
            'rekomendasi_surveyor'=> 'required|string',
            'catatan'             => 'nullable|string',
            'foto_lahan'          => 'nullable|image|max:5120',
        ]);

        $assignment = $proposal->surveyAssignments->last();
        if (!$assignment) {
            return back()->with('error', 'Data surat tugas tidak ditemukan.');
        }

        $path = null;
        if ($request->hasFile('foto_lahan')) {
            $path = $request->file('foto_lahan')->store('survey_dokumentasi', 'public');
        }

        $proposal->cpclVerifications()->create([
            'survey_assignment_id' => $assignment->id,
            'status_kepemilikan'   => $request->status_kepemilikan,
            'luas_lahan'           => $request->luas_lahan,
            'kondisi_lahan'        => $request->kondisi_lahan,
            'kesesuaian_komoditas' => $request->kesesuaian_komoditas,
            'rekomendasi_surveyor' => $request->rekomendasi_surveyor,
            'catatan'              => $request->catatan,
        ]);

        if ($path) {
            $proposal->surveyDocumentations()->create([
                'file_path' => $path,
                'keterangan' => 'Foto Lahan Survei CPCL',
            ]);
        }

        // Update status ke selesai_survei
        $proposal->update(['status' => 'survei_selesai']);

        return redirect()->route('admin.proposals.show', $proposal)
            ->with('success', 'Data Hasil Verifikasi CPCL berhasil disimpan. Status menjadi "Survei Selesai".');
    }
}
