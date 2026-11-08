<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminGalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('category', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $galleries = $query->orderBy('order_num')->latest()->paginate(12)->withQueryString();

        return view('admin.galeri.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'alt_text' => 'nullable|string|max:150',
            'status' => 'required|in:published,draft',
            'order_num' => 'nullable|integer|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'gallery_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/gallery');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $validated['image'] = 'gallery/' . $filename;
        }

        if (empty($validated['order_num'])) {
            $validated['order_num'] = 0;
        }

        $gallery = Gallery::create($validated);

        ActivityLog::record(
            'create',
            "Mengunggah foto galeri: \"{$gallery->title}\" [{$gallery->status}]",
            $gallery
        );

        return redirect()->route('admin.galeri.index')->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $galeri)
    {
        return view('admin.galeri.edit', ['gallery' => $galeri]);
    }

    public function update(Request $request, Gallery $galeri)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'alt_text' => 'nullable|string|max:150',
            'status' => 'required|in:published,draft',
            'order_num' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'gallery_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/gallery');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            if ($galeri->image && file_exists(storage_path('app/public/' . $galeri->image))) {
                @unlink(storage_path('app/public/' . $galeri->image));
            }
            $file->move($destination, $filename);
            $validated['image'] = 'gallery/' . $filename;
        }

        $galeri->update($validated);

        ActivityLog::record(
            'update',
            "Memperbarui foto galeri: \"{$galeri->title}\"",
            $galeri
        );

        return redirect()->route('admin.galeri.index')->with('success', 'Foto galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $galeri)
    {
        $title = $galeri->title;

        if ($galeri->image && file_exists(storage_path('app/public/' . $galeri->image))) {
            @unlink(storage_path('app/public/' . $galeri->image));
        }

        $galeri->delete();

        ActivityLog::record(
            'delete',
            "Menghapus foto galeri: \"{$title}\"",
            null
        );

        return redirect()->route('admin.galeri.index')->with('success', 'Foto galeri berhasil dihapus.');
    }
}
