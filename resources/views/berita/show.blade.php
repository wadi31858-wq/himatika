@extends('layouts.app')
@section('title', $news->title . ' - HIMATIKA UNUJA')

@section('content')

@php
    $mainImgSrc = null;
    $isPoster = false;
    if (!empty($news->thumbnail)) {
        $storagePath = storage_path('app/public/' . $news->thumbnail);
        if (file_exists($storagePath)) {
            $mainImgSrc = asset('storage/' . $news->thumbnail);
            $sz = @getimagesize($storagePath);
            if ($sz && $sz[1] >= $sz[0] * 0.9) {
                $isPoster = true;
            }
        } elseif (file_exists(public_path('storage/' . $news->thumbnail))) {
            $mainImgSrc = asset('storage/' . $news->thumbnail);
            $sz = @getimagesize(public_path('storage/' . $news->thumbnail));
            if ($sz && $sz[1] >= $sz[0] * 0.9) {
                $isPoster = true;
            }
        } elseif (file_exists(public_path($news->thumbnail))) {
            $mainImgSrc = asset($news->thumbnail);
            $sz = @getimagesize(public_path($news->thumbnail));
            if ($sz && $sz[1] >= $sz[0] * 0.9) {
                $isPoster = true;
            }
        }
    }

    // Cek apakah artikel merupakan tema November disiplin belajar (untuk catatan ilustrasi)
    $isIllustration = str_contains(strtolower($news->slug), 'november') || str_contains(strtolower($news->title), 'november');
@endphp

<section class="berita-detail-section py-4 py-md-5">
    <div class="container">

        {{-- 1. JUDUL DAN METADATA (BAGIAN PALING ATAS) --}}
        <div class="berita-header-wrap mb-4">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge-detail-category">{{ strtoupper($news->category ?: 'BERITA') }}</span>
                <span class="badge-detail-date">{{ $news->published_at ? $news->published_at->format('d M Y') : '' }}</span>
            </div>
            <h1 class="berita-detail-title">{{ $news->title }}</h1>
            <div class="berita-detail-meta">
                <i class="fas fa-user text-muted me-1"></i>
                <span>{{ $news->author ?: 'Tim Humas' }}</span>
            </div>
        </div>

        {{-- 2. DUA KOLOM LAYOUT (70:30 DI DESKTOP, 1 KOLOM DI HP) --}}
        <div class="berita-content-grid">

            {{-- KOLOM KIRI (~70%): FOTO UTAMA & CARD DESKRIPSI BERITA --}}
            <div class="berita-col-main">

                {{-- FOTO UTAMA --}}
                @if($mainImgSrc)
                    <div class="berita-main-photo-frame">
                        <img src="{{ $mainImgSrc }}" 
                             alt="{{ $news->title }}" 
                             class="berita-main-img {{ $isPoster ? 'is-poster' : '' }}">
                        @if($isIllustration)
                            <div class="berita-photo-badge-note">
                                <i class="fas fa-camera me-1"></i> Ilustrasi suasana belajar
                            </div>
                        @endif
                    </div>
                @endif

                {{-- CARD DESKRIPSI BERITA (PUTIH, TEPAT DI BAWAH FOTO) --}}
                <div class="berita-desc-box">
                    <h2 class="berita-desc-heading">Deskripsi Berita</h2>
                    <div class="berita-article-body">
                        {!! $news->content !!}
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN (~30%): PANEL BERITA TERBARU --}}
            <div class="berita-col-aside">
                <div class="berita-terbaru-panel">
                    <h3 class="berita-terbaru-heading">Berita Terbaru</h3>
                    <div class="d-flex flex-column gap-3">
                        @forelse($recentNews as $rn)
                            @php
                                $rnThumb = null;
                                if (!empty($rn->thumbnail)) {
                                    if (file_exists(public_path('storage/' . $rn->thumbnail)) || file_exists(storage_path('app/public/' . $rn->thumbnail))) {
                                        $rnThumb = asset('storage/' . $rn->thumbnail);
                                    } elseif (file_exists(public_path($rn->thumbnail))) {
                                        $rnThumb = asset($rn->thumbnail);
                                    }
                                }
                            @endphp
                            <a href="{{ route('berita.show', $rn->slug) }}" class="berita-terbaru-item">
                                @if($rnThumb)
                                    <div class="berita-terbaru-thumb-box">
                                        <img src="{{ $rnThumb }}" alt="{{ $rn->title }}" class="berita-terbaru-thumb-img">
                                    </div>
                                @endif
                                <div class="berita-terbaru-info">
                                    <h4 class="berita-terbaru-title">{{ $rn->title }}</h4>
                                    <span class="berita-terbaru-date">{{ $rn->published_at ? $rn->published_at->format('d M Y') : '' }}</span>
                                </div>
                            </a>
                        @empty
                            <p class="text-muted small mb-0">Belum ada berita terbaru lainnya.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        {{-- 3. BAGIAN BERITA TERKAIT (3 CARD DI BAWAH) --}}
        @if($relatedNews && $relatedNews->count())
            <div class="berita-related-wrap mt-5 pt-4">
                <h3 class="berita-related-heading mb-3">Berita Terkait</h3>
                <div class="row g-3">
                    @foreach($relatedNews as $item)
                        <div class="col-md-4 col-sm-6 col-12">
                            <a href="{{ route('berita.show', $item->slug) }}" class="berita-related-card">
                                <div>
                                    <span class="badge-terkait">{{ strtoupper($item->category ?: 'BERITA') }}</span>
                                    <h4 class="berita-related-title">{{ $item->title }}</h4>
                                </div>
                                <span class="berita-related-date">{{ $item->published_at ? $item->published_at->format('d M Y') : '' }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- 4. TOMBOL KEMBALI KE BERITA --}}
        <div class="mt-4 pt-2">
            <a href="{{ route('berita') }}" class="btn-kembali-berita">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Berita
            </a>
        </div>

    </div>
</section>

@push('styles')
<style>
    .berita-detail-section {
        background: #FDF2F4;
        min-height: 80vh;
    }

    .badge-detail-category {
        background: #711C35;
        color: #ffffff;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1px;
        padding: 4px 10px;
        border-radius: 4px;
        display: inline-block;
    }

    .badge-detail-date {
        background: #F4D6DE;
        color: #711C35;
        font-size: 0.74rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 4px;
        border: 1px solid #E9CDD5;
        display: inline-block;
    }

    .berita-detail-title {
        font-size: 1.85rem;
        font-weight: 800;
        color: #1A0A0F;
        line-height: 1.25;
        margin-bottom: 0.5rem;
        letter-spacing: -0.3px;
    }

    .berita-detail-meta {
        font-size: 0.85rem;
        color: #6B7280;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    /* 2-Column Grid (70:30 Desktop, 24px gap) */
    .berita-content-grid {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        gap: 24px;
    }

    .berita-col-main {
        flex: 0 0 calc(70% - 12px);
        width: calc(70% - 12px);
        min-width: 0;
    }

    .berita-col-aside {
        flex: 0 0 calc(30% - 12px);
        width: calc(30% - 12px);
        min-width: 0;
    }

    /* Foto Utama (280 - 300px desktop, rounded 12px) */
    .berita-main-photo-frame {
        width: 100%;
        height: 290px;
        border-radius: 12px;
        overflow: hidden;
        background: #F3E8EC;
        position: relative;
        box-shadow: 0 4px 14px rgba(113, 28, 53, 0.05);
        border: 1px solid rgba(233, 205, 213, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .berita-main-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
    }

    .berita-main-img.is-poster {
        object-fit: contain;
        background: #1A0A0F;
    }

    .berita-photo-badge-note {
        position: absolute;
        bottom: 10px;
        right: 12px;
        background: rgba(26, 10, 15, 0.78);
        backdrop-filter: blur(4px);
        color: #ffffff;
        font-size: 0.72rem;
        padding: 3px 10px;
        border-radius: 50px;
        font-weight: 500;
        pointer-events: none;
    }

    /* Card Deskripsi Berita (Tepat di bawah foto, gap 12-16px, padding 20px, rounded 12px) */
    .berita-desc-box {
        background: #ffffff;
        border: 1px solid rgba(233, 205, 213, 0.8);
        border-radius: 12px;
        padding: 20px;
        margin-top: 14px;
        box-shadow: 0 4px 16px rgba(113, 28, 53, 0.04);
    }

    .berita-desc-heading {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1A0A0F;
        margin-bottom: 10px;
    }

    .berita-article-body {
        font-size: 0.92rem;
        line-height: 1.75;
        color: #374151;
    }
    .berita-article-body p:last-child {
        margin-bottom: 0;
    }

    /* Panel Berita Terbaru */
    .berita-terbaru-panel {
        width: 100%;
    }

    .berita-terbaru-heading {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1A0A0F;
        margin-bottom: 14px;
    }

    .berita-terbaru-item {
        background: #ffffff;
        border: 1px solid rgba(233, 205, 213, 0.8);
        border-radius: 12px;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 2px 8px rgba(113, 28, 53, 0.03);
    }

    .berita-terbaru-item:hover {
        border-color: #711C35;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(113, 28, 53, 0.1);
    }

    .berita-terbaru-thumb-box {
        width: 56px;
        height: 56px;
        min-width: 56px;
        border-radius: 8px;
        overflow: hidden;
        background: #F3E8EC;
        flex-shrink: 0;
    }

    .berita-terbaru-thumb-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .berita-terbaru-info {
        flex-grow: 1;
        min-width: 0;
    }

    .berita-terbaru-title {
        font-size: 0.84rem;
        font-weight: 700;
        color: #1A0A0F;
        margin-bottom: 4px;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .berita-terbaru-item:hover .berita-terbaru-title {
        color: #711C35;
    }

    .berita-terbaru-date {
        font-size: 0.74rem;
        color: #8C7880;
        display: block;
        font-weight: 500;
    }

    /* Berita Terkait */
    .berita-related-wrap {
        border-top: 1px solid rgba(233, 205, 213, 0.7);
    }

    .berita-related-heading {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1A0A0F;
    }

    .berita-related-card {
        background: #ffffff;
        border: 1px solid rgba(233, 205, 213, 0.8);
        border-radius: 12px;
        padding: 16px 18px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 2px 8px rgba(113, 28, 53, 0.03);
    }

    .berita-related-card:hover {
        border-color: #711C35;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(113, 28, 53, 0.08);
    }

    .badge-terkait {
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: #711C35;
        background: #F4D6DE;
        padding: 2px 8px;
        border-radius: 4px;
        display: inline-block;
        width: fit-content;
        margin-bottom: 8px;
    }

    .berita-related-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1A0A0F;
        line-height: 1.4;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .berita-related-card:hover .berita-related-title {
        color: #711C35;
    }

    .berita-related-date {
        font-size: 0.74rem;
        color: #8C7880;
        font-weight: 500;
    }

    .btn-kembali-berita {
        color: #711C35;
        font-weight: 700;
        text-decoration: none;
        font-size: 0.88rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-kembali-berita:hover {
        color: #541326;
        transform: translateX(-3px);
    }

    /* Mobile Responsive (767px and below) */
    @media (max-width: 767.98px) {
        .berita-content-grid {
            flex-direction: column;
            gap: 20px;
        }
        .berita-col-main,
        .berita-col-aside {
            flex: 0 0 100%;
            width: 100%;
        }
        .berita-main-photo-frame {
            height: 220px;
        }
        .berita-detail-title {
            font-size: 1.45rem;
        }
    }
</style>
@endpush
@endsection
