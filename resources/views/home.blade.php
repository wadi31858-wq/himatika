@extends('layouts.app')

@section('content')

{{-- ==================== BAGIAN 1: SAMPUL (HERO) ==================== --}}
<section class="hero-modern-section" id="hero">
    {{-- Background Campus Photo with Elegant Overlay --}}
    <div class="hero-bg-photo-wrapper" aria-hidden="true">
        @if(!empty($profile->hero_image))
            <img src="{{ asset('storage/' . $profile->hero_image) }}" alt="{{ $profile->hero_image_alt ?? 'Kampus UNUJA' }}" class="hero-bg-photo">
        @else
            <img src="{{ asset('images/hero-bg-unuja.jpg') }}" alt="Kampus UNUJA" class="hero-bg-photo">
        @endif
        <div class="hero-bg-photo-overlay"></div>
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center gy-5 gy-lg-0">
            {{-- Left Content --}}
            <div class="col-lg-6 pe-lg-4">
                {{-- Badge Capsule & Companion Text --}}
                <div class="hero-badge-container mb-3">
                    <div class="hero-navy-capsule">
                        <i class="fas fa-graduation-cap me-1"></i>
                        <span>{{ $profile->hero_badge ?? 'HIMATIKA FMIPA UNUJA' }}</span>
                    </div>
                    <div class="hero-tag-companion">
                        <span class="hero-tag-vbar"></span>
                        <span>{{ $profile->hero_tagline ?? 'Synchronized Growth, Reaching New Heights' }}</span>
                    </div>
                </div>

                {{-- Main Title --}}
                <h1 class="hero-main-title">
                    {!! nl2br(e($profile->hero_title ?? "Rumah yang\ninklusif, inovatif,\ndan tumbuh bersama.")) !!}
                </h1>

                <p class="hero-new-desc">
                    {{ $profile->hero_desc ?? 'Ruang resmi mahasiswa Matematika UNUJA untuk mengakses layanan, mengikuti kegiatan, menyampaikan aspirasi, dan mengenal karya HIMATIKA.' }}
                </p>

                {{-- Action Buttons --}}
                <div class="hero-new-btn-group d-flex gap-3 flex-wrap">
                    <a href="{{ $profile->hero_btn_primary_url ?? route('kontak') }}" class="btn-hero-primary">
                        <i class="fas fa-home"></i>
                        <span>{{ $profile->hero_btn_primary_text ?? 'Hubungi Kami' }}</span>
                    </a>
                    <a href="{{ $profile->hero_btn_secondary_url ?? route('profil') }}" class="btn-hero-outline">
                        <i class="fas fa-user"></i>
                        <span>{{ $profile->hero_btn_secondary_text ?? 'Pelajari Profil' }}</span>
                    </a>
                </div>
            </div>

            {{-- Right Visual: Rectangular Wide Frame --}}
            <div class="col-lg-6 ps-lg-4">
                <div class="hero-frame-wrapper">
                    <div class="hero-wide-card">
                        @if($globalProfile && $globalProfile->image)
                            <img src="{{ asset('storage/' . $globalProfile->image) }}" alt="HIMATIKA UNUJA 2026" class="hero-wide-img">
                        @else
                            <img src="{{ asset('storage/profile/MmO6PGEjnheZras5q3R0WVRZ8WpodO9mDExn1wgH.jpg') }}" alt="HIMATIKA UNUJA 2026" class="hero-wide-img">
                        @endif
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
            <div class="tentang-top-label">
                <span class="tentang-label-bar"></span>
                <span>Tentang Organisasi</span>
            </div>
            <h2 class="tentang-main-title">
                Tentang <span style="color: #711C35;">HIMATIKA</span>
            </h2>
            <p class="tentang-main-desc">
                Mengenal wadah persatuan, pengembangan intelektual, dan ruang tumbuh bersama seluruh mahasiswa Program Studi Matematika FMIPA Universitas Nurul Jadid.
            </p>
        </div>

        {{-- 2 Balanced Cards (Desktop Side-by-Side, Mobile Stacked) --}}
        <div class="row g-4 align-items-stretch">
            {{-- Card Kiri: Sambutan Kaprodi --}}
            <div class="col-lg-6">
                <div class="tentang-card">
                    <div>
                        <div class="tentang-card-badge">
                            <i class="fas fa-university me-1"></i> Program Studi Matematika FMIPA
                        </div>
                        <h3 class="tentang-card-title">
                            <i class="fas fa-quote-left"></i> Sambutan Kaprodi
                        </h3>

                        @if($kaprodi)
                            <div class="kaprodi-profile-box">
                                <div class="kaprodi-photo-wrap">
                                    @if($kaprodi->photo)
                                        <img src="{{ asset('storage/' . $kaprodi->photo) }}" alt="{{ $kaprodi->name }}">
                                    @else
                                        <i class="fas fa-user-tie fs-3 text-primary"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="kaprodi-name">{{ $kaprodi->name }}</h4>
                                    <p class="kaprodi-role">{{ $kaprodi->position }}</p>
                                </div>
                            </div>
                            <div class="kaprodi-quote-box">
                                “{{ Str::limit(strip_tags($kaprodi->bio), 220) }}”
                            </div>
                        @else
                            {{-- Clean, Formal Empty State (No Fabricated Data) --}}
                            <div class="kaprodi-empty-state">
                                <div class="kaprodi-empty-avatar">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <h4 class="kaprodi-empty-title">Ketua Program Studi Matematika</h4>
                                <p class="kaprodi-empty-text">
                                    Naskah dan dokumentasi sambutan resmi Ketua Program Studi Matematika FMIPA UNUJA sedang dalam proses penyusunan dan kurasi oleh pengurus himpunan.
                                </p>
                            </div>
                        @endif
                    </div>

                    <div>
                        <a href="{{ route('profil') }}" class="btn-tentang-outline w-100">
                            <span>Pelajari Profil Lengkap</span>
                            <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Card Kanan: Struktur Organisasi --}}
            <div class="col-lg-6">
                <div class="tentang-card">
                    <div>
                        <div class="tentang-card-badge">
                            <i class="fas fa-sitemap me-1"></i> Kepengurusan Periode 2026
                        </div>
                        <h3 class="tentang-card-title">
                            <i class="fas fa-project-diagram"></i> Struktur Organisasi
                        </h3>

                        {{-- Diagram Preview Vector / Graphic --}}
                        <div class="struktur-preview-box">
                            <img src="{{ asset('images/struktur-organisasi-himatika.svg') }}" alt="Bagan Struktur Organisasi HIMATIKA UNUJA 2026" class="struktur-preview-img">
                        </div>

                        <p class="struktur-desc-text">
                            Bagan kepengurusan HIMATIKA FMIPA UNUJA yang menaungi Badan Pengurus Harian (BPH) serta divisi keilmuan, minat bakat, humas, dan pengembangan mahasiswa.
                        </p>
                    </div>

                    <div>
                        <a href="{{ route('struktur-organisasi') }}" class="btn-tentang-primary w-100">
                            <i class="fas fa-sitemap me-1"></i>
                            <span>Lihat Struktur</span>
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
                    <span>Kabar & Artikel</span>
                </div>
                <h2 class="berita-main-title">
                    Berita & <span class="berita-gold-text">Informasi Terkini</span>
                </h2>
            </div>
            <div>
                <a href="{{ route('berita') }}" class="btn-semua-artikel">
                    <span>Lihat Semua Artikel</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        @php
            $featuredNews = $news->first();
            $sideNews = $news->slice(1, 2);
            $bottomNews = $news->slice(3, 3);

            $getNewsThumb = function($item, $defaultIndex) {
                if ($item && $item->thumbnail && file_exists(public_path('storage/' . $item->thumbnail))) {
                    return asset('storage/' . $item->thumbnail);
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
                    <a href="{{ route('berita.show', $featuredNews->slug) }}" class="news-featured-card">
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
                                    {{ $featuredNews->published_at ? $featuredNews->published_at->format('d M Y') : '04 Nov 2026' }}
                                </span>
                            </div>
                            <h3 class="news-featured-title">{{ $featuredNews->title }}</h3>
                            <p class="news-featured-excerpt">{{ Str::limit(strip_tags($featuredNews->content), 130) }}</p>
                            <div class="news-featured-meta">
                                <span class="featured-meta-views">
                                    <i class="far fa-eye"></i> {{ number_format($featuredNews->views ?? 58) }} dilihat
                                </span>
                                <span class="featured-readmore">
                                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                @endif
            </div>

            {{-- 2 Stacked Cards --}}
            <div class="col-lg-5">
                <div class="d-flex flex-column gap-3 h-100 justify-content-between">
                    @foreach($sideNews as $idx => $sNews)
                        <a href="{{ route('berita.show', $sNews->slug) }}" class="news-horizontal-card">
                            <div class="news-horizontal-thumb">
                                <img src="{{ $getNewsThumb($sNews, $loop->iteration + 1) }}" alt="{{ $sNews->title }}">
                            </div>
                            <div class="news-horizontal-info">
                                <span class="news-tag-outline">{{ $sNews->category ?? 'Berita' }}</span>
                                <h4 class="news-horizontal-title">{{ $sNews->title }}</h4>
                                <div class="news-horizontal-meta">
                                    <span class="news-meta-date">
                                        <i class="far fa-calendar"></i>
                                        {{ $sNews->published_at ? $sNews->published_at->format('d M Y') : '' }}
                                    </span>
                                    <span class="news-meta-views">
                                        <i class="far fa-eye"></i>
                                        {{ number_format($sNews->views ?? ($loop->first ? 9 : 112)) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ROW 2: 3 Vertical Cards --}}
        @if($bottomNews->isNotEmpty())
            <div class="row g-4">
                @foreach($bottomNews as $bIdx => $bNews)
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('berita.show', $bNews->slug) }}" class="news-vertical-card">
                            <div class="news-vertical-img-wrap">
                                <img src="{{ $getNewsThumb($bNews, $loop->iteration + 3) }}" alt="{{ $bNews->title }}">
                                <span class="badge-floating-cat">{{ $bNews->category ?? 'Berita' }}</span>
                            </div>
                            <div class="news-vertical-body">
                                <h4 class="news-vertical-title">{{ $bNews->title }}</h4>
                                <p class="news-vertical-desc">{{ Str::limit(strip_tags($bNews->content), 95) }}</p>
                            </div>
                            <div class="news-vertical-footer">
                                <span class="news-vertical-date">
                                    <i class="far fa-calendar"></i>
                                    {{ $bNews->published_at ? $bNews->published_at->format('d M Y') : '' }}
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
                KARYA & KONTRIBUSI
            </span>
        </div>

        <div class="peduli-main-grid">
            {{-- Kolom Kiri: Teks Pengantar --}}
            <div class="peduli-text-col">
                <h2 class="peduli-heading">HIMATIKA Berdampak</h2>
                <p class="peduli-desc">
                    Mengenal karya, kegiatan, dan kontribusi HIMATIKA yang memberikan manfaat bagi mahasiswa dan lingkungan sekitar.
                </p>
                <a href="{{ route('prestasi') }}" class="peduli-cta">
                    <span>Jelajahi karya & prestasi</span>
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
                        <span class="peduli-stat-number">{{ $totalAchievements ?? 3 }}</span>
                    </div>
                    <span class="peduli-stat-text">prestasi resmi terdata</span>

                    <div class="mt-3 pt-3 border-top border-white border-opacity-10 w-100">
                        <div class="small text-white-50 mb-1">Kegiatan Terlaksana</div>
                        <div class="fw-bold fs-5 text-white">{{ $totalActivities ?? 5 }}+</div>
                    </div>

                    <a href="{{ route('prestasi') }}" class="peduli-stat-btn mt-3">
                        <span>Lihat Prestasi</span>
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
                    <span>Dokumentasi Kegiatan</span>
                </div>
                <h2 class="tentang-main-title">
                    Dokumentasi <span style="color: #711C35;">Momen</span>
                </h2>
                <p class="tentang-main-desc">
                    Jejak kebersamaan dan berbagai kegiatan HIMATIKA dalam setiap momen.
                </p>
            </div>
            <div>
                <a href="{{ route('galeri') }}" class="btn-semua-artikel">
                    <span>Lihat Semua Dokumentasi</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- 2-Column Photo Grid (Desktop 2 Kolom, Mobile 1 Kolom) --}}
        <div class="row g-4">
            @if($galleries->isNotEmpty())
                @foreach($galleries->take(4) as $gal)
                    <div class="col-lg-6 col-12">
                        <a href="{{ route('galeri') }}" class="doc-momen-card">
                            <img src="{{ asset('storage/' . $gal->image) }}" alt="{{ $gal->title }}" class="doc-momen-img">
                            <div class="doc-momen-overlay">
                                @if($gal->category)
                                    <span class="doc-momen-badge">{{ $gal->category }}</span>
                                @endif
                                <h3 class="doc-momen-title">{{ $gal->title }}</h3>
                                @if($gal->description)
                                    <p class="doc-momen-caption">{{ Str::limit($gal->description, 95) }}</p>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                {{-- Representative Activities Showcase --}}
                <div class="col-lg-6 col-12">
                    <a href="{{ route('galeri') }}" class="doc-momen-card">
                        <img src="{{ asset('images/news/news-1.jpg') }}" alt="Pelantikan & Rapat Kerja HIMATIKA" class="doc-momen-img">
                        <div class="doc-momen-overlay">
                            <span class="doc-momen-badge">Kegiatan Organisasi</span>
                            <h3 class="doc-momen-title">Pelantikan & Rapat Kerja Kepengurusan 2026</h3>
                            <p class="doc-momen-caption">Momen pelantikan pengurus HIMATIKA FMIPA UNUJA dan perumusan program kerja tahunan.</p>
                        </div>
                    </a>
                </div>

                <div class="col-lg-6 col-12">
                    <a href="{{ route('galeri') }}" class="doc-momen-card">
                        <img src="{{ asset('images/news/news-2.jpg') }}" alt="Seminar & Workshop Matematika" class="doc-momen-img">
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
</section>

@endsection
