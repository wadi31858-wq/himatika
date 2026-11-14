@extends('layouts.app')
@section('title', ($siteSettings['vm_banner_title'] ?? 'Visi dan Misi') . ' - HIMATIKA UNUJA')

@section('content')

@php
    $vmBannerTitle = $siteSettings['vm_banner_title'] ?? 'Visi dan Misi';
    $vmBannerSubtitle = $siteSettings['vm_banner_subtitle'] ?? 'Arah dan tujuan pengembangan HIMATIKA UNUJA.';
    $vmVisionTitle = $siteSettings['vm_vision_title'] ?? 'Visi HIMATIKA UNUJA';
    $vmMissionTitle = $siteSettings['vm_mission_title'] ?? 'Misi HIMATIKA UNUJA';
    $vmIsVisible = ($siteSettings['vm_is_visible'] ?? '1') !== '0';
@endphp

{{-- ==================== BANNER VISI & MISI ==================== --}}
<section class="tentang-opening-banner" id="visi-misi-section">
    <div class="container position-relative" style="z-index: 1;">
        <span class="tentang-hero-label">VISI &amp; MISI</span>
        <h1 class="tentang-hero-heading">{{ $vmBannerTitle }}</h1>
        @if(!empty($vmBannerSubtitle))
            <p class="tentang-hero-desc">{{ $vmBannerSubtitle }}</p>
        @endif
    </div>
</section>

{{-- ==================== KONTEN DUA CARD ==================== --}}
<section class="vm-content-section py-5">
    <div class="container">
        @if(!$vmIsVisible)
            {{-- Status Saat Halaman Dinonaktifkan / Disembunyikan --}}
            <div class="text-center py-5">
                <div class="p-5 bg-white rounded-4 border shadow-sm mx-auto" style="max-width: 620px;">
                    <div class="mb-3 text-muted">
                        <i class="fas fa-eye-slash fa-3x" style="color: var(--burgundy-accent);"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: var(--burgundy-darkest);">Halaman Visi dan Misi Sedang Dinonaktifkan</h3>
                    <p class="text-muted mb-4">Informasi Visi dan Misi saat ini sedang diperbarui oleh administrator organisasi.</p>
                    <a href="{{ route('home') }}" class="btn px-4 py-2 text-white rounded-pill" style="background: var(--burgundy-main);">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        @else
            <div class="row g-4 align-items-stretch">
                
                {{-- CARD KIRI: VISI --}}
                <div class="col-lg-5 col-md-6 col-12 d-flex">
                    <div class="card-visi-navy w-100 p-4 p-md-5 rounded-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="visi-quote-icon mb-3">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            
                            <h3 class="visi-title mb-3">{{ $vmVisionTitle }}</h3>
                            
                            <p class="visi-text">
                                “{{ $vm->vision ?? 'Menjadi organisasi mahasiswa Matematika yang aktif, inovatif, kolaboratif, dan unggul dalam pengembangan ilmu matematika serta sumber daya mahasiswa.' }}”
                            </p>
                        </div>

                        <div class="visi-footer-badge pt-3 mt-4 border-top border-white border-opacity-25">
                            <small class="text-white-50"><i class="fas fa-compass me-1"></i> Pedoman Strategis Organisasi</small>
                        </div>
                    </div>
                </div>

                {{-- CARD KANAN: MISI --}}
                <div class="col-lg-7 col-md-6 col-12 d-flex">
                    <div class="card-misi-white w-100 p-4 p-md-5 rounded-4 bg-white border shadow-sm d-flex flex-column justify-content-between">
                        <div>
                            <div class="misi-header mb-4">
                                <span class="misi-gold-subtitle">{{ $vmMissionTitle }}</span>
                            </div>

                            <div class="misi-list d-flex flex-column gap-3">
                                @forelse($mission as $index => $m)
                                    <div class="misi-item d-flex align-items-start gap-3">
                                        <div class="misi-num-badge">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="misi-text-content flex-grow-1">
                                            {{ $m }}
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-muted fst-italic py-3">
                                        Belum ada butir misi yang ditambahkan.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="misi-footer-note pt-3 mt-4 border-top border-light-subtle text-end">
                            <small class="text-muted"><i class="fas fa-check-circle text-primary me-1"></i> Komitmen Implementasi Kepengurusan</small>
                        </div>
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
        scroll-margin-top: 85px;
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

    /* SECTION KONTEN */
    .vm-content-section {
        background-color: #F6E9EE;
        min-height: auto;
    }

    /* CARD VISI */
    .card-visi-navy {
        background: linear-gradient(145deg, #250D17 0%, #641D38 100%);
        border: 1px solid #8A3151;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(37, 13, 23, 0.25);
        color: #FFF7FA;
    }
    .visi-quote-icon {
        font-size: 2.5rem;
        color: #8A3151;
        opacity: 0.9;
        line-height: 1;
    }
    .visi-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #FFF7FA;
        letter-spacing: -0.3px;
    }
    .visi-text {
        font-size: 1.05rem;
        line-height: 1.8;
        color: #FFF7FA;
        font-style: italic;
    }

    /* CARD MISI */
    .card-misi-white {
        background: #FFFFFF !important;
        border: 1px solid #E2CBD3 !important;
        border-radius: 16px;
    }
    .misi-gold-subtitle {
        font-size: 1rem;
        font-weight: 700;
        color: #641D38;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .misi-item {
        padding: 6px 0;
    }
    .misi-num-badge {
        width: 30px;
        height: 30px;
        min-width: 30px;
        background: #8A3151;
        color: #FFF7FA;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
        margin-top: 2px;
        box-shadow: 0 2px 6px rgba(138, 49, 81, 0.25);
    }
    .misi-text-content {
        font-size: 0.96rem;
        line-height: 1.7;
        color: #32121F;
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
        .card-visi-navy, .card-misi-white {
            padding: 24px 20px !important;
        }
        .visi-title {
            font-size: 1.35rem;
        }
    }
</style>
@endpush
