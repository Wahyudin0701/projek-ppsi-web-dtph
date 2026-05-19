<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TimSurveiController extends Controller
{
    /**
     * List all surveyors (visible to all kabid).
     */
    public function index()
    {
        $surveyors = User::where('role', 'tim_survei')->latest()->get();
        return view('kabid.tim-survei.index', compact('surveyors'));
    }

    /**
     * Show form to create surveyor account.
     */
    public function create()
    {
        return view('kabid.tim-survei.create');
    }

    /**
     * Store new surveyor account.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'tim_survei',
        ]);

        return redirect()->route('kabid.tim-survei.index')
            ->with('success', "Akun Tim Survei untuk {$request->name} berhasil dibuat.");
    }

    /**
     * Delete surveyor account.
     */
    public function destroy(User $user)
    {
        if ($user->role !== 'tim_survei') {
            abort(403, 'Hanya akun Tim Survei yang dapat dihapus dari menu ini.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('kabid.tim-survei.index')
            ->with('success', "Akun {$name} berhasil dihapus.");
    }
}
