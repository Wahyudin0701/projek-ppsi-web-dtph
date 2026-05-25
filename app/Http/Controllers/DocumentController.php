<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Cek otorisasi agar hanya yang berhak yang bisa mencetak.
     */
    private function authorizeAccess(Proposal $proposal)
    {
        $user = Auth::user();
        if ($user->role === 'user' && $proposal->user_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }
        if (in_array($user->role, ['kabid_psp', 'kabid_tp', 'kabid_hortikultura'])) {
            if ($proposal->kabid_id && $proposal->kabid_id !== $user->id) {
                abort(403, 'Bukan wewenang Anda.');
            }
        }
    }

    /**
     * Cetak Hasil Verifikasi CPCL
     */
    public function printCpcl(Proposal $proposal)
    {
        $this->authorizeAccess($proposal);

        if ($proposal->cpclVerifications->isEmpty()) {
            abort(404, 'Data Verifikasi CPCL belum diinput.');
        }

        $proposal->load(['user.farmerProfile', 'surveyAssignments', 'cpclVerifications']);
        $kepalaDinas = \App\Models\Employee::where('role', 'Kepala Dinas')->first();

        $pdf = Pdf::loadView('documents.cpcl', compact('proposal', 'kepalaDinas'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Berita_Acara_Verifikasi_CPCL_PRP_' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }

    /**
     * Cetak Berita Acara (BA)
     */
    public function printBeritaAcara(Proposal $proposal)
    {
        $this->authorizeAccess($proposal);

        if (!$proposal->beritaAcara) {
            abort(404, 'Berita Acara belum dibuat.');
        }

        $proposal->load(['user.farmerProfile', 'beritaAcara.kabid', 'cpclVerifications']);
        $kepalaDinas = \App\Models\Employee::where('role', 'Kepala Dinas')->first();

        $pdf = Pdf::loadView('documents.berita-acara', compact('proposal', 'kepalaDinas'));
        return $pdf->stream('Berita_Acara_PRP_' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }

    /**
     * Cetak SK Bantuan (untuk Program Bantuan yang disetujui)
     */
    public function printSKBantuan(Proposal $proposal)
    {
        $this->authorizeAccess($proposal);

        if ($proposal->status !== 'disetujui' || $proposal->alsintan_id) {
            abort(404, 'SK Bantuan tidak tersedia untuk proposal ini.');
        }

        $proposal->load(['user.farmerProfile', 'program']);
        $kepalaDinas = \App\Models\Employee::where('role', 'Kepala Dinas')->first();

        $pdf = Pdf::loadView('documents.sk-bantuan', compact('proposal', 'kepalaDinas'));
        return $pdf->stream('SK_Bantuan_PRP_' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }

    /**
     * Cetak Surat Perjanjian Pinjam Pakai (untuk Alsintan yang disetujui)
     */
    public function printSuratPerjanjian(Proposal $proposal)
    {
        $this->authorizeAccess($proposal);

        if ($proposal->status !== 'disetujui' || !$proposal->alsintan_id) {
            abort(404, 'Surat Perjanjian tidak tersedia untuk proposal ini.');
        }

        $proposal->load(['user.farmerProfile', 'alsintan']);
        $kepalaDinas = \App\Models\Employee::where('role', 'Kepala Dinas')->first();

        $pdf = Pdf::loadView('documents.surat-perjanjian', compact('proposal', 'kepalaDinas'));
        return $pdf->stream('Surat_Perjanjian_PRP_' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }
}
