<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verifyProposal($id, $hash)
    {
        $proposal = Proposal::with(['user.farmerProfile', 'alsintan', 'program'])->find($id);

        if (!$proposal) {
            return view('public.verifikasi.status', [
                'status' => 'not_found',
                'message' => 'Dokumen Tidak Ditemukan. QR Code ini mungkin tidak valid atau dokumen telah dihapus.'
            ]);
        }

        // Generate expected hash
        $expectedHash = substr(md5($proposal->id . $proposal->submission_date->timestamp . config('app.key')), 0, 10);

        if ($hash !== $expectedHash) {
            return view('public.verifikasi.status', [
                'status' => 'invalid',
                'message' => 'Dokumen Tidak Valid. Tanda tangan digital pada dokumen ini tidak cocok dengan data di server kami. Indikasi pemalsuan dokumen.'
            ]);
        }

        return view('public.verifikasi.status', [
            'status' => 'valid',
            'proposal' => $proposal
        ]);
    }
}
