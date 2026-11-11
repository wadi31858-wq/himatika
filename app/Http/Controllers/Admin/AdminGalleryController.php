<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use App\Models\SiteSetting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminGalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::withCount('photos');

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
            'description' => 'nullable|string|max:1000',
            'alt_text' => 'nullable|string|max:150',
            'status' => 'required|in:published,draft',
            'order_num' => 'nullable|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'photos' => 'nullable|array|max:30',
            'photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'photos.max' => 'Maksimal dapat mengunggah 30 foto sekaligus dalam satu album.',
            'photos.*.image' => 'Setiap berkas harus berupa gambar yang valid (JPG, PNG, WebP).',
            'photos.*.max' => 'Ukuran maksimal tiap foto adalah 5 MB.',
        ]);

        $destination = storage_path('app/public/gallery');
        if (!File::isDirectory($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = 'cover_' . time() . '_' . $file->hashName();
            $file->move($destination, $filename);
            $coverPath = 'gallery/' . $filename;
        }

        $gallery = Gallery::create([
            'title' => $validated['title'],
            'category' => $validated['category'] ?? null,
            'description' => $validated['description'] ?? null,
            'alt_text' => $validated['alt_text'] ?? null,
            'status' => $validated['status'],
            'order_num' => $validated['order_num'] ?? 0,
            'image' => $coverPath ?? '',
        ]);

        // Process batch photos
        $savedPhotosCount = 0;
        $firstSavedPhoto = null;

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $idx => $photoFile) {
                if ($photoFile->isValid()) {
                    $pFilename = 'photo_' . time() . '_' . $idx . '_' . $photoFile->hashName();
                    $photoFile->move($destination, $pFilename);
                    $path = 'gallery/' . $pFilename;

                    GalleryPhoto::create([
                        'gallery_id' => $gallery->id,
                        'image' => $path,
                        'alt_text' => $gallery->title . ' - Foto ' . ($idx + 1),
                        'order_num' => $idx + 1,
                    ]);

                    if (!$firstSavedPhoto) {
                        $firstSavedPhoto = $path;
                    }
                    $savedPhotosCount++;
                }
            }
        }

        // If no explicit cover was uploaded, use the first saved photo
        if (empty($gallery->image) && $firstSavedPhoto) {
            $gallery->update(['image' => $firstSavedPhoto]);
        }

        ActivityLog::record(
            'create',
            "Membuat album galeri \"{$gallery->title}\" dengan {$savedPhotosCount} foto",
            $gallery
        );

        return redirect()->route('admin.galeri.index')->with('success', "Album galeri berhasil dibuat dengan {$savedPhotosCount} foto tersimpan.");
    }

    public function edit(Gallery $galeri)
    {
        $galeri->load('photos');
        return view('admin.galeri.edit', ['gallery' => $galeri]);
    }

    public function update(Request $request, Gallery $galeri)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'alt_text' => 'nullable|string|max:150',
            'status' => 'required|in:published,draft',
            'order_num' => 'nullable|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'photos' => 'nullable|array|max:30',
            'photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $destination = storage_path('app/public/gallery');
        if (!File::isDirectory($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = 'cover_' . time() . '_' . $file->hashName();
            if ($galeri->image && file_exists(storage_path('app/public/' . $galeri->image))) {
                @unlink(storage_path('app/public/' . $galeri->image));
            }
            $file->move($destination, $filename);
            $validated['image'] = 'gallery/' . $filename;
        }

        $galeri->update($validated);

        // Append new photos if uploaded
        $newPhotosCount = 0;
        if ($request->hasFile('photos')) {
            $currentMaxOrder = $galeri->photos()->max('order_num') ?? 0;
            foreach ($request->file('photos') as $idx => $photoFile) {
                if ($photoFile->isValid()) {
                    $pFilename = 'photo_' . time() . '_' . $idx . '_' . $photoFile->hashName();
                    $photoFile->move($destination, $pFilename);
                    $path = 'gallery/' . $pFilename;

                    GalleryPhoto::create([
                        'gallery_id' => $galeri->id,
                        'image' => $path,
                        'alt_text' => $galeri->title . ' - Foto ' . ($currentMaxOrder + $idx + 1),
                        'order_num' => $currentMaxOrder + $idx + 1,
                    ]);
                    $newPhotosCount++;
                }
            }
        }

        // If album still has no cover, pick first photo
        if (empty($galeri->image)) {
            $firstP = $galeri->photos()->first();
            if ($firstP) {
                $galeri->update(['image' => $firstP->image]);
            }
        }

        ActivityLog::record(
            'update',
            "Memperbarui album galeri \"{$galeri->title}\"" . ($newPhotosCount > 0 ? " (+{$newPhotosCount} foto)" : ""),
            $galeri
        );

        return redirect()->route('admin.galeri.edit', $galeri)->with('success', 'Album galeri berhasil diperbarui' . ($newPhotosCount > 0 ? " dengan penambahan {$newPhotosCount} foto baru." : "."));
    }

    public function destroy(Gallery $galeri)
    {
        $title = $galeri->title;
        $photosCount = $galeri->photos()->count();

        // Delete photo files
        foreach ($galeri->photos as $p) {
            if ($p->image && file_exists(storage_path('app/public/' . $p->image))) {
                @unlink(storage_path('app/public/' . $p->image));
            }
        }
        if ($galeri->image && file_exists(storage_path('app/public/' . $galeri->image))) {
            @unlink(storage_path('app/public/' . $galeri->image));
        }

        $galeri->delete();

        ActivityLog::record(
            'delete',
            "Menghapus album galeri \"{$title}\" beserta {$photosCount} foto di dalamnya",
            null
        );

        return redirect()->route('admin.galeri.index')->with('success', "Album \"{$title}\" berhasil dihapus.");
    }

    public function destroyPhoto(GalleryPhoto $photo)
    {
        $gallery = $photo->gallery;
        if ($photo->image && file_exists(storage_path('app/public/' . $photo->image))) {
            @unlink(storage_path('app/public/' . $photo->image));
        }
        $photo->delete();

        // If deleted photo was album cover, update to next photo
        if ($gallery->image === $photo->image) {
            $next = $gallery->photos()->first();
            $gallery->update(['image' => $next ? $next->image : '']);
        }

        return back()->with('success', 'Foto berhasil dihapus dari album.');
    }

    public function setCover(GalleryPhoto $photo)
    {
        $gallery = $photo->gallery;
        $gallery->update(['image' => $photo->image]);
        return back()->with('success', 'Foto berhasil ditetapkan sebagai sampul album.');
    }

    public function settings()
    {
        $pageTitle = SiteSetting::get('gallery_page_title', 'Momen HIMATIKA UNUJA');
        $pageDesc = SiteSetting::get('gallery_page_desc', 'Dokumentasi kegiatan yang memperlihatkan semangat, kolaborasi, dan capaian HIMATIKA');
        $pageBadge = SiteSetting::get('gallery_page_badge', 'GALERI');

        return view('admin.galeri.pengaturan', compact('pageTitle', 'pageDesc', 'pageBadge'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'gallery_page_title' => 'required|string|max:255',
            'gallery_page_desc' => 'nullable|string|max:1000',
            'gallery_page_badge' => 'nullable|string|max:100',
        ]);

        foreach ($validated as $k => $v) {
            SiteSetting::set($k, $v, 'galeri');
        }

        ActivityLog::record('update', 'Memperbarui pengaturan halaman Galeri Foto', null);

        return back()->with('success', 'Pengaturan halaman Galeri berhasil disimpan.');
    }

    public function allPhotos(Request $request)
    {
        $photos = GalleryPhoto::with('gallery')->latest()->paginate(24);
        return view('admin.galeri.media', compact('photos'));
    }
}
