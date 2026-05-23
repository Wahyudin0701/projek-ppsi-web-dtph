<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('role', 'user')
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
        if ($user->farmerProfile && $user->farmerProfile->status === 'menunggu') {
            $user->farmerProfile->update(['status' => 'reviewed']);
        }

        return view('admin.users.show', compact('user'));
    }

    public function markAsReviewed(User $user)
    {
        if ($user->farmerProfile && $user->farmerProfile->status === 'menunggu') {
            $user->farmerProfile->update(['status' => 'reviewed']);
        }
        return response()->json([
            'success' => true,
            'status' => $user->farmerProfile->status ?? null
        ]);
    }

    public function approve(User $user)
    {
        if ($user->farmerProfile) {
            $user->farmerProfile->update(['status' => 'approved']);
            
            \App\Models\FarmerVerificationLog::create([
                'farmer_profile_id' => $user->farmerProfile->id,
                'admin_id' => auth()->id(),
                'status' => 'approved',
                'notes' => 'Disetujui oleh admin.',
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', "Akun Kelompok Tani {$user->farmerProfile->nama_kelompok} berhasil disetujui.");
    }

    public function reject(Request $request, User $user)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        if ($user->farmerProfile) {
            $user->farmerProfile->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
            ]);

            \App\Models\FarmerVerificationLog::create([
                'farmer_profile_id' => $user->farmerProfile->id,
                'admin_id' => auth()->id(),
                'status' => 'rejected',
                'notes' => $request->rejection_reason,
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', "Pendaftaran Kelompok Tani {$user->farmerProfile->nama_kelompok} telah ditolak.");
    }

    public function revise(Request $request, User $user)
    {
        $request->validate([
            'revision_note' => 'required|string',
        ]);

        if ($user->farmerProfile) {
            $user->farmerProfile->update([
                'status' => 'revisi',
                'rejection_reason' => $request->revision_note, // We can reuse this column for the latest note for backward compatibility if needed, but we also have logs
            ]);

            \App\Models\FarmerVerificationLog::create([
                'farmer_profile_id' => $user->farmerProfile->id,
                'admin_id' => auth()->id(),
                'status' => 'revisi',
                'notes' => $request->revision_note,
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', "Pendaftaran Kelompok Tani {$user->farmerProfile->nama_kelompok} dikembalikan untuk direvisi.");
    }

    public function list(Request $request)
    {
        $query = User::where('role', 'user')->with('farmerProfile');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->whereHas('farmerProfile', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        if ($request->filled('search')) {
            $query->whereHas('farmerProfile', function ($q) use ($request) {
                $q->where('nama_kelompok', 'like', '%' . $request->search . '%');
            });
        }

        // We can't orderBy a relationship column easily with Eloquent, so we join or sort collection
        // Joining is better for performance if pagination is used later.
        // For now we'll fetch and sort.
        $users = $query->get()->sortBy(function($user) {
            return $user->farmerProfile->nama_kelompok ?? '';
        });

        return view('admin.users.list', compact('users'));
    }
    public function respondChangeRequest(Request $request, User $user)
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
        ]);

        if ($user->farmerProfile->status !== 'pengajuan_revisi') {
            return redirect()->back()->with('error', 'Status Kelompok Tani bukan sedang dalam pengajuan revisi.');
        }

        $actionText = '';
        if ($validated['action'] === 'approve') {
            $user->farmerProfile->update([
                'status' => 'revisi',
                'change_request_reason' => null, // clear it
                'rejection_reason' => null, // clear old rejection reason
            ]);
            $actionText = 'diizinkan';
        } else {
            $user->farmerProfile->update([
                'status' => 'approved',
                'change_request_reason' => null, // clear it
            ]);
            $actionText = 'ditolak';
        }

        // Log the decision
        $user->farmerProfile->verificationLogs()->create([
            'admin_id' => auth()->id(),
            'status' => $validated['action'] === 'approve' ? 'revisi' : 'approved',
            'notes' => "Permohonan ubah data $actionText.",
        ]);

        return redirect()->route('admin.users.show', $user)->with('success', "Permohonan perubahan data berhasil $actionText.");
    }
}
