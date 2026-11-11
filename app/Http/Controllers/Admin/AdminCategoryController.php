<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'informasi');
        $categories = Category::where('type', $type)->orderBy('order_num')->get();

        // Calculate count of news per category
        $counts = [];
        foreach ($categories as $cat) {
            $counts[$cat->id] = News::where('category', $cat->name)->count();
        }

        return view('admin.informasi.kategori', compact('categories', 'type', 'counts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:informasi,download',
            'order_num' => 'nullable|integer',
        ]);

        $slug = Str::slug($validated['name']);
        $count = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = Str::slug($validated['name']) . '-' . $count++;
        }
        $validated['slug'] = $slug;
        $validated['order_num'] = $validated['order_num'] ?? Category::where('type', $validated['type'])->count() + 1;

        $category = Category::create($validated);

        ActivityLog::record('create', "Menambahkan kategori {$validated['type']}: \"{$category->name}\"", $category);

        return back()->with('success', "Kategori \"{$category->name}\" berhasil ditambahkan.");
    }

    public function update(Request $request, Category $kategori)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'order_num' => 'nullable|integer',
        ]);

        $oldName = $kategori->name;
        $kategori->update($validated);

        // If category name changed, update existing news using old category name
        if ($oldName !== $kategori->name) {
            News::where('category', $oldName)->update(['category' => $kategori->name]);
        }

        ActivityLog::record('update', "Memperbarui kategori: \"{$oldName}\" menjadi \"{$kategori->name}\"", $kategori);

        return back()->with('success', "Kategori \"{$kategori->name}\" berhasil diperbarui.");
    }

    public function destroy(Request $request, Category $kategori)
    {
        // Check if category is used in News
        $usedCount = News::where('category', $kategori->name)->count();

        if ($usedCount > 0) {
            $replacementName = $request->input('replacement_category');
            if (empty($replacementName)) {
                return back()->with('error', "Kategori \"{$kategori->name}\" masih digunakan oleh {$usedCount} konten informasi. Silakan pilih kategori pengganti sebelum menghapus.");
            }

            // Transfer contents to replacement
            News::where('category', $kategori->name)->update(['category' => $replacementName]);
        }

        $name = $kategori->name;
        $kategori->delete();

        ActivityLog::record('delete', "Menghapus kategori: \"{$name}\"" . ($usedCount > 0 ? " (dipindahkan {$usedCount} konten)" : ""), null);

        return back()->with('success', "Kategori \"{$name}\" berhasil dihapus.");
    }
}

