<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return view('dashboard');
        }

        // Farmer/User dashboard data
        $proposals = Proposal::where('user_id', $user->id)->get();

        $stats = [
            'total'   => $proposals->count(),
            'proses'  => $proposals->whereIn('status', ['pending_verifikasi', 'dalam_proses'])->count(),
            'selesai' => $proposals->where('status', 'disetujui')->count(),
        ];

        $recentProposals = Proposal::where('user_id', $user->id)
            ->with('program')
            ->latest('submission_date')
            ->take(5)
            ->get();

        $programs = Program::where('is_open', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('stats', 'recentProposals', 'programs'));
    }
}
