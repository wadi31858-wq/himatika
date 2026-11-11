<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\SiteSetting;
use App\Models\NavMenu;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminSettingController extends Controller
{
    // ==========================================
    // 1. IDENTITAS WEBSITE
    // ==========================================
    public function edit()
    {
        return $this->identitas();
    }

    public function identitas()
    {
        $profile = Profile::firstOrCreate([], [
            'title' => 'HIMATIKA FMIPA UNUJA',
            'campus_name' => 'Universitas Nurul Jadid',
            'motto' => 'Synchronized Growth, Reaching New Heights',
            'email' => 'himatika@unuja.ac.id',
            'phone' => '+62 812-3456-7890',
            'footer_text' => 'Himpunan Mahasiswa Matematika (HIMATIKA) Fakultas MIPA Universitas Nurul Jadid Paiton Probolinggo.',
        ]);

        return view('admin.tampilan.identitas', compact('profile'));
    }

    public function updateIdentitas(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_title' => 'nullable|string|max:50',
            'campus_name' => 'nullable|string|max:255',
            'faculty_name' => 'nullable|string|max:255',
            'motto' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        $profile = Profile::firstOrCreate([]);
        $profile->update([
            'title' => $validated['title'],
            'campus_name' => $validated['campus_name'] ?? '',
            'motto' => $validated['motto'] ?? '',
            'meta_description' => $validated['meta_description'] ?? '',
        ]);

        SiteSetting::set('site_short_title', $validated['short_title'] ?? 'HIMATIKA', 'identitas');
        SiteSetting::set('site_faculty_name', $validated['faculty_name'] ?? 'Fakultas MIPA', 'identitas');
        SiteSetting::set('site_meta_keywords', $validated['meta_keywords'] ?? 'HIMATIKA, UNUJA, Matematika, FMIPA, Nurul Jadid', 'identitas');

        ActivityLog::record('update', 'Memperbarui identitas dan meta informasi website', $profile);

        return back()->with('success', 'Identitas website berhasil diperbarui.');
    }

    public function update(Request $request)
    {
        return $this->updateIdentitas($request);
    }

    // ==========================================
    // 2. LOGO & FAVICON PER LOKASI
    // ==========================================
    public function logoFavicon()
    {
        $profile = Profile::firstOrCreate([]);

        $locations = [
            'nav_desktop' => [
                'name' => 'Logo Navbar Desktop',
                'desc' => 'Tampil di bilah navigasi atas pada layar komputer & laptop.',
                'use_custom_key' => 'logo_nav_desktop_custom',
                'file_key' => 'logo_nav_desktop_file',
                'alt_key' => 'logo_nav_desktop_alt',
                'default_alt' => 'Logo HIMATIKA UNUJA',
            ],
            'nav_mobile' => [
                'name' => 'Logo Navbar Mobile',
                'desc' => 'Tampil di header navigasi smartphone & tablet saat responsive.',
                'use_custom_key' => 'logo_nav_mobile_custom',
                'file_key' => 'logo_nav_mobile_file',
                'alt_key' => 'logo_nav_mobile_alt',
                'default_alt' => 'Logo Mobile HIMATIKA',
            ],
            'footer' => [
                'name' => 'Logo Footer Website',
                'desc' => 'Tampil di bagian bawah (footer) seluruh halaman publik.',
                'use_custom_key' => 'logo_footer_custom',
                'file_key' => 'logo_footer_file',
                'alt_key' => 'logo_footer_alt',
                'default_alt' => 'Logo Footer HIMATIKA UNUJA',
            ],
            'admin_login' => [
                'name' => 'Logo Halaman Login Admin',
                'desc' => 'Tampil di atas kartu formulir login panel admin.',
                'use_custom_key' => 'logo_admin_login_custom',
                'file_key' => 'logo_admin_login_file',
                'alt_key' => 'logo_admin_login_alt',
                'default_alt' => 'Logo Login Admin HIMATIKA',
            ],
            'admin_sidebar' => [
                'name' => 'Logo Sidebar Admin',
                'desc' => 'Tampil di sudut kiri atas sidebar dashboard admin.',
                'use_custom_key' => 'logo_admin_sidebar_custom',
                'file_key' => 'logo_admin_sidebar_file',
                'alt_key' => 'logo_admin_sidebar_alt',
                'default_alt' => 'Logo Sidebar Admin',
            ],
            'favicon' => [
                'name' => 'Favicon Tab Browser',
                'desc' => 'Ikon kecil pada tab browser dan bookmark (format .ico, .png, .svg).',
                'use_custom_key' => 'favicon_custom',
                'file_key' => 'favicon_file',
                'alt_key' => 'favicon_alt',
                'default_alt' => 'Favicon HIMATIKA',
            ],
        ];

        return view('admin.tampilan.logo-favicon', compact('profile', 'locations'));
    }

    public function updateLogoFavicon(Request $request)
    {
        $profile = Profile::firstOrCreate([]);
        $destination = storage_path('app/public/branding');
        if (!File::isDirectory($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        // 1. Main Logo
        if ($request->hasFile('main_logo')) {
            $file = $request->file('main_logo');
            $filename = 'logo_main_' . time() . '.' . $file->getClientOriginalExtension();
            if ($profile->logo && file_exists(storage_path('app/public/' . $profile->logo))) {
                @unlink(storage_path('app/public/' . $profile->logo));
            }
            $file->move($destination, $filename);
            $profile->update(['logo' => 'branding/' . $filename]);
            SiteSetting::set('main_logo', 'branding/' . $filename, 'branding');
        }

        // 2. Main Favicon
        if ($request->hasFile('main_favicon')) {
            $file = $request->file('main_favicon');
            $filename = 'favicon_main_' . time() . '.' . $file->getClientOriginalExtension();
            if ($profile->favicon && file_exists(storage_path('app/public/' . $profile->favicon))) {
                @unlink(storage_path('app/public/' . $profile->favicon));
            }
            $file->move($destination, $filename);
            $profile->update(['favicon' => 'branding/' . $filename]);
            SiteSetting::set('main_favicon', 'branding/' . $filename, 'branding');
        }

        // 3. Location overrides
        $locations = ['nav_desktop', 'nav_mobile', 'footer', 'admin_login', 'admin_sidebar', 'favicon'];
        foreach ($locations as $loc) {
            $useCustom = $request->input("use_custom_{$loc}") ? '1' : '0';
            SiteSetting::set("logo_{$loc}_custom", $useCustom, 'branding');

            $altText = $request->input("alt_{$loc}");
            if ($altText !== null) {
                SiteSetting::set("logo_{$loc}_alt", $altText, 'branding');
            }

            if ($request->hasFile("file_{$loc}")) {
                $file = $request->file("file_{$loc}");
                $filename = "logo_{$loc}_" . time() . '.' . $file->getClientOriginalExtension();
                $oldFile = SiteSetting::get("logo_{$loc}_file");
                if ($oldFile && file_exists(storage_path('app/public/' . $oldFile))) {
                    @unlink(storage_path('app/public/' . $oldFile));
                }
                $file->move($destination, $filename);
                SiteSetting::set("logo_{$loc}_file", 'branding/' . $filename, 'branding');
            }
        }

        ActivityLog::record('update', 'Memperbarui logo utama, favicon, dan pengaturan logo per lokasi', null);

        return back()->with('success', 'Pengaturan logo dan favicon per lokasi berhasil disimpan.');
    }

    public function resetLogoLocation($location)
    {
        $oldFile = SiteSetting::get("logo_{$location}_file");
        if ($oldFile && file_exists(storage_path('app/public/' . $oldFile))) {
            @unlink(storage_path('app/public/' . $oldFile));
        }
        SiteSetting::set("logo_{$location}_custom", '0', 'branding');
        SiteSetting::set("logo_{$location}_file", '', 'branding');

        return back()->with('success', "Logo khusus untuk {$location} berhasil direset ke Logo Utama.");
    }

    // ==========================================
    // 3. NAVBAR & SUBMENU
    // ==========================================
    public function navbar()
    {
        $menus = NavMenu::whereNull('parent_id')
            ->with(['children' => function ($q) {
                $q->orderBy('order_num');
            }])
            ->orderBy('order_num')
            ->get();

        return view('admin.tampilan.navbar', compact('menus'));
    }

    public function storeNavbar(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:nav_menus,id',
            'order_num' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['order_num'] = $validated['order_num'] ?? 0;
        $validated['is_active'] = $request->has('is_active');

        NavMenu::create($validated);
        ActivityLog::record('create', "Menambahkan item menu navbar: \"{$validated['label']}\"", null);

        return back()->with('success', 'Item menu navbar berhasil ditambahkan.');
    }

    public function updateNavbar(Request $request, NavMenu $menu)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:nav_menus,id',
            'order_num' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['order_num'] = $validated['order_num'] ?? 0;
        $validated['is_active'] = $request->has('is_active');

        $menu->update($validated);
        ActivityLog::record('update', "Memperbarui item menu navbar: \"{$menu->label}\"", $menu);

        return back()->with('success', 'Item menu navbar berhasil diperbarui.');
    }

    public function destroyNavbar(NavMenu $menu)
    {
        $label = $menu->label;
        $menu->children()->delete();
        $menu->delete();

        ActivityLog::record('delete', "Menghapus item menu navbar: \"{$label}\"", null);

        return back()->with('success', "Item menu \"{$label}\" berhasil dihapus.");
    }

    // ==========================================
    // 4. FOOTER & KONTAK
    // ==========================================
    public function footer()
    {
        $profile = Profile::firstOrCreate([]);
        return view('admin.tampilan.footer', compact('profile'));
    }

    public function updateFooter(Request $request)
    {
        $validated = $request->validate([
            'footer_text' => 'nullable|string|max:1000',
            'copyright_text' => 'nullable|string|max:255',
            'managed_by' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'maps_embed' => 'nullable|string|max:2000',
        ]);

        $profile = Profile::firstOrCreate([]);
        $profile->update([
            'footer_text' => $validated['footer_text'] ?? '',
            'email' => $validated['email'] ?? '',
            'phone' => $validated['phone'] ?? '',
            'address' => $validated['address'] ?? '',
            'instagram' => $validated['instagram'] ?? '',
            'youtube' => $validated['youtube'] ?? '',
            'tiktok' => $validated['tiktok'] ?? '',
            'facebook' => $validated['facebook'] ?? '',
        ]);

        SiteSetting::set('footer_copyright', $validated['copyright_text'] ?? '© 2026 HIMATIKA UNUJA 2026.', 'footer');
        SiteSetting::set('footer_managed_by', $validated['managed_by'] ?? 'Dikelola oleh Tim Website HIMATIKA', 'footer');
        SiteSetting::set('footer_maps_embed', $validated['maps_embed'] ?? '', 'footer');

        ActivityLog::record('update', 'Memperbarui teks footer, kontak, sosial media, dan peta', null);

        return back()->with('success', 'Pengaturan Footer & Kontak berhasil disimpan.');
    }

    // ==========================================
    // 5. PUSTAKA MEDIA (BROWSER)
    // ==========================================
    public function mediaLibrary(Request $request)
    {
        $baseDir = storage_path('app/public');
        $files = [];

        if (File::isDirectory($baseDir)) {
            $allFiles = File::allFiles($baseDir);
            $search = strtolower($request->get('search', ''));
            $filter = $request->get('type', '');

            foreach ($allFiles as $file) {
                $name = $file->getFilename();
                $relPath = str_replace([$baseDir . DIRECTORY_SEPARATOR, $baseDir . '/'], '', $file->getPathname());
                $relPath = str_replace('\\', '/', $relPath);
                $ext = strtolower($file->getExtension());
                $size = $file->getSize();
                $time = $file->getMTime();

                $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']);
                $isDoc = in_array($ext, ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip', 'rar', 'ppt', 'pptx']);

                if ($search && !str_contains(strtolower($name), $search) && !str_contains(strtolower($relPath), $search)) {
                    continue;
                }

                if ($filter === 'image' && !$isImg) {
                    continue;
                }
                if ($filter === 'document' && !$isDoc) {
                    continue;
                }

                $files[] = [
                    'name' => $name,
                    'path' => $relPath,
                    'url' => asset('storage/' . $relPath),
                    'size' => $this->formatSize($size),
                    'ext' => $ext,
                    'is_image' => $isImg,
                    'mtime' => date('d M Y, H:i', $time),
                    'timestamp' => $time,
                ];
            }

            // Sort newest first
            usort($files, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);
        }

        $totalFiles = count($files);

        // Paginate manually with LengthAwarePaginator
        $page = (int) $request->get('page', 1);
        $perPage = 24;
        $offset = ($page - 1) * $perPage;
        $slice = array_slice($files, $offset, $perPage);

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $slice,
            $totalFiles,
            $perPage,
            $page,
            ['path' => route('admin.tampilan.media'), 'query' => $request->query()]
        );

        return view('admin.tampilan.media', [
            'files' => $paginator,
            'totalFiles' => $totalFiles,
        ]);
    }

    private function formatSize($bytes)
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return round($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }
}
