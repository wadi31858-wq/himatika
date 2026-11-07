<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;

class AdminDownloadController extends Controller
{
    public function index(Request $request)
    {
        $query = Download::query();
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }
        $downloads = $query->latest()->paginate(10)->withQueryString();
        return view('admin.download.index', compact('downloads'));
    }

    public function create()
    {
        return view('admin.download.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240',
        ]);

        $file = $request->file('file');
        if (!$file->isValid()) {
            return redirect()->back()->withErrors(['file' => 'Upload gagal: ' . $file->getErrorMessage()]);
        }
        $filename = $file->hashName();
        $destinationPath = storage_path('app/public/downloads');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $file->move($destinationPath, $filename);
        $validated['file'] = 'downloads/' . $filename;

        Download::create($validated);
        return redirect()->route('admin.download.index')->with('success', 'Download berhasil ditambahkan.');
    }

    public function edit(Download $download)
    {
        return view('admin.download.edit', compact('download'));
    }

    public function update(Request $request, Download $download)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if (!$file->isValid()) {
                return redirect()->back()->withErrors(['file' => 'Upload gagal: ' . $file->getErrorMessage()]);
            }
            $filename = $file->hashName();
            $destinationPath = storage_path('app/public/downloads');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['file'] = 'downloads/' . $filename;
        }

        $download->update($validated);
        return redirect()->route('admin.download.index')->with('success', 'Download berhasil diperbarui.');
    }

    public function destroy(Download $download)
    {
        $download->delete();
        return redirect()->route('admin.download.index')->with('success', 'Download berhasil dihapus.');
    }
}
