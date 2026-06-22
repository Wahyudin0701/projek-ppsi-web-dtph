<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\SurveyAssignment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class ProposalController extends Controller
{
    /**
     * Dashboard Kepala Bidang.
     */
    public function dashboard()
    {
        $kabid = Auth::user();

        $statusCounts = Proposal::where('kabid_id', $kabid->id)
            ->select('status', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $stats = [
            'total'           => $statusCounts->sum(),
            'menunggu_survei' => $statusCounts->get('persiapan_survei', 0),
            'dalam_survei'    => $statusCounts->get('sedang_survei', 0),
            'survei_selesai'  => $statusCounts->get('verifikasi_cpcl', 0),
            'selesai'         => $statusCounts->get('menunggu_keputusan_akhir', 0) + $statusCounts->get('disetujui', 0) + $statusCounts->get('ditolak', 0),
        ];

        $pendingAction = Proposal::where('kabid_id', $kabid->id)
            ->whereIn('status', ['persiapan_survei', 'verifikasi_cpcl'])
            ->with(['user.farmerProfile', 'program', 'alsintan'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        // Chart data: only kabid's proposals, only current year for performance
        $currentYear = now()->year;
        $chartData = Proposal::select('id', 'submission_date', 'alsintan_id', 'program_id', 'user_id', 'status')
            ->with(['user.farmerProfile', 'alsintan.category', 'program.category'])
            ->whereNotNull('submission_date')
            ->whereYear('submission_date', $currentYear)
            ->get()
            ->map(function($item) {
                return [
                    'date'             => $item->submission_date->format('Y-m-d'),
                    'type'             => $item->alsintan_id ? 'alsintan' : 'program',
                    'status'           => $item->status,
                    'kecamatan'        => $item->user?->farmerProfile?->kecamatan ?? 'Lainnya',
                    'desa'             => $item->user?->farmerProfile?->alamat ?? 'Lainnya',
                    'kelompok'         => $item->user?->farmerProfile?->nama_kelompok ?? $item->user?->name ?? 'Lainnya',
                    'kategori_alat'    => $item->alsintan_id ? ($item->alsintan?->category?->name ?? 'Tanpa Kategori') : null,
                    'kategori_program' => $item->program_id ? ($item->program?->category?->name ?? 'Tanpa Kategori') : null
                ];
            })->values()->toArray();

        return view('kabid.dashboard', compact('stats', 'pendingAction', 'kabid', 'chartData'));
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
            if ($request->status === 'selesai_kabid') {
                $query->whereIn('status', [
                    'menunggu_keputusan_akhir', 'direkomendasikan', 'disetujui', 
                    'dikembalikan', 'ditolak', 'ditolak_pusat'
                ]);
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->filled('type')) {
            if ($request->type === 'alsintan') {
                $query->whereNotNull('alsintan_id');
            } else {
                $query->whereNotNull('program_id');
            }
        }

        if ($request->filled('start_date')) {
            $query->whereDate('submission_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('submission_date', '<=', $request->end_date);
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

        if ($proposal->status !== 'persiapan_survei') {
            return redirect()->route('kabid.proposals.show', $proposal)
                ->with('error', 'Proposal tidak dalam status disposisi untuk pembentukan tim survei.');
        }

        $proposal->load(['user.farmerProfile', 'program', 'alsintan']);
        
        // Filter employees based on logged in Kabid's role
        $userRole = auth()->user()->role;
        $targetBidang = null;
        
        if ($userRole === 'kabid_tp') {
            $targetBidang = 'Tanaman Pangan';
        } elseif ($userRole === 'kabid_hortikultura') {
            $targetBidang = 'Hortikultura';
        } elseif ($userRole === 'kabid_psp') {
            $targetBidang = 'PSP';
        }
        
        $employees = \App\Models\Employee::when($targetBidang, function($query) use ($targetBidang) {
            $query->where('bidang', $targetBidang);
        })->get();

        return view('kabid.proposals.assign-team', compact('proposal', 'employees'));
    }

    /**
     * Assign tim survei ke proposal.
     */
    public function assignTeam(Request $request, Proposal $proposal)
    {
        $this->authorizeKabid($proposal);

        if ($proposal->status !== 'persiapan_survei') {
            return back()->with('error', 'Proposal tidak dalam status disposisi.');
        }

        $request->validate([
            'nomor_surat'   => 'required|string|max:255|unique:survey_assignments,nomor_surat',
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
            'valid_from'   => $request->valid_from,
            'valid_until'  => $request->valid_until,
            'team_members' => $request->team_members,
            'is_approved_by_pimpinan' => true, // Tidak perlu TTE lagi, langsung anggap disetujui untuk lanjut
        ]);

        // Karena TTE ditiadakan dan tanda tangan manual, status langsung diubah ke sedang_survei
        $proposal->update(['status' => 'sedang_survei']);

        return redirect()->route('kabid.proposals.show', $proposal)
            ->with('success', 'Tim survei berhasil dibentuk. Silakan cetak Surat Tugas dan mintakan tanda tangan basah kepada Kepala Dinas.');
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
        $userRole = auth()->user()->role;
        $targetBidang = null;
        
        if ($userRole === 'kabid_tp') {
            $targetBidang = 'Tanaman Pangan';
        } elseif ($userRole === 'kabid_hortikultura') {
            $targetBidang = 'Hortikultura';
        } elseif ($userRole === 'kabid_psp') {
            $targetBidang = 'PSP';
        }
        
        $employees = \App\Models\Employee::when($targetBidang, function($query) use ($targetBidang) {
            $query->where('bidang', $targetBidang);
        })->get();

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
            'valid_from'    => 'required|date',
            'valid_until'   => 'required|date|after_or_equal:valid_from',
            'team_members'  => 'required|array|min:1',
            'team_members.*.name' => 'required|string|distinct',
            'team_members.*.nip'  => 'nullable|string',
            'team_members.*.role' => 'required|string',
        ]);

        $assignment->update([
            'nomor_surat'  => $request->nomor_surat,
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

    /**
     * Cetak Surat Tugas.
     */
    public function cetakSuratTugas(Proposal $proposal)
    {
        $this->authorizeKabid($proposal);

        if ($proposal->surveyAssignments()->doesntExist()) {
            abort(403, 'Surat tugas belum diterbitkan.');
        }

        $proposal->load(['user.farmerProfile', 'program', 'alsintan', 'surveyAssignments']);
        $assignment = $proposal->surveyAssignments->last();
        if (!$assignment) abort(404, 'Data surat tugas tidak ditemukan.');

        $kepalaDinas = \App\Models\Employee::where('role', 'Kepala Dinas')->first();

        // Update the view path to kabid
        $pdf = Pdf::loadView('kabid.proposals.cetak-surat-tugas', compact('proposal', 'assignment', 'kepalaDinas'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Surat_Tugas_Survei_PRP_' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }

    /**
     * Cetak Form Verifikasi CPCL (Blank/Template)
     */
    public function cetakFormCpcl(Proposal $proposal)
    {
        $this->authorizeKabid($proposal);

        if (!in_array($proposal->status, ['sedang_survei', 'verifikasi_cpcl', 'menunggu_keputusan_akhir', 'disetujui'])) {
            abort(403, 'Form CPCL belum tersedia.');
        }

        $proposal->load(['user.farmerProfile', 'surveyAssignments']);
        $kepalaDinas = \App\Models\Employee::where('role', 'Kepala Dinas')->first();

        // Menggunakan view documents.cetak-form-cpcl untuk template blank yang dicetak
        $pdf = Pdf::loadView('documents.cetak-form-cpcl', compact('proposal', 'kepalaDinas'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Form_Verifikasi_CPCL_PRP_' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }

    /**
     * Tampilkan form input hasil verifikasi CPCL.
     */
    public function createCpcl(Proposal $proposal)
    {
        $this->authorizeKabid($proposal);

        if ($proposal->status !== 'sedang_survei') {
            return back()->with('error', 'Hanya proposal berstatus "Sedang Survei" yang dapat diinput CPCL-nya.');
        }

        return view('kabid.proposals.cpcl.create', compact('proposal'));
    }

    /**
     * Simpan hasil verifikasi CPCL.
     */
    public function storeCpcl(Request $request, Proposal $proposal)
    {
        $this->authorizeKabid($proposal);

        if ($proposal->status !== 'sedang_survei') {
            return back()->with('error', 'Hanya proposal berstatus "Sedang Survei" yang dapat diinput CPCL-nya.');
        }

        $request->validate([
            // Verifikasi Teknis
            'status_kepemilikan'  => 'required|string',
            'luas_lahan'          => 'required|numeric',
            'kondisi_lahan'       => 'required|string',
            'kesesuaian_komoditas'=> 'required|boolean',
            'rekomendasi_surveyor'=> 'required|string',
            'catatan'             => 'nullable|string',
            'jenis_tanah'         => 'required|string',
            'sumber_air'          => 'required|string',
            'rawan_bencana'       => 'required|string',
            'pemanfaatan_lahan_sebelumnya' => 'required|string',
            'pengalaman_budidaya' => 'required|string',
            'petugas_dokumentasi' => 'nullable|string',
            'petugas_pemetaan'    => 'nullable|string',
            'no_hp_pemetaan'      => 'nullable|string',
            'foto_lahan'          => 'nullable|image|max:5120',
            'foto_pemetaan_data'  => 'nullable|image|max:5120',
            'dokumen_fisik'       => 'nullable|file|extensions:pdf,jpg,jpeg,png|max:5120',
            // Verifikasi Administrasi
            'is_surat_permohonan_sesuai' => 'required|boolean',
            'ket_surat_permohonan'       => 'nullable|string',
            'is_ktp_sesuai'              => 'required|boolean',
            'ket_ktp'                    => 'nullable|string',
            'is_sk_desa_sesuai'          => 'required|boolean',
            'ket_sk_desa'                => 'nullable|string',
            'is_simluhtan_sesuai'        => 'required|boolean',
            'ket_simluhtan'              => 'nullable|string',
            'is_notula_rapat_sesuai'     => 'required|boolean',
            'ket_notula_rapat'           => 'nullable|string',
            'is_titik_koordinat_sesuai'  => 'required|boolean',
            'ket_titik_koordinat'        => 'nullable|string',
            'is_tidak_menerima_bantuan_sama' => 'required|boolean',
            'ket_tidak_menerima_bantuan_sama'=> 'nullable|string',
        ]);

        $assignment = $proposal->surveyAssignments->last();
        if (!$assignment) {
            return back()->with('error', 'Data surat tugas tidak ditemukan.');
        }

        $assignment->cpclVerifications()->create([
            'survey_assignment_id' => $assignment->id,
            // Teknis
            'status_kepemilikan'   => $request->status_kepemilikan,
            'luas_lahan'           => $request->luas_lahan,
            'kondisi_lahan'        => $request->kondisi_lahan,
            'kesesuaian_komoditas' => $request->kesesuaian_komoditas,
            'rekomendasi_surveyor' => $request->rekomendasi_surveyor,
            'catatan'              => $request->catatan,
            'jenis_tanah'          => $request->jenis_tanah,
            'sumber_air'           => $request->sumber_air,
            'rawan_bencana'        => $request->rawan_bencana,
            'pemanfaatan_lahan_sebelumnya' => $request->pemanfaatan_lahan_sebelumnya,
            'pengalaman_budidaya'  => $request->pengalaman_budidaya,
            'petugas_dokumentasi'  => $request->petugas_dokumentasi,
            'petugas_pemetaan'     => $request->petugas_pemetaan,
            'no_hp_pemetaan'       => $request->no_hp_pemetaan,
            // Administrasi
            'is_surat_permohonan_sesuai' => $request->is_surat_permohonan_sesuai,
            'ket_surat_permohonan'       => $request->ket_surat_permohonan,
            'is_ktp_sesuai'              => $request->is_ktp_sesuai,
            'ket_ktp'                    => $request->ket_ktp,
            'is_sk_desa_sesuai'          => $request->is_sk_desa_sesuai,
            'ket_sk_desa'                => $request->ket_sk_desa,
            'is_simluhtan_sesuai'        => $request->is_simluhtan_sesuai,
            'ket_simluhtan'              => $request->ket_simluhtan,
            'is_notula_rapat_sesuai'     => $request->is_notula_rapat_sesuai,
            'ket_notula_rapat'           => $request->ket_notula_rapat,
            'is_titik_koordinat_sesuai'  => $request->is_titik_koordinat_sesuai,
            'ket_titik_koordinat'        => $request->ket_titik_koordinat,
            'is_tidak_menerima_bantuan_sama' => $request->is_tidak_menerima_bantuan_sama,
            'ket_tidak_menerima_bantuan_sama'=> $request->ket_tidak_menerima_bantuan_sama,
            'dokumen_fisik_path'             => $request->hasFile('dokumen_fisik') ? $request->file('dokumen_fisik')->storeAs('cpcl_fisik', \Illuminate\Support\Str::random(40) . '.' . $request->file('dokumen_fisik')->getClientOriginalExtension(), 'public') : null,
        ]);

        if ($request->hasFile('foto_lahan')) {
            $proposal->surveyDocumentations()->create([
                'file_path' => $request->file('foto_lahan')->storeAs('survey_dokumentasi', \Illuminate\Support\Str::random(40) . '.' . $request->file('foto_lahan')->getClientOriginalExtension(), 'public'),
                'keterangan' => 'Foto Lahan Survei CPCL',
            ]);
        }

        if ($request->hasFile('foto_pemetaan_data')) {
            $proposal->surveyDocumentations()->create([
                'file_path' => $request->file('foto_pemetaan_data')->storeAs('survey_dokumentasi', \Illuminate\Support\Str::random(40) . '.' . $request->file('foto_pemetaan_data')->getClientOriginalExtension(), 'public'),
                'keterangan' => 'Foto Hasil Pemetaan Data',
            ]);
        }

        // Buat Berita Acara Otomatis
        $beritaAcara = $proposal->beritaAcara()->create([
            'kabid_id'       => $proposal->kabid_id,
            'content'        => $request->catatan ?? 'Telah dilakukan verifikasi teknis dan administrasi pada kelompok ' . ($proposal->user->farmerProfile->nama_kelompok ?? $proposal->user->name),
            'survey_date'    => now(),
            'location'       => $proposal->user->farmerProfile->alamat ?? '-',
            'recommendation' => $request->rekomendasi_surveyor,
        ]);

        // Generate TTE QR Code (Signature) for Surveyor (Tim Survei)
        \App\Models\DocumentSignature::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'document_type' => 'berita_acara_surveyor',
            'document_id' => $beritaAcara->id,
            'signed_by' => auth()->id(),
            'signed_at' => now(),
        ]);

        // Update status ke menunggu_review_kabid
        $proposal->update(['status' => 'verifikasi_cpcl']);

        return redirect()->route('kabid.proposals.show', $proposal)
            ->with('success', 'Data Hasil Verifikasi CPCL dan Berita Acara berhasil disimpan. Anda sekarang dapat meneruskannya ke Pimpinan.');
    }

    /**
     * Tampilkan form edit hasil verifikasi CPCL.
     */
    public function editCpcl(Proposal $proposal)
    {
        $this->authorizeKabid($proposal);

        if (in_array($proposal->status, ['menunggu_keputusan_akhir', 'disetujui', 'ditolak'])) {
            abort(403, 'Data CPCL tidak dapat diubah lagi karena proposal sudah diteruskan ke Pimpinan atau sudah memiliki keputusan akhir.');
        }

        $assignment = $proposal->surveyAssignments->last();
        if (!$assignment || !$assignment->cpclVerifications->count()) {
            return back()->with('error', 'Data CPCL tidak ditemukan untuk proposal ini.');
        }

        $cpcl = $assignment->cpclVerifications->last();

        return view('kabid.proposals.cpcl.edit', compact('proposal', 'cpcl'));
    }

    /**
     * Update hasil verifikasi CPCL.
     */
    public function updateCpcl(Request $request, Proposal $proposal)
    {
        $this->authorizeKabid($proposal);

        if (in_array($proposal->status, ['menunggu_keputusan_akhir', 'disetujui', 'ditolak'])) {
            abort(403, 'Data CPCL tidak dapat diubah lagi karena proposal sudah diteruskan ke Pimpinan atau sudah memiliki keputusan akhir.');
        }

        $request->validate([
            // Verifikasi Teknis
            'status_kepemilikan'  => 'required|string',
            'luas_lahan'          => 'required|numeric',
            'kondisi_lahan'       => 'required|string',
            'kesesuaian_komoditas'=> 'required|boolean',
            'rekomendasi_surveyor'=> 'required|string',
            'catatan'             => 'nullable|string',
            'jenis_tanah'         => 'required|string',
            'sumber_air'          => 'required|string',
            'rawan_bencana'       => 'required|string',
            'pemanfaatan_lahan_sebelumnya' => 'required|string',
            'pengalaman_budidaya' => 'required|string',
            'petugas_dokumentasi' => 'nullable|string',
            'petugas_pemetaan'    => 'nullable|string',
            'no_hp_pemetaan'      => 'nullable|string',
            'foto_lahan'          => 'nullable|image|max:5120',
            'foto_pemetaan_data'  => 'nullable|image|max:5120',
            'dokumen_fisik'       => 'nullable|file|extensions:pdf,jpg,jpeg,png|max:5120',
            // Verifikasi Administrasi
            'is_surat_permohonan_sesuai' => 'required|boolean',
            'ket_surat_permohonan'       => 'nullable|string',
            'is_ktp_sesuai'              => 'required|boolean',
            'ket_ktp'                    => 'nullable|string',
            'is_sk_desa_sesuai'          => 'required|boolean',
            'ket_sk_desa'                => 'nullable|string',
            'is_simluhtan_sesuai'        => 'required|boolean',
            'ket_simluhtan'              => 'nullable|string',
            'is_notula_rapat_sesuai'     => 'required|boolean',
            'ket_notula_rapat'           => 'nullable|string',
            'is_titik_koordinat_sesuai'  => 'required|boolean',
            'ket_titik_koordinat'        => 'nullable|string',
            'is_tidak_menerima_bantuan_sama' => 'required|boolean',
            'ket_tidak_menerima_bantuan_sama'=> 'nullable|string',
        ]);

        $assignment = $proposal->surveyAssignments->last();
        if (!$assignment) {
            return back()->with('error', 'Data surat tugas tidak ditemukan.');
        }

        $cpcl = $assignment->cpclVerifications->last();
        if (!$cpcl) {
            return back()->with('error', 'Data CPCL belum dibuat.');
        }

        $cpcl->update([
            // Teknis
            'status_kepemilikan'   => $request->status_kepemilikan,
            'luas_lahan'           => $request->luas_lahan,
            'kondisi_lahan'        => $request->kondisi_lahan,
            'kesesuaian_komoditas' => $request->kesesuaian_komoditas,
            'rekomendasi_surveyor' => $request->rekomendasi_surveyor,
            'catatan'              => $request->catatan,
            'jenis_tanah'          => $request->jenis_tanah,
            'sumber_air'           => $request->sumber_air,
            'rawan_bencana'        => $request->rawan_bencana,
            'pemanfaatan_lahan_sebelumnya' => $request->pemanfaatan_lahan_sebelumnya,
            'pengalaman_budidaya'  => $request->pengalaman_budidaya,
            'petugas_dokumentasi'  => $request->petugas_dokumentasi,
            'petugas_pemetaan'     => $request->petugas_pemetaan,
            'no_hp_pemetaan'       => $request->no_hp_pemetaan,
            // Administrasi
            'is_surat_permohonan_sesuai' => $request->is_surat_permohonan_sesuai,
            'ket_surat_permohonan'       => $request->ket_surat_permohonan,
            'is_ktp_sesuai'              => $request->is_ktp_sesuai,
            'ket_ktp'                    => $request->ket_ktp,
            'is_sk_desa_sesuai'          => $request->is_sk_desa_sesuai,
            'ket_sk_desa'                => $request->ket_sk_desa,
            'is_simluhtan_sesuai'        => $request->is_simluhtan_sesuai,
            'ket_simluhtan'              => $request->ket_simluhtan,
            'is_notula_rapat_sesuai'     => $request->is_notula_rapat_sesuai,
            'ket_notula_rapat'           => $request->ket_notula_rapat,
            'is_titik_koordinat_sesuai'  => $request->is_titik_koordinat_sesuai,
            'ket_titik_koordinat'        => $request->ket_titik_koordinat,
            'is_tidak_menerima_bantuan_sama' => $request->is_tidak_menerima_bantuan_sama,
            'ket_tidak_menerima_bantuan_sama'=> $request->ket_tidak_menerima_bantuan_sama,
            'dokumen_fisik_path'             => $request->hasFile('dokumen_fisik') ? $request->file('dokumen_fisik')->storeAs('cpcl_fisik', \Illuminate\Support\Str::random(40) . '.' . $request->file('dokumen_fisik')->getClientOriginalExtension(), 'public') : $cpcl->dokumen_fisik_path,
        ]);

        if ($request->hasFile('foto_lahan')) {
            $proposal->surveyDocumentations()->create([
                'file_path' => $request->file('foto_lahan')->storeAs('survey_dokumentasi', \Illuminate\Support\Str::random(40) . '.' . $request->file('foto_lahan')->getClientOriginalExtension(), 'public'),
                'keterangan' => 'Foto Lahan Survei CPCL',
            ]);
        }

        if ($request->hasFile('foto_pemetaan_data')) {
            $proposal->surveyDocumentations()->create([
                'file_path' => $request->file('foto_pemetaan_data')->storeAs('survey_dokumentasi', \Illuminate\Support\Str::random(40) . '.' . $request->file('foto_pemetaan_data')->getClientOriginalExtension(), 'public'),
                'keterangan' => 'Foto Hasil Pemetaan Data',
            ]);
        }

        return redirect()->route('kabid.proposals.show', $proposal)
            ->with('success', 'Data Hasil Verifikasi CPCL berhasil diperbarui.');
    }
}
