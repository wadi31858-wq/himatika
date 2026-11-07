<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::query();
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }
        $activities = $query->latest('date')->paginate(10)->withQueryString();
        return view('admin.kegiatan.index', compact('activities'));
    }

    public function create()
    {
        return view('admin.kegiatan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|string',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (!$file->isValid()) {
                return redirect()->back()->withErrors(['image' => 'Upload gagal: ' . $file->getErrorMessage()]);
            }
            $filename = $file->hashName();
            $destinationPath = storage_path('app/public/activities');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['image'] = 'activities/' . $filename;
        }

        Activity::create($validated);
        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(Activity $kegiatan)
    {
        return view('admin.kegiatan.edit', ['activity' => $kegiatan]);
    }

    public function update(Request $request, Activity $kegiatan)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|string',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (!$file->isValid()) {
                return redirect()->back()->withErrors(['image' => 'Upload gagal: ' . $file->getErrorMessage()]);
            }
            $filename = $file->hashName();
            $destinationPath = storage_path('app/public/activities');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['image'] = 'activities/' . $filename;
        }

        $kegiatan->update($validated);
        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Activity $kegiatan)
    {
        $kegiatan->delete();
        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
