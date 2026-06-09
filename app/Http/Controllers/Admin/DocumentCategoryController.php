<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class DocumentCategoryController extends Controller
{
    public function index()
    {
        $categories = DocumentCategory::withCount('documents')->latest()->get();
        return view('admin.document_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.document_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:document_categories',
            'description' => 'nullable|string'
        ]);

        DocumentCategory::create($request->all());

        return redirect()->route('admin.document-categories.index')
            ->with('success', 'Kategori Dokumen berhasil ditambahkan.');
    }

    public function edit(DocumentCategory $documentCategory)
    {
        return view('admin.document_categories.edit', compact('documentCategory'));
    }

    public function update(Request $request, DocumentCategory $documentCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:document_categories,name,' . $documentCategory->id,
            'description' => 'nullable|string'
        ]);

        $documentCategory->update($request->all());

        return redirect()->route('admin.document-categories.index')
            ->with('success', 'Kategori Dokumen berhasil diperbarui.');
    }

    public function destroy(DocumentCategory $documentCategory)
    {
        if ($documentCategory->documents()->exists()) {
            return redirect()->route('admin.document-categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh dokumen. Silakan ubah kategori dokumen-dokumen tersebut terlebih dahulu.');
        }

        try {
            $documentCategory->delete();
            return redirect()->route('admin.document-categories.index')
                ->with('success', 'Kategori berhasil dihapus.');
        } catch (QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->route('admin.document-categories.index')
                    ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan.');
            }
            throw $e;
        }
    }
}
