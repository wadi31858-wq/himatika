<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Activity;
use Illuminate\Http\Request;

class AdminGalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::with('activity');
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }
        $galleries = $query->latest()->paginate(12)->withQueryString();
        return view('admin.galeri.index', compact('galleries'));
    }

    public function create()
    {
        $activities = Activity::latest('date')->get();
        return view('admin.galeri.create', compact('activities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'description' => 'nullable|string',
            'activity_id' => 'nullable|exists:activities,id',
        ]);

        $file = $request->file('image');
        if (!$file->isValid()) {
            return redirect()->back()->withErrors(['image' => 'Upload gagal: ' . $file->getErrorMessage()]);
        }
        $filename = $file->hashName();
        $destinationPath = storage_path('app/public/galleries');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $file->move($destinationPath, $filename);
        $validated['image'] = 'galleries/' . $filename;

        Gallery::create($validated);
        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $galeri)
    {
        $activities = Activity::latest('date')->get();
        return view('admin.galeri.edit', ['gallery' => $galeri, 'activities' => $activities]);
    }

    public function update(Request $request, Gallery $galeri)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'description' => 'nullable|string',
            'activity_id' => 'nullable|exists:activities,id',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (!$file->isValid()) {
                return redirect()->back()->withErrors(['image' => 'Upload gagal: ' . $file->getErrorMessage()]);
            }
            $filename = $file->hashName();
            $destinationPath = storage_path('app/public/galleries');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['image'] = 'galleries/' . $filename;
        }

        $galeri->update($validated);
        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $galeri)
    {
        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil dihapus.');
    }
}
