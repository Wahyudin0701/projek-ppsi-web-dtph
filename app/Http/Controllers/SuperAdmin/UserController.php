<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Activitylog\Facades\Activity;

class UserController extends Controller
{
    private $fixedRoles = ['super_admin', 'admin', 'pimpinan', 'kabid_psp', 'kabid_tp', 'kabid_hortikultura'];

    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = User::with('roles');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%")
                  ->orWhereHas('roles', function($r) use ($search) {
                      $r->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $users = $query->get();
        $fixedRoles = $this->fixedRoles;
        return view('super-admin.users.index', compact('users', 'fixedRoles'));
    }

    public function create()
    {
        $roles = Role::whereNotIn('name', $this->fixedRoles)->get();
        return view('super-admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string'],
            'status' => ['required', 'string', 'in:menunggu,reviewed,approved,rejected,pengajuan_revisi'],
        ]);

        if (in_array($request->role, $this->fixedRoles)) {
            return back()->with('error', 'Tidak dapat membuat akun dengan role tetap dari antarmuka ini.');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
            'is_verified' => 1,
            'email_verified_at' => now(),
        ]);

        $user->assignRole($request->role);

        if ($request->role === 'petani' && $request->has('profile')) {
            $profileData = $request->input('profile');
            
            $skPath = null;
            if ($request->hasFile('profile.file_sk')) {
                $file = $request->file('profile.file_sk');
                $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
                $skPath = $file->storeAs('dokumen_sk', $filename, 'public');
            }

            $ktpPath = null;
            if ($request->hasFile('profile.foto_ktp')) {
                $file = $request->file('profile.foto_ktp');
                $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
                $ktpPath = $file->storeAs('ktp', $filename, 'public');
            }

            $komoditiStr = isset($profileData['komoditi']) && is_array($profileData['komoditi']) 
                ? implode(', ', $profileData['komoditi']) 
                : ($profileData['komoditi'] ?? null);

            $farmerProfile = $user->farmerProfile()->create([
                'nama_kelompok' => $profileData['nama_kelompok'] ?? '',
                'id_poktan' => $profileData['id_poktan'] ?? '',
                'no_sk' => $profileData['no_sk'] ?? null,
                'ketua' => $profileData['ketua'] ?? '',
                'nik_ketua' => $profileData['nik_ketua'] ?? '',
                'kontak' => $profileData['kontak'] ?? null,
                'pekerjaan' => $profileData['pekerjaan'] ?? 'Petani',
                'grade' => $profileData['grade'] ?? 'Pemula',
                'luas_lahan' => $profileData['luas_lahan'] ?? 0,
                'komoditi' => $komoditiStr,
                'komoditi_utama' => $profileData['komoditi_utama'] ?? null,
                'alamat' => $profileData['alamat'] ?? null,
                'kecamatan' => $profileData['kecamatan'] ?? null,
                'sk_pengukuhan_path' => $skPath,
                'foto_ktp' => $ktpPath,
            ]);

            if (isset($profileData['anggota_nama']) && is_array($profileData['anggota_nama'])) {
                foreach ($profileData['anggota_nama'] as $index => $nama) {
                    $nik = $profileData['anggota_nik'][$index] ?? null;
                    if (!empty(trim($nama)) && !empty(trim($nik))) {
                        $farmerProfile->members()->create([
                            'nama' => $nama,
                            'nik' => $nik,
                        ]);
                    }
                }
            }
        }

        // Log otomatis sudah ditangani oleh trait LogsActivity di model User

        return redirect()->route('super-admin.users.index')->with('success', 'Pengguna baru berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $roles = Role::whereNotIn('name', $this->fixedRoles)->get();
        $isFixed = in_array($user->role, $this->fixedRoles) || $user->roles->whereIn('name', $this->fixedRoles)->isNotEmpty();
        
        return view('super-admin.users.edit', compact('user', 'roles', 'isFixed'));
    }

    public function update(Request $request, User $user)
    {
        $isFixed = in_array($user->role, $this->fixedRoles) || $user->roles->whereIn('name', $this->fixedRoles)->isNotEmpty();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ];

        if (!$isFixed) {
            $rules['role'] = ['required', 'string'];
            $rules['status'] = ['required', 'string', 'in:menunggu,reviewed,approved,rejected,pengajuan_revisi'];
        }

        $request->validate($rules);

        $oldRole = $user->roles->first()?->name ?? $user->role;

        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if (!$isFixed && $request->has('status')) {
            $user->status = $request->status;
        }

        $user->save();

        if ($isFixed) {
            $roleMapping = [
                'pimpinan' => 'Kepala Dinas',
                'kabid_tp' => 'Kabid. Tanaman Pangan',
                'kabid_hortikultura' => 'Kabid. Hortikultura',
                'kabid_psp' => 'Kabid. PSP',
            ];
            
            if (isset($roleMapping[$oldRole])) {
                \App\Models\Employee::updateOrCreate(
                    ['role' => $roleMapping[$oldRole]],
                    ['name' => $user->name]
                );
            }
        }

        if (!$isFixed) {
            $newRole = $request->role;
            if ($oldRole !== $newRole) {
                if (in_array($newRole, $this->fixedRoles)) {
                    return back()->with('error', 'Tidak dapat mengubah menjadi role tetap.');
                }
                $user->syncRoles([$newRole]);
                $user->role = $newRole;
                $user->save();
            }

            // Update or Create Farmer Profile if role is petani
            if ($newRole === 'petani' && $request->has('profile')) {
                $profileData = $request->input('profile');
                
                // Handle File Uploads
                $skPath = optional($user->farmerProfile)->sk_pengukuhan_path;
                if ($request->hasFile('profile.file_sk')) {
                    if ($skPath) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($skPath);
                    }
                    $file = $request->file('profile.file_sk');
                    $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
                    $skPath = $file->storeAs('dokumen_sk', $filename, 'public');
                }

                $ktpPath = optional($user->farmerProfile)->foto_ktp;
                if ($request->hasFile('profile.foto_ktp')) {
                    if ($ktpPath) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($ktpPath);
                    }
                    $file = $request->file('profile.foto_ktp');
                    $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
                    $ktpPath = $file->storeAs('ktp', $filename, 'public');
                }

                // Handle Komoditi Array
                $komoditiStr = isset($profileData['komoditi']) && is_array($profileData['komoditi']) 
                    ? implode(', ', $profileData['komoditi']) 
                    : ($profileData['komoditi'] ?? optional($user->farmerProfile)->komoditi);

                $farmerProfile = $user->farmerProfile()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nama_kelompok' => $profileData['nama_kelompok'] ?? optional($user->farmerProfile)->nama_kelompok,
                        'id_poktan' => $profileData['id_poktan'] ?? optional($user->farmerProfile)->id_poktan,
                        'no_sk' => $profileData['no_sk'] ?? optional($user->farmerProfile)->no_sk,
                        'ketua' => $profileData['ketua'] ?? optional($user->farmerProfile)->ketua,
                        'nik_ketua' => $profileData['nik_ketua'] ?? optional($user->farmerProfile)->nik_ketua,
                        'kontak' => $profileData['kontak'] ?? optional($user->farmerProfile)->kontak,
                        'pekerjaan' => $profileData['pekerjaan'] ?? optional($user->farmerProfile)->pekerjaan ?? 'Petani',
                        'grade' => $profileData['grade'] ?? optional($user->farmerProfile)->grade ?? 'Pemula',
                        'luas_lahan' => $profileData['luas_lahan'] ?? optional($user->farmerProfile)->luas_lahan ?? 0,
                        'komoditi' => $komoditiStr,
                        'komoditi_utama' => $profileData['komoditi_utama'] ?? optional($user->farmerProfile)->komoditi_utama,
                        'alamat' => $profileData['alamat'] ?? optional($user->farmerProfile)->alamat,
                        'kecamatan' => $profileData['kecamatan'] ?? optional($user->farmerProfile)->kecamatan,
                        'sk_pengukuhan_path' => $skPath,
                        'foto_ktp' => $ktpPath,
                    ]
                );

                // Handle Anggota
                if (isset($profileData['anggota_nama']) && is_array($profileData['anggota_nama'])) {
                    $farmerProfile->members()->delete();
                    foreach ($profileData['anggota_nama'] as $index => $nama) {
                        $nik = $profileData['anggota_nik'][$index] ?? null;
                        if (!empty(trim($nama)) && !empty(trim($nik))) {
                            $farmerProfile->members()->create([
                                'nama' => $nama,
                                'nik' => $nik,
                            ]);
                        }
                    }
                }
            }
        }

        // Log otomatis perubahan data sudah ditangani oleh trait LogsActivity di model User

        return redirect()->route('super-admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $isFixed = in_array($user->role, $this->fixedRoles) || $user->roles->whereIn('name', $this->fixedRoles)->isNotEmpty();
        
        if ($isFixed) {
            return back()->with('error', 'Tidak dapat menghapus pengguna dengan role tetap.');
        }

        // Log otomatis penghapusan sudah ditangani oleh trait LogsActivity di model User

        $user->delete();

        return redirect()->route('super-admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
