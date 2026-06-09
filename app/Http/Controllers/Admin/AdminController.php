<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    public function index()
    {
        $pendingUsers = User::whereIn('role', ['petani', 'umum'])
            ->whereIn('status', ['menunggu', 'reviewed', 'pengajuan_revisi'])
            ->with(['farmerProfile', 'umumProfile'])
            ->latest()
            ->get();

        return view('admin.users.index', compact('pendingUsers'));
    }

    public function show(User $user)
    {
        if ($user->status === 'menunggu') {
            $user->update(['status' => 'reviewed']);
        }

        return view('admin.users.show', compact('user'));
    }

    public function markAsReviewed(User $user)
    {
        if ($user->status === 'menunggu') {
            $user->update(['status' => 'reviewed']);
        }
        return response()->json([
            'success' => true,
            'status' => $user->status
        ]);
    }

    public function approve(User $user)
    {
        $user->update(['status' => 'approved']);
        
        if ($user->role === 'petani' && $user->farmerProfile) {
            \App\Models\FarmerVerificationLog::create([
                'farmer_profile_id' => $user->farmerProfile->id,
                'admin_id' => auth()->id(),
                'status' => 'approved',
                'notes' => 'Disetujui oleh admin.',
            ]);
            $user->farmerProfile->update(['status' => 'approved']);
        } elseif ($user->role === 'umum' && $user->umumProfile) {
            $user->umumProfile->update(['status' => 'approved']);
        }

        $nama = $user->role === 'umum' ? $user->name : ($user->farmerProfile->nama_kelompok ?? $user->name);
        return redirect()->route('admin.users.index')->with('success', "Akun {$nama} berhasil disetujui.");
    }

    public function reject(Request $request, User $user)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        $user->update(['status' => 'rejected']);

        if ($user->role === 'petani' && $user->farmerProfile) {
            $user->farmerProfile->update([
                'rejection_reason' => $request->rejection_reason,
                'status' => 'rejected'
            ]);

            \App\Models\FarmerVerificationLog::create([
                'farmer_profile_id' => $user->farmerProfile->id,
                'admin_id' => auth()->id(),
                'status' => 'rejected',
                'notes' => $request->rejection_reason,
            ]);
        } elseif ($user->role === 'umum' && $user->umumProfile) {
            $user->umumProfile->update([
                'rejection_reason' => $request->rejection_reason,
                'status' => 'rejected'
            ]);
        }

        $nama = $user->role === 'umum' ? $user->name : ($user->farmerProfile->nama_kelompok ?? $user->name);
        return redirect()->route('admin.users.index')->with('success', "Pendaftaran {$nama} telah ditolak.");
    }

    public function revise(Request $request, User $user)
    {
        $request->validate([
            'revision_note' => 'required|string',
        ]);

        $user->update(['status' => 'revisi']);

        if ($user->role === 'petani' && $user->farmerProfile) {
            $user->farmerProfile->update([
                'rejection_reason' => $request->revision_note,
                'status' => 'revisi'
            ]);

            \App\Models\FarmerVerificationLog::create([
                'farmer_profile_id' => $user->farmerProfile->id,
                'admin_id' => auth()->id(),
                'status' => 'revisi',
                'notes' => $request->revision_note,
            ]);
        } elseif ($user->role === 'umum' && $user->umumProfile) {
            $user->umumProfile->update([
                'rejection_reason' => $request->revision_note,
                'status' => 'revisi'
            ]);
        }

        $nama = $user->role === 'umum' ? $user->name : ($user->farmerProfile->nama_kelompok ?? $user->name);
        return redirect()->route('admin.users.index')->with('success', "Pendaftaran {$nama} dikembalikan untuk direvisi.");
    }

    public function list(Request $request)
    {
        // Use join to enable DB-level orderBy on related farmer_profiles.nama_kelompok
        $query = User::where('users.role', 'petani')
            ->with('farmerProfile')
            ->join('farmer_profiles', 'users.id', '=', 'farmer_profiles.user_id')
            ->select('users.*')
            ->orderBy('farmer_profiles.nama_kelompok', 'asc');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('users.status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('users.created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('users.created_at', '<=', $request->end_date);
        }

        if ($request->filled('search')) {
            $query->where('farmer_profiles.nama_kelompok', 'like', '%' . $request->search . '%');
        }

        $users = $query->get();

        return view('admin.users.user-list-kelompok-tani', compact('users'));
    }

    public function listUmum(Request $request)
    {
        $query = User::where('role', 'umum')->with('umumProfile');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('umumProfile', function ($q) use ($search) {
                      $q->where('nik', 'like', "%{$search}%");
                  });
            });
        }

        $users = $query->orderBy('name', 'asc')->get();

        return view('admin.users.user-list-umum', compact('users'));
    }

    public function respondChangeRequest(Request $request, User $user)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'rejection_reason' => 'required_if:action,reject|string|nullable'
        ]);

        if ($user->status !== 'pengajuan_revisi') {
            return redirect()->route('admin.verifikasi.index')->with('error', 'Profil ini tidak dalam status pengajuan revisi.');
        }

        if ($request->action === 'approve') {
            $user->update(['status' => 'approved']);
            
            Activity::causedBy(Auth::user())
                ->performedOn($user)
                ->event('approved_revision')
                ->log("Admin menyetujui revisi profil {$user->name}");
                
            return redirect()->route('admin.users.index')->with('success', 'Revisi disetujui, akun aktif.');
        } else {
            $user->update(['status' => 'rejected']);
            
            if ($user->role === 'petani' && $user->farmerProfile) {
                $user->farmerProfile->update([
                    'rejection_reason' => $request->rejection_reason
                ]);
            } elseif ($user->role === 'umum' && $user->umumProfile) {
                $user->umumProfile->update([
                    'rejection_reason' => $request->rejection_reason
                ]);
            }
            
            Activity::causedBy(Auth::user())
                ->performedOn($user)
                ->event('rejected_revision')
                ->log("Admin menolak revisi profil {$user->name}");
                
            return redirect()->route('admin.users.index')->with('success', 'Revisi ditolak.');
        }
    }
}
