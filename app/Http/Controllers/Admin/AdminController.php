<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('role', 'petani')
            ->whereHas('farmerProfile', function ($query) {
                $query->whereIn('status', ['menunggu', 'reviewed', 'pengajuan_revisi']);
            })
            ->with('farmerProfile')
            ->latest()
            ->get();

        return view('admin.users.index', compact('pendingUsers'));
    }

    public function show(User $user)
    {
        if ($user->status === 'menunggu') {
            $user->farmerProfile->update(['status' => 'reviewed']);
        }

        return view('admin.users.show', compact('user'));
    }

    public function markAsReviewed(User $user)
    {
        if ($user->status === 'menunggu') {
            $user->farmerProfile->update(['status' => 'reviewed']);
        }
        return response()->json([
            'success' => true,
            'status' => $user->status
        ]);
    }

    public function approve(User $user)
    {
        $user->update(['status' => 'approved']);
        
        if ($user->farmerProfile) {
            \App\Models\FarmerVerificationLog::create([
                'farmer_profile_id' => $user->farmerProfile->id,
                'admin_id' => auth()->id(),
                'status' => 'approved',
                'notes' => 'Disetujui oleh admin.',
            ]);
        }

        $nama = $user->farmerProfile->nama_kelompok ?? $user->name;
        return redirect()->route('admin.users.index')->with('success', "Akun {$nama} berhasil disetujui.");
    }

    public function reject(Request $request, User $user)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        $user->update(['status' => 'rejected']);

        if ($user->farmerProfile) {
            $user->farmerProfile->update([
                'rejection_reason' => $request->rejection_reason,
            ]);

            \App\Models\FarmerVerificationLog::create([
                'farmer_profile_id' => $user->farmerProfile->id,
                'admin_id' => auth()->id(),
                'status' => 'rejected',
                'notes' => $request->rejection_reason,
            ]);
        }

        $nama = $user->farmerProfile->nama_kelompok ?? $user->name;
        return redirect()->route('admin.users.index')->with('success', "Pendaftaran {$nama} telah ditolak.");
    }

    public function revise(Request $request, User $user)
    {
        $request->validate([
            'revision_note' => 'required|string',
        ]);

        $user->update(['status' => 'revisi']);

        if ($user->farmerProfile) {
            $user->farmerProfile->update([
                'rejection_reason' => $request->revision_note, // We can reuse this column for the latest note for backward compatibility if needed, but we also have logs
            ]);

            \App\Models\FarmerVerificationLog::create([
                'farmer_profile_id' => $user->farmerProfile->id,
                'admin_id' => auth()->id(),
                'status' => 'revisi',
                'notes' => $request->revision_note,
            ]);
        }

        $nama = $user->farmerProfile->nama_kelompok ?? $user->name;
        return redirect()->route('admin.users.index')->with('success', "Pendaftaran {$nama} dikembalikan untuk direvisi.");
    }

    public function list(Request $request)
    {
        $query = User::where('role', 'petani')->with('farmerProfile');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('farmerProfile', function ($q) use ($request) {
                $q->where('nama_kelompok', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->get()->sortBy(function($user) {
            return $user->farmerProfile->nama_kelompok ?? '';
        });

        return view('admin.users.list', compact('users'));
    }

    public function listIndividuals(Request $request)
    {
        $query = User::where('role', 'umum')->with('farmerProfile');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('farmerProfile', function ($q) use ($request) {
                      $q->where('nama_kelompok', 'like', '%' . $request->search . '%')
                        ->orWhere('nik_ketua', 'like', '%' . $request->search . '%');
                  });
        }

        $users = $query->get()->sortBy(function($user) {
            return $user->name;
        });

        return view('admin.users.individuals', compact('users'));
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
                
            return redirect()->route('admin.verifikasi.index')->with('success', 'Revisi disetujui, akun aktif.');
        } else {
            $user->update(['status' => 'rejected']);
            $user->farmerProfile->update([
                'rejection_reason' => $request->rejection_reason
            ]);
            
            Activity::causedBy(Auth::user())
                ->performedOn($user)
                ->event('rejected_revision')
                ->log("Admin menolak revisi profil {$user->name}");
                
            return redirect()->route('admin.verifikasi.index')->with('success', 'Revisi ditolak.');
        }
    }
}
