@extends('layouts.app')
@section('title', 'Sejarah - HIMATIKA UNUJA')

@section('content')

{{-- ==================== OPENING BANNER SEJARAH ==================== --}}
<section class="tentang-opening-banner">
    <div class="container position-relative" style="z-index: 1;">
        <span class="tentang-hero-label">SEJARAH</span>
        <h1 class="tentang-hero-heading">Sejarah HIMATIKA UNUJA</h1>
        <p class="tentang-hero-desc">Mengenal awal berdiri dan perjalanan Himpunan Mahasiswa Matematika Universitas Nurul Jadid.</p>
    </div>
</section>

{{-- ==================== KONTEN UTAMA SEJARAH ==================== --}}
<section class="sejarah-section-wrapper">
    <div class="container">
        @if(($siteSettings['history_is_visible'] ?? '1') === '0')
            <div class="text-center py-5">
                <div class="p-5 bg-white rounded-4 border shadow-sm mx-auto" style="max-width: 620px;">
                    <div class="mb-3 text-muted">
                        <i class="fas fa-eye-slash fa-3x" style="color: var(--burgundy-accent);"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: var(--burgundy-darkest);">Halaman Sejarah Sedang Dinonaktifkan</h3>
                    <p class="text-muted mb-4">Informasi Sejarah saat ini sedang diperbarui oleh administrator organisasi.</p>
                    <a href="{{ route('home') }}" class="btn px-4 py-2 text-white rounded-pill" style="background: var(--burgundy-main);">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        @else
        <div class="sejarah-card-wrapper mx-auto">
            
            {{-- 1. CARD UTAMA SEJARAH --}}
            <div class="card-sejarah-main">

                {{-- 2. GAMBAR UTAMA SEJARAH --}}
                @php
                    $historyImg = asset('images/gedung-man1-probolinggo.jpg');
                    if (!empty($siteSettings['history_image']) && file_exists(public_path('storage/' . $siteSettings['history_image']))) {
                        $historyImg = asset('storage/' . $siteSettings['history_image']);
                    } elseif (!empty($profile->image) && file_exists(public_path('storage/' . $profile->image))) {
                        $historyImg = asset('storage/' . $profile->image);
                    } elseif (file_exists(public_path('images/gedung-man1-probolinggo.jpg'))) {
                        $historyImg = asset('images/gedung-man1-probolinggo.jpg');
                    }
                @endphp
                <div class="sejarah-img-container">
                    <img src="{{ $historyImg }}" alt="Sejarah HIMATIKA UNUJA" class="sejarah-building-img">
                </div>

                {{-- 3. ISI SEJARAH --}}
                <div class="sejarah-body-content">
                    @if(!empty($siteSettings['history_subtitle']))
                        <h3 class="sejarah-content-heading">{{ $siteSettings['history_subtitle'] }}</h3>
                    @endif
                    
                    @if($profile && !empty($profile->history))
                        <div class="sejarah-paragraphs">
                            @if(strip_tags($profile->history) === $profile->history)
                                {!! nl2br(e($profile->history)) !!}
                            @else
                                {!! $profile->history !!}
                            @endif
                        </div>
                    @else
                        <div class="sejarah-paragraphs">
                            <p>
                                HIMATIKA UNUJA merupakan organisasi kemahasiswaan di bawah naungan Program Studi Matematika Fakultas Sains dan Teknologi Universitas Nurul Jadid yang berdedikasi mewadahi aspirasi, penalaran, dan pengembangan keilmuan mahasiswa.
                            </p>
                            <p>
                                Sejak awal pembentukannya, HIMATIKA UNUJA berkomitmen memperkuat kebersamaan, menjunjung tinggi nilai-nilai keislaman dan kepesantrenan, serta terus berinovasi dalam mengabdi dan berkarya demi kemajuan civitas akademika dan masyarakat luas.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- 4. CARD DOKUMENTASI SEJARAH (BAWAH) --}}
            <div class="card-dokumentasi-wrapper">
                <div class="dokumentasi-text">
                    <h4 class="dokumentasi-title">{{ $siteSettings['history_doc_text'] ?? 'Dokumentasi Sejarah' }}</h4>
                    <p class="dokumentasi-desc">
                        {{ $siteSettings['history_doc_desc'] ?? 'Jelajahi dokumentasi dan arsip sejarah perjalanan HIMATIKA UNUJA dalam galeri kami.' }}
                    </p>
                </div>
                <div class="dokumentasi-btn-box">
                    <a href="{{ $siteSettings['history_doc_url'] ?? route('galeri') }}" class="btn-lihat-galeri">
                        <i class="fas fa-images"></i>
                        <span>{{ $siteSettings['history_doc_text'] ?? 'Lihat Galeri' }}</span>
                    </a>
                </div>
            </div>

        </div>
        @endif
    </div>
</section>

@endsection

@push('styles')
<style>
    /* ==================== OPENING BANNER MENU TENTANG ==================== */
    .tentang-opening-banner {
        background-color: #FFF7FA;
        padding: 125px 0 36px;
        margin-top: 0;
        border-top: none;
        border-bottom: 1px solid #E2CBD3;
        position: relative;
        overflow: hidden;
        height: auto;
        min-height: auto;
    }
    .tentang-opening-banner::before {
        content: '';
        position: absolute;
        top: -80px;
        right: -80px;
        width: 280px;
        height: 280px;
        background: radial-gradient(circle, rgba(100, 29, 56, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .tentang-opening-banner::after {
        content: '';
        position: absolute;
        bottom: -60px;
        left: -60px;
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(138, 49, 81, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .tentang-hero-label {
        display: inline-block;
        background: #641D38;
        color: #FFF7FA;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 2px;
        padding: 6px 18px;
        border-radius: 50px;
        margin-bottom: 12px;
        text-transform: uppercase;
    }
    .tentang-hero-heading {
        font-size: 2.15rem;
        font-weight: 800;
        color: #32121F;
        line-height: 1.25;
        margin-bottom: 10px;
        text-align: left;
    }
    .tentang-hero-desc {
        font-size: 0.98rem;
        font-weight: 500;
        color: #641D38;
        max-width: 720px;
        line-height: 1.65;
        margin-bottom: 0;
        text-align: left;
    }

    /* ==================== KONTEN SECTION SEJARAH ==================== */
    .sejarah-section-wrapper {
        background-color: #F6E9EE;
        min-height: calc(100vh - 280px);
        padding: 48px 0 80px;
    }

    /* Container Wrapper di Tengah */
    .sejarah-card-wrapper {
        max-width: 860px;
        width: 100%;
        padding: 0 15px;
    }

    /* 1. CARD UTAMA */
    .card-sejarah-main {
        background: #ffffff;
        border-radius: 20px;
        padding: 32px 34px 36px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.02);
        border: 1px solid #E2CBD3;
    }

    /* 2. GAMBAR UTAMA */
    .sejarah-img-container {
        width: 100%;
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 24px;
        background-color: #f1f1f1;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }
    .sejarah-building-img {
        width: 100%;
        height: auto;
        max-height: 380px;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }

    /* 3. ISI SEJARAH */
    .sejarah-body-content {
        margin-top: 6px;
    }
    .sejarah-content-heading {
        color: #32121F;
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 16px;
        line-height: 1.35;
    }
    .sejarah-paragraphs,
    .sejarah-paragraphs p {
        color: #4A4A4A;
        font-size: 0.9rem;
        line-height: 1.8;
        text-align: justify;
        text-justify: inter-word;
        margin-bottom: 16px;
    }
    .sejarah-paragraphs p:last-child {
        margin-bottom: 0;
    }

    /* 4. CARD DOKUMENTASI SEJARAH (BAWAH) */
    .card-dokumentasi-wrapper {
        background: #ffffff;
        border-radius: 16px;
        padding: 22px 30px;
        margin-top: 22px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.02);
        border: 1px solid #E2CBD3;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }
    .dokumentasi-title {
        color: #32121F;
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .dokumentasi-desc {
        color: #641D38;
        font-size: 0.85rem;
        margin-bottom: 0;
        line-height: 1.5;
        opacity: 0.85;
    }
    .btn-lihat-galeri {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #641D38;
        color: #ffffff !important;
        font-size: 0.85rem;
        font-weight: 600;
        padding: 9px 24px;
        border-radius: 9999px;
        text-decoration: none;
        white-space: nowrap;
        box-shadow: 0 2px 8px rgba(100, 29, 56, 0.25);
        transition: all 0.25s ease;
    }
    .btn-lihat-galeri:hover {
        background: #8A3151;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(100, 29, 56, 0.35);
    }

    /* RESPONSIVE SMARTPHONE / HP */
    @media (max-width: 767.98px) {
        .tentang-opening-banner {
            padding: 105px 0 28px;
        }
        .tentang-hero-heading {
            font-size: 1.75rem;
            margin-bottom: 8px;
        }
        .tentang-hero-desc {
            font-size: 0.92rem;
        }
        .sejarah-section-wrapper {
            padding: 32px 0 60px;
        }
        .sejarah-card-wrapper {
            padding: 0 10px;
        }
        .card-sejarah-main {
            padding: 20px 16px 24px;
            border-radius: 16px;
        }
        .sejarah-img-container {
            border-radius: 10px;
            margin-bottom: 18px;
        }
        .sejarah-building-img {
            max-height: 220px;
        }
        .sejarah-content-heading {
            font-size: 1.15rem;
            margin-bottom: 12px;
        }
        .sejarah-paragraphs,
        .sejarah-paragraphs p {
            font-size: 0.85rem;
            line-height: 1.7;
            margin-bottom: 14px;
        }
        .card-dokumentasi-wrapper {
            flex-direction: column;
            align-items: flex-start;
            padding: 18px 16px;
            gap: 14px;
        }
        .dokumentasi-btn-box {
            width: 100%;
        }
        .btn-lihat-galeri {
            width: 100%;
        }
    }
</style>
@endpush
