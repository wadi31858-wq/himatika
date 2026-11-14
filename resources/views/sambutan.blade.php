@extends('layouts.app')
@section('title', 'Sambutan Kaprodi - HIMATIKA UNUJA')

@section('content')

@php
    $kaprodiName = !empty($siteSettings['sambutan_name']) ? $siteSettings['sambutan_name'] : ($kaprodi->name ?? 'MUDAKKIR, S.Pd., MM.');
    $kaprodiRole = !empty($siteSettings['sambutan_title']) ? $siteSettings['sambutan_title'] : ($kaprodi->position ?? 'Ketua Program Studi Matematika');
    $badgeText = !empty($siteSettings['sambutan_badge']) ? $siteSettings['sambutan_badge'] : 'PESAN PIMPINAN';
    $rawTitle = !empty($siteSettings['sambutan_banner_title']) ? $siteSettings['sambutan_banner_title'] : 'Sambutan Kaprodi';

    if (stripos($rawTitle, 'Sambutan') === 0) {
        $titlePrefix = 'Sambutan';
        $titleAccent = trim(substr($rawTitle, 8));
        if (empty($titleAccent)) {
            $titleAccent = 'Kaprodi';
        }
    } else {
        $titlePrefix = $rawTitle;
        $titleAccent = '';
    }

    $kaprodiPhoto = null;
    if (!empty($siteSettings['sambutan_photo']) && file_exists(public_path('storage/' . $siteSettings['sambutan_photo']))) {
        $kaprodiPhoto = asset('storage/' . $siteSettings['sambutan_photo']);
    } elseif ($kaprodi && $kaprodi->photo && file_exists(public_path('storage/' . $kaprodi->photo))) {
        $kaprodiPhoto = asset('storage/' . $kaprodi->photo);
    } else {
        $kaprodiPhoto = asset('storage/profile/sambutan_1794400568_4jRmDkAS3by8fJdumt7yXqA03XvRNJdCIiK1z8KM.png');
    }
@endphp

{{-- ==================== OPENING BANNER SAMBUTAN KAPRODI ==================== --}}
<section class="tentang-opening-banner">
    <div class="container position-relative" style="z-index: 1;">
        <span class="tentang-hero-label">SAMBUTAN KAPRODI</span>
        <h1 class="tentang-hero-heading">Sambutan Kaprodi<br>HIMATIKA UNUJA</h1>
        <p class="tentang-hero-desc">Pesan dan arahan Ketua Program Studi Matematika Fakultas Matematika dan Ilmu Pengetahuan Alam Universitas Nurul Jadid.</p>
    </div>
</section>

<section class="sambutan-ref-section">
    <div class="container">
        @if(($siteSettings['sambutan_is_visible'] ?? '1') === '0')
            <div class="text-center py-5">
                <div class="p-5 bg-white rounded-4 border shadow-sm mx-auto" style="max-width: 620px;">
                    <div class="mb-3 text-muted">
                        <i class="fas fa-eye-slash fa-3x" style="color: var(--burgundy-accent);"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: var(--burgundy-darkest);">Halaman Sambutan Sedang Dinonaktifkan</h3>
                    <p class="text-muted mb-4">Informasi Sambutan Kaprodi saat ini sedang diperbarui oleh administrator organisasi.</p>
                    <a href="{{ route('home') }}" class="btn px-4 py-2 text-white rounded-pill" style="background: var(--burgundy-main);">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        @else
        <div class="sambutan-ref-card mx-auto" style="max-width: 1060px;">
            {{-- Header: — PESAN PIMPINAN & Sambutan Kaprodi --}}
            <div class="sambutan-ref-header">
                <div class="sambutan-ref-badge-wrap">
                    <span class="sambutan-ref-bar"></span>
                    <span class="sambutan-ref-badge-text">{{ $badgeText }}</span>
                </div>
                <h1 class="sambutan-ref-title">
                    {{ $titlePrefix }}@if($titleAccent)<span class="sambutan-title-accent">{{ $titleAccent }}</span>@endif
                </h1>
            </div>

            {{-- 2 Columns: Photo Left, Italic Message Right --}}
            <div class="row g-4 g-lg-5 align-items-center">
                {{-- Left: Portrait Frame with rounded corners & green border --}}
                <div class="col-lg-4 col-md-5 col-12 text-center">
                    <div class="sambutan-ref-photo-frame mx-auto">
                        <img src="{{ $kaprodiPhoto }}" alt="{{ $kaprodiName }}" class="sambutan-ref-photo-img">
                    </div>
                </div>

                {{-- Right: Italic Message + Divider + Signature --}}
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="sambutan-ref-body">
                        @if(!empty($siteSettings['sambutan_content']))
                            @foreach(explode("\n", str_replace("\r", "", $siteSettings['sambutan_content'])) as $paragraph)
                                @if(trim($paragraph) !== '')
                                    <p class="sambutan-ref-p">
                                        {{ trim($paragraph) }}
                                    </p>
                                @endif
                            @endforeach
                        @else
                            <p class="sambutan-ref-p">
                                Assalamualaikum warahmatullahi wabarakatuh. Puji syukur ke hadirat Allah SWT atas segala limpahan rahmat dan karunia-Nya sehingga website resmi HIMATIKA Universitas Nurul Jadid dapat hadir sebagai media informasi dan komunikasi bagi seluruh mahasiswa, civitas akademika, alumni, serta masyarakat luas.
                            </p>
                            <p class="sambutan-ref-p">
                                Website ini kami hadirkan sebagai upaya strategis untuk memperkuat transparansi, meningkatkan kualitas pelayanan informasi kemahasiswaan, serta mempererat tali silaturahmi antara program studi, dosen, mahasiswa, dan masyarakat luas.
                            </p>
                            <p class="sambutan-ref-p mb-0">
                                Semoga wadah ini dapat menjadi pendorong kemajuan intelektual, moral, dan prestasi keilmuan matematika bagi seluruh keluarga besar HIMATIKA UNUJA.
                            </p>
                        @endif

                        {{-- Horizontal Divider --}}
                        <div class="sambutan-ref-divider"></div>

                        {{-- Signature Block --}}
                        <div class="sambutan-ref-sig-name">
                            {{ $kaprodiName }}
                        </div>
                        <div class="sambutan-ref-sig-role">
                            {{ $kaprodiRole }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

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
    .sambutan-ref-section {
        padding: 48px 0 80px;
        background: #F6E9EE;
    }
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
        .sambutan-ref-section {
            padding: 32px 0 60px;
        }
    }
</style>
@endpush

@endsection
