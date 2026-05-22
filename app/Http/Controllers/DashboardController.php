<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Proposal;
use App\Models\Alsintan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Handle verification acknowledgment
        if ($request->has('verified') && $user->farmerProfile && $user->farmerProfile->status === 'approved' && !$user->farmerProfile->is_verified_acknowledged) {
            $user->farmerProfile->update(['is_verified_acknowledged' => true]);
            return redirect()->route('dashboard');
        }

        if ($user->isAdmin()) {
            return view('admin.dashboard');
        }

        if ($user->isPimpinan()) {
            return redirect()->route('pimpinan.dashboard');
        }

        if ($user->isKabid()) {
            return redirect()->route('kabid.dashboard');
        }

        if (!$user->isApproved()) {
            return view('farmer.dashboard');
        }

        // Farmer/User dashboard data
        $allUserProposals = Proposal::where('user_id', $user->id)
            ->with('program')
            ->get();

        $stats = [
            'total'     => $allUserProposals->count(),
            'proses'    => $allUserProposals->whereIn('status', [
                                'pending_verifikasi', 'diteruskan_ke_pimpinan',
                                'didisposisi_kabid', 'surat_tugas_terbit',
                                'survei_selesai', 'menunggu_approval_ba',
                            ])->count(),
            'disetujui' => $allUserProposals->where('status', 'disetujui')->count(),
            'ditolak'   => $allUserProposals->where('status', 'ditolak')->count(),
        ];

        $recentProposals = $allUserProposals->sortByDesc('submission_date')->take(3);

        // IDs and Types already applied for
        $activeProposals = $allUserProposals->whereIn('status', ['pending_verifikasi', 'diteruskan_ke_pimpinan', 'disetujui']);
        
        $activeProposalProgramTypes = $activeProposals->whereNotNull('program_id')
            ->pluck('program.type')
            ->filter()
            ->unique()
            ->toArray();

        $activeProposalAlsintanIds = $activeProposals->whereNotNull('alsintan_id')
            ->pluck('alsintan_id')
            ->toArray();

        $programs = Program::where('is_open', true)
            ->whereNotIn('type', $activeProposalProgramTypes)
            ->whereNotNull('open_date')
            ->where('open_date', '<=', now()->startOfDay())
            ->where(function ($query) {
                $query->whereNull('close_date')
                      ->orWhere('close_date', '>=', now()->startOfDay());
            })
            ->latest()
            ->take(3)
            ->get();

        $alsintans = Alsintan::whereNotIn('id', $activeProposalAlsintanIds)
            ->whereRaw('(stock - borrowed_count - broken_count) > 0')
            ->latest()
            ->take(3)
            ->get();

        return view('farmer.dashboard', compact('stats', 'recentProposals', 'programs', 'alsintans'));
    }
}
