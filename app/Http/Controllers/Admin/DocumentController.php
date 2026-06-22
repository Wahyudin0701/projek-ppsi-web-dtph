<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('category')->latest()->paginate(10);
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        $categories = DocumentCategory::orderBy('name')->get();
        return view('admin.documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_category_id' => 'required|exists:document_categories,id',
            'file' => 'required|file|extensions:pdf,doc,docx,xls,xlsx,zip,rar|max:20480', // max 20MB
            'is_public' => 'boolean',
        ]);

        $file = $request->file('file');
        
        // Simpan file
        $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('dokumen', $fileName, 'public');

        // Hitung ukuran
        $bytes = $file->getSize();
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        $fileSize = round($bytes, 1) . ' ' . $units[$pow];

        // Format
        $fileFormat = strtoupper($file->getClientOriginalExtension());

        Document::create([
            'title' => $request->title,
            'description' => $request->description,
            'document_category_id' => $request->document_category_id,
            'file_path' => $path,
            'file_size' => $fileSize,
            'file_format' => $fileFormat,
            'is_public' => $request->has('is_public'),
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function edit(Document $document)
    {
        $categories = DocumentCategory::orderBy('name')->get();
        return view('admin.documents.edit', compact('document', 'categories'));
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_category_id' => 'required|exists:document_categories,id',
            'file' => 'nullable|file|extensions:pdf,doc,docx,xls,xlsx,zip,rar|max:20480',
            'is_public' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'document_category_id' => $request->document_category_id,
            'is_public' => $request->has('is_public'),
        ];

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('dokumen', $fileName, 'public');

            $bytes = $file->getSize();
            $units = ['B', 'KB', 'MB', 'GB', 'TB'];
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
            $pow = min($pow, count($units) - 1);
            $size = round($bytes / (1 << (10 * $pow)), 1) . ' ' . $units[$pow];

            $data['file_path'] = $path;
            $data['file_size'] = $size;
            $data['file_format'] = strtoupper($file->getClientOriginalExtension());
        }

        $document->update($data);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document)
    {
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        $document->delete();

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
