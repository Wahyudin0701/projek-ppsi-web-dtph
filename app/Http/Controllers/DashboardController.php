<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Proposal;
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

        if (!$user->isApproved()) {
            return view('farmer.dashboard');
        }

        // Farmer/User dashboard data
        $proposals = Proposal::where('user_id', $user->id)->get();

        $stats = [
            'total'     => $proposals->count(),
            'proses'    => $proposals->whereIn('status', ['pending_verifikasi', 'dalam_proses'])->count(),
            'disetujui' => $proposals->where('status', 'disetujui')->count(),
            'ditolak'   => $proposals->where('status', 'ditolak')->count(),
        ];

        $recentProposals = Proposal::where('user_id', $user->id)
            ->with(['program', 'alsintan'])
            ->latest('submission_date')
            ->take(5)
            ->get();

        $programs = Program::where('is_open', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('farmer.dashboard', compact('stats', 'recentProposals', 'programs'));
    }
}
