<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SatuanKerja;
use Illuminate\Http\Request;

class SatuanKerjaController extends Controller
{
    public function index()
    {
        $satuanKerjas = SatuanKerja::latest()->paginate(10);
        return view('admin.satuan-kerja.index', compact('satuanKerjas'));
    }

    public function create()
    {
        return view('admin.satuan-kerja.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'koordinator' => 'required|string|max:255',
            'hp' => 'required|string|max:255',
            'maps' => 'nullable|string',
        ]);

        SatuanKerja::create($validated);

        return redirect()->route('admin.satuan-kerja.index')->with('success', 'Satuan Kerja berhasil ditambahkan.');
    }

    public function edit(SatuanKerja $satuan_kerja)
    {
        return view('admin.satuan-kerja.edit', compact('satuan_kerja'));
    }

    public function update(Request $request, SatuanKerja $satuan_kerja)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'koordinator' => 'required|string|max:255',
            'hp' => 'required|string|max:255',
            'maps' => 'nullable|string',
        ]);

        $satuan_kerja->update($validated);

        return redirect()->route('admin.satuan-kerja.index')->with('success', 'Satuan Kerja berhasil diperbarui.');
    }

    public function destroy(SatuanKerja $satuan_kerja)
    {
        $satuan_kerja->delete();
        return redirect()->route('admin.satuan-kerja.index')->with('success', 'Satuan Kerja berhasil dihapus.');
    }
}
