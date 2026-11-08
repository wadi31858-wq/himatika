<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationalStructure;
use App\Models\Member;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminOrganizationController extends Controller
{
    public function index(Request $request)
    {
        $query = OrganizationalStructure::with('parent');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('position', 'like', "%{$s}%")
                  ->orWhere('division', 'like', "%{$s}%");
            });
        }

        $structures = $query->orderBy('order_num')->latest()->paginate(15)->withQueryString();
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
            'period' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:organizational_structures,id',
            'order_num' => 'nullable|integer|min:0',
            'is_active' => 'required|boolean',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'struct_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/structures');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $validated['photo'] = 'structures/' . $filename;
        }

        $structure = OrganizationalStructure::create($validated);

        ActivityLog::record(
            'create',
            "Menambahkan struktur organisasi: \"{$structure->name}\" - {$structure->position}",
            $structure
        );

        return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Data struktur organisasi berhasil ditambahkan.');
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
            'period' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:organizational_structures,id',
            'order_num' => 'nullable|integer|min:0',
            'is_active' => 'required|boolean',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        // Prevent setting parent to itself
        if (!empty($validated['parent_id']) && $validated['parent_id'] == $struktur->id) {
            return back()->withInput()->withErrors(['parent_id' => 'Struktur tidak dapat menjadi induk bagi dirinya sendiri.']);
        }

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'struct_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/structures');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            if ($struktur->photo && file_exists(storage_path('app/public/' . $struktur->photo))) {
                @unlink(storage_path('app/public/' . $struktur->photo));
            }
            $file->move($destination, $filename);
            $validated['photo'] = 'structures/' . $filename;
        }

        $struktur->update($validated);

        ActivityLog::record(
            'update',
            "Memperbarui struktur organisasi: \"{$struktur->name}\"",
            $struktur
        );

        return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Data struktur organisasi berhasil diperbarui.');
    }

    public function destroy(OrganizationalStructure $struktur)
    {
        // Safe deletion check: has children or members?
        $hasChildren = OrganizationalStructure::where('parent_id', $struktur->id)->exists();
        $hasMembers = false;
        if (!empty($struktur->division)) {
            $hasMembers = Member::where('division', $struktur->division)->exists();
        } elseif (!empty($struktur->position)) {
            $hasMembers = Member::where('position', $struktur->position)->exists();
        }

        if ($hasChildren) {
            return redirect()->route('admin.struktur-organisasi.index')->with('error', 'Gagal menghapus: Struktur ini memiliki sub-divisi di bawahnya. Harap pindahkan atau hapus sub-divisi terlebih dahulu.');
        }

        if ($hasMembers) {
            return redirect()->route('admin.struktur-organisasi.index')->with('error', 'Gagal menghapus: Masih terdapat anggota/pengurus yang terdaftar di bidang/divisi ini.');
        }

        $title = $struktur->name;
        if ($struktur->photo && file_exists(storage_path('app/public/' . $struktur->photo))) {
            @unlink(storage_path('app/public/' . $struktur->photo));
        }

        $struktur->delete();

        ActivityLog::record(
            'delete',
            "Menghapus struktur organisasi: \"{$title}\"",
            null
        );

        return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Struktur organisasi berhasil dihapus.');
    }
}
