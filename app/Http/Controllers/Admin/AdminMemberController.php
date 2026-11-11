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
        $query = Member::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('nim', 'like', "%{$s}%")
                  ->orWhere('position', 'like', "%{$s}%")
                  ->orWhere('division', 'like', "%{$s}%");
            });
        }

        if ($request->filled('division')) {
            $query->where('division', $request->division);
        }

        if ($request->filled('kelompok')) {
            $query->where('kelompok', $request->kelompok);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $members = $query->orderBy('order_num')->latest()->paginate(12)->withQueryString();
        
        $divisions = Member::select('division')->whereNotNull('division')->where('division', '!=', '')->distinct()->pluck('division');

        return view('admin.pengurus.index', compact('members', 'divisions'));
    }

    public function create()
    {
        $structures = OrganizationalStructure::where('is_active', true)->get();
        return view('admin.pengurus.create', compact('structures'));
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

        return redirect()->route('admin.pengurus.index')->with('success', 'Pengurus berhasil ditambahkan.');
    }

    public function edit(Member $penguru)
    {
        $structures = OrganizationalStructure::where('is_active', true)->get();
        return view('admin.pengurus.edit', ['member' => $penguru, 'structures' => $structures]);
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

        return redirect()->route('admin.pengurus.index')->with('success', 'Data pengurus berhasil diperbarui.');
    }

    public function destroy(Member $penguru)
    {
        $name = $penguru->name;

        if ($penguru->photo && file_exists(storage_path('app/public/' . $penguru->photo))) {
            @unlink(storage_path('app/public/' . $penguru->photo));
        }

        $penguru->delete();

        ActivityLog::record(
            'delete',
            "Menghapus pengurus: \"{$name}\"",
            null
        );

        return redirect()->route('admin.pengurus.index')->with('success', 'Pengurus berhasil dihapus.');
    }
}
