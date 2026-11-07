<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminNewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::query();
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }
        $news = $query->latest('published_at')->paginate(10)->withQueryString();
        return view('admin.berita.index', compact('news'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'content' => 'required|string',
            'author' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            if (!$file->isValid()) {
                return redirect()->back()->withErrors(['thumbnail' => 'Upload gagal: ' . $file->getErrorMessage()]);
            }
            $filename = $file->hashName();
            $destinationPath = storage_path('app/public/news');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['thumbnail'] = 'news/' . $filename;
        }

        News::create($validated);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $berita)
    {
        return view('admin.berita.edit', ['news' => $berita]);
    }

    public function update(Request $request, News $berita)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'content' => 'required|string',
            'author' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            if (!$file->isValid()) {
                return redirect()->back()->withErrors(['thumbnail' => 'Upload gagal: ' . $file->getErrorMessage()]);
            }
            $filename = $file->hashName();
            $destinationPath = storage_path('app/public/news');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['thumbnail'] = 'news/' . $filename;
        }

        $berita->update($validated);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $berita)
    {
        $berita->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
