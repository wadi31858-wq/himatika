<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
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
                  ->orWhere('nim', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $aspirations = $query->latest()->paginate(10)->withQueryString();
        return view('admin.aspirasi.index', compact('aspirations'));
    }

    public function show(Aspiration $aspirasi)
    {
        if ($aspirasi->status === 'Baru') {
            $aspirasi->update(['status' => 'Dibaca']);
        }
        return view('admin.aspirasi.show', compact('aspirasi'));
    }

    public function update(Request $request, Aspiration $aspirasi)
    {
        $validated = $request->validate([
            'status' => 'required|in:Baru,Dibaca,Diproses,Selesai',
            'admin_reply' => 'nullable|string',
        ]);

        $aspirasi->update($validated);

        return redirect()->route('admin.aspirasi.show', $aspirasi)->with('success', 'Aspirasi berhasil diperbarui.');
    }

    public function destroy(Aspiration $aspirasi)
    {
        $aspirasi->delete();
        return redirect()->route('admin.aspirasi.index')->with('success', 'Aspirasi berhasil dihapus.');
    }
}
