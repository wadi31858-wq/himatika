@extends('layouts.app')
@section('title', 'Pusat Informasi - HIMATIKA UNUJA')

@section('content')

{{-- ==================== 1. BREADCRUMB ==================== --}}
<section class="berita-breadcrumb">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('home') }}" class="berita-breadcrumb-back">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
            </a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pusat Informasi</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- ==================== 2. BANNER PUSAT INFORMASI ==================== --}}
<section class="berita-hero">
    <div class="container text-center">
        <span class="berita-hero-label">HIMATIKA FMIPA UNUJA</span>
        <h1 class="berita-hero-title">Pusat Informasi</h1>
        <p class="berita-hero-desc">Dapatkan kabar terkini, pengumuman resmi, liputan kegiatan, prestasi mahasiswa, dan agenda HIMATIKA FMIPA UNUJA.</p>
    </div>
</section>

{{-- ==================== 3. BILAH CARI ==================== --}}
<section class="berita-filter-section mb-4">
    <div class="container">
        <form id="beritaFilterForm" class="filter-card p-3 p-md-4 rounded-4 bg-white border shadow-sm" method="GET" action="{{ route('berita') }}">
            <input type="hidden" name="category" id="filterCategoryInput" value="{{ request('category') }}">
            <div class="w-100">
                <label class="filter-label fw-semibold mb-2 d-flex align-items-center gap-2" for="searchInput" style="color: #28151D; font-size: 0.9rem;">
                    <i class="fas fa-search" style="color: #711C35;"></i>
                    <span style="font-weight: 700;">Cari</span>
                </label>
                <div class="position-relative w-100">
                    <input type="text" name="search" id="searchInput" class="form-control filter-input w-100" placeholder="Cari judul atau topik" value="{{ request('search') }}" autocomplete="off">
                </div>
            </div>
        </form>
    </div>
</section>

{{-- ==================== AREA KONTEN (AJAX CONTAINER) ==================== --}}
<section class="berita-content-section pb-5">
    <div class="container">
        <div id="informasiContentArea">
            @php
                $hasNews = $news->count() > 0;
                $isFirstPage = $news->currentPage() == 1;
                $featured = $hasNews ? $news->first() : null;
                $sideNews = $hasNews ? $news->slice(1, 2) : collect();
                $additionalNews = $hasNews ? $news->slice(3) : collect();
            @endphp

            {{-- 4. KELOMPOK INFORMASI UTAMA (1 CARD BESAR DI KIRI & 2 CARD KECIL BERTUMPUK DI KANAN) --}}
            @if($hasNews && $isFirstPage)
                <div class="kelompok-utama-wrapper mb-5">
                    <div class="row g-4 align-items-stretch kelompok-utama-row">
                        {{-- Card Besar di Kiri --}}
                        <div class="col-lg-7 col-md-12 col-12 d-flex">
                            <div class="featured-main-card w-100">
                                @if($featured->thumbnail)
                                    <img src="{{ asset('storage/' . $featured->thumbnail) }}" alt="{{ $featured->title }}" class="featured-bg-img">
                                @else
                                    <div class="featured-bg-fallback">
                                        <i class="far fa-newspaper fa-4x text-white opacity-25"></i>
                                    </div>
                                @endif
                                <div class="featured-overlay"></div>
                                <div class="featured-content">
                                    <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                        <span class="badge bg-primary px-3 py-1 fw-semibold">
                                            {{ $featured->category }}
                                        </span>
                                        @if($featured->published_at)
                                            <span class="badge bg-dark bg-opacity-50 text-white">
                                                <i class="far fa-calendar-alt me-1"></i>{{ $featured->published_at->format('d M Y') }}
                                            </span>
                                        @endif
                                        @if(isset($featured->views))
                                            <span class="badge bg-dark bg-opacity-50 text-white">
                                                <i class="far fa-eye me-1"></i>{{ $featured->views }} dilihat
                                            </span>
                                        @endif
                                    </div>

                                    <h3 class="featured-title">
                                        <a href="{{ route('berita.show', $featured->slug) }}" class="text-white text-decoration-none">
                                            {{ $featured->title }}
                                        </a>
                                    </h3>

                                    <p class="featured-excerpt">
                                        {{ Str::limit(strip_tags($featured->content), 125) }}
                                    </p>

                                    <div class="d-flex justify-content-end align-items-center pt-2">
                                        <a href="{{ route('berita.show', $featured->slug) }}" class="btn-readmore-small btn-readmore-light">
                                            Baca Selengkapnya &rarr;
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Dua Card Kecil Bertumpuk di Kanan --}}
                        <div class="col-lg-5 col-md-12 col-12 d-flex flex-column gap-3 justify-content-between">
                            @forelse($sideNews as $sItem)
                                <div class="side-compact-card flex-fill d-flex flex-row align-items-stretch">
                                    <div class="side-card-img-wrap">
                                        @if($sItem->thumbnail)
                                            <img src="{{ asset('storage/' . $sItem->thumbnail) }}" alt="{{ $sItem->title }}" class="side-card-img">
                                        @else
                                            <div class="side-card-img-placeholder">
                                                <i class="far fa-newspaper fa-2x text-primary opacity-50"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="side-card-body p-3 d-flex flex-column justify-content-between flex-grow-1">
                                        <div>
                                            <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                                <span class="badge bg-primary-subtle text-primary fw-semibold" style="font-size: 0.7rem; padding: 3px 8px; border-radius: 4px;">
                                                    {{ $sItem->category }}
                                                </span>
                                                @if($sItem->published_at)
                                                    <span class="text-muted" style="font-size: 0.72rem;">
                                                        <i class="far fa-calendar-alt me-1"></i>{{ $sItem->published_at->format('d M Y') }}
                                                    </span>
                                                @endif
                                                @if(isset($sItem->views))
                                                    <span class="text-muted" style="font-size: 0.72rem;">
                                                        <i class="far fa-eye me-1"></i>{{ $sItem->views }}
                                                    </span>
                                                @endif
                                            </div>

                                            <h4 class="side-card-title">
                                                <a href="{{ route('berita.show', $sItem->slug) }}" class="text-decoration-none">
                                                    {{ $sItem->title }}
                                                </a>
                                            </h4>
                                        </div>

                                        <div class="text-end pt-2">
                                            <a href="{{ route('berita.show', $sItem->slug) }}" class="btn-readmore-small">
                                                Selengkapnya &rarr;
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center text-muted bg-white rounded-4 border">
                                    <small>Tidak ada informasi pendamping lainnya.</small>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif

            {{-- 5. DERETAN CARD INFORMASI TAMBAHAN (GRID 3 KOLOM DESKTOP) --}}
            @php
                $gridList = $isFirstPage ? $additionalNews : $news;
            @endphp

            @if($gridList->count() > 0)
                <div class="grid-tambahan-wrapper mb-5">
                    @if($isFirstPage)
                        <div class="section-title-divider mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="card-header-icon-box">
                                    <i class="fas fa-layer-group"></i>
                                </div>
                                <span class="card-header-divider">|</span>
                                <h3 class="fw-bold mb-0" style="color: #28151D; font-size: 1.25rem;">Informasi Lainnya</h3>
                            </div>
                        </div>
                    @endif

                    <div class="row g-4">
                        @foreach($gridList as $item)
                            <div class="col-lg-4 col-md-6 col-12">
                                <article class="info-card-standard h-100">
                                    <div class="info-card-img-wrap">
                                        @if($item->thumbnail)
                                            <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" class="info-card-img">
                                        @else
                                            <div class="info-card-placeholder">
                                                <i class="far fa-newspaper fa-2x mb-2 text-primary opacity-50"></i>
                                                <span class="small text-muted">HIMATIKA UNUJA</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="info-card-body p-3 d-flex flex-column flex-grow-1">
                                        <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                            <span class="badge bg-primary-subtle text-primary fw-semibold" style="font-size: 0.72rem; padding: 4px 10px; border-radius: 6px;">
                                                {{ $item->category }}
                                            </span>
                                            @if($item->published_at)
                                                <span class="text-muted small" style="font-size: 0.75rem;">
                                                    <i class="far fa-calendar-alt me-1"></i>{{ $item->published_at->format('d M Y') }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <h4 class="info-card-title">
                                            <a href="{{ route('berita.show', $item->slug) }}" class="text-decoration-none">
                                                {{ $item->title }}
                                            </a>
                                        </h4>
                                        
                                        <p class="info-card-excerpt flex-grow-1 mb-3">
                                            {{ Str::limit(strip_tags($item->content), 105) }}
                                        </p>

                                        <div class="pt-2 border-top border-light-subtle d-flex justify-content-between align-items-center">
                                            @if(isset($item->views))
                                                <span class="text-muted small" style="font-size: 0.75rem;">
                                                    <i class="far fa-eye me-1"></i>{{ $item->views }} dilihat
                                                </span>
                                            @else
                                                <span></span>
                                            @endif
                                            <a href="{{ route('berita.show', $item->slug) }}" class="btn-readmore-small">
                                                Baca Selengkapnya &rarr;
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>

                    <div class="berita-pagination-wrapper mt-4">
                        {{ $news->links() }}
                    </div>
                </div>
            @elseif(!$hasNews && (!$showAgenda || $agendas->count() == 0))
                <div class="berita-empty-state my-5 text-center p-5 bg-white rounded-4 border">
                    <i class="far fa-newspaper fa-3x text-primary opacity-50 mb-3"></i>
                    <h4 class="fw-bold mb-2" style="color: #28151D;">Informasi tidak ditemukan</h4>
                    <p class="text-secondary small mb-3">Tidak ada informasi atau kabar yang sesuai dengan kata kunci pencarian atau kategori yang dipilih.</p>
                    <a href="{{ route('berita') }}" class="btn-readmore-small">
                        <i class="fas fa-rotate-left me-1"></i> Lihat Semua Informasi &rarr;
                    </a>
                </div>
            @endif

            {{-- 6. BAGIAN CARD/FOTO AGENDA SESUAI KETENTUAN FILTER --}}
            @if($showAgenda && $agendas->count() > 0)
                <section class="agenda-section mt-5 pt-4 border-top border-light-subtle">
                    <div class="agenda-section-header mb-4">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <div class="card-header-icon-box">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <span class="card-header-divider">|</span>
                            <h3 class="fw-bold mb-0" style="color: #28151D; font-size: 1.3rem;">Agenda Kegiatan HIMATIKA</h3>
                        </div>
                        <p class="text-muted small mb-0">Jadwal dan agenda kegiatan mendatang organisasi mahasiswa Matematika UNUJA.</p>
                    </div>

                    <div class="row g-4">
                        @foreach($agendas as $agenda)
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="agenda-card h-100 bg-white rounded-4 overflow-hidden border shadow-sm d-flex flex-column">
                                    <div class="agenda-card-img-wrap position-relative">
                                        @if($agenda->image)
                                            <img src="{{ asset('storage/' . $agenda->image) }}" alt="{{ $agenda->title }}" class="agenda-card-img">
                                        @else
                                            <div class="agenda-card-img-placeholder d-flex flex-column align-items-center justify-content-center text-center p-4">
                                                <i class="fas fa-calendar-day fa-2x mb-2 text-primary opacity-75"></i>
                                                <span class="badge bg-primary text-white" style="font-size: 0.75rem;">
                                                    {{ $agenda->date ? $agenda->date->format('d M Y') : 'Jadwal Agenda' }}
                                                </span>
                                            </div>
                                        @endif
                                        <span class="badge bg-primary position-absolute top-0 end-0 m-3" style="font-size: 0.72rem;">
                                            {{ $agenda->status ?? 'Akan Datang' }}
                                        </span>
                                    </div>

                                    <div class="p-3 d-flex flex-column flex-grow-1 justify-content-between">
                                        <div>
                                            <h4 class="fw-bold mb-2" style="font-size: 1.05rem; color: #28151D; line-height: 1.35;">
                                                {{ $agenda->title }}
                                            </h4>
                                            <p class="text-secondary small mb-3" style="font-size: 0.85rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                {{ $agenda->description }}
                                            </p>
                                            <div class="agenda-meta-list small text-muted mb-2">
                                                <div class="d-flex align-items-center gap-2 mb-1">
                                                    <i class="far fa-calendar-alt text-primary" style="width: 16px;"></i>
                                                    <span>{{ $agenda->date ? $agenda->date->format('d M Y') : '-' }}</span>
                                                </div>
                                                @if($agenda->time)
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <i class="far fa-clock text-primary" style="width: 16px;"></i>
                                                        <span>{{ $agenda->time }}</span>
                                                    </div>
                                                @endif
                                                @if($agenda->location)
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="fas fa-map-marker-alt text-primary" style="width: 16px;"></i>
                                                        <span>{{ $agenda->location }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        @if($agenda->registration_link)
                                            <div class="pt-2 mt-2 border-top border-light-subtle text-end">
                                                <a href="{{ $agenda->registration_link }}" target="_blank" class="btn-readmore-small">
                                                    Daftar Agenda &rarr;
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* ===== BREADCRUMB ===== */
    .berita-breadcrumb {
        background: #1A0A0F;
        padding: 0.85rem 0;
    }
    .berita-breadcrumb-back {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        font-size: 0.85rem;
        transition: color 0.2s;
    }
    .berita-breadcrumb-back:hover {
        color: #fff;
    }
    .berita-breadcrumb .breadcrumb {
        background: transparent;
        margin: 0;
        padding: 0;
        font-size: 0.85rem;
    }
    .berita-breadcrumb .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: color 0.2s;
    }
    .berita-breadcrumb .breadcrumb-item a:hover {
        color: #fff;
    }
    .berita-breadcrumb .breadcrumb-item.active {
        color: rgba(255, 255, 255, 0.95);
    }
    .berita-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.5);
    }

    /* ===== HERO BANNER PUSAT INFORMASI ===== */
    .berita-hero {
        background: #FFF7F9;
        padding: 3.5rem 0 2.5rem;
        border-bottom: 1px solid #E9CDD5;
    }
    .berita-hero-label {
        display: inline-block;
        background: #F4D6DE;
        color: #711C35;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        padding: 0.35rem 1.2rem;
        border-radius: 50px;
        margin-bottom: 0.85rem;
        border: 1px solid #E9CDD5;
    }
    .berita-hero-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 2.3rem;
        color: #28151D;
        margin-bottom: 0.65rem;
        letter-spacing: -0.5px;
    }
    .berita-hero-desc {
        font-size: 1rem;
        color: #475569;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* ===== FILTER BAR (CARI SELEBAR CONTAINER) ===== */
    .berita-filter-section {
        margin-top: -25px;
        position: relative;
        z-index: 10;
    }
    .filter-card {
        border: 1px solid #E9CDD5 !important;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(26, 10, 15, 0.08) !important;
        background: #FFFFFF;
    }
    .filter-input {
        border: 1.5px solid #E9CDD5;
        border-radius: 12px;
        padding: 0.75rem 1.25rem;
        font-size: 0.95rem;
        color: #28151D;
        background-color: #FFFFFF;
        transition: all 0.2s ease;
        width: 100%;
    }
    .filter-input:focus {
        border-color: #711C35;
        box-shadow: 0 0 0 3px rgba(163, 59, 89, 0.2);
        outline: none;
    }
    .filter-input::placeholder {
        color: rgba(40, 21, 29, 0.45);
    }

    /* ===== KELOMPOK UTAMA (CARD BESAR & 2 CARD KECIL) ===== */
    .kelompok-utama-row {
        align-items: stretch;
    }
    .featured-main-card {
        min-height: 380px;
        height: 100%;
        background: #1A0A0F;
        border-radius: 16px;
        position: relative;
        overflow: hidden;
        border: 1px solid #E9CDD5;
        box-shadow: 0 4px 20px rgba(26, 10, 15, 0.08);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }
    .featured-bg-img {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        object-fit: cover;
        z-index: 1;
        transition: transform 0.4s ease;
    }
    .featured-main-card:hover .featured-bg-img {
        transform: scale(1.03);
    }
    .featured-bg-fallback {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(135deg, #1A0A0F 0%, #711C35 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
    }
    .featured-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(180deg, rgba(26, 10, 15, 0.2) 0%, rgba(26, 10, 15, 0.6) 45%, rgba(26, 10, 15, 0.96) 100%);
        z-index: 2;
        pointer-events: none;
    }
    .featured-content {
        position: relative;
        z-index: 3;
        padding: 2rem;
    }
    .featured-title {
        font-size: 1.45rem;
        font-weight: 700;
        line-height: 1.35;
        margin-bottom: 0.65rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .featured-excerpt {
        font-size: 0.9rem;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* 2 CARD KECIL BERTUMPUK DI KANAN */
    .side-compact-card {
        border-radius: 16px;
        border: 1px solid #E9CDD5;
        background: #ffffff;
        box-shadow: 0 4px 14px rgba(26, 10, 15, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        overflow: hidden;
    }
    .side-compact-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(26, 10, 15, 0.1);
    }
    .side-card-img-wrap {
        width: 140px;
        min-width: 140px;
        background: #FFF7F9;
        overflow: hidden;
        position: relative;
    }
    .side-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }
    .side-compact-card:hover .side-card-img {
        transform: scale(1.06);
    }
    .side-card-img-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #FFF7F9;
    }
    .side-card-title {
        font-size: 0.98rem;
        font-weight: 700;
        line-height: 1.4;
        margin-bottom: 0.4rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .side-card-title a {
        color: #28151D;
        transition: color 0.2s;
    }
    .side-card-title a:hover {
        color: #711C35;
    }

    /* ===== DERETAN CARD INFORMASI TAMBAHAN (GRID 3 KOLOM) ===== */
    .info-card-standard {
        background: #ffffff;
        border: 1px solid #E9CDD5;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(26, 10, 15, 0.05);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        display: flex;
        flex-direction: column;
    }
    .info-card-standard:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(26, 10, 15, 0.12);
    }
    .info-card-img-wrap {
        width: 100%;
        aspect-ratio: 16/10;
        overflow: hidden;
        background: #FFF7F9;
        position: relative;
    }
    .info-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }
    .info-card-standard:hover .info-card-img {
        transform: scale(1.05);
    }
    .info-card-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #FFF7F9 0%, #F4D6DE 100%);
    }
    .info-card-title {
        font-size: 1.05rem;
        font-weight: 700;
        line-height: 1.4;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .info-card-title a {
        color: #28151D;
        transition: color 0.2s;
    }
    .info-card-title a:hover {
        color: #711C35;
    }
    .info-card-excerpt {
        font-size: 0.86rem;
        color: #475569;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ===== AGENDA SECTION & CARDS ===== */
    .agenda-card {
        border-radius: 16px;
        border: 1px solid #E9CDD5;
        background: #ffffff;
        box-shadow: 0 4px 16px rgba(26, 10, 15, 0.05);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .agenda-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(26, 10, 15, 0.12);
    }
    .agenda-card-img-wrap {
        width: 100%;
        aspect-ratio: 16/9;
        overflow: hidden;
        background: #FFF7F9;
    }
    .agenda-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .agenda-card-img-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(145deg, #FFF7F9 0%, #F4D6DE 100%);
    }

    /* ===== TOMBOL KECIL (BACA SELENGKAPNYA / SELENGKAPNYA) ===== */
    .btn-readmore-small {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.82rem;
        font-weight: 600;
        color: #711C35;
        text-decoration: none;
        padding: 5px 12px;
        border-radius: 6px;
        background: #FFF7F9;
        border: 1px solid #E9CDD5;
        transition: all 0.2s ease;
        line-height: 1.2;
    }
    .btn-readmore-small:hover {
        background: #711C35;
        color: #ffffff;
        border-color: #711C35;
    }
    .btn-readmore-light {
        background: rgba(255, 255, 255, 0.95);
        color: #28151D;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
    }
    .btn-readmore-light:hover {
        background: #ffffff;
        color: #711C35;
    }

    /* ICONS & DIVIDERS */
    .card-header-icon-box {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #FFF7F9;
        border: 1px solid #E9CDD5;
        color: #711C35;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .card-header-divider {
        color: #94A3B8;
        font-size: 1.3rem;
        font-weight: 300;
        line-height: 1;
    }

    /* ===== PAGINATION ===== */
    .berita-pagination-wrapper {
        display: flex;
        justify-content: center;
    }
    .berita-pagination-wrapper .pagination {
        gap: 0.35rem;
    }
    .berita-pagination-wrapper .page-link {
        border: 1px solid #E9CDD5;
        border-radius: 8px;
        padding: 0.45rem 0.95rem;
        font-size: 0.88rem;
        color: #711C35;
        background: #ffffff;
        transition: all 0.2s;
    }
    .berita-pagination-wrapper .page-link:hover {
        background: #FFF7F9;
        border-color: #711C35;
        color: #28151D;
    }
    .berita-pagination-wrapper .page-item.active .page-link {
        background: #711C35;
        border-color: #711C35;
        color: #fff;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 991.98px) {
        .featured-main-card {
            min-height: 340px;
        }
    }
    @media (max-width: 767.98px) {
        .berita-hero {
            padding: 2.5rem 0 2rem;
        }
        .berita-hero-title {
            font-size: 1.7rem;
        }
        .featured-content {
            padding: 1.25rem;
        }
        .featured-title {
            font-size: 1.2rem;
        }
        .side-card-img-wrap {
            width: 110px;
            min-width: 110px;
        }
        .btn-readmore-small {
            padding: 6px 14px;
            font-size: 0.85rem;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        var filterTimer;

        // Auto filter saat mengetik di input Cari (debounced)
        $('#searchInput').on('input', function() {
            clearTimeout(filterTimer);
            filterTimer = setTimeout(function() {
                $('#beritaFilterForm').trigger('submit');
            }, 350);
        });

        // Form submit AJAX handler
        $('#beritaFilterForm').on('submit', function(e) {
            e.preventDefault();
            var $form = $(this);
            
            // Susun query string: pertahankan kata kunci cari dan kategori aktif
            var params = [];
            var searchVal = ($('#searchInput').val() || '').trim();
            var catVal = ($('#filterCategoryInput').val() || '').trim();

            if (searchVal) {
                params.push('search=' + encodeURIComponent(searchVal));
            }
            if (catVal) {
                params.push('category=' + encodeURIComponent(catVal));
            }

            var queryString = params.length ? '?' + params.join('&') : '';
            var url = $form.attr('action') + queryString;
            var $container = $('#informasiContentArea');

            if (window.history.pushState) {
                window.history.pushState(null, '', url);
            }

            // Sinkronkan sorotan kategori aktif pada dropdown Informasi di navbar
            $('.informasi-dropdown-item').removeClass('active');
            if (catVal) {
                $('.informasi-dropdown-item[data-category="' + catVal + '"]').addClass('active');
            } else {
                $('.informasi-dropdown-item[data-category=""]').addClass('active');
            }

            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function() {
                    $container.css('opacity', '0.45');
                },
                success: function(response) {
                    var $newContent = $(response).find('#informasiContentArea');
                    if ($newContent.length) {
                        $container.html($newContent.html());
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Filter AJAX error:', error);
                },
                complete: function() {
                    $container.css('opacity', '1');
                }
            });
        });

        // Pagination AJAX handler
        $(document).on('click', '.berita-pagination-wrapper a.page-link', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var $container = $('#informasiContentArea');

            if (window.history.pushState) {
                window.history.pushState(null, '', url);
            }

            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function() {
                    $container.css('opacity', '0.45');
                },
                success: function(response) {
                    var $newContent = $(response).find('#informasiContentArea');
                    if ($newContent.length) {
                        $container.html($newContent.html());
                    }
                    $('html, body').animate({ scrollTop: $('#informasiContentArea').offset().top - 120 }, 300);
                },
                complete: function() {
                    $container.css('opacity', '1');
                }
            });
        });

        // Dukung tombol Back / Forward browser
        window.addEventListener('popstate', function() {
            var searchParams = new URLSearchParams(window.location.search);
            var searchVal = searchParams.get('search') || '';
            var catVal = searchParams.get('category') || '';

            $('#searchInput').val(searchVal);
            $('#filterCategoryInput').val(catVal);

            $('.informasi-dropdown-item').removeClass('active');
            if (catVal) {
                $('.informasi-dropdown-item[data-category="' + catVal + '"]').addClass('active');
            } else {
                $('.informasi-dropdown-item[data-category=""]').addClass('active');
            }

            var $container = $('#informasiContentArea');
            if ($container.length) {
                $.ajax({
                    url: window.location.href,
                    type: 'GET',
                    beforeSend: function() {
                        $container.css('opacity', '0.45');
                    },
                    success: function(response) {
                        var $newContent = $(response).find('#informasiContentArea');
                        if ($newContent.length) {
                            $container.html($newContent.html());
                        }
                    },
                    complete: function() {
                        $container.css('opacity', '1');
                    }
                });
            }
        });
    });
</script>
@endpush
