<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\DispositionLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    /**
     * Dashboard pimpinan.
     */
    public function dashboard()
    {
        $statsRaw = Proposal::selectRaw("
            SUM(CASE WHEN alsintan_id IS NOT NULL THEN 1 ELSE 0 END) as alsintan_count,
            SUM(CASE WHEN program_id IS NOT NULL THEN 1 ELSE 0 END) as program_count
        ")->first();

        $totalPoktan = \App\Models\FarmerProfile::count();
        $totalUserUmum = 0; // Not applicable anymore
        $totalAlsintan = \App\Models\Alsintan::count();
        $totalProgram = \App\Models\Program::where('is_open', true)->count();

        $stats = [
            'total_poktan'       => $totalPoktan,
            'total_user'         => $totalUserUmum,
            'katalog_alsintan'   => $totalAlsintan,
            'program_aktif'      => $totalProgram,
            'pengajuan_alsintan' => (int) ($statsRaw->alsintan_count ?? 0),
            'pengajuan_program'  => (int) ($statsRaw->program_count ?? 0),
        ];

        // Chart data: limited to current year only for performance
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

        $pendingProposals = Proposal::with(['user.farmerProfile', 'program', 'alsintan'])
            ->whereIn('status', ['sedang_diverifikasi_pimpinan', 'menunggu_keputusan_akhir'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('pimpinan.dashboard', compact('stats', 'chartData', 'pendingProposals'));
    }

    /**
     * Daftar semua proposal.
     */
    public function index(Request $request)
    {
        $query = Proposal::with(['user.farmerProfile', 'program', 'alsintan', 'kabid'])
            ->latest('submission_date');

        $query->whereIn('status', [
            'sedang_diverifikasi_pimpinan',
            'menunggu_keputusan_akhir'
        ]);

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
                  ->orWhereHas('alsintan', fn($a) => $a->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('program', fn($p) => $p->where('name', 'like', "%{$search}%"));
            });
        }

        $proposals = $query->paginate(15)->withQueryString();

        $statsRaw = Proposal::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'sedang_diverifikasi_pimpinan' THEN 1 ELSE 0 END) as menunggu,
            SUM(CASE WHEN status = 'menunggu_keputusan_akhir' THEN 1 ELSE 0 END) as menunggu_akhir,
            SUM(CASE WHEN status = 'disetujui' THEN 1 ELSE 0 END) as disetujui,
            SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) as ditolak
        ")->first();

        $stats = [
            'menunggu'       => (int) ($statsRaw->menunggu ?? 0),
            'menunggu_akhir' => (int) ($statsRaw->menunggu_akhir ?? 0),
            'disetujui'      => (int) ($statsRaw->disetujui ?? 0),
            'ditolak'        => (int) ($statsRaw->ditolak ?? 0),
            'total'          => (int) ($statsRaw->total ?? 0),
        ];

        $isArchive = false;
        return view('pimpinan.proposals.index', compact('proposals', 'stats', 'isArchive'));
    }

    /**
     * Daftar arsip keputusan proposal.
     */
    public function archives(Request $request)
    {
        $query = Proposal::with(['user.farmerProfile', 'program', 'alsintan', 'kabid'])
            ->latest('submission_date');

        // Arsip Keputusan sekarang menampilkan semua proposal dengan semua status
        // Tidak ada filter status default (kecuali jika ditambahkan via request nantinya)

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
                  ->orWhereHas('alsintan', fn($a) => $a->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('program', fn($p) => $p->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $proposals = $query->paginate(15)->withQueryString();

        $isArchive = true;

        return view('pimpinan.proposals.index', compact('proposals', 'isArchive'));
    }

    /**
     * Detail proposal.
     */
    public function show(Proposal $proposal)
    {
        $proposal->load([
            'user.farmerProfile', 'program', 'alsintan',
            'kabid', 'latestDispositionLog.toUser', 'beritaAcara.kabid',
            'surveyAssignments', 'cpclVerifications', 'surveyDocumentations',
        ]);

        // Kabid yang tersedia untuk disposisi
        $kabidList = User::whereIn('role', ['kabid_psp', 'kabid_tp', 'kabid_hortikultura'])->get();

        // Ambil stok alsintan yang tersedia (hanya jika proposal berupa alsintan)
        $availableInventories = [];
        if ($proposal->alsintan_id) {
            $availableInventories = \App\Models\AlsintanInventory::where('alsintan_id', $proposal->alsintan_id)
                ->where('status_ketersediaan', 'Tersedia')
                ->get();
        }

        return view('pimpinan.proposals.show', compact('proposal', 'kabidList', 'availableInventories'));
    }

    /**
     * Disposisi proposal ke kabid.
     */
    public function dispose(Request $request, Proposal $proposal)
    {
        if ($proposal->status !== 'sedang_diverifikasi_pimpinan') {
            return back()->with('error', 'Hanya proposal berstatus "Diteruskan ke Pimpinan" yang dapat didisposisi.');
        }

        $request->validate([
            'kabid_id'          => 'required|exists:users,id',
            'disposition_notes' => 'nullable|string|max:1000',
        ]);

        $kabid = User::findOrFail($request->kabid_id);
        if (!$kabid->isKabid()) {
            return back()->with('error', 'User yang dipilih bukan Kepala Bidang.');
        }

        // Simpan disposisi
        DispositionLog::create([
            'proposal_id' => $proposal->id,
            'disposed_by' => Auth::id(),
            'disposed_to' => $kabid->id,
            'notes'       => $request->disposition_notes,
        ]);

        // Update proposal
        $proposal->update([
            'status'            => 'persiapan_survei',
            'kabid_id'          => $kabid->id,
            'disposition_notes' => $request->disposition_notes,
        ]);

        return redirect()->route('pimpinan.proposals.show', $proposal)
            ->with('success', "Proposal berhasil didisposisi ke {$kabid->roleLabel}.");
    }



    /**
     * Setujui proposal (keputusan akhir).
     */
    public function approve(Request $request, Proposal $proposal)
    {
        if (!in_array($proposal->status, ['sedang_diverifikasi_pimpinan', 'menunggu_keputusan_akhir'])) {
            return back()->with('error', 'Proposal tidak dapat disetujui pada status ini.');
        }

        $request->validate([
            'pimpinan_notes'        => 'nullable|string|max:1000',
            'alsintan_inventory_id' => $proposal->alsintan_id ? 'required|exists:alsintan_inventories,id' : 'nullable',
        ]);

        // Auto-generate nomor surat resmi
        $year = date('Y');
        $month = date('m');
        $id = str_pad($proposal->id, 3, '0', STR_PAD_LEFT);

        if ($proposal->program_id) {
            $nomorCpcl = "CPCL/{$year}/{$month}/PRP-{$id}";
            $proposal->update([
                'status'                => 'direkomendasikan',
                'pimpinan_notes'        => $request->pimpinan_notes,
                'nomor_dokumen_final'   => $nomorCpcl, // SK CPCL
            ]);
            return redirect()->route('pimpinan.proposals.show', $proposal)
                ->with('success', 'Proposal Program Bantuan #PRP-' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . ' telah disetujui sebagai CPCL dan Nomor Surat Rekomendasi/CPCL (' . $nomorCpcl . ') berhasil diterbitkan. Status: Menunggu Keputusan Pusat.');
        }

        // Jika Alsintan, langsung disetujui
        $nomor = "SP/{$year}/{$month}/PRP-{$id}";

        $proposal->update([
            'status'                => 'disetujui',
            'decided_at'            => now(),
            'pimpinan_notes'        => $request->pimpinan_notes,
            'nomor_dokumen_final'   => $nomor,
            'alsintan_inventory_id' => $request->alsintan_inventory_id,
        ]);

        if ($request->alsintan_inventory_id) {
            \App\Models\AlsintanInventory::where('id', $request->alsintan_inventory_id)
                ->update(['status_ketersediaan' => 'Dipinjam']);
        }

        return redirect()->route('pimpinan.proposals.show', $proposal)
            ->with('success', 'Proposal Alsintan #PRP-' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . ' telah disetujui dan Nomor Surat Resmi (' . $nomor . ') berhasil diterbitkan otomatis.');
    }

    /**
     * Konfirmasi Persetujuan dari Pusat untuk Program Bantuan (CPCL -> Disetujui)
     */
    public function finalizeApproval(Request $request, Proposal $proposal)
    {
        if ($proposal->status !== 'direkomendasikan') {
            return back()->with('error', 'Hanya proposal berstatus Direkomendasikan yang dapat ditetapkan.');
        }

        $year = date('Y');
        $month = date('m');
        $id = str_pad($proposal->id, 3, '0', STR_PAD_LEFT);
        $nomor = "SK-BANTUAN/{$year}/{$month}/PRP-{$id}";

        $proposal->update([
            'status'                => 'disetujui',
            'decided_at'            => now(),
            'nomor_dokumen_final'   => $nomor,
        ]);

        return redirect()->route('pimpinan.proposals.show', $proposal)
            ->with('success', 'Proposal Program Bantuan #PRP-' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . ' telah ditetapkan/disetujui oleh Pusat. SK Penerima Bantuan (' . $nomor . ') berhasil diterbitkan.');
    }

    /**
     * Konfirmasi Penolakan dari Pusat untuk Program Bantuan (CPCL -> Ditolak Pusat)
     */
    public function rejectByPusat(Request $request, Proposal $proposal)
    {
        if ($proposal->status !== 'direkomendasikan') {
            return back()->with('error', 'Hanya proposal berstatus Direkomendasikan yang dapat ditolak oleh pusat.');
        }

        $request->validate([
            'pimpinan_notes' => 'required|string|max:1000',
        ]);

        $proposal->update([
            'status'         => 'ditolak_pusat',
            'decided_at'     => now(),
            'pimpinan_notes' => 'DITOLAK PUSAT: ' . $request->pimpinan_notes,
        ]);

        return redirect()->route('pimpinan.proposals.show', $proposal)
            ->with('success', 'Proposal Program Bantuan #PRP-' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . ' telah ditandai sebagai Ditolak oleh Pusat.');
    }


    /**
     * Tolak proposal (keputusan akhir).
     */
    public function reject(Request $request, Proposal $proposal)
    {
        if (!in_array($proposal->status, ['sedang_diverifikasi_pimpinan', 'menunggu_keputusan_akhir'])) {
            return back()->with('error', 'Proposal tidak dapat ditolak pada status ini.');
        }

        $request->validate([
            'pimpinan_notes' => 'required|string|max:1000',
        ]);

        // Penolakan permanen (Keputusan Akhir)
        $proposal->update([
            'status'         => 'ditolak',
            'decided_at'     => now(),
            'pimpinan_notes' => $request->pimpinan_notes,
        ]);

        return redirect()->route('pimpinan.proposals.show', $proposal)
            ->with('success', 'Proposal #PRP-' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . ' telah ditolak.');
    }

    /**
     * Halaman laporan dan rekapitulasi.
     */
    public function reports(Request $request)
    {
        $query = Proposal::with(['user.farmerProfile', 'program', 'alsintan', 'kabid'])
            ->latest('submission_date');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('submission_date', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        if ($request->filled('type')) {
            if ($request->type === 'alsintan') {
                $query->whereNotNull('alsintan_id');
            } elseif ($request->type === 'program') {
                $query->whereNotNull('program_id');
            }
        }

        if ($request->filled('status')) {
            if ($request->status === 'menunggu') {
                $query->whereIn('status', ['sedang_diverifikasi_pimpinan', 'menunggu_keputusan_akhir']);
            } elseif ($request->status === 'ditolak') {
                $query->whereIn('status', ['ditolak', 'ditolak_pusat']);
            } else {
                $query->where('status', $request->status);
            }
        }

        $proposals = $query->paginate(20)->withQueryString();
        
        return view('pimpinan.reports.index', compact('proposals'));
    }

    /**
     * Halaman cetak laporan.
     */
    public function printReport(Request $request)
    {
        $query = Proposal::with(['user.farmerProfile', 'program.category', 'alsintan.category', 'kabid'])
            ->latest('submission_date');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('submission_date', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        if ($request->filled('type')) {
            if ($request->type === 'alsintan') {
                $query->whereNotNull('alsintan_id');
            } elseif ($request->type === 'program') {
                $query->whereNotNull('program_id');
            }
        }

        if ($request->filled('status')) {
            if ($request->status === 'menunggu') {
                $query->whereIn('status', ['sedang_diverifikasi_pimpinan', 'menunggu_keputusan_akhir']);
            } elseif ($request->status === 'ditolak') {
                $query->whereIn('status', ['ditolak', 'ditolak_pusat']);
            } else {
                $query->where('status', $request->status);
            }
        }

        $proposals = $query->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pimpinan.reports.print', compact('proposals'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan_Rekapitulasi_Proposal.pdf');
    }

    /**
     * Halaman laporan pengguna terdaftar.
     */
    public function reportUsers(Request $request)
    {
        $query = User::with('farmerProfile')->whereIn('role', ['petani', 'umum'])->latest('created_at');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        if ($request->filled('afiliasi')) {
            $query->whereHas('farmerProfile', function ($q) use ($request) {
                if ($request->afiliasi === 'individu') {
                    $q->where('afiliasi_lembaga', 'Individu');
                } else {
                    $q->where('afiliasi_lembaga', '!=', 'Individu');
                }
            });
        }

        if ($request->filled('status')) {
            $query->whereHas('farmerProfile', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $users = $query->paginate(20)->withQueryString();
        
        return view('pimpinan.reports.users', compact('users'));
    }

    /**
     * Halaman cetak laporan pengguna terdaftar.
     */
    public function printReportUsers(Request $request)
    {
        $query = User::with('farmerProfile')->whereIn('role', ['petani', 'umum'])->latest('created_at');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        if ($request->filled('afiliasi')) {
            $query->whereHas('farmerProfile', function ($q) use ($request) {
                if ($request->afiliasi === 'individu') {
                    $q->where('afiliasi_lembaga', 'Individu');
                } else {
                    $q->where('afiliasi_lembaga', '!=', 'Individu');
                }
            });
        }

        if ($request->filled('status')) {
            $query->whereHas('farmerProfile', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $users = $query->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pimpinan.reports.print_users', compact('users'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan_Pengguna_Terdaftar.pdf');
    }
}

