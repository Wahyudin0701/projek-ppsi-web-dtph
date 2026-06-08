<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alsintan;
use App\Models\AlsintanInventory;
use Illuminate\Http\Request;

class AlsintanInventoryController extends Controller
{
    public function store(Request $request, Alsintan $alsintan)
    {
        $validated = $request->validate([
            'nomor_rangka' => 'nullable|string|max:255',
            'nomor_mesin' => 'nullable|string|max:255',
            'sumber_dana' => 'nullable|string|in:APBD,APBN,Lainnya',
            'tahun_pengadaan' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'status_ketersediaan' => 'required|string|in:Tersedia,Dipinjam,Sedang Rusak',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $alsintan->inventories()->create($validated);

        return redirect()->back()->with('success', 'Unit inventaris berhasil ditambahkan.');
    }

    public function update(Request $request, Alsintan $alsintan, AlsintanInventory $inventory)
    {
        $validated = $request->validate([
            'nomor_rangka' => 'nullable|string|max:255',
            'nomor_mesin' => 'nullable|string|max:255',
            'sumber_dana' => 'nullable|string|in:APBD,APBN,Lainnya',
            'tahun_pengadaan' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'status_ketersediaan' => 'required|string|in:Tersedia,Dipinjam,Sedang Rusak',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $inventory->update($validated);

        return redirect()->back()->with('success', 'Unit inventaris berhasil diperbarui.');
    }

    public function destroy(Alsintan $alsintan, AlsintanInventory $inventory)
    {
        $inventory->delete();
        return redirect()->back()->with('success', 'Unit inventaris berhasil dihapus.');
    }
}
