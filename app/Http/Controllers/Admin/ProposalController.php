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

        $signature = \App\Models\DocumentSignature::with('signer')
            ->where('document_type', 'surat_tugas')
            ->where('document_id', $assignment->id)
            ->first();
        $kepalaDinas = \App\Models\Employee::where('role', 'Kepala Dinas')->first();

        $pdf = Pdf::loadView('admin.proposals.cetak-surat-tugas', compact('proposal', 'assignment', 'kepalaDinas', 'signature'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('Surat_Tugas_Survei_PRP_' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }

    /**
     * Cetak Form Verifikasi CPCL (Blank/Template)
     */
    public function cetakFormCpcl(Proposal $proposal)
    {
        if (!in_array($proposal->status, ['surat_tugas_terbit', 'survei_selesai', 'menunggu_review_kabid', 'menunggu_approval_ba', 'disetujui'])) {
            abort(403, 'Form CPCL belum tersedia.');
        }

        $proposal->load(['user.farmerProfile', 'surveyAssignments']);
        $kepalaDinas = \App\Models\Employee::where('role', 'Kepala Dinas')->first();

        // Menggunakan view documents.cpcl yang bisa menghandle cpclVerifications kosong sebagai template
        $pdf = Pdf::loadView('documents.cpcl', compact('proposal', 'kepalaDinas'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('Form_Verifikasi_CPCL_PRP_' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }

    /**
     * Tampilkan form input hasil verifikasi CPCL.
     */
    public function createCpcl(Proposal $proposal)
    {
        if ($proposal->status !== 'surat_tugas_terbit') {
            return back()->with('error', 'Hanya proposal berstatus "Sedang Survei" yang dapat diinput CPCL-nya.');
        }

        return view('admin.proposals.cpcl.create', compact('proposal'));
    }

    /**
     * Simpan hasil verifikasi CPCL.
     */
    public function storeCpcl(Request $request, Proposal $proposal)
    {
        if ($proposal->status !== 'surat_tugas_terbit') {
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
            'jenis_tanah'         => 'nullable|string',
            'sumber_air'          => 'nullable|string',
            'rawan_bencana'       => 'nullable|string',
            'pemanfaatan_lahan_sebelumnya' => 'nullable|string',
            'pengalaman_budidaya' => 'nullable|string',
            'petugas_dokumentasi' => 'nullable|string',
            'petugas_pemetaan'    => 'nullable|string',
            'no_hp_pemetaan'      => 'nullable|string',
            'foto_lahan'          => 'nullable|image|max:5120',
            'foto_pemetaan_data'  => 'nullable|image|max:5120',
            'dokumen_fisik'       => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
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
            'dokumen_fisik_path'             => $request->hasFile('dokumen_fisik') ? $request->file('dokumen_fisik')->store('cpcl_fisik', 'public') : null,
        ]);

        if ($request->hasFile('foto_lahan')) {
            $proposal->surveyDocumentations()->create([
                'file_path' => $request->file('foto_lahan')->store('survey_dokumentasi', 'public'),
                'keterangan' => 'Foto Lahan Survei CPCL',
            ]);
        }

        if ($request->hasFile('foto_pemetaan_data')) {
            $proposal->surveyDocumentations()->create([
                'file_path' => $request->file('foto_pemetaan_data')->store('survey_dokumentasi', 'public'),
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
        $proposal->update(['status' => 'menunggu_review_kabid']);

        return redirect()->route('admin.proposals.show', $proposal)
            ->with('success', 'Data Hasil Verifikasi CPCL dan Berita Acara berhasil disimpan. Diteruskan ke Kabid untuk direview.');
    }

    /**
     * Tampilkan form edit hasil verifikasi CPCL.
     */
    public function editCpcl(Proposal $proposal)
    {
        $assignment = $proposal->surveyAssignments->last();
        if (!$assignment || !$assignment->cpclVerifications->count()) {
            return back()->with('error', 'Data CPCL tidak ditemukan untuk proposal ini.');
        }

        $cpcl = $assignment->cpclVerifications->last();

        return view('admin.proposals.cpcl.edit', compact('proposal', 'cpcl'));
    }

    /**
     * Update hasil verifikasi CPCL.
     */
    public function updateCpcl(Request $request, Proposal $proposal)
    {
        $request->validate([
            // Verifikasi Teknis
            'status_kepemilikan'  => 'required|string',
            'luas_lahan'          => 'required|numeric',
            'kondisi_lahan'       => 'required|string',
            'kesesuaian_komoditas'=> 'required|boolean',
            'rekomendasi_surveyor'=> 'required|string',
            'catatan'             => 'nullable|string',
            'jenis_tanah'         => 'nullable|string',
            'sumber_air'          => 'nullable|string',
            'rawan_bencana'       => 'nullable|string',
            'pemanfaatan_lahan_sebelumnya' => 'nullable|string',
            'pengalaman_budidaya' => 'nullable|string',
            'petugas_dokumentasi' => 'nullable|string',
            'petugas_pemetaan'    => 'nullable|string',
            'no_hp_pemetaan'      => 'nullable|string',
            'foto_lahan'          => 'nullable|image|max:5120',
            'foto_pemetaan_data'  => 'nullable|image|max:5120',
            'dokumen_fisik'       => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
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
            'dokumen_fisik_path'             => $request->hasFile('dokumen_fisik') ? $request->file('dokumen_fisik')->store('cpcl_fisik', 'public') : $cpcl->dokumen_fisik_path,
        ]);

        if ($request->hasFile('foto_lahan')) {
            // Kita bisa menggunakan create untuk menambah foto baru, tapi idealnya kita update record foto yg sudah ada. 
            // Karena relasi bersifat One-to-Many tanpa identifier spesifik di schema, menambah record baru yang lebih baru bisa jadi strategi jika diperlukan.
            $proposal->surveyDocumentations()->create([
                'file_path' => $request->file('foto_lahan')->store('survey_dokumentasi', 'public'),
                'keterangan' => 'Foto Lahan Survei CPCL',
            ]);
        }

        if ($request->hasFile('foto_pemetaan_data')) {
            $proposal->surveyDocumentations()->create([
                'file_path' => $request->file('foto_pemetaan_data')->store('survey_dokumentasi', 'public'),
                'keterangan' => 'Foto Hasil Pemetaan Data',
            ]);
        }

        return redirect()->route('admin.proposals.show', $proposal)
            ->with('success', 'Data Hasil Verifikasi CPCL berhasil diperbarui.');
    }
}
