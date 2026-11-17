<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\OrganizationalStructure;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminMemberController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('admin.struktur-organisasi.index');
    }

    public function create(Request $request)
    {
        return redirect()->route('admin.struktur-organisasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:30|unique:members,nim',
            'position' => 'required|string|max:255',
            'division' => 'nullable|string|max:255',
            'kelompok' => 'required|string|in:putra,putri',
            'period' => 'nullable|string|max:50',
            'order_num' => 'nullable|integer|min:0',
            'is_active' => 'required|boolean',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'member_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/members');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $validated['photo'] = 'members/' . $filename;
        }

        if (empty($validated['order_num'])) {
            $validated['order_num'] = 0;
        }

        $member = Member::create($validated);

        ActivityLog::record(
            'create',
            "Menambahkan pengurus: \"{$member->name}\" ({$member->position})",
            $member
        );

        if ($request->filled('return_unit')) {
            return redirect()->route('admin.struktur-organisasi.index', [
                'unit' => $request->return_unit,
                'kelompok' => $validated['kelompok']
            ])->with('success', "Pengurus \"{$member->name}\" ({$member->position}) berhasil ditambahkan ke unit.");
        }

        return redirect()->route('admin.pengurus.index')->with('success', 'Pengurus berhasil ditambahkan.');
    }

    public function edit(Request $request, Member $penguru)
    {
        $structures = OrganizationalStructure::where('is_active', true)->get();
        $returnUnit = $request->query('unit', $request->query('return_unit'));
        return view('admin.pengurus.edit', ['member' => $penguru, 'structures' => $structures, 'returnUnit' => $returnUnit]);
    }

    public function update(Request $request, Member $penguru)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:30|unique:members,nim,' . $penguru->id,
            'position' => 'required|string|max:255',
            'division' => 'nullable|string|max:255',
            'kelompok' => 'required|string|in:putra,putri',
            'period' => 'nullable|string|max:50',
            'order_num' => 'nullable|integer|min:0',
            'is_active' => 'required|boolean',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'member_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/members');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            if ($penguru->photo && file_exists(storage_path('app/public/' . $penguru->photo))) {
                @unlink(storage_path('app/public/' . $penguru->photo));
            }
            $file->move($destination, $filename);
            $validated['photo'] = 'members/' . $filename;
        }

        $penguru->update($validated);

        ActivityLog::record(
            'update',
            "Memperbarui data pengurus: \"{$penguru->name}\"",
            $penguru
        );

        if ($request->filled('return_unit')) {
            return redirect()->route('admin.struktur-organisasi.index', [
                'unit' => $request->return_unit,
                'kelompok' => $validated['kelompok']
            ])->with('success', "Data pengurus \"{$penguru->name}\" berhasil diperbarui.");
        }

        return redirect()->route('admin.pengurus.index')->with('success', 'Data pengurus berhasil diperbarui.');
    }

    public function destroy(Request $request, Member $penguru)
    {
        $name = $penguru->name;
        $kelompok = $penguru->kelompok;
        $returnUnit = $request->input('return_unit', $request->query('return_unit'));

        if ($penguru->photo && file_exists(storage_path('app/public/' . $penguru->photo))) {
            @unlink(storage_path('app/public/' . $penguru->photo));
        }

        $penguru->delete();

        ActivityLog::record(
            'delete',
            "Menghapus pengurus: \"{$name}\"",
            null
        );

        if ($returnUnit) {
            return redirect()->route('admin.struktur-organisasi.index', [
                'unit' => $returnUnit,
                'kelompok' => $kelompok
            ])->with('success', "Pengurus \"{$name}\" berhasil dihapus.");
        }

        return redirect()->route('admin.pengurus.index')->with('success', 'Pengurus berhasil dihapus.');
    }
}
