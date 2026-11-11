@extends('layouts.app')

@section('content')

{{-- ==================== BAGIAN 1: SAMPUL (HERO) ==================== --}}
<section class="hero-modern-section" id="hero">
    {{-- Background Campus Photo with Translucent White Overlay --}}
    <div class="hero-bg-photo-wrapper" aria-hidden="true">
        @if(!empty($profile->hero_image) && file_exists(public_path('storage/' . $profile->hero_image)))
            <img src="{{ asset('storage/' . $profile->hero_image) }}" alt="{{ $profile->hero_image_alt ?? 'Kampus UNUJA' }}" class="hero-bg-photo">
        @elseif(file_exists(public_path('images/hero-bg-unuja.jpg')))
            <img src="{{ asset('images/hero-bg-unuja.jpg') }}" alt="Kampus UNUJA" class="hero-bg-photo">
        @else
            <img src="{{ asset('images/unuja-campus-banner.jpg') }}" alt="Kampus UNUJA" class="hero-bg-photo">
        @endif
        <div class="hero-bg-photo-overlay"></div>
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center hero-grid-row gx-lg-5 gy-5 gy-lg-0">
            {{-- Left Content (~45% on desktop) --}}
            <div class="col-lg-5 hero-col-content">
                {{-- Badge Capsule & Companion Text --}}
                <div class="hero-badge-container mb-3">
                    <div class="hero-navy-capsule">
                        <i class="fas fa-graduation-cap me-1"></i>
                        <span>{{ $profile->hero_badge ?? 'HIMATIKA UNUJA' }}</span>
                    </div>
                    @if(!empty($profile->hero_tagline))
                        <div class="hero-tag-companion">
                            <span class="hero-tag-vbar"></span>
                            <span>{{ $profile->hero_tagline }}</span>
                        </div>
                    @else
                        <div class="hero-tag-companion">
                            <span class="hero-tag-vbar"></span>
                            <span>Grow with himatika</span>
                        </div>
                    @endif
                </div>

                {{-- Main Title --}}
                <h1 class="hero-main-title">
                    {!! nl2br(e($profile->hero_title ?? "Ruang\nberkembang,berinovasi\nBagi Mahasiswa\nInformatika")) !!}
                </h1>

                <p class="hero-new-desc">
                    {{ $profile->hero_desc ?? 'Ruang resmi mahasiswa Informatika UNUJA untuk mengakses layanan, mengikuti kegiatan, menyampaikan aspirasi, dan mengenal karya HIMATIKA.' }}
                </p>

                {{-- Action Buttons: Stacked vertically with consistent width, burgundy background, white text, and right arrow --}}
                <div class="hero-vertical-buttons">
                    @if(($profile->hero_btn_primary_active ?? 1) == 1)
                        <a href="{{ !empty($profile->hero_btn_primary_url) ? url($profile->hero_btn_primary_url) : route('kontak') }}" class="btn-hero-navy btn-hero-primary">
                            <span>{{ $profile->hero_btn_primary_text ?? 'Hubungi Kami' }}</span>
                            <i class="fas fa-caret-right"></i>
                        </a>
                    @endif
                    @if(($profile->hero_btn_secondary_active ?? 1) == 1)
                        <a href="{{ ($profile->hero_btn_secondary_url && $profile->hero_btn_secondary_url !== '/profil') ? url($profile->hero_btn_secondary_url) : '#tentang' }}" class="btn-hero-navy btn-hero-outline">
                            <span>{{ $profile->hero_btn_secondary_text ?? 'Pelajari Profil' }}</span>
                            <i class="fas fa-caret-right"></i>
                        </a>
                    @endif
                </div>

                {{-- 5 Foto Terbaru di Pinggir Kiri: Berita Terbaru, Prestasi, Agenda, Kegiatan, Dokumentasi --}}
                @if(!empty($heroRecentPhotos) && count($heroRecentPhotos) > 0)
                    <div class="hero-recent-preview-group mt-4 pt-1">
                        <div class="hero-recent-avatars-row">
                            <div class="hero-avatar-stack" aria-label="5 Foto Terbaru Kegiatan & Informasi HIMATIKA">
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

            {{-- Right Visual: Large Rounded Frame with Collage (~55% on desktop) --}}
            <div class="col-lg-7 hero-col-visual">
                <div class="hero-frame-wrapper">
                    <div class="hero-visual-frame">
                        @php
                            $mainPhoto = null;
                            if ($globalProfile && $globalProfile->image && file_exists(public_path('storage/' . $globalProfile->image))) {
                                $mainPhoto = asset('storage/' . $globalProfile->image);
                            } elseif (file_exists(public_path('images/unuja-campus-banner.jpg'))) {
                                $mainPhoto = asset('images/unuja-campus-banner.jpg');
                            } else {
                                $mainPhoto = asset('images/hero-bg-unuja.jpg');
                            }

                            $getNewsPhoto = function($item, $default) {
                                if (!$item) return asset($default);
                                $thumb = $item->thumbnail ?? $item->image;
                                if (!$thumb) return asset($default);
                                if (file_exists(public_path('storage/' . $thumb))) return asset('storage/' . $thumb);
                                if (file_exists(public_path('images/' . $thumb))) return asset('images/' . $thumb);
                                if (file_exists(public_path($thumb))) return asset($thumb);
                                return asset('storage/' . $thumb);
                            };

                            $photo1 = $getNewsPhoto($news[0] ?? null, 'images/news/news-1.jpg');
                            $photo2 = $getNewsPhoto($news[1] ?? null, 'images/news/news-2.jpg');
                            $photo3 = $getNewsPhoto($news[2] ?? null, 'images/news/news-3.jpg');
                            $photo4 = $getNewsPhoto($news[3] ?? null, 'images/news/news-4.jpg');
                        @endphp

                        {{-- Collage Grid --}}
                        <div class="hero-collage-grid" aria-hidden="true">
                            <div class="hero-collage-cell">
                                <img src="{{ $photo1 }}" alt="Aktivitas HIMATIKA 1">
                            </div>
                            <div class="hero-collage-cell">
                                <img src="{{ $photo2 }}" alt="Aktivitas HIMATIKA 2">
                            </div>
                            <div class="hero-collage-cell">
                                <img src="{{ $photo3 }}" alt="Aktivitas HIMATIKA 3">
                            </div>
                            <div class="hero-collage-cell">
                                <img src="{{ $photo4 }}" alt="Aktivitas HIMATIKA 4">
                            </div>
                        </div>

                        {{-- Center Emblem Badge --}}
                        <div class="hero-collage-emblem">
                            <div class="hero-collage-emblem-logo">
                                @if($globalProfile && $globalProfile->logo && file_exists(public_path('storage/' . $globalProfile->logo)))
                                    <img src="{{ asset('storage/' . $globalProfile->logo) }}" alt="Logo HIMATIKA">
                                @elseif(!empty($siteSettings['main_logo']) && file_exists(public_path('storage/' . $siteSettings['main_logo'])))
                                    <img src="{{ asset('storage/' . $siteSettings['main_logo']) }}" alt="Logo HIMATIKA">
                                @else
                                    <i class="fas fa-infinity" style="color: #711C35; font-size: 1.4rem;"></i>
                                @endif
                            </div>
                            <div>
                                <div class="hero-collage-emblem-title">HIMATIKA</div>
                                <div class="hero-collage-emblem-sub">FMIPA UNUJA</div>
                            </div>
                        </div>

                        {{-- Overlapping Front Card (Main Visual / Team) --}}
                        <div class="hero-collage-front-card">
                            <img src="{{ $mainPhoto }}" alt="HIMATIKA UNUJA 2026">
                        </div>
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

            {{-- Card Kanan: Struktur Organisasi --}}
            <div class="col-lg-6">
                <div class="tentang-card">
                    <div>
                        <div class="tentang-card-badge">
                            <i class="fas fa-sitemap me-1"></i> {{ $siteSettings['home_struktur_badge'] ?? 'Kepengurusan Periode 2026' }}
                        </div>
                        <h3 class="tentang-card-title">
                            <i class="fas fa-project-diagram"></i> {{ $siteSettings['home_struktur_title'] ?? 'Struktur Organisasi' }}
                        </h3>

                        {{-- Diagram Preview Vector / Graphic --}}
                        <div class="struktur-preview-box">
                            <img src="{{ asset('images/struktur-organisasi-himatika.svg') }}" alt="Bagan Struktur Organisasi HIMATIKA UNUJA 2026" class="struktur-preview-img">
                        </div>

                        <p class="struktur-desc-text">
                            {{ $siteSettings['home_struktur_summary'] ?? ($siteSettings['home_struktur_desc'] ?? 'Bagan kepengurusan HIMATIKA FMIPA UNUJA yang menaungi Badan Pengurus Harian (BPH) serta divisi keilmuan, minat bakat, humas, dan pengembangan mahasiswa.') }}
                        </p>
                    </div>

                    <div>
                        <a href="{{ !empty($siteSettings['home_struktur_btn_url']) ? url($siteSettings['home_struktur_btn_url']) : route('struktur-organisasi') }}" class="btn-tentang-primary w-100">
                            <i class="fas fa-sitemap me-1"></i>
                            <span>{{ $siteSettings['home_struktur_btn_text'] ?? 'Lihat Struktur Lengkap' }}</span>
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
                    <span>{{ $siteSettings['home_galeri_badge'] ?? 'Dokumentasi Kegiatan' }}</span>
                </div>
                <h2 class="tentang-main-title">
                    {{ $siteSettings['home_galeri_title'] ?? 'Dokumentasi Momen' }}
                </h2>
                <p class="tentang-main-desc">
                    {{ $siteSettings['home_galeri_desc'] ?? 'Jejak kebersamaan dan berbagai kegiatan HIMATIKA dalam setiap momen.' }}
                </p>
            </div>
            <div>
                <a href="{{ !empty($siteSettings['home_galeri_btn_url']) ? url($siteSettings['home_galeri_btn_url']) : route('galeri') }}" class="btn-semua-artikel">
                    <span>{{ $siteSettings['home_galeri_btn_text'] ?? 'Lihat Semua Dokumentasi' }}</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- 2-Column Photo Grid (Desktop 2 Kolom, Mobile 1 Kolom) --}}
        <div class="row g-4">
            @if($galleries->isNotEmpty())
                @foreach($galleries->take(4) as $gal)
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
                    @endphp
                    <div class="col-lg-6 col-12">
                        <a href="{{ route('galeri') }}" class="doc-momen-card">
                            <img src="{{ $galImg }}" alt="{{ $gal->alt_text ?: $gal->title }}" class="doc-momen-img">
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
