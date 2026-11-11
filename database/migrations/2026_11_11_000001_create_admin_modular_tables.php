<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Gallery photos for multi-photo albums
        if (!Schema::hasTable('gallery_photos')) {
            Schema::create('gallery_photos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('gallery_id')->constrained('galleries')->onDelete('cascade');
                $table->string('image');
                $table->string('caption')->nullable();
                $table->string('alt_text')->nullable();
                $table->integer('order_num')->default(0);
                $table->timestamps();
            });
        }

        // 2. Categories table
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug');
                $table->string('type')->default('informasi'); // informasi, download
                $table->integer('order_num')->default(0);
                $table->timestamps();
            });

            // Seed default information categories
            $infoCats = ['Semua Kategori', 'Kegiatan', 'Pengumuman', 'Prestasi', 'Berita', 'Agenda'];
            foreach ($infoCats as $idx => $cat) {
                if ($cat !== 'Semua Kategori') {
                    DB::table('categories')->insert([
                        'name' => $cat,
                        'slug' => Str::slug($cat),
                        'type' => 'informasi',
                        'order_num' => $idx,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Seed default download categories
            $downCats = ['Karya Website', 'Panduan & SOP', 'Formulir & Dokumen', 'Akademik'];
            foreach ($downCats as $idx => $cat) {
                DB::table('categories')->insert([
                    'name' => $cat,
                    'slug' => Str::slug($cat),
                    'type' => 'download',
                    'order_num' => $idx,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 3. Navigation menus table
        if (!Schema::hasTable('nav_menus')) {
            Schema::create('nav_menus', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('parent_id')->nullable()->index();
                $table->string('label');
                $table->string('url')->default('#');
                $table->string('icon')->nullable();
                $table->integer('order_num')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });

            // Seed default nav items matching website structure
            $berandaId = DB::table('nav_menus')->insertGetId([
                'label' => 'Beranda',
                'url' => '/',
                'icon' => 'fas fa-home',
                'order_num' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $tentangId = DB::table('nav_menus')->insertGetId([
                'label' => 'Tentang',
                'url' => '/profil',
                'icon' => 'fas fa-info-circle',
                'order_num' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('nav_menus')->insert([
                ['parent_id' => $tentangId, 'label' => 'Sejarah', 'url' => '/sejarah', 'icon' => 'fas fa-landmark', 'order_num' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['parent_id' => $tentangId, 'label' => 'Sambutan Kaprodi', 'url' => '/sambutan', 'icon' => 'fas fa-user-tie', 'order_num' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['parent_id' => $tentangId, 'label' => 'Visi dan Misi', 'url' => '/visi-misi', 'icon' => 'fas fa-bullseye', 'order_num' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['parent_id' => $tentangId, 'label' => 'Struktur Organisasi', 'url' => '/struktur-organisasi', 'icon' => 'fas fa-sitemap', 'order_num' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $informasiId = DB::table('nav_menus')->insertGetId([
                'label' => 'Informasi',
                'url' => '/berita',
                'icon' => 'fas fa-newspaper',
                'order_num' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('nav_menus')->insert([
                ['parent_id' => $informasiId, 'label' => 'Semua Kategori', 'url' => '/berita', 'icon' => 'fas fa-th-large', 'order_num' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['parent_id' => $informasiId, 'label' => 'Kegiatan', 'url' => '/berita?kategori=Kegiatan', 'icon' => 'fas fa-running', 'order_num' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['parent_id' => $informasiId, 'label' => 'Pengumuman', 'url' => '/berita?kategori=Pengumuman', 'icon' => 'fas fa-bullhorn', 'order_num' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['parent_id' => $informasiId, 'label' => 'Prestasi', 'url' => '/berita?kategori=Prestasi', 'icon' => 'fas fa-trophy', 'order_num' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['parent_id' => $informasiId, 'label' => 'Berita', 'url' => '/berita?kategori=Berita', 'icon' => 'fas fa-newspaper', 'order_num' => 5, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['parent_id' => $informasiId, 'label' => 'Agenda', 'url' => '/berita?kategori=Agenda', 'icon' => 'fas fa-calendar-alt', 'order_num' => 6, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);

            DB::table('nav_menus')->insert([
                ['parent_id' => null, 'label' => 'Galeri', 'url' => '/galeri', 'icon' => 'fas fa-images', 'order_num' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['parent_id' => null, 'label' => 'Galeri Website', 'url' => '/download', 'icon' => 'fas fa-laptop-code', 'order_num' => 5, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['parent_id' => null, 'label' => 'Aspirasi', 'url' => '/aspirasi', 'icon' => 'fas fa-comment-dots', 'order_num' => 6, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['parent_id' => null, 'label' => 'Kontak', 'url' => '/kontak', 'icon' => 'fas fa-phone-alt', 'order_num' => 7, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // 4. Site settings table (flexible key-value store avoiding MySQL row size limits)
        if (!Schema::hasTable('site_settings')) {
            Schema::create('site_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key', 100)->unique();
                $table->longText('value')->nullable();
                $table->string('group', 50)->default('general');
                $table->timestamps();
            });

            // Seed default settings matching current content
            $defaults = [
                // Logos per location
                'logo_alt_text' => 'Logo HIMATIKA UNUJA',
                'use_custom_logo_navbar_desktop' => '0',
                'logo_navbar_desktop' => '',
                'use_custom_logo_navbar_mobile' => '0',
                'logo_navbar_mobile' => '',
                'use_custom_logo_footer' => '0',
                'logo_footer' => '',
                'use_custom_logo_admin_login' => '0',
                'logo_admin_login' => '',
                'use_custom_logo_admin_sidebar' => '0',
                'logo_admin_sidebar' => '',

                // Hero buttons visibility & extra config
                'hero_btn_primary_active' => '1',
                'hero_btn_secondary_active' => '1',

                // Beranda: Tentang HIMATIKA section
                'home_tentang_badge' => 'Tentang Organisasi',
                'home_tentang_title' => 'Tentang HIMATIKA',
                'home_tentang_desc' => 'Mengenal wadah persatuan, pengembangan intelektual, dan ruang tumbuh bersama seluruh mahasiswa Program Studi Matematika FMIPA Universitas Nurul Jadid.',
                'home_sambutan_summary' => 'Sambutan resmi dari pimpinan dan Ketua Program Studi Matematika Universitas Nurul Jadid mengenai arah, visi, dan semangat pengembangan mahasiswa di era digital.',
                'home_sambutan_btn_text' => 'Baca Sambutan Selengkapnya',
                'home_sambutan_btn_url' => '/sambutan',
                'home_struktur_summary' => 'Struktur kepengurusan resmi HIMATIKA UNUJA 2026 yang terbagi dalam divisi Putra dan Putri dengan komitmen kolaborasi, transparansi, dan sinergi.',
                'home_struktur_btn_text' => 'Lihat Struktur Lengkap',
                'home_struktur_btn_url' => '/struktur-organisasi',

                // Beranda: Berita section
                'home_berita_badge' => 'INFORMASI TERBARU',
                'home_berita_title' => 'Kabar & Informasi Terkini',
                'home_berita_desc' => 'Ikuti perkembangan terbaru, pengumuman penting, liputan kegiatan, dan kabar prestasi seputar mahasiswa Matematika UNUJA.',
                'home_berita_btn_text' => 'Lihat Semua Berita',
                'home_berita_btn_url' => '/berita',
                'home_featured_news_id' => '',

                // Beranda: HIMATIKA Berdampak / Peduli
                'home_peduli_badge' => 'HIMATIKA BERDAMPAK',
                'home_peduli_title' => 'Mengabdi dengan Hati, Berkontribusi Nyata',
                'home_peduli_desc' => 'Melalui berbagai inisiatif sosial, pelatihan, dan pengabdian masyarakat, mahasiswa Matematika terus aktif menebarkan manfaat di dalam dan luar kampus.',
                'home_peduli_btn_text' => 'Lihat Semua Prestasi',
                'home_peduli_btn_url' => '/prestasi',
                'home_peduli_stat1_num' => '10+',
                'home_peduli_stat1_label' => 'Program Sosial & Edukasi',
                'home_peduli_stat2_num' => '500+',
                'home_peduli_stat2_label' => 'Penerima Manfaat',
                'home_peduli_stat3_num' => '100%',
                'home_peduli_stat3_label' => 'Dedikasi Mahasiswa',

                // Beranda: Dokumentasi Momen
                'home_galeri_badge' => 'DOKUMENTASI MOMEN',
                'home_galeri_title' => 'Jejak Langkah & Kebersamaan',
                'home_galeri_desc' => 'Setiap momen kebersamaan dan perjuangan terabadikan dalam galeri resmi kegiatan HIMATIKA.',
                'home_galeri_btn_text' => 'Buka Galeri Foto',
                'home_galeri_btn_url' => '/galeri',
                'home_featured_gallery_id' => '',

                // Sejarah
                'history_title' => 'Sejarah HIMATIKA UNUJA',
                'history_subtitle' => 'Perjalanan panjang himpunan mahasiswa dalam mengabdi dan berkarya',
                'history_image' => '',
                'history_doc_url' => '/galeri',
                'history_doc_text' => 'Dokumentasi Sejarah',

                // Sambutan
                'sambutan_name' => 'MUDDAKKIR, S.Pd., MM.',
                'sambutan_title' => 'Ketua Program Studi Matematika',
                'sambutan_quote' => 'Mewujudkan generasi unggul yang beriman, berilmu, dan berakhlak mulia.',

                // Struktur mode
                'structure_chart_mode' => 'interactive',
                'structure_chart_image' => '',

                // Galeri Page Settings
                'gallery_page_badge' => 'GALERI',
                'gallery_page_title' => 'Momen HIMATIKA UNUJA',
                'gallery_page_desc' => 'Dokumentasi kegiatan yang memperlihatkan semangat, kolaborasi, dan capaian HIMATIKA',

                // Dokumen Page Settings
                'download_page_badge' => 'DOKUMEN & KARYA',
                'download_page_title' => 'Karya Website Mahasiswa & Berkas',
                'download_page_desc' => 'Kumpulan karya website inovatif hasil cipta mahasiswa Matematika UNUJA beserta dokumen resmi',

                // Aspirasi Form Settings
                'aspiration_intro_title' => 'Kanal Aspirasi Mahasiswa',
                'aspiration_intro_desc' => 'Sampaikan kritik, saran, gagasan, dan aspirasi Anda secara konstruktif untuk kemajuan bersama.',
                'aspiration_btn_text' => 'Kirimkan Aspirasi',
                'aspiration_success_message' => 'Aspirasi Anda berhasil dikirim dan akan segera ditinjau oleh pengurus HIMATIKA.',

                // Footer settings
                'footer_copyright' => '© 2026 HIMATIKA FMIPA Universitas Nurul Jadid. Seluruh hak cipta dilindungi.',
                'footer_map_embed' => '',
            ];

            foreach ($defaults as $k => $v) {
                DB::table('site_settings')->insert([
                    'key' => $k,
                    'value' => $v,
                    'group' => 'system',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 5. Downloads table: add preview_image, year, order_num for student websites
        Schema::table('downloads', function (Blueprint $table) {
            if (!Schema::hasColumn('downloads', 'preview_image')) {
                $table->string('preview_image')->nullable()->after('file_type');
            }
            if (!Schema::hasColumn('downloads', 'year')) {
                $table->string('year', 10)->nullable()->default('2026')->after('author_name');
            }
            if (!Schema::hasColumn('downloads', 'order_num')) {
                $table->integer('order_num')->default(0)->after('status');
            }
        });
    }

    public function down(): void
    {
        // Safe reversible migration
    }
};
