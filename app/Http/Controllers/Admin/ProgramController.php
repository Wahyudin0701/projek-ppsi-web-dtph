<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::latest()->get();
        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:bantuan_permanen,pinjam_alat,usulan_pendanaan',
            'open_date' => 'nullable|date',
            'close_date' => 'nullable|date|after_or_equal:open_date',
        ]);

        Program::create($request->all());

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dibuat.');
    }

    public function edit(Program $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:bantuan_permanen,pinjam_alat,usulan_pendanaan',
            'open_date' => 'nullable|date',
            'close_date' => 'nullable|date|after_or_equal:open_date',
        ]);

        $program->update($request->all());

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil diperbarui.');
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dihapus.');
    }

    public function toggleStatus(Program $program)
    {
        $program->update(['is_open' => !$program->is_open]);
        return back()->with('success', 'Status program berhasil diubah.');
    }
}
