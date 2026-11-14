<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            // Visi & Misi
            ['key' => 'vm_banner_title', 'value' => 'Visi dan Misi', 'group' => 'visi_misi'],
            ['key' => 'vm_banner_subtitle', 'value' => 'Arah dan tujuan pengembangan HIMATIKA FMIPA UNUJA.', 'group' => 'visi_misi'],
            ['key' => 'vm_vision_title', 'value' => 'Visi HIMATIKA FMIPA UNUJA', 'group' => 'visi_misi'],
            ['key' => 'vm_mission_title', 'value' => 'Misi HIMATIKA FMIPA UNUJA', 'group' => 'visi_misi'],
            ['key' => 'vm_is_visible', 'value' => '1', 'group' => 'visi_misi'],
            ['key' => 'home_visi_summary', 'value' => 'Menjadi organisasi mahasiswa Matematika yang aktif, inovatif, kolaboratif, dan unggul dalam pengembangan ilmu matematika serta sumber daya mahasiswa.', 'group' => 'home_tentang'],
            ['key' => 'home_visi_badge', 'value' => 'PEDOMAN ORGANISASI', 'group' => 'home_tentang'],
            ['key' => 'home_visi_btn_text', 'value' => 'Lihat Visi dan Misi', 'group' => 'home_tentang'],
            ['key' => 'home_visi_btn_url', 'value' => '/visi-misi', 'group' => 'home_tentang'],

            // Hero Beranda
            ['key' => 'hero_is_visible', 'value' => '1', 'group' => 'hero'],
            ['key' => 'hero_btn_primary_active', 'value' => '1', 'group' => 'hero'],
            ['key' => 'hero_btn_secondary_active', 'value' => '1', 'group' => 'hero'],

            // Sections Beranda
            ['key' => 'home_tentang_active', 'value' => '1', 'group' => 'home_tentang'],
            ['key' => 'home_berita_active', 'value' => '1', 'group' => 'home_berita'],
            ['key' => 'home_peduli_active', 'value' => '1', 'group' => 'home_peduli'],
            ['key' => 'home_galeri_active', 'value' => '1', 'group' => 'home_momen'],

            // Halaman Tentang
            ['key' => 'history_is_visible', 'value' => '1', 'group' => 'tentang'],
            ['key' => 'sambutan_is_visible', 'value' => '1', 'group' => 'tentang'],
            ['key' => 'structure_is_visible', 'value' => '1', 'group' => 'tentang'],

            // Berkarya
            ['key' => 'home_peduli_badge', 'value' => 'HIMATIKA BERKARYA', 'group' => 'home_peduli'],
            ['key' => 'home_peduli_title', 'value' => 'Karya Website Mahasiswa', 'group' => 'home_peduli'],
            ['key' => 'home_peduli_desc', 'value' => 'Jelajahi website karya mahasiswa Informatika Universitas Nurul Jadid dan lihat bagaimana ide mereka diwujudkan menjadi proyek digital.', 'group' => 'home_peduli'],
            ['key' => 'home_peduli_btn_text', 'value' => 'Lihat Galeri Website', 'group' => 'home_peduli'],
            ['key' => 'home_peduli_btn_url', 'value' => '/download', 'group' => 'home_peduli'],
        ];

        $count = 0;
        foreach ($defaults as $item) {
            $existing = SiteSetting::where('key', $item['key'])->first();
            if (!$existing) {
                SiteSetting::create($item);
                $count++;
            }
        }

        $this->command->info("SiteSettingSeeder executed: {$count} newly created keys.");
    }
}
