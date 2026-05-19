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
        if ($user->role === 'kabid_psp' || $user->role === 'kabid_tp') {
            if ($proposal->kabid_id && $proposal->kabid_id !== $user->id) {
                abort(403, 'Bukan wewenang Anda.');
            }
        }
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

        $pdf = Pdf::loadView('documents.berita-acara', compact('proposal'));
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

        $pdf = Pdf::loadView('documents.sk-bantuan', compact('proposal'));
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

        $pdf = Pdf::loadView('documents.surat-perjanjian', compact('proposal'));
        return $pdf->stream('Surat_Perjanjian_PRP_' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }
}
