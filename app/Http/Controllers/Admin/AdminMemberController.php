<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class AdminMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")->orWhere('nim', 'like', "%{$s}%");
            });
        }
        $members = $query->latest()->paginate(10)->withQueryString();
        return view('admin.pengurus.index', compact('members'));
    }

    public function create()
    {
        return view('admin.pengurus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:members,nim',
            'position' => 'required|string|max:255',
            'division' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'period' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            if (!$file->isValid()) {
                return redirect()->back()->withErrors(['photo' => 'Upload gagal: ' . $file->getErrorMessage()]);
            }
            $filename = $file->hashName();
            $destinationPath = storage_path('app/public/members');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['photo'] = 'members/' . $filename;
        }

        Member::create($validated);
        return redirect()->route('admin.pengurus.index')->with('success', 'Pengurus berhasil ditambahkan.');
    }

    public function edit(Member $penguru)
    {
        return view('admin.pengurus.edit', ['member' => $penguru]);
    }

    public function update(Request $request, Member $penguru)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:members,nim,' . $penguru->id,
            'position' => 'required|string|max:255',
            'division' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'period' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            if (!$file->isValid()) {
                return redirect()->back()->withErrors(['photo' => 'Upload gagal: ' . $file->getErrorMessage()]);
            }
            $filename = $file->hashName();
            $destinationPath = storage_path('app/public/members');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['photo'] = 'members/' . $filename;
        }

        $penguru->update($validated);
        return redirect()->route('admin.pengurus.index')->with('success', 'Pengurus berhasil diperbarui.');
    }

    public function destroy(Member $penguru)
    {
        $penguru->delete();
        return redirect()->route('admin.pengurus.index')->with('success', 'Pengurus berhasil dihapus.');
    }
}
