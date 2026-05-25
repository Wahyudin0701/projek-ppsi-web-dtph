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
        $query = Employee::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
        }
        
        $employees = $query->latest()->paginate(10)->withQueryString();
        return view('admin.employees.index', compact('employees'));
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
            'role' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $data = $request->only(['name', 'nip', 'role']);

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
            'role'   => 'required|string|max:255',
            'foto'   => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $data = $request->only(['name', 'nip', 'role']);

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
