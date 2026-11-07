<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;

class AdminAchievementController extends Controller
{
    public function index(Request $request)
    {
        $query = Achievement::query();
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")->orWhere('participant', 'like', "%{$s}%");
            });
        }
        $achievements = $query->latest('year')->paginate(10)->withQueryString();
        return view('admin.prestasi.index', compact('achievements'));
    }

    public function create()
    {
        return view('admin.prestasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'participant' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'year' => 'nullable|digits:4|integer|min:2000|max:2100',
            'rank' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (!$file->isValid()) {
                return redirect()->back()->withErrors(['image' => 'Upload gagal: ' . $file->getErrorMessage()]);
            }
            $filename = $file->hashName();
            $destinationPath = storage_path('app/public/achievements');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['image'] = 'achievements/' . $filename;
        }

        Achievement::create($validated);
        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function edit(Achievement $prestasi)
    {
        return view('admin.prestasi.edit', ['achievement' => $prestasi]);
    }

    public function update(Request $request, Achievement $prestasi)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'participant' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'year' => 'nullable|digits:4|integer|min:2000|max:2100',
            'rank' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (!$file->isValid()) {
                return redirect()->back()->withErrors(['image' => 'Upload gagal: ' . $file->getErrorMessage()]);
            }
            $filename = $file->hashName();
            $destinationPath = storage_path('app/public/achievements');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['image'] = 'achievements/' . $filename;
        }

        $prestasi->update($validated);
        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(Achievement $prestasi)
    {
        $prestasi->delete();
        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil dihapus.');
    }
}
