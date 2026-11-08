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

        {{-- ==================== BAGIAN 2: STATISTIK ==================== --}}
        <div class="hero-new-stats">
            <div class="hero-stat-item">
                <div class="stat-icon-wrap stat-icon-navy">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-val">{{ $totalMembers ?? 68 }}</span>
                    <span class="stat-text">Pengurus 2026</span>
                </div>
            </div>

            <div class="stat-sep" aria-hidden="true"></div>

            <div class="hero-stat-item">
                <div class="stat-icon-wrap stat-icon-navy">
                    <i class="fas fa-handshake"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-val">{{ $totalBidang ?? 6 }}</span>
                    <span class="stat-text">Bidang</span>
                </div>
            </div>

            <div class="stat-sep" aria-hidden="true"></div>

            <div class="hero-stat-item">
                <div class="stat-icon-wrap stat-icon-navy">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-val">{{ $totalBiro ?? 4 }}</span>
                    <span class="stat-text">Biro</span>
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
                                    <i class="far fa-eye"></i> 58 dilihat
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
                                        {{ $loop->first ? '9' : '112' }}
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

{{-- ==================== SECTION 6: MATEMATIKA PEDULI ==================== --}}
<section class="section-peduli" id="peduli">
    <div class="peduli-bg-glow peduli-glow-1" aria-hidden="true"></div>
    <div class="peduli-bg-glow peduli-glow-2" aria-hidden="true"></div>

    <div class="container position-relative" style="z-index:1;">
        {{-- Section Header --}}
        <div class="peduli-section-header">
            <span class="peduli-label">
                <span class="peduli-label-icon"><i class="fas fa-hand-holding-heart"></i></span>
                MATEMATIKA PEDULI
            </span>
        </div>

        <div class="peduli-main-grid">
            {{-- Kolom Kiri: Teks --}}
            <div class="peduli-text-col">
                <h2 class="peduli-heading">Gerakan gotong royong<br>untuk mahasiswa<br>aktif Matematika yang<br>membutuhkan bantuan.</h2>
                <p class="peduli-desc">Program solidaritas mahasiswa Matematika FMIPA UNUJA yang hadir untuk mendukung teman-teman yang membutuhkan dukungan finansial maupun moral selama menjalani perkuliahan.</p>
                <a href="{{ route('profil') }}" class="peduli-cta">
                    <span>Kenali gerakan kami</span>
                    <span class="peduli-cta-arrow"><i class="fas fa-arrow-right"></i></span>
                </a>
            </div>

            {{-- Kolom Tengah: Image Collage --}}
            <div class="peduli-collage-col">
                <div class="peduli-image-collage">
                    <div class="peduli-image-placeholder peduli-img-1">
                        <i class="fas fa-users"></i>
                        <span>Dokumentasi</span>
                    </div>
                    <div class="peduli-image-placeholder peduli-img-2">
                        <i class="fas fa-hands-helping"></i>
                        <span>Dokumentasi</span>
                    </div>
                    <div class="peduli-image-placeholder peduli-img-3">
                        <i class="fas fa-heart"></i>
                        <span>Dokumentasi</span>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Stat Card --}}
            <div class="peduli-stat-col">
                <div class="peduli-stat-card">
                    <span class="peduli-stat-label">DAMPAK KOLEKTIF</span>
                    <div class="peduli-stat-number-wrap">
                        <span class="peduli-stat-number">6</span>
                    </div>
                    <span class="peduli-stat-text">penerima manfaat terdata</span>
                    <a href="{{ route('profil') }}" class="peduli-stat-btn">
                        <span>Lihat Program</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ==================== SECTION 8: DOKUMENTASI ==================== --}}
<section class="dark-green section-dark py-5" id="dokumentasi" style="border-top: 1px solid rgba(255, 255, 255, 0.08);">
    <div class="container">
        <div class="row align-items-center justify-content-between mb-5">
            <div class="col-lg-6">
                <span class="section-label">DOKUMENTASI</span>
                <h2 class="section-title text-white mt-3">Momen yang tumbuh bersama HIMATIKA.</h2>
            </div>
            <div class="col-lg-auto mt-4 mt-lg-0">
                <a href="{{ route('galeri') }}" class="doc-album-link">Buka Semua Album →</a>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="doc-album-card">
                    <div class="doc-album-image">
                        <span class="doc-album-label">ALBUM 01</span>
                        <div class="doc-album-placeholder"></div>
                    </div>
                    <div class="doc-album-overlay">
                        <span class="doc-album-title">Pelantikan HIMATIKA 2026</span>
                        <span class="doc-album-desc">Dokumentasi pelantikan HIMATIKA 2026</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="doc-album-card">
                    <div class="doc-album-image">
                        <span class="doc-album-label">ALBUM 02</span>
                        <div class="doc-album-placeholder"></div>
                    </div>
                    <div class="doc-album-overlay">
                        <span class="doc-album-title">Arsip Kegiatan HIMATIKA</span>
                        <span class="doc-album-desc">Dokumentasi kegiatan HIMATIKA yang telah dipublikasikan.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-math-deco math-deco-6" aria-hidden="true">
            <span>∑ π ∞ f(x) Δ √</span>
        </div>
    </div>
</section>

{{-- ==================== SECTION 9: CERITA & PERJALANAN ==================== --}}
<section class="section-cream py-5" id="cerita">
    <div class="container">
        <span class="section-label">RUANG & CERITA HIMATIKA</span>
        <h2 class="section-title mt-3 mb-5">Kenali cerita dan<br>perjalanan HIMATIKA.</h2>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="video-card">
                    <span class="video-label">VIDEO PROFIL</span>
                    <h3 class="video-title">HIMATIKA lebih dekat.</h3>
                    <div class="video-thumbnail">
                        <div class="video-play-btn">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="angka-card">
                    <span class="angka-label">HIMATIKA DALAM ANGKA</span>
                    <div class="angka-sejak">
                        <span class="angka-sejak-text">SEJAK</span>
                        <span class="angka-date">02.06.1997</span>
                    </div>
                    <p class="angka-desc">Lahir sebagai rumah bersama mahasiswa Matematika UNUJA.</p>
                    <div class="angka-stats">
                        <div class="angka-stat-item">
                            <span class="angka-stat-num">68</span>
                            <span class="angka-stat-label">Pengurus 2026</span>
                        </div>
                        <div class="angka-stat-item">
                            <span class="angka-stat-num">6</span>
                            <span class="angka-stat-label">Bidang</span>
                        </div>
                        <div class="angka-stat-item">
                            <span class="angka-stat-num">4</span>
                            <span class="angka-stat-label">Biro</span>
                        </div>
                    </div>
                    <p class="angka-tagline">{{ $profile->motto ?? 'Synchronized Growth, Reaching New Heights' }}</p>
                </div>
            </div>
        </div>
        <div class="bg-math-deco math-deco-7" aria-hidden="true">
            <span>∑ π ∞ f(x) Δ √</span>
        </div>
    </div>
</section>

{{-- ==================== BAGIAN 10 & 11: KOLABORASI & ASPIRASI ==================== --}}
<section class="section-off-white py-5" id="kolaborasi">
    <div class="container">
        {{-- KOLABORASI --}}
        <span class="section-label">KOLABORASI</span>
        <h2 class="section-title mt-2 mb-3" style="font-size: 1.6rem;">Partner yang mendukung<br>perjalanan kami.</h2>
        <div class="kolaborasi-container mb-5">
            <div class="kolaborasi-logo-placeholder" style="border: none; background: transparent;">
                @if($globalProfile && $globalProfile->logo)
                    <img src="{{ asset('storage/' . $globalProfile->logo) }}" alt="Logo" style="max-height: 80px; object-fit: contain;">
                @else
                    <i class="fas fa-graduation-cap"></i>
                    <span>HIMATIKA</span>
                @endif
            </div>
        </div>

        {{-- ASPIRASI --}}
        <div class="cta-card d-flex flex-column flex-lg-row align-items-lg-center justify-content-between" id="aspirasi">
            <div class="cta-text">
                <span class="section-label text-gold">RUANG UNTUK DIDENGAR</span>
                <h2 class="cta-heading mt-2">Punya gagasan,<br>kebutuhan, atau aspirasi?</h2>
                <p class="cta-desc mb-0">Sampaikan melalui kanal resmi agar dapat ditindaklanjuti oleh tim yang tepat.</p>
            </div>
            <div class="cta-actions d-flex gap-3 flex-wrap mt-4 mt-lg-0">
                <a href="{{ route('aspirasi.index') }}" class="cta-btn-gold">Kirim Aspirasi</a>
                <a href="{{ route('kontak') }}" class="cta-btn-outline">Hubungi Kami</a>
            </div>
        </div>
    </div>
</section>

@endsection
