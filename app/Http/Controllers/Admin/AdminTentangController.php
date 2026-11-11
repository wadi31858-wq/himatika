<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\SiteSetting;
use App\Models\Member;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminTentangController extends Controller
{
    public function sejarah()
    {
        $profile = Profile::firstOrCreate([]);
        return view('admin.tentang.sejarah', compact('profile'));
    }

    public function updateSejarah(Request $request)
    {
        $validated = $request->validate([
            'history_title' => 'required|string|max:255',
            'history_subtitle' => 'nullable|string|max:500',
            'history_content' => 'required|string',
            'history_doc_url' => 'nullable|string|max:255',
            'history_doc_text' => 'nullable|string|max:100',
            'history_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $profile = Profile::firstOrCreate([]);

        if ($request->hasFile('history_image')) {
            $file = $request->file('history_image');
            $filename = 'history_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/history');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            $file->move($destination, $filename);
            SiteSetting::set('history_image', 'history/' . $filename, 'tentang');
        }

        SiteSetting::set('history_title', $validated['history_title'], 'tentang');
        SiteSetting::set('history_subtitle', $validated['history_subtitle'] ?? '', 'tentang');
        SiteSetting::set('history_doc_url', $validated['history_doc_url'] ?? '/galeri', 'tentang');
        SiteSetting::set('history_doc_text', $validated['history_doc_text'] ?? 'Dokumentasi Sejarah', 'tentang');

        $profile->update(['history' => $validated['history_content']]);

        ActivityLog::record('update', 'Memperbarui Halaman Sejarah HIMATIKA', $profile);

        return back()->with('success', 'Halaman Sejarah HIMATIKA berhasil diperbarui.');
    }

    public function sambutan()
    {
        $profile = Profile::firstOrCreate([]);
        $kaprodi = Member::where('position', 'like', '%kaprodi%')
            ->orWhere('position', 'like', '%ketua prodi%')
            ->orWhere('position', 'like', '%ketua program studi%')
            ->first();

        return view('admin.tentang.sambutan', compact('profile', 'kaprodi'));
    }

    public function updateSambutan(Request $request)
    {
        $validated = $request->validate([
            'sambutan_name' => 'required|string|max:255',
            'sambutan_title' => 'required|string|max:255',
            'sambutan_quote' => 'nullable|string|max:500',
            'sambutan_content' => 'required|string',
            'sambutan_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $destination = storage_path('app/public/profile');
        if (!File::isDirectory($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        if ($request->hasFile('sambutan_photo')) {
            $file = $request->file('sambutan_photo');
            $filename = 'sambutan_' . time() . '_' . $file->hashName();
            $file->move($destination, $filename);
            SiteSetting::set('sambutan_photo', 'profile/' . $filename, 'tentang');
        }

        SiteSetting::set('sambutan_name', $validated['sambutan_name'], 'tentang');
        SiteSetting::set('sambutan_title', $validated['sambutan_title'], 'tentang');
        SiteSetting::set('sambutan_quote', $validated['sambutan_quote'] ?? '', 'tentang');
        SiteSetting::set('sambutan_content', $validated['sambutan_content'], 'tentang');

        // Also update or create Member entry if exists
        $kaprodi = Member::where('position', 'like', '%kaprodi%')
            ->orWhere('position', 'like', '%ketua prodi%')
            ->first();

        if ($kaprodi) {
            $kaprodi->update([
                'name' => $validated['sambutan_name'],
                'position' => $validated['sambutan_title'],
                'bio' => $validated['sambutan_content'],
            ]);
            if (isset($filename)) {
                $kaprodi->update(['photo' => 'profile/' . $filename]);
            }
        }

        ActivityLog::record('update', 'Memperbarui Halaman Sambutan Kaprodi', null);

        return back()->with('success', 'Halaman Sambutan Kaprodi berhasil diperbarui.');
    }
}
