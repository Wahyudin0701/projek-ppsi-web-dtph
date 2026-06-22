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
use Illuminate\Support\Facades\Storage;
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
                'nama_kelompok' => ['required', 'string', 'max:255'],
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
                'file_sk' => ['required_without:temp_file_sk', 'nullable', 'file', 'extensions:pdf,jpg,jpeg,png', 'max:5120'],
                'temp_file_sk' => ['nullable', 'string'],
                'foto_ktp' => ['required_without:temp_foto_ktp', 'nullable', 'file', 'extensions:jpg,jpeg,png', 'max:5120'],
                'temp_foto_ktp' => ['nullable', 'string'],
                'id_poktan' => ['required', 'string', 'max:255'],
            ]);
        } elseif ($role === 'umum') {
            $rules = array_merge($rules, [
                'nik_ketua' => ['required', 'string', 'size:16'],
                'no_wa' => ['required', 'string', 'max:20'],
                'alamat' => ['required', 'string'],
                'foto_ktp' => ['required_without:temp_foto_ktp', 'nullable', 'file', 'extensions:jpg,jpeg,png', 'max:5120'],
                'temp_foto_ktp' => ['nullable', 'string'],
            ]);
        }

        $request->validate($rules);

        $user = DB::transaction(function () use ($request, $role) {
            $dbRole = $role;

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $dbRole,
            ]);

            $user->assignRole($dbRole);

            if ($role === 'petani') {
                $profile = $user->farmerProfile()->create([
                    'nama_kelompok' => $request->nama_kelompok,
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
                    'sk_pengukuhan_path' => $this->handleFileUpload($request, 'file_sk', 'temp_file_sk', 'sk_kelompok'),
                    'foto_ktp' => $this->handleFileUpload($request, 'foto_ktp', 'temp_foto_ktp', 'ktp_ketua'),
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
            } elseif ($role === 'umum') {
                $user->umumProfile()->create([
                    'nik' => $request->nik_ketua,
                    'no_wa' => $request->no_wa,
                    'alamat' => $request->alamat,
                    'foto_ktp' => $this->handleFileUpload($request, 'foto_ktp', 'temp_foto_ktp', 'ktp_umum'),
                ]);
            }

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    private function handleFileUpload($request, $fileKey, $tempKey, $destination)
    {
        if ($request->hasFile($fileKey)) {
            $file = $request->file($fileKey);
            $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
            return $file->storeAs($destination, $filename, 'public');
        } elseif ($request->filled($tempKey) && Storage::disk('public')->exists($request->input($tempKey))) {
            $tempPath = $request->input($tempKey);
            $newPath = str_replace('temp/', $destination . '/', $tempPath);
            Storage::disk('public')->move($tempPath, $newPath);
            return $newPath;
        }
        return null;
    }

    public function tempUpload(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'extensions:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('temp', $filename, 'public');
            return response()->json(['path' => $path]);
        }

        return response()->json(['error' => 'File not found'], 400);
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
        ]);

        $exists = User::where('email', $request->email)->exists();

        return response()->json(['exists' => $exists]);
    }
}
