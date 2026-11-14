@extends('layouts.app')

@section('content')

{{-- ==================== BAGIAN 1: SAMPUL (HERO) ==================== --}}
<section class="hero-modern-section" id="hero">
    {{-- Background Campus Photo with Bright, Visible Architecture --}}
    <div class="hero-bg-photo-wrapper" aria-hidden="true">
        <img src="{{ asset('images/hero-bg-unuja.jpg') }}" alt="Kampus UNUJA" class="hero-bg-photo">
        <div class="hero-bg-photo-overlay"></div>
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center hero-grid-row gx-lg-5 gy-5 gy-lg-0">
            {{-- Left Content (~48% on desktop) --}}
            <div class="col-lg-5 hero-col-content">
                {{-- Badge Capsule & Companion Text --}}
                <div class="hero-badge-container mb-3">
                    <div class="hero-navy-capsule">
                        <i class="fas fa-graduation-cap me-1"></i>
                        <span>{{ $profile->hero_badge ?? 'HIMATIKA UNUJA' }}</span>
                    </div>
                    <div class="hero-tag-companion">
                        <span class="hero-tag-vbar"></span>
                        <span>{{ !empty($profile->hero_tagline) ? $profile->hero_tagline : 'Grow with himatika' }}</span>
                    </div>
                </div>

                {{-- Main Title --}}
                <h1 class="hero-main-title">
                    {!! nl2br(e($profile->hero_title ?? "Ruang Berkarya\nMahasiswa Informatika")) !!}
                </h1>

                <p class="hero-new-desc">
                    {{ $profile->hero_desc ?? 'Temukan kegiatan, layanan, dan karya HIMATIKA UNUJA.' }}
                </p>

                {{-- Action Buttons: Horizontal Pill Buttons Matching Mockup --}}
                <div class="hero-horizontal-buttons">
                    @if(($profile->hero_btn_primary_active ?? 1) == 1)
                        <a href="{{ !empty($profile->hero_btn_primary_url) ? url($profile->hero_btn_primary_url) : route('kontak') }}" class="btn-hero-pill">
                            <span>{{ $profile->hero_btn_primary_text ?? 'Hubungi Kami' }}</span>
                            <i class="fas fa-caret-right"></i>
                        </a>
                    @endif
                    @if(($profile->hero_btn_secondary_active ?? 1) == 1)
                        <a href="{{ ($profile->hero_btn_secondary_url && $profile->hero_btn_secondary_url !== '/profil') ? url($profile->hero_btn_secondary_url) : route('profil') }}" class="btn-hero-pill">
                            <span>{{ $profile->hero_btn_secondary_text ?? 'Pelajari Profil' }}</span>
                            <i class="fas fa-caret-right"></i>
                        </a>
                    @endif
                </div>

                {{-- 4 Foto Terbaru di Pinggir Kiri: Logo + 3 Dokumentasi Terkini --}}
                @if(!empty($heroRecentPhotos) && count($heroRecentPhotos) > 0)
                    <div class="hero-recent-preview-group mt-4 pt-1">
                        <div class="hero-recent-avatars-row">
                            <div class="hero-avatar-stack" aria-label="Foto & Informasi Terkini HIMATIKA">
                                @foreach($heroRecentPhotos as $idx => $photoItem)
                                    <a href="{{ $photoItem['url'] }}" 
                                       class="hero-avatar-item" 
                                       title="[{{ $photoItem['category'] }}] {{ $photoItem['title'] }}"
                                       data-bs-toggle="tooltip" 
                                       data-bs-placement="top"
                                       style="z-index: {{ 10 - $idx }};">
                                        <img src="{{ $photoItem['photo'] }}" alt="{{ $photoItem['title'] }}" loading="lazy">
                                    </a>
                                @endforeach
                            </div>
                            <div class="hero-recent-text">
                                <span class="hero-recent-headline">Update Terkini</span>
                                <span class="hero-recent-subline">Berita • Prestasi • Agenda • Kegiatan</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right Visual: Single Hero Photo Pengurus HIMATIKA --}}
            <div class="col-lg-7 hero-col-visual">
                <div class="hero-frame-wrapper">
                    <div class="hero-visual-frame">
                        @php
                            $heroPengurusPhoto = file_exists(public_path('storage/news/news_1794407889_gb5rjeODz5yqGHUwbWhGZ34Odvvpuo9LrKyJBBhM.png'))
                                ? asset('storage/news/news_1794407889_gb5rjeODz5yqGHUwbWhGZ34Odvvpuo9LrKyJBBhM.png')
                                : asset('images/news/news-1.jpg');
                        @endphp
                        <img src="{{ $heroPengurusPhoto }}" alt="Pengurus HIMATIKA UNUJA" class="hero-single-img">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== BAGIAN 2: TENTANG HIMATIKA ==================== --}}
<section class="section-tentang-himatika" id="tentang">
    <div class="container">
        {{-- Section Header --}}
        <div class="tentang-header-area">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-2">
                <div class="tentang-top-label mb-0">
                    <span class="tentang-label-bar"></span>
                    <span>{{ $siteSettings['home_tentang_badge'] ?? 'Tentang Organisasi' }}</span>
                </div>
                <a href="{{ route('profil') }}" class="btn-tentang-outline py-1 px-3" style="border-radius: 9999px; font-size: 0.8rem; text-decoration: none;">
                    <span>Halaman Profil Lengkap</span>
                    <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <h2 class="tentang-main-title">
                {{ $siteSettings['home_tentang_title'] ?? 'Tentang HIMATIKA' }}
            </h2>
            <p class="tentang-main-desc">
                {{ $siteSettings['home_tentang_desc'] ?? 'Mengenal wadah persatuan, pengembangan intelektual, dan ruang tumbuh bersama seluruh mahasiswa Program Studi Matematika FMIPA Universitas Nurul Jadid.' }}
            </p>
        </div>

        {{-- 2 Balanced Cards (Desktop Side-by-Side, Mobile Stacked) --}}
        <div class="row g-4 align-items-stretch">
            {{-- Card Kiri: Sambutan Kaprodi --}}
            <div class="col-lg-6">
                <div class="tentang-card sambutan-home-card">
                    <div>
                        <div class="sambutan-ref-badge-wrap mb-2">
                            <span class="sambutan-ref-bar"></span>
                            <span class="sambutan-ref-badge-text">{{ $siteSettings['sambutan_badge'] ?? 'PESAN PIMPINAN' }}</span>
                        </div>
                        <h3 class="sambutan-ref-home-title mb-3">
                            Sambutan <span class="sambutan-title-accent">Kaprodi</span>
                        </h3>

                        @php
                            $kaprodiName = !empty($siteSettings['sambutan_name']) ? $siteSettings['sambutan_name'] : ($kaprodi->name ?? 'MUDAKKIR, S.Pd., MM.');
                            $kaprodiRole = !empty($siteSettings['sambutan_title']) ? $siteSettings['sambutan_title'] : ($kaprodi->position ?? 'Ketua Program Studi Matematika');
                            $kaprodiQuote = !empty($siteSettings['sambutan_quote']) ? $siteSettings['sambutan_quote'] : ($siteSettings['home_sambutan_summary'] ?? ($kaprodi->bio ?? 'Puji syukur ke hadirat Allah SWT atas segala limpahan rahmat dan karunia-Nya sehingga website resmi HIMATIKA dapat hadir sebagai media informasi dan komunikasi bagi seluruh civitas akademika, mahasiswa, alumni, serta masyarakat luas.'));
                            
                            $kaprodiPhoto = null;
                            if (!empty($siteSettings['sambutan_photo']) && file_exists(public_path('storage/' . $siteSettings['sambutan_photo']))) {
                                $kaprodiPhoto = asset('storage/' . $siteSettings['sambutan_photo']);
                            } elseif ($kaprodi && $kaprodi->photo && file_exists(public_path('storage/' . $kaprodi->photo))) {
                                $kaprodiPhoto = asset('storage/' . $kaprodi->photo);
                            } else {
                                $kaprodiPhoto = asset('storage/profile/sambutan_1794400568_4jRmDkAS3by8fJdumt7yXqA03XvRNJdCIiK1z8KM.png');
                            }
                        @endphp

                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-sm-4 col-5">
                                <div class="sambutan-portrait-frame-sm">
                                    <img src="{{ $kaprodiPhoto }}" alt="{{ $kaprodiName }}" class="sambutan-ref-photo-img">
                                </div>
                            </div>
                            <div class="col-sm-8 col-7">
                                <div class="sambutan-italic-preview mb-2">
                                    “{{ Str::limit(strip_tags($kaprodiQuote), 160) }}”
                                </div>
                                <div class="sambutan-ref-divider-sm my-2"></div>
                                <div class="sambutan-ref-sig-name">{{ $kaprodiName }}</div>
                                <div class="sambutan-ref-sig-role">{{ $kaprodiRole }}</div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <a href="{{ !empty($siteSettings['home_sambutan_btn_url']) ? url($siteSettings['home_sambutan_btn_url']) : route('sambutan') }}" class="btn-tentang-outline w-100">
                            <span>{{ $siteSettings['home_sambutan_btn_text'] ?? 'Baca Sambutan Selengkapnya' }}</span>
                            <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Card Kanan: Visi dan Misi --}}
            <div class="col-lg-6">
                <div class="tentang-card h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="sambutan-ref-badge-wrap mb-2">
                            <span class="sambutan-ref-bar"></span>
                            <span class="sambutan-ref-badge-text">{{ $siteSettings['home_visi_badge'] ?? 'PEDOMAN ORGANISASI' }}</span>
                        </div>
                        <h3 class="sambutan-ref-home-title mb-3">
                            Visi &amp; <span class="sambutan-title-accent">Misi HIMATIKA</span>
                        </h3>

                        {{-- Tata Letak 2 Kolom Horizontal (VISI di Kiri, Garis Vertikal Emas di Tengah, MISI di Kanan) --}}
                        <div class="vm-two-col-wrap mb-4">
                            {{-- BAGIAN KIRI — VISI --}}
                            <div class="vm-col-left">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge" style="background: #C59B27; color: #fff; font-size: 0.72rem; font-weight: 700; letter-spacing: 1.2px; padding: 4px 10px; border-radius: 4px;">VISI</span>
                                        <span class="fw-bold text-dark" style="font-size: 0.95rem; letter-spacing: 0.2px;">Visi Utama</span>
                                    </div>
                                    <small class="text-muted" style="font-size: 0.72rem;"><i class="fas fa-compass me-1 text-warning"></i> Pedoman</small>
                                </div>
                                <div class="vm-visi-content-box">
                                    <div class="vm-visi-quote-icon mb-2">
                                        <i class="fas fa-quote-left"></i>
                                    </div>
                                    <p class="mb-0 vm-visi-quote-text">
                                        “{{ $vm?->vision ?? ($siteSettings['home_visi_summary'] ?? 'Menjadi organisasi mahasiswa Matematika yang aktif, inovatif, kolaboratif, dan unggul dalam pengembangan ilmu matematika serta sumber daya mahasiswa.') }}”
                                    </p>
                                    <div class="mt-3 pt-2" style="border-top: 1px solid rgba(233, 205, 213, 0.6);">
                                        <small class="text-muted" style="font-size: 0.72rem;"><i class="fas fa-bullseye me-1 text-primary"></i> Arah &amp; Cita-cita Strategis</small>
                                    </div>
                                </div>
                            </div>

                            {{-- BAGIAN TENGAH — GARIS PEMISAH VERTIKAL (EMAS) --}}
                            <div class="vm-divider-center" aria-hidden="true"></div>

                            {{-- GARIS PEMISAH HORIZONTAL (KHUSUS ANDROID / LAYAR KECIL) --}}
                            <div class="vm-divider-horizontal-mobile" aria-hidden="true"></div>

                            {{-- BAGIAN KANAN — MISI --}}
                            <div class="vm-col-right">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="badge" style="background: var(--burgundy-main); color: #fff; font-size: 0.72rem; font-weight: 700; letter-spacing: 1.2px; padding: 4px 10px; border-radius: 4px;">MISI</span>
                                    <span class="fw-bold text-dark" style="font-size: 0.95rem; letter-spacing: 0.2px;">Misi Organisasi</span>
                                </div>
                                <div class="d-flex flex-column gap-2 vm-misi-list">
                                    @foreach($missions ?? [] as $idx => $m)
                                        <div class="d-flex align-items-start gap-2">
                                            <span class="vm-num-bullet">{{ $idx + 1 }}</span>
                                            <span class="vm-misi-item-text">{{ $m }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <a href="{{ !empty($siteSettings['home_visi_btn_url']) ? url($siteSettings['home_visi_btn_url']) : route('visi-misi') }}" class="btn-tentang-primary w-100">
                            <i class="fas fa-bullseye me-1"></i>
                            <span>{{ $siteSettings['home_visi_btn_text'] ?? 'Lihat Visi & Misi Selengkapnya' }}</span>
                            <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== BAGIAN 3: BERITA & INFORMASI TERKINI ==================== --}}
<section class="section-berita-modern" id="kabar-terbaru">
    <div class="container">
        {{-- Section Header --}}
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
            <div>
                <div class="berita-top-label">
                    <span class="berita-label-bar"></span>
                    <span>{{ $siteSettings['home_berita_badge'] ?? 'Kabar & Artikel' }}</span>
                </div>
                <h2 class="berita-main-title">
                    {{ $siteSettings['home_berita_title'] ?? 'Berita & Informasi Terkini' }}
                </h2>
                @if(!empty($siteSettings['home_berita_desc']))
                    <p class="text-muted mb-0 mt-1 small" style="max-width: 600px;">
                        {{ $siteSettings['home_berita_desc'] }}
                    </p>
                @endif
            </div>
            <div>
                <a href="{{ !empty($siteSettings['home_berita_btn_url']) ? url($siteSettings['home_berita_btn_url']) : route('berita') }}" class="btn-semua-artikel">
                    <span>{{ $siteSettings['home_berita_btn_text'] ?? 'Lihat Semua Artikel' }}</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        @php
            $featuredNews = $news->first();
            $sideNews = $news->slice(1, 2);
            $bottomNews = $news->slice(3, 3);

            $getNewsThumb = function($item, $defaultIndex) {
                if ($item) {
                    $thumb = $item->thumbnail ?? $item->image;
                    if ($thumb) {
                        if (file_exists(public_path('storage/' . $thumb))) {
                            return asset('storage/' . $thumb);
                        }
                        if (file_exists(public_path('images/' . $thumb))) {
                            return asset('images/' . $thumb);
                        }
                        if (file_exists(public_path($thumb))) {
                            return asset($thumb);
                        }
                        return asset('storage/' . $thumb);
                    }
                }
                if (file_exists(public_path('images/news/news-' . $defaultIndex . '.jpg'))) {
                    return asset('images/news/news-' . $defaultIndex . '.jpg');
                }
                return asset('images/berita-placeholder.svg');
            };
        @endphp

        {{-- ROW 1: Featured Card (Left) + 2 Stacked Cards (Right) --}}
        <div class="row g-4 mb-4">
            {{-- Big Featured Card --}}
            <div class="col-lg-7">
                @if($featuredNews)
                    <a href="{{ $featuredNews->url }}" class="news-featured-card">
                        <img src="{{ $getNewsThumb($featuredNews, 1) }}" alt="{{ $featuredNews->title }}" class="news-featured-bg">
                        <div class="news-featured-overlay"></div>
                        <div class="news-featured-content">
                            <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                <span class="badge-featured-cat">
                                    <i class="fas fa-bookmark"></i>
                                    {{ $featuredNews->category ?? 'Berita' }}
                                </span>
                                <span class="badge-featured-date">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $featuredNews->published_at ? \Carbon\Carbon::parse($featuredNews->published_at)->format('d M Y') : '' }}
                                </span>
                            </div>
                            <h3 class="news-featured-title">{{ $featuredNews->title }}</h3>
                            <p class="news-featured-excerpt">{{ Str::limit(strip_tags($featuredNews->excerpt ?: $featuredNews->content), 130) }}</p>
                            <div class="news-featured-meta">
                                @if(isset($featuredNews->views) && $featuredNews->views !== null)
                                    <span class="featured-meta-views">
                                        <i class="far fa-eye"></i> {{ number_format($featuredNews->views) }} dilihat
                                    </span>
                                @else
                                    <span class="featured-meta-views">
                                        <i class="far fa-bookmark"></i> {{ $featuredNews->category }}
                                    </span>
                                @endif
                                <span class="featured-readmore">
                                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                @else
                    <div class="p-5 bg-white rounded-4 border text-center text-muted">
                        <i class="far fa-newspaper fa-3x mb-3 text-secondary"></i>
                        <p class="mb-0">Belum ada artikel atau berita yang dipublikasikan.</p>
                    </div>
                @endif
            </div>

            {{-- 2 Stacked Cards --}}
            <div class="col-lg-5">
                <div class="d-flex flex-column gap-3 h-100 justify-content-between">
                    @forelse($sideNews as $idx => $sNews)
                        <a href="{{ $sNews->url }}" class="news-horizontal-card">
                            <div class="news-horizontal-thumb">
                                <img src="{{ $getNewsThumb($sNews, $loop->iteration + 1) }}" alt="{{ $sNews->title }}">
                            </div>
                            <div class="news-horizontal-info">
                                <span class="news-tag-outline">{{ $sNews->category ?? 'Berita' }}</span>
                                <h4 class="news-horizontal-title">{{ $sNews->title }}</h4>
                                <div class="news-horizontal-meta">
                                    <span class="news-meta-date">
                                        <i class="far fa-calendar"></i>
                                        {{ $sNews->published_at ? \Carbon\Carbon::parse($sNews->published_at)->format('d M Y') : '' }}
                                    </span>
                                    @if(isset($sNews->views) && $sNews->views !== null)
                                        <span class="news-meta-views">
                                            <i class="far fa-eye"></i>
                                            {{ number_format($sNews->views) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-4 bg-white rounded-3 border text-center text-muted">
                            <p class="small mb-0">Informasi tambahan sedang dipersiapkan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ROW 2: 3 Vertical Cards --}}
        @if($bottomNews->isNotEmpty())
            <div class="row g-4">
                @foreach($bottomNews as $bIdx => $bNews)
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ $bNews->url }}" class="news-vertical-card">
                            <div class="news-vertical-img-wrap">
                                <img src="{{ $getNewsThumb($bNews, $loop->iteration + 3) }}" alt="{{ $bNews->title }}">
                                <span class="badge-floating-cat">{{ $bNews->category ?? 'Berita' }}</span>
                            </div>
                            <div class="news-vertical-body">
                                <h4 class="news-vertical-title">{{ $bNews->title }}</h4>
                                <p class="news-vertical-desc">{{ Str::limit(strip_tags($bNews->excerpt ?: $bNews->content), 95) }}</p>
                            </div>
                            <div class="news-vertical-footer">
                                <span class="news-vertical-date">
                                    <i class="far fa-calendar"></i>
                                    {{ $bNews->published_at ? \Carbon\Carbon::parse($bNews->published_at)->format('d M Y') : '' }}
                                </span>
                                <span class="news-vertical-read">
                                    Baca <i class="fas fa-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ==================== BAGIAN 4: HIMATIKA BERDAMPAK ==================== --}}
<section class="section-peduli" id="berdampak">
    <div class="peduli-bg-glow peduli-glow-1" aria-hidden="true"></div>
    <div class="peduli-bg-glow peduli-glow-2" aria-hidden="true"></div>

    <div class="container position-relative" style="z-index: 1;">
        {{-- Section Header --}}
        <div class="peduli-section-header">
            <span class="peduli-label">
                <span class="peduli-label-icon"><i class="fas fa-award"></i></span>
                {{ $siteSettings['home_peduli_badge'] ?? 'KARYA & KONTRIBUSI' }}
            </span>
        </div>

        <div class="peduli-main-grid">
            {{-- Kolom Kiri: Teks Pengantar --}}
            <div class="peduli-text-col">
                <h2 class="peduli-heading">{{ $siteSettings['home_peduli_title'] ?? 'HIMATIKA Berdampak' }}</h2>
                <p class="peduli-desc">
                    {{ $siteSettings['home_peduli_desc'] ?? 'Mengenal karya, kegiatan, dan kontribusi HIMATIKA yang memberikan manfaat bagi mahasiswa dan lingkungan sekitar.' }}
                </p>
                <a href="{{ !empty($siteSettings['home_peduli_btn_url']) ? url($siteSettings['home_peduli_btn_url']) : route('prestasi') }}" class="peduli-cta">
                    <span>{{ $siteSettings['home_peduli_btn_text'] ?? 'Jelajahi karya & prestasi' }}</span>
                    <span class="peduli-cta-arrow"><i class="fas fa-arrow-right"></i></span>
                </a>
            </div>

            {{-- Kolom Tengah: Card Hasil Nyata & Kontribusi --}}
            <div class="peduli-collage-col">
                <div class="d-flex flex-column h-100 justify-content-center">
                    @forelse($achievements->take(2) as $ach)
                        <div class="berdampak-item-card">
                            <div class="berdampak-item-header">
                                <span class="berdampak-tag"><i class="fas fa-trophy text-warning me-1"></i> {{ $ach->rank ?? 'Prestasi' }}</span>
                                <small class="text-white-50">{{ $ach->year }}</small>
                            </div>
                            <h4 class="berdampak-item-title">{{ $ach->title }}</h4>
                            <p class="berdampak-item-desc">Tingkat {{ $ach->level ?? 'Nasional' }} &bull; Kontribusi keilmuan mahasiswa Matematika UNUJA.</p>
                        </div>
                    @empty
                        <div class="berdampak-item-card">
                            <div class="berdampak-item-header">
                                <span class="berdampak-tag"><i class="fas fa-laptop-code text-info me-1"></i> Karya Digital</span>
                            </div>
                            <h4 class="berdampak-item-title">Galeri Website Mahasiswa</h4>
                            <p class="berdampak-item-desc">Wadah dokumentasi dan portofolio karya digital mahasiswa Matematika UNUJA.</p>
                        </div>
                    @endforelse

                    @if($activities->isNotEmpty())
                        @php $firstAct = $activities->first(); @endphp
                        <div class="berdampak-item-card">
                            <div class="berdampak-item-header">
                                <span class="berdampak-tag"><i class="fas fa-calendar-check text-success me-1"></i> Program Terlaksana</span>
                                <small class="text-white-50">{{ $firstAct->date ? \Carbon\Carbon::parse($firstAct->date)->format('Y') : '2026' }}</small>
                            </div>
                            <h4 class="berdampak-item-title">{{ $firstAct->title }}</h4>
                            <p class="berdampak-item-desc">{{ Str::limit(strip_tags($firstAct->description), 90) ?: 'Program pengembangan kompetensi akademik dan soft-skill mahasiswa.' }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Kolom Kanan: Stat Card (Data Nyata) --}}
            <div class="peduli-stat-col">
                <div class="peduli-stat-card">
                    <span class="peduli-stat-label">DAMPAK & PRESTASI</span>
                    <div class="peduli-stat-number-wrap">
                        <span class="peduli-stat-number">{{ !empty($siteSettings['home_peduli_stat1_num']) ? $siteSettings['home_peduli_stat1_num'] : (($totalAchievements ?? 3) . '+') }}</span>
                    </div>
                    <span class="peduli-stat-text">{{ !empty($siteSettings['home_peduli_stat1_label']) ? $siteSettings['home_peduli_stat1_label'] : 'prestasi resmi terdata' }}</span>

                    <div class="mt-3 pt-3 border-top border-white border-opacity-10 w-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="small text-white-50">{{ !empty($siteSettings['home_peduli_stat2_label']) ? $siteSettings['home_peduli_stat2_label'] : 'Kegiatan Terlaksana' }}</div>
                            <div class="fw-bold fs-6 text-white">{{ !empty($siteSettings['home_peduli_stat2_num']) ? $siteSettings['home_peduli_stat2_num'] : (($totalActivities ?? 5) . '+') }}</div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="small text-white-50">{{ !empty($siteSettings['home_peduli_stat3_label']) ? $siteSettings['home_peduli_stat3_label'] : 'Dedikasi Mahasiswa' }}</div>
                            <div class="fw-bold fs-6 text-white">{{ !empty($siteSettings['home_peduli_stat3_num']) ? $siteSettings['home_peduli_stat3_num'] : '100%' }}</div>
                        </div>
                    </div>

                    <a href="{{ !empty($siteSettings['home_peduli_btn_url']) ? url($siteSettings['home_peduli_btn_url']) : route('prestasi') }}" class="peduli-stat-btn mt-3">
                        <span>{{ $siteSettings['home_peduli_btn_text'] ?? 'Lihat Prestasi' }}</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== BAGIAN 5: DOKUMENTASI MOMEN ==================== --}}
<section class="section-dokumentasi-momen" id="dokumentasi">
    <div class="container">
        {{-- Section Header --}}
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
            <div>
                <div class="tentang-top-label">
                    <span class="tentang-label-bar"></span>
                    <span>{{ $siteSettings['home_galeri_badge'] ?? 'DOKUMENTASI MOMEN' }}</span>
                </div>
                <h2 class="tentang-main-title">
                    {{ $siteSettings['home_galeri_title'] ?? 'Jejak Langkah & Kebersamaan' }}
                </h2>
                <p class="tentang-main-desc">
                    {{ $siteSettings['home_galeri_desc'] ?? 'Setiap momen kebersamaan dan perjuangan terabadikan dalam galeri resmi kegiatan HIMATIKA.' }}
                </p>
            </div>
            <div>
                <a href="{{ !empty($siteSettings['home_galeri_btn_url']) ? url($siteSettings['home_galeri_btn_url']) : route('galeri') }}" class="btn-semua-artikel">
                    <span>{{ $siteSettings['home_galeri_btn_text'] ?? 'Buka Galeri Foto' }}</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Slider Wrapper --}}
        <div class="doc-slider-wrapper" id="docSliderWrapper">
            <div class="doc-slider-container" id="docSliderContainer">
                <div class="doc-slider-track" id="docSliderTrack">
                    @if($galleries->isNotEmpty())
                        @foreach($galleries as $gal)
                            @php
                                $galImg = null;
                                if (!empty($gal->image)) {
                                    if (file_exists(public_path('storage/' . $gal->image))) {
                                        $galImg = asset('storage/' . $gal->image);
                                    } elseif (file_exists(public_path('images/' . $gal->image))) {
                                        $galImg = asset('images/' . $gal->image);
                                    } elseif (file_exists(public_path($gal->image))) {
                                        $galImg = asset($gal->image);
                                    }
                                }
                                if (!$galImg) {
                                    $galImg = asset('images/news/news-' . (($loop->index % 4) + 1) . '.jpg');
                                }
                                $cardUrl = !empty($gal->id) ? route('galeri.show', $gal->id) : (!empty($siteSettings['home_galeri_btn_url']) ? url($siteSettings['home_galeri_btn_url']) : route('galeri'));
                            @endphp
                            <div class="doc-slider-item">
                                <a href="{{ $cardUrl }}" class="doc-momen-card" draggable="false">
                                    <img src="{{ $galImg }}" alt="{{ $gal->alt_text ?: $gal->title }}" class="doc-momen-img" draggable="false" loading="lazy">
                                    <div class="doc-momen-overlay">
                                        <span class="doc-momen-badge">{{ $gal->activity ? $gal->activity->title : 'Dokumentasi HIMATIKA' }}</span>
                                        <h3 class="doc-momen-title">{{ $gal->title }}</h3>
                                        @if($gal->description)
                                            <p class="doc-momen-caption">{{ Str::limit($gal->description, 95) }}</p>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        @php
                            $defaultGalleryUrl = !empty($siteSettings['home_galeri_btn_url']) ? url($siteSettings['home_galeri_btn_url']) : route('galeri');
                        @endphp
                        <div class="doc-slider-item">
                            <a href="{{ $defaultGalleryUrl }}" class="doc-momen-card" draggable="false">
                                <img src="{{ asset('images/news/news-1.jpg') }}" alt="Pelantikan & Rapat Kerja HIMATIKA" class="doc-momen-img" draggable="false">
                                <div class="doc-momen-overlay">
                                    <span class="doc-momen-badge">Kegiatan Organisasi</span>
                                    <h3 class="doc-momen-title">Pelantikan & Rapat Kerja Kepengurusan 2026</h3>
                                    <p class="doc-momen-caption">Momen pelantikan pengurus HIMATIKA FMIPA UNUJA dan perumusan program kerja tahunan.</p>
                                </div>
                            </a>
                        </div>

                        <div class="doc-slider-item">
                            <a href="{{ $defaultGalleryUrl }}" class="doc-momen-card" draggable="false">
                                <img src="{{ asset('images/news/news-2.jpg') }}" alt="Seminar & Workshop Matematika" class="doc-momen-img" draggable="false">
                                <div class="doc-momen-overlay">
                                    <span class="doc-momen-badge">Akademik & Keilmuan</span>
                                    <h3 class="doc-momen-title">Seminar & Workshop Keilmuan Mahasiswa</h3>
                                    <p class="doc-momen-caption">Penguatan wawasan matematika komputasi dan analisis data terapan bagi seluruh mahasiswa.</p>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Slider Controls (Panah & Indikator Titik) --}}
            <div class="doc-slider-controls" id="docSliderControls" style="display: none;">
                <button type="button" class="doc-slider-arrow doc-slider-prev" id="docSliderPrev" aria-label="Lihat dokumentasi sebelumnya">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="doc-slider-dots" id="docSliderDots" role="tablist" aria-label="Pilih dokumentasi">
                    {{-- Dinamis dibuat oleh JavaScript --}}
                </div>
                <button type="button" class="doc-slider-arrow doc-slider-next" id="docSliderNext" aria-label="Lihat dokumentasi berikutnya">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    /* ==================== ANIMASI SLIDER DOKUMENTASI MOMEN ==================== */
    .doc-slider-wrapper {
        position: relative;
        width: 100%;
    }

    .doc-slider-container {
        overflow: hidden;
        width: 100%;
        /* Beri ruang agar bayangan dan efek hover card tidak terpotong */
        padding: 8px 4px 18px;
        margin: -8px -4px -18px;
    }

    .doc-slider-track {
        display: flex;
        gap: 24px;
        transition: transform 400ms cubic-bezier(0.25, 1, 0.5, 1);
        will-change: transform;
        touch-action: pan-y;
    }

    .doc-slider-item {
        flex: 0 0 calc((100% - 24px) / 2);
        max-width: calc((100% - 24px) / 2);
        width: calc((100% - 24px) / 2);
        box-sizing: border-box;
        user-select: none;
    }

    .doc-slider-item .doc-momen-card {
        width: 100%;
        height: 320px;
        margin: 0;
    }

    @media (max-width: 767.98px) {
        .doc-slider-item {
            flex: 0 0 100%;
            max-width: 100%;
            width: 100%;
        }
        .doc-slider-item .doc-momen-card {
            height: 280px;
        }
    }

    .doc-slider-controls {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        margin-top: 28px;
    }

    .doc-slider-arrow {
        width: 36px;
        height: 36px;
        min-width: 36px;
        border-radius: 50%;
        background: #ffffff;
        border: 1px solid rgba(113, 28, 53, 0.25);
        color: #711C35;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.85rem;
        box-shadow: 0 2px 8px rgba(113, 28, 53, 0.08);
        transition: all 0.25s ease;
        padding: 0;
        outline: none;
    }

    .doc-slider-arrow:hover {
        background: #711C35;
        color: #ffffff;
        border-color: #711C35;
        transform: scale(1.08);
        box-shadow: 0 4px 14px rgba(113, 28, 53, 0.25);
    }

    .doc-slider-arrow:focus-visible {
        outline: 2px solid #711C35;
        outline-offset: 2px;
    }

    .doc-slider-dots {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .doc-slider-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #D1D5DB;
        border: none;
        padding: 0;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        outline: none;
    }

    .doc-slider-dot:hover {
        background: #A07A86;
    }

    .doc-slider-dot.active {
        width: 24px;
        height: 8px;
        border-radius: 4px;
        background: #711C35;
        box-shadow: 0 2px 6px rgba(113, 28, 53, 0.35);
    }

    .doc-slider-dot:focus-visible {
        outline: 2px solid #711C35;
        outline-offset: 2px;
    }

    @media (prefers-reduced-motion: reduce) {
        .doc-slider-track {
            transition: none !important;
        }
        .doc-slider-arrow,
        .doc-slider-dot,
        .doc-momen-card,
        .doc-momen-img {
            transition: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('docSliderWrapper');
    if (!wrapper) return;

    const container = document.getElementById('docSliderContainer');
    const track = document.getElementById('docSliderTrack');
    const controls = document.getElementById('docSliderControls');
    const prevBtn = document.getElementById('docSliderPrev');
    const nextBtn = document.getElementById('docSliderNext');
    const dotsContainer = document.getElementById('docSliderDots');
    const items = track.querySelectorAll('.doc-slider-item');
    const totalItems = items.length;

    if (totalItems === 0) return;

    let currentIndex = 0;
    let cardsPerView = 2;
    let maxIndex = 0;
    let autoplayTimer = null;
    let isIntersecting = false;
    let isHovered = false;
    let isFocused = false;
    let isPointerActive = false;
    let suppressClick = false;

    // Cek reduced motion
    const prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function getGap() {
        return 24; // konsisten dengan bootstrap g-4
    }

    function calculateMetrics() {
        const isDesktop = window.innerWidth >= 768;
        cardsPerView = isDesktop ? 2 : 1;
        maxIndex = Math.max(0, totalItems - cardsPerView);
        if (currentIndex > maxIndex) {
            currentIndex = maxIndex;
        }
    }

    function buildDots() {
        dotsContainer.innerHTML = '';
        if (maxIndex <= 0) return;

        const count = maxIndex + 1;
        for (let i = 0; i < count; i++) {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'doc-slider-dot' + (i === currentIndex ? ' active' : '');
            dot.setAttribute('role', 'tab');
            dot.setAttribute('aria-label', 'Pindah ke slide ' + (i + 1));
            dot.setAttribute('aria-selected', i === currentIndex ? 'true' : 'false');
            dot.addEventListener('click', function(e) {
                e.preventDefault();
                goToSlide(i);
                restartAutoplay();
            });
            dotsContainer.appendChild(dot);
        }
    }

    function updateDots() {
        const dots = dotsContainer.querySelectorAll('.doc-slider-dot');
        dots.forEach((dot, idx) => {
            if (idx === currentIndex) {
                dot.classList.add('active');
                dot.setAttribute('aria-selected', 'true');
            } else {
                dot.classList.remove('active');
                dot.setAttribute('aria-selected', 'false');
            }
        });
    }

    function updateTrackPosition(withTransition = true) {
        if (!items[0]) return;
        const itemWidth = items[0].getBoundingClientRect().width;
        const gap = getGap();
        const shift = currentIndex * (itemWidth + gap);

        if (prefersReducedMotion || !withTransition) {
            track.style.transition = 'none';
        } else {
            track.style.transition = 'transform 400ms cubic-bezier(0.25, 1, 0.5, 1)';
        }

        track.style.transform = `translate3d(-${shift}px, 0, 0)`;
    }

    function updateView() {
        calculateMetrics();

        if (maxIndex <= 0) {
            controls.style.display = 'none';
            stopAutoplay();
            track.style.transform = 'translate3d(0, 0, 0)';
            return;
        }

        controls.style.display = 'flex';
        buildDots();
        updateTrackPosition(false);
    }

    function goToSlide(index, withTransition = true) {
        if (index < 0) {
            currentIndex = maxIndex;
        } else if (index > maxIndex) {
            currentIndex = 0;
        } else {
            currentIndex = index;
        }
        updateTrackPosition(withTransition);
        updateDots();
    }

    function nextSlide() {
        goToSlide(currentIndex + 1);
    }

    function prevSlide() {
        goToSlide(currentIndex - 1);
    }

    // Tombol Panah Kiri dan Kanan
    if (prevBtn) {
        prevBtn.addEventListener('click', function(e) {
            e.preventDefault();
            prevSlide();
            restartAutoplay();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function(e) {
            e.preventDefault();
            nextSlide();
            restartAutoplay();
        });
    }

    // Autoplay logic
    function shouldAutoplayRun() {
        if (prefersReducedMotion) return false;
        if (maxIndex <= 0) return false;
        if (!isIntersecting) return false;
        if (isHovered) return false;
        if (isFocused) return false;
        if (isPointerActive) return false;
        return true;
    }

    function tickAutoplay() {
        if (shouldAutoplayRun()) {
            nextSlide();
        }
    }

    function startAutoplay() {
        if (autoplayTimer) return;
        if (prefersReducedMotion || maxIndex <= 0) return;
        autoplayTimer = setInterval(tickAutoplay, 5000);
    }

    function stopAutoplay() {
        if (autoplayTimer) {
            clearInterval(autoplayTimer);
            autoplayTimer = null;
        }
    }

    function restartAutoplay() {
        stopAutoplay();
        startAutoplay();
    }

    // IntersectionObserver: jalankan autoplay hanya ketika terlihat di layar
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                isIntersecting = entry.isIntersecting;
                if (isIntersecting) {
                    startAutoplay();
                } else {
                    stopAutoplay();
                }
            });
        }, { threshold: 0.2 });
        observer.observe(wrapper);
    } else {
        isIntersecting = true;
        startAutoplay();
    }

    // Jeda saat hover
    wrapper.addEventListener('mouseenter', () => {
        isHovered = true;
        stopAutoplay();
    });
    wrapper.addEventListener('mouseleave', () => {
        isHovered = false;
        startAutoplay();
    });

    // Jeda saat fokus keyboard
    wrapper.addEventListener('focusin', () => {
        isFocused = true;
        stopAutoplay();
    });
    wrapper.addEventListener('focusout', () => {
        isFocused = false;
        startAutoplay();
    });

    // Navigasi keyboard tombol panah
    wrapper.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            prevSlide();
            restartAutoplay();
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            nextSlide();
            restartAutoplay();
        }
    });

    // Swipe & Drag Touch / Pointer Events
    let startX = 0;
    let startY = 0;
    let currentX = 0;
    let hasDragged = false;
    let initialShift = 0;

    function onPointerDown(e) {
        if (maxIndex <= 0) return;
        isPointerActive = true;
        stopAutoplay();
        startX = e.clientX || (e.touches && e.touches[0].clientX) || 0;
        startY = e.clientY || (e.touches && e.touches[0].clientY) || 0;
        currentX = startX;
        hasDragged = false;

        const itemWidth = items[0].getBoundingClientRect().width;
        const gap = getGap();
        initialShift = currentIndex * (itemWidth + gap);
    }

    function onPointerMove(e) {
        if (!isPointerActive) return;
        const pageX = e.clientX || (e.touches && e.touches[0].clientX) || 0;
        const pageY = e.clientY || (e.touches && e.touches[0].clientY) || 0;
        const diffX = pageX - startX;
        const diffY = pageY - startY;

        if (!hasDragged) {
            if (Math.abs(diffX) > 8 && Math.abs(diffX) > Math.abs(diffY)) {
                hasDragged = true;
                suppressClick = true;
            } else if (Math.abs(diffY) > 8) {
                // Dominan scroll vertikal, batalkan drag slider agar halaman bisa di-scroll
                isPointerActive = false;
                startAutoplay();
                return;
            }
        }

        if (hasDragged) {
            currentX = pageX;
            track.style.transition = 'none';

            let appliedDiff = diffX;
            if ((currentIndex === 0 && diffX > 0) || (currentIndex === maxIndex && diffX < 0)) {
                appliedDiff = diffX * 0.35; // resistensi batas
            }
            track.style.transform = `translate3d(-${initialShift - appliedDiff}px, 0, 0)`;
        }
    }

    function onPointerUp() {
        if (!isPointerActive) return;
        isPointerActive = false;

        if (hasDragged) {
            const diffX = currentX - startX;
            const threshold = 45;

            if (diffX < -threshold) {
                nextSlide();
            } else if (diffX > threshold) {
                prevSlide();
            } else {
                goToSlide(currentIndex);
            }

            setTimeout(() => {
                suppressClick = false;
                hasDragged = false;
            }, 120);
        }

        startAutoplay();
    }

    container.addEventListener('pointerdown', onPointerDown);
    window.addEventListener('pointermove', onPointerMove);
    window.addEventListener('pointerup', onPointerUp);
    window.addEventListener('pointercancel', onPointerUp);

    // Mencegah navigasi tidak sengaja saat drag selesai
    const cards = track.querySelectorAll('.doc-momen-card');
    cards.forEach(card => {
        card.addEventListener('click', function(e) {
            if (suppressClick) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
    });

    // Inisialisasi tampilan
    updateView();

    let resizeTimeout = null;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            updateView();
            goToSlide(currentIndex, false);
        }, 100);
    });
});
</script>
@endpush

@endsection
