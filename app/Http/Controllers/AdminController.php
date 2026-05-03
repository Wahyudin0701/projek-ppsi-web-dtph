<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('role', 'user')
            ->whereIn('status', ['menunggu', 'reviewed'])
            ->latest()
            ->get();

        return view('admin.users.index', compact('pendingUsers'));
    }

    public function show(User $user)
    {
        if ($user->status === 'menunggu') {
            $user->status = 'reviewed';
            $user->save();
        }

        return view('admin.users.show', compact('user'));
    }

    public function markAsReviewed(User $user)
    {
        if ($user->status === 'menunggu') {
            $user->status = 'reviewed';
            $user->save();
        }
        return response()->json([
            'success' => true,
            'status' => $user->status
        ]);
    }

    public function approve(User $user)
    {
        $user->update(['status' => 'approved']);

        return redirect()->route('admin.users.index')->with('success', "Akun Kelompok Tani {$user->nama_kelompok} berhasil disetujui.");
    }

    public function reject(Request $request, User $user)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        $user->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->route('admin.users.index')->with('success', "Pendaftaran Kelompok Tani {$user->nama_kelompok} telah ditolak.");
    }

    public function list(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('nama_kelompok', 'like', '%' . $request->search . '%');
        }

        $users = $query->orderBy('nama_kelompok', 'asc')->get();

        return view('admin.users.list', compact('users'));
    }
}
