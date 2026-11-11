<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminDownloadController extends Controller
{
    public function index(Request $request)
    {
        $query = Download::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('author_name', 'like', "%{$s}%")
                  ->orWhere('category', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%");
            });
        }

        if ($request->filled('type')) {
            if ($request->type === 'website') {
                $query->whereNotNull('website_url')->where('website_url', '!=', '');
            } elseif ($request->type === 'file') {
                $query->whereNotNull('file')->where('file', '!=', '');
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $downloads = $query->orderBy('order_num')->latest()->paginate(12)->withQueryString();

        $counts = [
            'total' => Download::count(),
            'websites' => Download::whereNotNull('website_url')->where('website_url', '!=', '')->count(),
            'files' => Download::whereNotNull('file')->where('file', '!=', '')->count(),
        ];

        return view('admin.download.index', compact('downloads', 'counts'));
    }

    public function create()
    {
        return view('admin.download.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'author_name' => 'nullable|string|max:150',
            'year' => 'nullable|string|max:10',
            'order_num' => 'nullable|integer|min:0',
            'website_url' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:published,draft',
            'file' => 'nullable|file|max:20480', // 20 MB max
            'preview_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if (empty($validated['website_url']) && !$request->hasFile('file')) {
            return back()->withInput()->withErrors(['file' => 'Wajib mengunggah berkas ATAU memasukkan tautan website.']);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $sizeInBytes = $file->getSize();
            $formattedSize = $this->formatFileSize($sizeInBytes);
            $ext = strtolower($file->getClientOriginalExtension());

            $filename = 'doc_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/downloads');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            $file->move($destination, $filename);

            $validated['file'] = 'downloads/' . $filename;
            $validated['file_size'] = $formattedSize;
            $validated['file_type'] = $ext;
        }

        if ($request->hasFile('preview_image')) {
            $prevFile = $request->file('preview_image');
            $prevFilename = 'prev_' . time() . '_' . $prevFile->hashName();
            $prevDest = storage_path('app/public/downloads/previews');
            if (!File::isDirectory($prevDest)) {
                File::makeDirectory($prevDest, 0755, true);
            }
            $prevFile->move($prevDest, $prevFilename);
            $validated['preview_image'] = 'downloads/previews/' . $prevFilename;
        }

        $validated['order_num'] = $validated['order_num'] ?? 0;
        $download = Download::create($validated);

        $typeLabel = $download->website_url ? 'Website Mahasiswa' : 'Dokumen';
        ActivityLog::record(
            'create',
            "Menambahkan {$typeLabel}: \"{$download->title}\" [{$download->status}]",
            $download
        );

        return redirect()->route('admin.download.index')->with('success', "{$typeLabel} berhasil ditambahkan.");
    }

    public function edit(Download $download)
    {
        return view('admin.download.edit', compact('download'));
    }

    public function update(Request $request, Download $download)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'author_name' => 'nullable|string|max:150',
            'year' => 'nullable|string|max:10',
            'order_num' => 'nullable|integer|min:0',
            'website_url' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:published,draft',
            'file' => 'nullable|file|max:20480',
            'preview_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if (empty($validated['website_url']) && empty($download->file) && !$request->hasFile('file')) {
            return back()->withInput()->withErrors(['file' => 'Wajib mengunggah berkas ATAU memasukkan tautan website.']);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $sizeInBytes = $file->getSize();
            $formattedSize = $this->formatFileSize($sizeInBytes);
            $ext = strtolower($file->getClientOriginalExtension());

            $filename = 'doc_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/downloads');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            if ($download->file && file_exists(storage_path('app/public/' . $download->file))) {
                @unlink(storage_path('app/public/' . $download->file));
            }
            $file->move($destination, $filename);

            $validated['file'] = 'downloads/' . $filename;
            $validated['file_size'] = $formattedSize;
            $validated['file_type'] = $ext;
        }

        if ($request->hasFile('preview_image')) {
            $prevFile = $request->file('preview_image');
            $prevFilename = 'prev_' . time() . '_' . $prevFile->hashName();
            $prevDest = storage_path('app/public/downloads/previews');
            if (!File::isDirectory($prevDest)) {
                File::makeDirectory($prevDest, 0755, true);
            }
            if ($download->preview_image && file_exists(storage_path('app/public/' . $download->preview_image))) {
                @unlink(storage_path('app/public/' . $download->preview_image));
            }
            $prevFile->move($prevDest, $prevFilename);
            $validated['preview_image'] = 'downloads/previews/' . $prevFilename;
        }

        $download->update($validated);

        ActivityLog::record(
            'update',
            "Memperbarui berkas/website: \"{$download->title}\"",
            $download
        );

        return redirect()->route('admin.download.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Download $download)
    {
        $title = $download->title;

        if ($download->file && file_exists(storage_path('app/public/' . $download->file))) {
            @unlink(storage_path('app/public/' . $download->file));
        }
        if ($download->preview_image && file_exists(storage_path('app/public/' . $download->preview_image))) {
            @unlink(storage_path('app/public/' . $download->preview_image));
        }

        $download->delete();

        ActivityLog::record(
            'delete',
            "Menghapus berkas/website: \"{$title}\"",
            null
        );

        return redirect()->route('admin.download.index')->with('success', 'Data berhasil dihapus.');
    }

    private function formatFileSize($bytes)
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return round($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }
}
