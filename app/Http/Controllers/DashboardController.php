<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Proposal;
use App\Models\Alsintan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Handle verification acknowledgment
        if ($request->has('verified') && $user->farmerProfile && $user->status === 'approved' && !$user->farmerProfile->is_verified_acknowledged) {
            $user->farmerProfile->update(['is_verified_acknowledged' => true]);
            return redirect()->route('dashboard');
        }

        if ($user->hasRole('super_admin')) {
            $stats = [
                'total_users' => User::count(),
                'total_roles' => \Spatie\Permission\Models\Role::count(),
                'total_permissions' => \Spatie\Permission\Models\Permission::count(),
                'recent_logs' => \Spatie\Activitylog\Models\Activity::count(),
            ];
            $latestLogs = \Spatie\Activitylog\Models\Activity::with('causer')->latest()->take(5)->get();
            
            return view('super-admin.dashboard', compact('stats', 'latestLogs'));
        }

        if ($user->isAdmin()) {
            $pendingUsersCount = User::where('role', 'petani')->whereHas('farmerProfile', function($q) {
                $q->whereIn('status', ['menunggu', 'reviewed']);
            })->count();

            $pendingProposalsCount = Proposal::where('status', 'sedang_diverifikasi_admin')->count();
            
            $totalProposalsCount = Proposal::count();

            $totalKelompokTaniCount = User::where('role', 'petani')->count();

            $stats = [
                'pending_users'       => $pendingUsersCount,
                'pending_proposals'   => $pendingProposalsCount,
                'total_kelompok_tani' => $totalKelompokTaniCount,
                'total_proposals'     => $totalProposalsCount,
            ];

            $latestPendingUsers = User::with('farmerProfile')
                ->where('role', 'petani')
                ->whereHas('farmerProfile', function($q) {
                    $q->whereIn('status', ['menunggu', 'reviewed']);
                })
                ->latest()
                ->take(3)
                ->get();

            $latestPendingProposals = Proposal::with(['user.farmerProfile', 'program', 'alsintan'])
                ->where('status', 'sedang_diverifikasi_admin')
                ->latest('updated_at')
                ->take(5)
                ->get();

            $dispositionedProposals = Proposal::with(['user.farmerProfile', 'program', 'alsintan', 'surveyAssignments'])
                ->where('status', 'sedang_survei')
                ->latest('updated_at')
                ->take(5)
                ->get();

            // Fetch data for chart — limited to current year for performance
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

            return view('admin.dashboard', compact('stats', 'latestPendingUsers', 'latestPendingProposals', 'dispositionedProposals', 'chartData'));
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

        // Farmer/User dashboard data — use targeted DB queries, not PHP filtering
        $userId = $user->id;

        $stats = [
            'total'     => Proposal::where('user_id', $userId)->count(),
            'proses'    => Proposal::where('user_id', $userId)->whereIn('status', [
                                'sedang_diverifikasi_admin', 'sedang_diverifikasi_pimpinan',
                                'persiapan_survei', 'sedang_survei',
                                'verifikasi_cpcl', 'menunggu_keputusan_akhir',
                                'direkomendasikan',
                            ])->count(),
            'disetujui' => Proposal::where('user_id', $userId)->whereIn('status', ['disetujui', 'dikembalikan'])->count(),
            'ditolak'   => Proposal::where('user_id', $userId)->whereIn('status', ['ditolak', 'ditolak_pusat'])->count(),
        ];

        $recentProposals = Proposal::where('user_id', $userId)
            ->with(['program', 'alsintan'])
            ->latest('submission_date')
            ->take(3)
            ->get();

        // IDs of alsintan with active proposals (to exclude from suggestions)
        $activeStatuses = ['sedang_diverifikasi_admin', 'sedang_diverifikasi_pimpinan', 'persiapan_survei', 'sedang_survei', 'verifikasi_cpcl', 'menunggu_keputusan_akhir', 'disetujui', 'direkomendasikan'];
        
        $activeAlsintanIds = Proposal::where('user_id', $userId)
            ->whereNotNull('alsintan_id')
            ->whereIn('status', $activeStatuses)
            ->pluck('alsintan_id')
            ->toArray();
        
        $activeProgramTypes = Proposal::where('user_id', $userId)
            ->whereNotNull('program_id')
            ->whereIn('status', $activeStatuses)
            ->with('program:id,type')
            ->get()
            ->pluck('program.type')
            ->filter()
            ->unique()
            ->toArray();

        $programs = Program::where('is_open', true)
            ->whereNotIn('type', $activeProgramTypes)
            ->whereNotNull('open_date')
            ->where('open_date', '<=', now()->startOfDay())
            ->where(function ($query) {
                $query->whereNull('close_date')
                      ->orWhere('close_date', '>=', now()->startOfDay());
            })
            ->latest()
            ->take(3)
            ->get();

        $alsintans = Alsintan::whereNotIn('id', $activeAlsintanIds)
            ->whereHas('inventories', function($q) {
                $q->where('status_ketersediaan', 'Tersedia');
            })
            ->latest()
            ->take(3)
            ->get();

        return view('farmer.dashboard', compact('stats', 'recentProposals', 'programs', 'alsintans'));
    }
}
