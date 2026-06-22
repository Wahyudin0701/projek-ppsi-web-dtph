<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::orderBy('open_date', 'asc')->get();
        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        $categories = ProgramCategory::orderBy('name', 'asc')->get();
        return view('admin.programs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'program_category_id' => 'required|exists:program_categories,id',
            'open_date'   => 'required|date',
            'close_date'  => 'required|date|after_or_equal:open_date',
            'description' => 'nullable|string',
            'sop_description' => 'nullable|string',
            'sasaran'     => 'nullable|string|max:255',
            'kuota'       => 'nullable|string|max:255',
            'requirements' => 'nullable|array',
            'requirements.*' => 'nullable|string|max:255',
            'juknis_file' => 'nullable|file|extensions:pdf|max:10240', // max 10MB
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        $data = $request->only([
            'name', 'program_category_id', 'open_date', 'close_date', 'description', 'sop_description', 'sasaran', 'kuota', 'requirements', 'contact_person', 'contact_phone'
        ]);

        if ($request->hasFile('juknis_file')) {
            $file = $request->file('juknis_file');
            $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
            $data['juknis_file'] = $file->storeAs('programs', $filename, 'public');
        }

        Program::create($data);

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dibuat.');
    }

    public function show(Program $program)
    {
        return view('admin.programs.show', compact('program'));
    }

    public function edit(Program $program)
    {
        $categories = ProgramCategory::orderBy('name', 'asc')->get();
        return view('admin.programs.edit', compact('program', 'categories'));
    }

    public function update(Request $request, Program $program)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'program_category_id' => 'required|exists:program_categories,id',
            'open_date'   => 'required|date',
            'close_date'  => 'required|date|after_or_equal:open_date',
            'description' => 'nullable|string',
            'sop_description' => 'nullable|string',
            'sasaran'     => 'nullable|string|max:255',
            'kuota'       => 'nullable|string|max:255',
            'requirements' => 'nullable|array',
            'requirements.*' => 'nullable|string|max:255',
            'juknis_file' => 'nullable|file|extensions:pdf|max:10240',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        $data = $request->only([
            'name', 'program_category_id', 'open_date', 'close_date', 'description', 'sop_description', 'sasaran', 'kuota', 'requirements', 'contact_person', 'contact_phone'
        ]);

        if ($request->hasFile('juknis_file')) {
            if ($program->juknis_file) {
                Storage::disk('public')->delete($program->juknis_file);
            }
            $file = $request->file('juknis_file');
            $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
            $data['juknis_file'] = $file->storeAs('programs', $filename, 'public');
        }

        $program->update($data);

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil diperbarui.');
    }

    public function destroy(Program $program)
    {
        if ($program->juknis_file) {
            Storage::disk('public')->delete($program->juknis_file);
        }
        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dihapus.');
    }
}
