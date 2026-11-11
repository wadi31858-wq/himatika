<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Member;
use App\Models\News;
use App\Models\Gallery;
use App\Models\OrganizationalStructure;
use App\Models\SiteSetting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminHomeController extends Controller
{
    public function edit()
    {
        return redirect()->route('admin.beranda.hero');
    }

    public function hero()
    {
        $profile = Profile::firstOrCreate([]);
        return view('admin.beranda.hero', compact('profile'));
    }

    public function updateHero(Request $request)
    {
        $validated = $request->validate([
            'hero_badge' => 'nullable|string|max:100',
            'hero_tagline' => 'nullable|string|max:150',
            'hero_title' => 'required|string|max:300',
            'hero_desc' => 'nullable|string|max:1000',
            'hero_btn_primary_text' => 'nullable|string|max:50',
            'hero_btn_primary_url' => 'nullable|string|max:255',
            'hero_btn_secondary_text' => 'nullable|string|max:50',
            'hero_btn_secondary_url' => 'nullable|string|max:255',
            'hero_btn_primary_active' => 'nullable|boolean',
            'hero_btn_secondary_active' => 'nullable|boolean',
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'hero_image_alt' => 'nullable|string|max:150',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $profile = Profile::firstOrCreate([]);
        $destination = storage_path('app/public/hero');
        if (!File::isDirectory($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            $filename = 'hero_' . time() . '_' . $file->hashName();
            if ($profile->hero_image && file_exists(storage_path('app/public/' . $profile->hero_image))) {
                @unlink(storage_path('app/public/' . $profile->hero_image));
            }
            $file->move($destination, $filename);
            $validated['hero_image'] = 'hero/' . $filename;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'profile_' . time() . '_' . $file->hashName();
            $pDest = storage_path('app/public/profile');
            if (!File::isDirectory($pDest)) {
                File::makeDirectory($pDest, 0755, true);
            }
            if ($profile->image && file_exists(storage_path('app/public/' . $profile->image))) {
                @unlink(storage_path('app/public/' . $profile->image));
            }
            $file->move($pDest, $filename);
            $validated['image'] = 'profile/' . $filename;
        }

        $validated['hero_btn_primary_active'] = $request->has('hero_btn_primary_active');
        $validated['hero_btn_secondary_active'] = $request->has('hero_btn_secondary_active');

        $profile->update($validated);

        SiteSetting::set('hero_btn_primary_active', $validated['hero_btn_primary_active'] ? '1' : '0', 'hero');
        SiteSetting::set('hero_btn_secondary_active', $validated['hero_btn_secondary_active'] ? '1' : '0', 'hero');

        ActivityLog::record('update', 'Memperbarui Hero Section Beranda', $profile);

        return back()->with('success', 'Pengaturan Hero Beranda berhasil disimpan.');
    }

    public function tentang()
    {
        $profile = Profile::firstOrCreate([]);
        $kaprodi = Member::where('position', 'like', '%kaprodi%')
            ->orWhere('position', 'like', '%ketua prodi%')
            ->first();

        return view('admin.beranda.tentang', compact('profile', 'kaprodi'));
    }

    public function updateTentang(Request $request)
    {
        $validated = $request->validate([
            'home_tentang_badge' => 'nullable|string|max:100',
            'home_tentang_title' => 'required|string|max:255',
            'home_tentang_desc' => 'nullable|string|max:1000',
            'home_sambutan_summary' => 'nullable|string|max:1000',
            'home_sambutan_btn_text' => 'nullable|string|max:100',
            'home_sambutan_btn_url' => 'nullable|string|max:255',
            'home_visi_badge' => 'nullable|string|max:100',
            'home_visi_title' => 'nullable|string|max:255',
            'home_visi_summary' => 'nullable|string|max:1000',
            'home_visi_btn_text' => 'nullable|string|max:100',
            'home_visi_btn_url' => 'nullable|string|max:255',
            'home_struktur_summary' => 'nullable|string|max:1000',
            'home_struktur_btn_text' => 'nullable|string|max:100',
            'home_struktur_btn_url' => 'nullable|string|max:255',
        ]);

        foreach ($validated as $k => $v) {
            SiteSetting::set($k, $v, 'home_tentang');
        }

        // Sinkronisasi dua arah ke model asli jika diubah dari form Beranda
        if (!empty($validated['home_visi_summary'])) {
            $vm = \App\Models\VisionMission::firstOrCreate([]);
            $vm->update(['vision' => $validated['home_visi_summary']]);
        }
        if (!empty($validated['home_sambutan_summary'])) {
            SiteSetting::set('sambutan_quote', $validated['home_sambutan_summary'], 'tentang');
        }

        ActivityLog::record('update', 'Memperbarui Bagian Tentang HIMATIKA di Beranda', null);

        return back()->with('success', 'Pengaturan Bagian Tentang HIMATIKA di Beranda berhasil disimpan.');
    }

    public function berita()
    {
        $allNews = News::published()->latest('published_at')->get();
        return view('admin.beranda.berita', compact('allNews'));
    }

    public function updateBerita(Request $request)
    {
        $validated = $request->validate([
            'home_berita_badge' => 'nullable|string|max:100',
            'home_berita_title' => 'required|string|max:255',
            'home_berita_desc' => 'nullable|string|max:1000',
            'home_berita_btn_text' => 'nullable|string|max:100',
            'home_berita_btn_url' => 'nullable|string|max:255',
            'home_featured_news_id' => 'nullable|exists:news,id',
        ]);

        foreach ($validated as $k => $v) {
            SiteSetting::set($k, $v, 'home_berita');
        }

        ActivityLog::record('update', 'Memperbarui Bagian Berita & Informasi Terkini di Beranda', null);

        return back()->with('success', 'Pengaturan Bagian Berita Terkini di Beranda berhasil disimpan.');
    }

    public function berdampak()
    {
        $profile = Profile::firstOrCreate([]);
        $autoStats = [
            'pengurus' => Member::where('is_active', true)->count(),
            'bidang' => OrganizationalStructure::whereNotNull('parent_id')->count() ?: 6,
            'biro' => OrganizationalStructure::whereNull('parent_id')->count() ?: 4,
        ];

        return view('admin.beranda.berdampak', compact('profile', 'autoStats'));
    }

    public function updateBerdampak(Request $request)
    {
        $validated = $request->validate([
            'home_peduli_badge' => 'nullable|string|max:100',
            'home_peduli_title' => 'required|string|max:255',
            'home_peduli_desc' => 'nullable|string|max:1000',
            'home_peduli_btn_text' => 'nullable|string|max:100',
            'home_peduli_btn_url' => 'nullable|string|max:255',
            'stats_mode' => 'required|in:auto,manual',
            'hero_stats_pengurus' => 'nullable|string|max:50',
            'hero_stats_bidang' => 'nullable|string|max:50',
            'hero_stats_biro' => 'nullable|string|max:50',
            'home_peduli_stat1_num' => 'nullable|string|max:50',
            'home_peduli_stat1_label' => 'nullable|string|max:100',
            'home_peduli_stat2_num' => 'nullable|string|max:50',
            'home_peduli_stat2_label' => 'nullable|string|max:100',
            'home_peduli_stat3_num' => 'nullable|string|max:50',
            'home_peduli_stat3_label' => 'nullable|string|max:100',
        ]);

        $profile = Profile::firstOrCreate([]);
        $profile->update([
            'stats_mode' => $validated['stats_mode'],
            'hero_stats_pengurus' => $validated['hero_stats_pengurus'] ?? 68,
            'hero_stats_bidang' => $validated['hero_stats_bidang'] ?? 6,
            'hero_stats_biro' => $validated['hero_stats_biro'] ?? 4,
        ]);

        foreach ($validated as $k => $v) {
            SiteSetting::set($k, $v, 'home_peduli');
        }

        ActivityLog::record('update', 'Memperbarui Bagian HIMATIKA Berdampak di Beranda', null);

        return back()->with('success', 'Pengaturan Bagian HIMATIKA Berdampak berhasil disimpan.');
    }

    public function momen()
    {
        $galleries = Gallery::published()->latest()->get();
        return view('admin.beranda.momen', compact('galleries'));
    }

    public function updateMomen(Request $request)
    {
        $validated = $request->validate([
            'home_galeri_badge' => 'nullable|string|max:100',
            'home_galeri_title' => 'required|string|max:255',
            'home_galeri_desc' => 'nullable|string|max:1000',
            'home_galeri_btn_text' => 'nullable|string|max:100',
            'home_galeri_btn_url' => 'nullable|string|max:255',
            'home_featured_gallery_id' => 'nullable|exists:galleries,id',
        ]);

        foreach ($validated as $k => $v) {
            SiteSetting::set($k, $v, 'home_momen');
        }

        ActivityLog::record('update', 'Memperbarui Bagian Dokumentasi Momen di Beranda', null);

        return back()->with('success', 'Pengaturan Bagian Dokumentasi Momen di Beranda berhasil disimpan.');
    }
}
