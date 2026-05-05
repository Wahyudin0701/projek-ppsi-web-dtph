<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::orderByRaw("open_date ASC")->get();
        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:bantuan_permanen,pinjam_alat,usulan_pendanaan',
            'jenis'       => 'required|in:alsintan,benih,pupuk,infrastruktur,pelatihan',
            'open_date'   => 'required|date',
            'close_date'  => 'required|date|after_or_equal:open_date',
            'description' => 'nullable|string',
            'sop_description' => 'nullable|string',
            'sasaran'     => 'nullable|string|max:255',
            'kuota'       => 'nullable|string|max:255',
            'requirements' => 'nullable|array',
            'requirements.*' => 'nullable|string|max:255',
        ]);

        Program::create($request->only([
            'name', 'type', 'jenis', 'open_date', 'close_date', 'description', 'sop_description', 'sasaran', 'kuota', 'requirements',
        ]));

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dibuat.');
    }

    public function edit(Program $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:bantuan_permanen,pinjam_alat,usulan_pendanaan',
            'jenis'       => 'required|in:alsintan,benih,pupuk,infrastruktur,pelatihan',
            'open_date'   => 'required|date',
            'close_date'  => 'required|date|after_or_equal:open_date',
            'description' => 'nullable|string',
            'sop_description' => 'nullable|string',
            'sasaran'     => 'nullable|string|max:255',
            'kuota'       => 'nullable|string|max:255',
            'requirements' => 'nullable|array',
            'requirements.*' => 'nullable|string|max:255',
        ]);

        $program->update($request->only([
            'name', 'type', 'jenis', 'open_date', 'close_date', 'description', 'sop_description', 'sasaran', 'kuota', 'requirements',
        ]));

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil diperbarui.');
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dihapus.');
    }
}
