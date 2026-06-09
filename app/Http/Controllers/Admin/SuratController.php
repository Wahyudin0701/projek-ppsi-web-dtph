<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        $letters = collect();
        
        // Mengambil semua proposal beserta relasinya yang diperlukan
        $proposals = Proposal::with(['surveyAssignments', 'user.farmerProfile', 'program', 'alsintan'])
            ->orderBy('updated_at', 'desc')
            ->get();

        foreach ($proposals as $p) {
            $kelompok = $p->user->farmerProfile->nama_kelompok ?? $p->user->name ?? 'N/A';
            $perihal = $p->alsintan_id ? 'Peminjaman ' . ($p->alsintan->name ?? 'Alsintan') : 'Bantuan ' . ($p->program->name ?? 'Program');
            
            // 1. Surat Tugas & Form CPCL (Muncul jika ada assignment)
            if ($p->surveyAssignments->isNotEmpty()) {
                $assignment = $p->surveyAssignments->last();
                
                // Surat Tugas
                $letters->push([
                    'id' => 'st_' . $assignment->id,
                    'jenis' => 'Surat Tugas Verifikasi',
                    'nomor' => $assignment->nomor_surat ?? '-',
                    'kelompok' => $kelompok,
                    'perihal' => $perihal,
                    'proposal_id' => $p->id,
                    'url' => route('documents.surat-tugas', $p->id),
                    'tanggal' => $assignment->created_at,
                ]);

                // Form CPCL (Kosong & Terisi)
                $letters->push([
                    'id' => 'cpcl_blank_' . $p->id,
                    'jenis' => 'Form CPCL (Kosong)',
                    'nomor' => '-',
                    'kelompok' => $kelompok,
                    'perihal' => $perihal,
                    'proposal_id' => $p->id,
                    'url' => route('documents.form-cpcl-blank', $p->id),
                    'tanggal' => $assignment->created_at,
                ]);
                
                if (in_array($p->status, ['survey_completed', 'disetujui', 'ditolak', 'disalurkan', 'dipinjam', 'selesai', 'approved', 'rejected', 'distributed', 'borrowed', 'completed'])) {
                    $letters->push([
                        'id' => 'cpcl_' . $p->id,
                        'jenis' => 'Hasil CPCL',
                        'nomor' => '-',
                        'kelompok' => $kelompok,
                        'perihal' => $perihal,
                        'proposal_id' => $p->id,
                        'url' => route('documents.cpcl', $p->id),
                        'tanggal' => $p->updated_at,
                    ]);
                }
            }

            // 2. Surat Perjanjian Pinjam Pakai (Untuk Alsintan yang di-approve)
            if ($p->alsintan_id && in_array($p->status, ['disetujui', 'dipinjam', 'selesai', 'approved', 'borrowed', 'completed'])) {
                $romawiBulan = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'];
                $bulanRomawi = $romawiBulan[now()->month];
                $tahun = now()->year;
                $nomorPerjanjian = '531.1/' . str_pad($p->id, 3, '0', STR_PAD_LEFT) . '/DTPH-PSP/' . $bulanRomawi . '/' . $tahun;
                
                $letters->push([
                    'id' => 'sp_' . $p->id,
                    'jenis' => 'Surat Perjanjian Pinjam Pakai',
                    'nomor' => $nomorPerjanjian,
                    'kelompok' => $kelompok,
                    'perihal' => $perihal,
                    'proposal_id' => $p->id,
                    'url' => route('documents.surat-perjanjian', $p->id),
                    'tanggal' => $p->decided_at ?? $p->updated_at,
                ]);
            }

            // 3. Surat Keputusan Bantuan (Untuk Program Bantuan yang di-approve)
            if ($p->program_id && in_array($p->status, ['disetujui', 'disalurkan', 'selesai', 'approved', 'distributed', 'completed'])) {
                $letters->push([
                    'id' => 'sk_' . $p->id,
                    'jenis' => 'Surat Keputusan Bantuan',
                    'nomor' => '-',
                    'kelompok' => $kelompok,
                    'perihal' => $perihal,
                    'proposal_id' => $p->id,
                    'url' => route('documents.sk-bantuan', $p->id),
                    'tanggal' => $p->decided_at ?? $p->updated_at,
                ]);
            }
        }

        // Sorting by date descending
        $letters = $letters->sortByDesc('tanggal')->values();

        // Fitur Filter Search
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $letters = $letters->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['jenis']), $search) || 
                       str_contains(strtolower($item['nomor']), $search) || 
                       str_contains(strtolower($item['kelompok']), $search) ||
                       str_contains(strtolower($item['perihal']), $search);
            })->values();
        }

        if ($request->filled('jenis_surat')) {
            $letters = $letters->where('jenis', $request->jenis_surat)->values();
        }

        if ($request->filled('start_date')) {
            $startDate = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $letters = $letters->filter(function($item) use ($startDate) {
                return \Carbon\Carbon::parse($item['tanggal'])->startOfDay() >= $startDate;
            })->values();
        }

        if ($request->filled('end_date')) {
            $endDate = \Carbon\Carbon::parse($request->end_date)->startOfDay();
            $letters = $letters->filter(function($item) use ($endDate) {
                return \Carbon\Carbon::parse($item['tanggal'])->startOfDay() <= $endDate;
            })->values();
        }

        // Manual Pagination
        $perPage = 15;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;
        
        $paginatedItems = new LengthAwarePaginator(
            $letters->slice($offset, $perPage)->all(),
            $letters->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.surat.index', ['letters' => $paginatedItems]);
    }
}
