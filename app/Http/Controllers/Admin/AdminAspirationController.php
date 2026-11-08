<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AdminAspirationController extends Controller
{
    public function index(Request $request)
    {
        $query = Aspiration::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('title', 'like', "%{$s}%")
                  ->orWhere('nim', 'like', "%{$s}%")
                  ->orWhere('content', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $aspirations = $query->latest()->paginate(10)->withQueryString();

        $counts = [
            'total' => Aspiration::count(),
            'baru' => Aspiration::where('status', 'Baru')->count(),
            'diproses' => Aspiration::where('status', 'Diproses')->count(),
            'selesai' => Aspiration::where('status', 'Selesai')->count(),
        ];

        return view('admin.aspirasi.index', compact('aspirations', 'counts'));
    }

    public function show(Aspiration $aspirasi)
    {
        return view('admin.aspirasi.show', compact('aspirasi'));
    }

    public function update(Request $request, Aspiration $aspirasi)
    {
        $validated = $request->validate([
            'status' => 'required|in:Baru,Diproses,Selesai',
            'admin_reply' => 'nullable|string|max:2000',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $oldStatus = $aspirasi->status;
        $aspirasi->update($validated);

        ActivityLog::record(
            'update',
            "Memperbarui status aspirasi #{$aspirasi->id} dari '{$oldStatus}' ke '{$aspirasi->status}'",
            $aspirasi
        );

        return redirect()->route('admin.aspirasi.show', $aspirasi)->with('success', 'Status dan tanggapan aspirasi berhasil diperbarui.');
    }

    public function destroy(Aspiration $aspirasi)
    {
        $title = $aspirasi->title;
        $id = $aspirasi->id;
        $aspirasi->delete();

        ActivityLog::record(
            'delete',
            "Menghapus aspirasi #{$id}: \"{$title}\"",
            null
        );

        return redirect()->route('admin.aspirasi.index')->with('success', 'Aspirasi berhasil dihapus.');
    }
}
