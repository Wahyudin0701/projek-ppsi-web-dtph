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
        if ($user->role === 'petani' && $proposal->user_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }
        if (in_array($user->role, ['kabid_psp', 'kabid_tp', 'kabid_hortikultura'])) {
            if ($proposal->kabid_id && $proposal->kabid_id !== $user->id) {
                abort(403, 'Bukan wewenang Anda.');
            }
        }
    }

    /**
     * Cetak Surat Tugas
     */
    public function printSuratTugas(Proposal $proposal)
    {
        $this->authorizeAccess($proposal);

        if ($proposal->surveyAssignments()->doesntExist()) {
            abort(403, 'Surat tugas belum diterbitkan.');
        }

        $proposal->load(['user.farmerProfile', 'program', 'alsintan', 'surveyAssignments']);
        $assignment = $proposal->surveyAssignments->last();
        if (!$assignment) abort(404, 'Data surat tugas tidak ditemukan.');

        $kepalaDinas = \App\Models\Employee::where('role', 'Kepala Dinas')->first();

        // Ambil signature untuk surat tugas
        $signature = \App\Models\DocumentSignature::with('signer')
            ->where('document_type', 'surat_tugas')
            ->where('document_id', $assignment->id)
            ->first();

        $pdf = Pdf::loadView('kabid.proposals.cetak-surat-tugas', compact('proposal', 'assignment', 'kepalaDinas', 'signature'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Surat_Tugas_Survei_PRP_' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }

    /**
     * Cetak Form Verifikasi CPCL (Blank/Template)
     */
    public function printFormCpcl(Proposal $proposal)
    {
        $this->authorizeAccess($proposal);

        if (!in_array($proposal->status, ['sedang_survei', 'verifikasi_cpcl', 'menunggu_keputusan_akhir', 'disetujui'])) {
            abort(403, 'Form CPCL belum tersedia.');
        }

        $proposal->load(['user.farmerProfile', 'surveyAssignments']);
        $kepalaDinas = \App\Models\Employee::where('role', 'Kepala Dinas')->first();

        // Menggunakan view cetak-form-cpcl untuk PDF rendering
        $pdf = Pdf::loadView('documents.cetak-form-cpcl', compact('proposal', 'kepalaDinas'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Form_Verifikasi_CPCL_PRP_' . str_pad($proposal->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }

    /**
     * Cetak Hasil Verifikasi CPCL
     */
    public function printCpcl(Proposal $proposal)
    {
        $this->authorizeAccess($proposal);

        // Prevent farmers (users) from accessing internal CPCL details
        if (Auth::user()->role === 'petani') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        if ($proposal->cpclVerifications->isEmpty()) {
            abort(404, 'Data Verifikasi CPCL belum diinput.');
        }

        $proposal->load(['user.farmerProfile', 'surveyAssignments', 'cpclVerifications']);
        $kepalaDinas = \App\Models\Employee::where('role', 'Kepala Dinas')->first();

        return view('documents.cpcl', compact('proposal', 'kepalaDinas'));
    }

    // Fitur Cetak PDF Berita Acara dihapus karena redundan dengan dokumen fisik yang sudah diunggah Kabid.

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
