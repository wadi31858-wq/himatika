<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminNewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('author', 'like', "%{$s}%")
                  ->orWhere('category', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $news = $query->latest('published_at')->latest('id')->paginate(10)->withQueryString();
        
        $counts = [
            'total' => News::count(),
            'published' => News::where('status', 'published')->count(),
            'draft' => News::where('status', 'draft')->count(),
        ];

        return view('admin.berita.index', compact('news', 'counts'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'author' => 'nullable|string|max:100',
            'status' => 'required|in:published,draft,archived',
            'published_at' => 'nullable|date',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'image_alt' => 'nullable|string|max:150',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $originalSlug = $validated['slug'];
        $count = 1;
        while (News::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        if (empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = 'news_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/news');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $validated['thumbnail'] = 'news/' . $filename;
        }

        $item = News::create($validated);

        ActivityLog::record(
            'create',
            'Menerbitkan berita/artikel baru: "' . $item->title . '" [' . strtoupper($item->status) . ']',
            $item
        );

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil disimpan.');
    }

    public function edit(News $berita)
    {
        return view('admin.berita.edit', ['news' => $berita]);
    }

    public function update(Request $request, News $berita)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'author' => 'nullable|string|max:100',
            'status' => 'required|in:published,draft,archived',
            'published_at' => 'nullable|date',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'image_alt' => 'nullable|string|max:150',
        ]);

        if ($berita->title !== $validated['title']) {
            $newSlug = Str::slug($validated['title']);
            $originalSlug = $newSlug;
            $count = 1;
            while (News::where('slug', $newSlug)->where('id', '!=', $berita->id)->exists()) {
                $newSlug = $originalSlug . '-' . $count++;
            }
            $validated['slug'] = $newSlug;
        }

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = 'news_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/news');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            if ($berita->thumbnail && file_exists(storage_path('app/public/' . $berita->thumbnail))) {
                @unlink(storage_path('app/public/' . $berita->thumbnail));
            }
            $file->move($destination, $filename);
            $validated['thumbnail'] = 'news/' . $filename;
        }

        $berita->update($validated);

        ActivityLog::record(
            'update',
            'Memperbarui berita: "' . $berita->title . '" [' . strtoupper($berita->status) . ']',
            $berita
        );

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $berita)
    {
        $title = $berita->title;

        if ($berita->thumbnail && file_exists(storage_path('app/public/' . $berita->thumbnail))) {
            @unlink(storage_path('app/public/' . $berita->thumbnail));
        }

        $berita->delete();

        ActivityLog::record(
            'delete',
            'Menghapus berita: "' . $title . '"',
            null
        );

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
