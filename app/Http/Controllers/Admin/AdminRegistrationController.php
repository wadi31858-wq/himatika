<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class AdminRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('nim', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $registrations = $query->latest()->paginate(10)->withQueryString();
        return view('admin.pendaftaran.index', compact('registrations'));
    }

    public function show(Registration $pendaftaran)
    {
        return view('admin.pendaftaran.show', ['registration' => $pendaftaran]);
    }

    public function update(Request $request, Registration $pendaftaran)
    {
        $validated = $request->validate([
            'status' => 'required|in:Menunggu,Diterima,Ditolak',
            'admin_notes' => 'nullable|string',
        ]);

        $pendaftaran->update($validated);

        return redirect()->route('admin.pendaftaran.show', $pendaftaran)->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    public function destroy(Registration $pendaftaran)
    {
        $pendaftaran->delete();
        return redirect()->route('admin.pendaftaran.index')->with('success', 'Data pendaftaran berhasil dihapus.');
    }
}
