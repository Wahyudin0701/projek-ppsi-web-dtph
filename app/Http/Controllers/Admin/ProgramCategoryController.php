<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramCategoryController extends Controller
{
    public function index()
    {
        $categories = ProgramCategory::withCount('programs')->orderBy('name')->get();
        return view('admin.program_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.program_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon_path' => 'nullable|string',
            'icon_color' => 'nullable|string|max:255',
            'icon_bg' => 'nullable|string|max:255',
        ]);

        ProgramCategory::create($request->all());

        return redirect()->route('admin.program-categories.index')->with('success', 'Jenis program berhasil ditambahkan.');
    }

    public function edit(ProgramCategory $programCategory)
    {
        return view('admin.program_categories.edit', compact('programCategory'));
    }

    public function update(Request $request, ProgramCategory $programCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon_path' => 'nullable|string',
            'icon_color' => 'nullable|string|max:255',
            'icon_bg' => 'nullable|string|max:255',
        ]);

        $programCategory->update($request->all());

        return redirect()->route('admin.program-categories.index')->with('success', 'Jenis program berhasil diperbarui.');
    }

    public function destroy(ProgramCategory $programCategory)
    {
        if ($programCategory->programs()->count() > 0) {
            return redirect()->route('admin.program-categories.index')->with('error', 'Jenis program tidak dapat dihapus karena masih digunakan oleh program.');
        }

        $programCategory->delete();
        return redirect()->route('admin.program-categories.index')->with('success', 'Jenis program berhasil dihapus.');
    }
}
