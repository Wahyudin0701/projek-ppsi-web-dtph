<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('role', 'user')
            ->where('status', 'pending')
            ->get();

        return view('admin.users.index', compact('pendingUsers'));
    }

    public function approve(User $user)
    {
        $user->update(['status' => 'approved']);

        return back()->with('success', 'User berhasil disetujui.');
    }
}
