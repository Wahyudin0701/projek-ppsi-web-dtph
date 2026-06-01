<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $structuralRolesList = [
            'Kepala Dinas', 
            'Sekretaris', 
            'Kasubbag Umum Kepegawaian', 
            'Fungsional Perencanaan', 
            'Fungsional Analis Keuangan Pusat dan Daerah', 
            'Kabid. Tanaman Pangan', 
            'Kabid. Hortikultura', 
            'Kabid. PSP', 
            'Kabid. Penyuluhan',
            'UPTD Balai Benih Utama Arang Arang'
        ];

        // Pastikan role struktural ada di DB agar bisa diedit di form
        foreach ($structuralRolesList as $role) {
            Employee::firstOrCreate(
                ['role' => $role],
                ['name' => '', 'nip' => null, 'pangkat_gol' => null]
            );
        }

        $pejabatStruktural = Employee::whereIn('role', $structuralRolesList)->get()->keyBy('role');

        $query = Employee::whereNotIn('role', $structuralRolesList);
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        }
        
        $employees = $query->latest()->paginate(10)->withQueryString();
        return view('admin.employees.index', compact('employees', 'pejabatStruktural', 'structuralRolesList'));
    }

    public function updateStruktur(Request $request)
    {
        $request->validate([
            'struktur' => 'required|array',
            'struktur.*.role' => 'required|string',
            'struktur.*.name' => 'nullable|string|max:255',
            'struktur.*.nip' => 'nullable|string|max:50',
            'struktur.*.pangkat_gol' => 'nullable|string|max:100',
        ]);

        foreach ($request->struktur as $item) {
            if (!empty($item['name']) || !empty($item['nip'])) {
                Employee::updateOrCreate(
                    ['role' => $item['role']],
                    [
                        'name' => $item['name'] ?? '',
                        'nip' => $item['nip'] ?? null,
                        'pangkat_gol' => $item['pangkat_gol'] ?? null,
                    ]
                );
            }
        }

        return redirect()->route('admin.employees.index')->with('success', 'Struktur Organisasi berhasil diperbarui.');
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip'  => 'nullable|string|max:50',
            'pangkat_gol' => 'nullable|string|max:100',
            'role' => 'required|string|max:100',
            'bidang' => 'nullable|string|max:100',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'nip', 'pangkat_gol', 'role', 'bidang']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('employees', 'public');
        }

        Employee::create($data);

        return redirect()->route('admin.employees.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'nip'    => 'nullable|string|max:50',
            'pangkat_gol' => 'nullable|string|max:100',
            'role'   => 'required|string|max:100',
            'bidang' => 'nullable|string|max:100',
            'foto'   => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'nip', 'pangkat_gol', 'role', 'bidang']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($employee->foto) {
                Storage::disk('public')->delete($employee->foto);
            }
            $data['foto'] = $request->file('foto')->store('employees', 'public');
        }

        // Hapus foto jika user klik "Hapus Foto"
        if ($request->boolean('hapus_foto')) {
            if ($employee->foto) {
                Storage::disk('public')->delete($employee->foto);
            }
            $data['foto'] = null;
        }

        $employee->update($data);

        return redirect()->route('admin.employees.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        // Hapus file foto dari storage jika ada
        if ($employee->foto) {
            Storage::disk('public')->delete($employee->foto);
        }
        
        $employee->delete();
        return redirect()->route('admin.employees.index')->with('success', 'Data pegawai berhasil dihapus.');
    }
}
