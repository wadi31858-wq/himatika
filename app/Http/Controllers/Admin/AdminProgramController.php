<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class AdminProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = Program::query();
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }
        $programs = $query->latest('date')->paginate(10)->withQueryString();
        return view('admin.program.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.program.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'division' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'status' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (!$file->isValid()) {
                return redirect()->back()->withErrors(['image' => 'Upload gagal: ' . $file->getErrorMessage()]);
            }
            $filename = $file->hashName();
            $destinationPath = storage_path('app/public/programs');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['image'] = 'programs/' . $filename;
        }

        Program::create($validated);
        return redirect()->route('admin.program.index')->with('success', 'Program kerja berhasil ditambahkan.');
    }

    public function edit(Program $program)
    {
        return view('admin.program.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'division' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'status' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (!$file->isValid()) {
                return redirect()->back()->withErrors(['image' => 'Upload gagal: ' . $file->getErrorMessage()]);
            }
            $filename = $file->hashName();
            $destinationPath = storage_path('app/public/programs');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['image'] = 'programs/' . $filename;
        }

        $program->update($validated);
        return redirect()->route('admin.program.index')->with('success', 'Program kerja berhasil diperbarui.');
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('admin.program.index')->with('success', 'Program kerja berhasil dihapus.');
    }
}
