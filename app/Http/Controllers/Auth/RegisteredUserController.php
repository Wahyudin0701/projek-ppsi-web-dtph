<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\FarmerProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $role = $request->query('role', 'petani');
        return view('auth.register', compact('role'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $role = $request->input('role', 'petani');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:petani,umum'],
        ];

        if ($role === 'petani') {
            $rules = array_merge($rules, [
                'nama_ketua' => ['required', 'string', 'max:255'],
                'nik_ketua' => ['required', 'string', 'size:16'],
                'no_wa' => ['required', 'string', 'max:20'],
                'grade' => ['required', 'string', 'in:Pemula,Madya,Utama'],
                'luas_lahan' => ['required', 'numeric', 'min:0'],
                'komoditi' => ['required', 'array', 'min:1'],
                'komoditi.*' => ['string', 'in:Padi Sawah,Padi Gogo,Jagung,Cabai,Sayuran,Kelapa Sawit'],
                'komoditi_utama' => ['required', 'string', 'in:Padi Sawah,Padi Gogo,Jagung,Cabai,Sayuran,Kelapa Sawit'],
                'kecamatan' => ['required', 'string', 'max:255'],
                'alamat' => ['required', 'string'],
            ]);
        }

        $request->validate($rules);

        $user = DB::transaction(function () use ($request, $role) {
            $dbRole = $role === 'petani' ? 'user' : $role;

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $dbRole,
            ]);

            if ($role === 'petani') {
                $user->farmerProfile()->create([
                    'nama_kelompok' => $request->name,
                    'ketua' => $request->nama_ketua,
                    'nik_ketua' => $request->nik_ketua,
                    'kontak' => $request->no_wa,
                    'grade' => $request->grade,
                    'luas_lahan' => $request->luas_lahan,
                    'komoditi' => implode(', ', $request->komoditi),
                    'komoditi_utama' => $request->komoditi_utama,
                    'kecamatan' => $request->kecamatan,
                    'alamat' => $request->alamat,
                    'status' => 'menunggu',
                ]);
            }

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
