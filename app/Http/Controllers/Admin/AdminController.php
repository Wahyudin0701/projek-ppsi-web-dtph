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
                $query->whereIn('status', ['menunggu', 'reviewed']);
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
        }

        return redirect()->route('admin.users.index')->with('success', "Pendaftaran Kelompok Tani {$user->farmerProfile->nama_kelompok} telah ditolak.");
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
}
