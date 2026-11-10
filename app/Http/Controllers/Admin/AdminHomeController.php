<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Member;
use App\Models\OrganizationalStructure;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminHomeController extends Controller
{
    public function edit()
    {
        $profile = Profile::firstOrCreate([], [
            'hero_badge' => 'HIMATIKA FMIPA UNUJA',
            'hero_tagline' => 'Synchronized Growth, Reaching New Heights',
            'hero_title' => "Rumah yang\ninklusif, inovatif,\ndan tumbuh bersama.",
            'hero_desc' => 'Ruang resmi mahasiswa Matematika UNUJA untuk mengakses layanan, mengikuti kegiatan, menyampaikan aspirasi, dan mengenal karya HIMATIKA.',
            'hero_btn_primary_text' => 'Hubungi Kami',
            'hero_btn_primary_url' => '/kontak',
            'hero_btn_secondary_text' => 'Pelajari Profil',
            'hero_btn_secondary_url' => '/profil',
            'stats_mode' => 'auto',
            'hero_stats_pengurus' => '68',
            'hero_stats_bidang' => '6',
            'hero_stats_biro' => '4',
        ]);

        $autoStats = [
            'pengurus' => Member::where('is_active', true)->count(),
            'bidang' => OrganizationalStructure::whereNotNull('parent_id')->count() ?: 6,
            'biro' => OrganizationalStructure::whereNull('parent_id')->count() ?: 4,
        ];

        return view('admin.beranda.edit', compact('profile', 'autoStats'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_badge' => 'nullable|string|max:100',
            'hero_tagline' => 'nullable|string|max:150',
            'hero_title' => 'required|string|max:300',
            'hero_desc' => 'nullable|string|max:600',
            'hero_btn_primary_text' => 'nullable|string|max:50',
            'hero_btn_primary_url' => 'nullable|string|max:255',
            'hero_btn_secondary_text' => 'nullable|string|max:50',
            'hero_btn_secondary_url' => 'nullable|string|max:255',
            'stats_mode' => 'required|in:auto,manual',
            'hero_stats_pengurus' => 'nullable|string|max:50',
            'hero_stats_bidang' => 'nullable|string|max:50',
            'hero_stats_biro' => 'nullable|string|max:50',
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'hero_image_alt' => 'nullable|string|max:150',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $profile = Profile::firstOrCreate([]);

        // Upload Hero Background Photo
        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            $filename = 'hero_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/hero');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            // Delete old file if present
            if ($profile->hero_image && file_exists(storage_path('app/public/' . $profile->hero_image))) {
                @unlink(storage_path('app/public/' . $profile->hero_image));
            }
            $file->move($destination, $filename);
            $validated['hero_image'] = 'hero/' . $filename;
        }

        // Upload Hero Card / Organization Photo
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'profile_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/profile');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            if ($profile->image && file_exists(storage_path('app/public/' . $profile->image))) {
                @unlink(storage_path('app/public/' . $profile->image));
            }
            $file->move($destination, $filename);
            $validated['image'] = 'profile/' . $filename;
        }

        $profile->update($validated);

        ActivityLog::record(
            'update',
            'Memperbarui pengaturan Beranda (Hero & Statistik)',
            $profile
        );

        return redirect()->route('admin.beranda.edit')->with('success', 'Pengaturan Beranda berhasil disimpan.');
    }
}

