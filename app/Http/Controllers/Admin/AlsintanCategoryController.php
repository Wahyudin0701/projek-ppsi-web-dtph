<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlsintanCategory;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class AlsintanCategoryController extends Controller
{
    public function index()
    {
        $categories = AlsintanCategory::withCount('inventories')->latest()->get();
        return view('admin.alsintan_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.alsintan_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        AlsintanCategory::create($request->all());

        return redirect()->route('admin.alsintan-categories.index')
            ->with('success', 'Kategori Alsintan berhasil ditambahkan.');
    }

    public function edit(AlsintanCategory $category)
    {
        return view('admin.alsintan_categories.edit', compact('category'));
    }

    public function update(Request $request, AlsintanCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $category->update($request->all());

        return redirect()->route('admin.alsintan-categories.index')
            ->with('success', 'Kategori Alsintan berhasil diperbarui.');
    }

    public function destroy(AlsintanCategory $category)
    {
        // Pengecekan eksplisit jika masih ada alat
        if ($category->alsintans()->exists()) {
            return redirect()->route('admin.alsintan-categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh alat. Silakan ubah kategori alat-alat tersebut terlebih dahulu.');
        }

        try {
            $category->delete();
            return redirect()->route('admin.alsintan-categories.index')
                ->with('success', 'Kategori berhasil dihapus.');
        } catch (QueryException $e) {
            // Tangkap exception restrict delete dari database
            if ($e->getCode() == "23000") {
                return redirect()->route('admin.alsintan-categories.index')
                    ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh data lain di dalam sistem.');
            }
            throw $e;
        }
    }
}
