<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alsintan;
use Illuminate\Http\Request;

class AlsintanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alsintans = Alsintan::latest()->get();
        return view('admin.alsintan.index', compact('alsintans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.alsintan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:traktor,pompa,pascapanen,tanam',
            'merk' => 'nullable|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'borrowed_count' => 'nullable|integer|min:0',
            'broken_count' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['borrowed_count'] = $validated['borrowed_count'] ?? 0;
        $validated['broken_count'] = $validated['broken_count'] ?? 0;

        if (($validated['borrowed_count'] + $validated['broken_count']) > $validated['stock']) {
            return back()->withInput()->withErrors([
                'stock' => 'Total alat dipinjam dan rusak (' . ($validated['borrowed_count'] + $validated['broken_count']) . ') tidak boleh melebihi total stok milik dinas (' . $validated['stock'] . ').'
            ]);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('alsintan', 'public');
        }

        Alsintan::create($validated);

        return redirect()->route('admin.alsintan.index')->with('success', 'Alsintan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alsintan $alsintan)
    {
        return view('admin.alsintan.show', compact('alsintan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alsintan $alsintan)
    {
        return view('admin.alsintan.edit', compact('alsintan'));
    }
    public function update(Request $request, Alsintan $alsintan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:traktor,pompa,pascapanen,tanam',
            'merk' => 'nullable|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'borrowed_count' => 'nullable|integer|min:0',
            'broken_count' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['borrowed_count'] = $validated['borrowed_count'] ?? 0;
        $validated['broken_count'] = $validated['broken_count'] ?? 0;

        if (($validated['borrowed_count'] + $validated['broken_count']) > $validated['stock']) {
            return back()->withInput()->withErrors([
                'stock' => 'Total alat dipinjam dan rusak (' . ($validated['borrowed_count'] + $validated['broken_count']) . ') tidak boleh melebihi total stok milik dinas (' . $validated['stock'] . ').'
            ]);
        }

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($alsintan->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($alsintan->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($alsintan->image);
            }
            $validated['image'] = $request->file('image')->store('alsintan', 'public');
        }

        $alsintan->update($validated);

        return redirect()->route('admin.alsintan.index')->with('success', 'Alsintan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alsintan $alsintan)
    {
        if ($alsintan->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($alsintan->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($alsintan->image);
        }
        
        $alsintan->delete();
        return redirect()->route('admin.alsintan.index')->with('success', 'Alsintan berhasil dihapus.');
    }
}
