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

            // Beranda Umum & Header
            ['key' => 'home_tentang_badge', 'value' => 'Tentang Organisasi', 'group' => 'home_tentang'],
            ['key' => 'home_tentang_title', 'value' => 'Tentang HIMATIKA FMIPA UNUJA', 'group' => 'home_tentang'],
            ['key' => 'home_tentang_desc', 'value' => 'Mengenal wadah persatuan, pengembangan intelektual, dan ruang tumbuh bersama seluruh mahasiswa Program Studi Matematika FMIPA Universitas Nurul Jadid.', 'group' => 'home_tentang'],
            ['key' => 'home_sambutan_summary', 'value' => 'Selamat datang di website resmi HIMATIKA FMIPA Universitas Nurul Jadid. Wadah resmi komunikasi, transparansi kegiatan, dan publikasi prestasi mahasiswa Matematika.', 'group' => 'home_tentang'],
            ['key' => 'home_sambutan_btn_text', 'value' => 'Baca Sambutan Lengkap', 'group' => 'home_tentang'],
            ['key' => 'home_sambutan_btn_url', 'value' => '/sambutan', 'group' => 'home_tentang'],
            ['key' => 'home_berita_badge', 'value' => 'KABAR TERBARU', 'group' => 'home_berita'],
            ['key' => 'home_berita_title', 'value' => 'Berita & Informasi Terkini', 'group' => 'home_berita'],
            ['key' => 'home_berita_desc', 'value' => 'Ikuti perkembangan terbaru seputar kegiatan akademik, prestasi mahasiswa, dan pengumuman resmi HIMATIKA.', 'group' => 'home_berita'],
            ['key' => 'home_berita_btn_text', 'value' => 'Lihat Semua Berita', 'group' => 'home_berita'],
            ['key' => 'home_berita_btn_url', 'value' => '/berita', 'group' => 'home_berita'],
            ['key' => 'home_galeri_badge', 'value' => 'DOKUMENTASI KEGIATAN', 'group' => 'home_momen'],
            ['key' => 'home_galeri_title', 'value' => 'Dokumentasi Momen HIMATIKA', 'group' => 'home_momen'],
            ['key' => 'home_galeri_desc', 'value' => 'Potret semangat kebersamaan, dedikasi, dan berbagai kegiatan bermakna keluarga besar HIMATIKA FMIPA UNUJA.', 'group' => 'home_momen'],
            ['key' => 'home_galeri_btn_text', 'value' => 'Lihat Galeri Foto', 'group' => 'home_momen'],
            ['key' => 'home_galeri_btn_url', 'value' => '/galeri', 'group' => 'home_momen'],

            // Sambutan Kaprodi
            ['key' => 'sambutan_badge', 'value' => 'PESAN PIMPINAN', 'group' => 'tentang'],
            ['key' => 'sambutan_banner_title', 'value' => 'Sambutan Kaprodi', 'group' => 'tentang'],
            ['key' => 'sambutan_name', 'value' => 'MUDAKKIR, S.Pd., MM.', 'group' => 'tentang'],
            ['key' => 'sambutan_title', 'value' => 'Ketua Program Studi Matematika', 'group' => 'tentang'],

            // Sejarah
            ['key' => 'history_title', 'value' => 'Sejarah MAN 1 PROBOLINGGO', 'group' => 'tentang'],
            ['key' => 'history_doc_text', 'value' => 'Lihat Galeri', 'group' => 'tentang'],
            ['key' => 'history_doc_url', 'value' => '/galeri', 'group' => 'tentang'],
            ['key' => 'history_doc_desc', 'value' => 'Jelajahi dokumentasi dan arsip sejarah perjalanan MAN 1 PROBOLINGGO dalam galeri kami.', 'group' => 'tentang'],

            // Identitas & Footer
            ['key' => 'site_short_title', 'value' => 'HIMATIKA', 'group' => 'identitas'],
            ['key' => 'footer_copyright', 'value' => '© 2026 HIMATIKA UNUJA 2026.', 'group' => 'footer'],
            ['key' => 'footer_managed_by', 'value' => 'Dikelola oleh Tim Website HIMATIKA', 'group' => 'footer'],
            ['key' => 'whatsapp_number', 'value' => '6281234567890', 'group' => 'footer'],
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

