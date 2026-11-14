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
use App\Models\HeroSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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

        if ($request->has('remove_hero_image')) {
            if ($profile->hero_image && file_exists(storage_path('app/public/' . $profile->hero_image))) {
                @unlink(storage_path('app/public/' . $profile->hero_image));
            }
            $validated['hero_image'] = null;
        }

        if ($request->has('remove_image')) {
            if ($profile->image && file_exists(storage_path('app/public/' . $profile->image))) {
                @unlink(storage_path('app/public/' . $profile->image));
            }
            $validated['image'] = null;
            SiteSetting::set('hero_pengurus_photo', '', 'hero');
        }

        $validated['hero_btn_primary_active'] = $request->has('hero_btn_primary_active');
        $validated['hero_btn_secondary_active'] = $request->has('hero_btn_secondary_active');

        $profile->update($validated);

        SiteSetting::set('hero_is_visible', $request->has('hero_is_visible') ? '1' : '0', 'hero');
        SiteSetting::set('hero_btn_primary_active', $validated['hero_btn_primary_active'] ? '1' : '0', 'hero');
        SiteSetting::set('hero_btn_secondary_active', $validated['hero_btn_secondary_active'] ? '1' : '0', 'hero');
        if (isset($validated['image'])) {
            SiteSetting::set('hero_pengurus_photo', $validated['image'] ?? '', 'hero');
        }

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
        SiteSetting::set('home_tentang_active', $request->has('home_tentang_active') ? '1' : '0', 'home_tentang');

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
        SiteSetting::set('home_berita_active', $request->has('home_berita_active') ? '1' : '0', 'home_berita');

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
        SiteSetting::set('home_peduli_active', $request->has('home_peduli_active') ? '1' : '0', 'home_peduli');

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
        SiteSetting::set('home_galeri_active', $request->has('home_galeri_active') ? '1' : '0', 'home_momen');

        ActivityLog::record('update', 'Memperbarui Bagian Dokumentasi Momen di Beranda', null);

        return back()->with('success', 'Pengaturan Bagian Dokumentasi Momen di Beranda berhasil disimpan.');
    }

    public function slider()
    {
        $sliders = HeroSlider::ordered()->get();
        $interval = (int) SiteSetting::get('hero_slider_interval', 5);
        $autoplay = SiteSetting::get('hero_slider_autoplay', '1') === '1';

        return view('admin.beranda.slider', compact('sliders', 'interval', 'autoplay'));
    }

    public function storeSlider(Request $request)
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ], [
            'photos.required' => 'Silakan pilih setidaknya satu foto untuk diunggah.',
            'photos.*.image' => 'File yang diunggah harus berupa gambar.',
            'photos.*.mimes' => 'Format file harus JPEG, PNG, JPG, WEBP, atau GIF.',
            'photos.*.max' => 'Ukuran setiap file maksimal 5MB.',
        ]);

        $destination = storage_path('app/public/hero_sliders');
        if (!File::isDirectory($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $uploadedCount = 0;
        $failedFiles = [];
        $maxOrder = HeroSlider::max('order_num') ?? 0;

        foreach ($request->file('photos') as $file) {
            try {
                if (!$file->isValid()) {
                    $failedFiles[] = $file->getClientOriginalName() . ' (File tidak valid)';
                    continue;
                }
                $filename = 'slider_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->move($destination, $filename);

                HeroSlider::create([
                    'image' => 'hero_sliders/' . $filename,
                    'title' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                    'alt_text' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                    'order_num' => ++$maxOrder,
                    'is_active' => true,
                ]);

                $uploadedCount++;
            } catch (\Exception $e) {
                $failedFiles[] = $file->getClientOriginalName() . ' (' . $e->getMessage() . ')';
            }
        }

        ActivityLog::record('create', "Mengunggah {$uploadedCount} foto ke Slider Hero Beranda", null);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'uploaded_count' => $uploadedCount,
                'failed_files' => $failedFiles,
                'message' => "Berhasil mengunggah {$uploadedCount} foto." . (count($failedFiles) ? ' ' . count($failedFiles) . ' file gagal.' : ''),
            ]);
        }

        if (count($failedFiles) > 0 && $uploadedCount === 0) {
            return back()->with('error', 'Semua file gagal diunggah: ' . implode(', ', $failedFiles));
        } elseif (count($failedFiles) > 0) {
            return back()->with('warning', "Berhasil mengunggah {$uploadedCount} foto. File gagal: " . implode(', ', $failedFiles));
        }

        return back()->with('success', "Berhasil menambahkan {$uploadedCount} foto ke slider hero.");
    }

    public function updateSliderSettings(Request $request)
    {
        $validated = $request->validate([
            'hero_slider_interval' => 'required|integer|min:1|max:60',
        ]);

        SiteSetting::set('hero_slider_interval', (string) $validated['hero_slider_interval'], 'hero');
        SiteSetting::set('hero_slider_autoplay', $request->has('hero_slider_autoplay') ? '1' : '0', 'hero');

        ActivityLog::record('update', 'Memperbarui pengaturan slider hero (interval & autoplay)', null);

        return back()->with('success', 'Pengaturan slider berhasil diperbarui.');
    }

    public function updateSlider(Request $request, HeroSlider $slider)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:150',
            'alt_text' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:255',
            'order_num' => 'nullable|integer|min:1',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ]);

        if ($request->hasFile('photo')) {
            $destination = storage_path('app/public/hero_sliders');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }

            if ($slider->image && str_starts_with($slider->image, 'hero_sliders/')) {
                $oldPath = storage_path('app/public/' . $slider->image);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('photo');
            $filename = 'slider_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move($destination, $filename);
            $slider->image = 'hero_sliders/' . $filename;
        }

        $slider->title = $validated['title'] ?? $slider->title;
        $slider->alt_text = $validated['alt_text'] ?? $slider->alt_text;
        $slider->caption = $validated['caption'] ?? $slider->caption;
        if (isset($validated['order_num'])) {
            $slider->order_num = (int) $validated['order_num'];
        }
        $slider->save();

        ActivityLog::record('update', "Memperbarui foto slider hero #{$slider->id}", null);

        return back()->with('success', 'Data foto slider berhasil diperbarui.');
    }

    public function toggleSlider(HeroSlider $slider)
    {
        $slider->update(['is_active' => !$slider->is_active]);

        ActivityLog::record('update', ($slider->is_active ? 'Mengaktifkan' : 'Menonaktifkan') . " foto slider #{$slider->id}", null);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $slider->is_active,
                'message' => $slider->is_active ? 'Foto diaktifkan' : 'Foto dinonaktifkan',
            ]);
        }

        return back()->with('success', 'Status tampilan foto berhasil diubah.');
    }

    public function reorderSlider(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'integer|exists:hero_sliders,id',
        ]);

        foreach ($request->orders as $index => $id) {
            HeroSlider::where('id', $id)->update(['order_num' => $index + 1]);
        }

        ActivityLog::record('update', 'Mengatur ulang urutan slider hero', null);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Urutan slider berhasil disimpan.']);
        }

        return back()->with('success', 'Urutan foto slider berhasil disimpan.');
    }

    public function destroySlider(HeroSlider $slider)
    {
        if ($slider->image && str_starts_with($slider->image, 'hero_sliders/')) {
            $filePath = storage_path('app/public/' . $slider->image);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        $sliderId = $slider->id;
        $slider->delete();

        ActivityLog::record('delete', "Menghapus foto slider #{$sliderId}", null);

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Foto slider berhasil dihapus.']);
        }

        return back()->with('success', 'Foto berhasil dihapus dari slider.');
    }
}
