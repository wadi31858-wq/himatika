<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationalStructure;
use Illuminate\Http\Request;

class AdminOrganizationController extends Controller
{
    public function index()
    {
        $structures = OrganizationalStructure::with('parent')->latest()->paginate(15);
        return view('admin.struktur.index', compact('structures'));
    }

    public function create()
    {
        $parents = OrganizationalStructure::whereNull('parent_id')->get();
        return view('admin.struktur.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'division' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:organizational_structures,id',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            if (!$file->isValid()) {
                return redirect()->back()->withErrors(['photo' => 'Upload gagal: ' . $file->getErrorMessage()]);
            }
            $filename = $file->hashName();
            $destinationPath = storage_path('app/public/structures');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['photo'] = 'structures/' . $filename;
        }

        OrganizationalStructure::create($validated);
        return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(OrganizationalStructure $struktur)
    {
        $parents = OrganizationalStructure::whereNull('parent_id')->where('id', '!=', $struktur->id)->get();
        return view('admin.struktur.edit', compact('struktur', 'parents'));
    }

    public function update(Request $request, OrganizationalStructure $struktur)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'division' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:organizational_structures,id',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            if (!$file->isValid()) {
                return redirect()->back()->withErrors(['photo' => 'Upload gagal: ' . $file->getErrorMessage()]);
            }
            $filename = $file->hashName();
            $destinationPath = storage_path('app/public/structures');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['photo'] = 'structures/' . $filename;
        }

        $struktur->update($validated);
        return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(OrganizationalStructure $struktur)
    {
        $struktur->delete();
        return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Data berhasil dihapus.');
    }
}
