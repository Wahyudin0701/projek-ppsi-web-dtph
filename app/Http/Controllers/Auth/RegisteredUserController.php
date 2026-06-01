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
                'komoditi.*' => ['string', 'max:255'],
                'komoditi_utama' => ['required', 'string', 'in:Padi Sawah,Padi Gogo,Jagung Hibrida,Kedelai,Kacang Tanah,Sayuran,Buah-buahan,Biofarmaka'],
                'kecamatan' => ['required', 'string', 'max:255'],
                'alamat' => ['required', 'string'],
                'anggota_nama' => ['required', 'array', 'min:1'],
                'anggota_nama.*' => ['required', 'string', 'max:255'],
                'anggota_nik' => ['required', 'array', 'min:1'],
                'anggota_nik.*' => ['required', 'string', 'size:16'],
                'no_sk' => ['required', 'string', 'max:255'],
                'file_sk' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
                'foto_ktp' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
                'id_poktan' => ['required', 'string', 'max:255'],
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
                $profile = $user->farmerProfile()->create([
                    'nama_kelompok' => $request->name,
                    'id_poktan' => $request->id_poktan,
                    'ketua' => $request->nama_ketua,
                    'nik_ketua' => $request->nik_ketua,
                    'kontak' => $request->no_wa,
                    'grade' => $request->grade,
                    'luas_lahan' => $request->luas_lahan,
                    'komoditi' => implode(', ', $request->komoditi),
                    'komoditi_utama' => $request->komoditi_utama,
                    'kecamatan' => $request->kecamatan,
                    'alamat' => $request->alamat,
                    'no_sk' => $request->no_sk,
                    'sk_pengukuhan_path' => $request->hasFile('file_sk') ? $request->file('file_sk')->store('sk_kelompok', 'public') : null,
                    'foto_ktp' => $request->hasFile('foto_ktp') ? $request->file('foto_ktp')->store('ktp_ketua', 'public') : null,
                    'status' => 'menunggu',
                ]);

                if ($request->has('anggota_nama') && is_array($request->anggota_nama)) {
                    foreach ($request->anggota_nama as $index => $namaAnggota) {
                        $nikAnggota = $request->anggota_nik[$index] ?? null;
                        $profile->members()->create([
                            'nama' => $namaAnggota,
                            'nik' => $nikAnggota,
                        ]);
                    }
                }
            }

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
