@extends('layouts.app')

@section('title', $jabatan->position . ' - HIMATIKA UNUJA')

@section('content')
<style>
    :root {
        --bg-dark: #250D17;
        --burgundy-main: #641D38;
        --burgundy-hover: #541326;
        --burgundy-focus: #8A3151;
        --rose-soft: #F6E9EE;
        --rose-pale: #FFF7FA;
        --text-dark: #32121F;
        --border-rose: #E2CBD3;
        --pure-white: #FFFFFF;
    }

    .detail-wrapper {
        background-color: var(--rose-pale);
        padding: 96px 0 70px;
        min-height: 100vh;
    }

    .detail-back-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: var(--burgundy-main);
        text-decoration: none;
        font-weight: 700;
        font-size: 0.92rem;
        transition: all 0.2s ease;
    }
    .detail-back-link:hover {
        color: var(--burgundy-hover);
        transform: translateX(-3px);
        text-decoration: none;
    }
    .detail-back-link i {
        font-size: 0.85rem !important;
        line-height: 1 !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .breadcrumb-nav {
        font-size: 0.85rem;
        color: rgba(40, 21, 29, 0.6);
    }
    .breadcrumb-nav a {
        color: var(--burgundy-main);
        text-decoration: none;
        font-weight: 600;
    }
    .breadcrumb-nav a:hover {
        color: var(--burgundy-hover);
        text-decoration: underline;
    }

    /* Main Burgundy Card */
    .hero-burgundy-card {
        background: linear-gradient(135deg, #641D38 0%, #250D17 100%);
        border-radius: 24px;
        padding: 48px;
        color: #ffffff;
        display: flex;
        gap: 40px;
        position: relative;
        overflow: hidden;
        margin-bottom: 56px;
        box-shadow: 0 16px 40px rgba(37, 13, 23, 0.2);
        border: 1px solid rgba(244, 214, 222, 0.2);
    }
    .hero-burgundy-card::before {
        content: '∑';
        position: absolute;
        top: -60px;
        left: -40px;
        opacity: 0.04;
        font-size: 340px;
        font-family: serif;
        user-select: none;
        pointer-events: none;
    }

    .hero-info-col {
        flex: 1;
        z-index: 1;
    }

    .hero-badge-pill {
        display: inline-block;
        background: var(--rose-soft);
        color: var(--burgundy-main);
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 1.5px;
        padding: 4px 14px;
        border-radius: 50px;
        margin-bottom: 12px;
        text-transform: uppercase;
    }

    .hero-title-text {
        font-size: 2.6rem;
        font-weight: 800;
        line-height: 1.15;
        margin-bottom: 8px;
        color: #ffffff;
    }

    .hero-officer-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--rose-soft);
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .hero-desc-text {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.85);
        line-height: 1.65;
        max-width: 90%;
        margin-bottom: 30px;
    }

    .hero-stat-box {
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.05);
        padding: 14px 20px;
        border-radius: 12px;
        min-width: 130px;
        backdrop-filter: blur(4px);
    }
    .hero-stat-num {
        color: var(--rose-soft);
        font-size: 1.8rem;
        font-weight: 800;
        margin: 0;
        line-height: 1;
    }
    .hero-stat-label {
        font-size: 0.72rem;
        color: rgba(255, 255, 255, 0.7);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .hero-photo-col {
        width: 360px;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }
    .hero-photo-wrap {
        width: 100%;
        height: 100%;
        min-height: 380px;
        background-color: rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        border: 2px solid rgba(244, 214, 222, 0.25);
    }
    .hero-photo-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
    }
    .hero-photo-watermark {
        position: absolute;
        bottom: 16px;
        right: 16px;
        background: var(--rose-soft);
        color: var(--burgundy-main);
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 50px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .terkait-chip {
        text-decoration: none;
        border: 1px solid rgba(255, 255, 255, 0.25);
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.85rem;
        color: #ffffff;
        display: inline-block;
        transition: all 0.2s ease;
        background: rgba(255, 255, 255, 0.06);
    }
    .terkait-chip:hover {
        background: rgba(255, 255, 255, 0.15);
        color: var(--rose-soft);
        transform: translateY(-2px);
    }

    /* Category Cards (Tugas Utama, Program, Tugas Teknis) */
    .role-category-card {
        background: var(--pure-white);
        border: 1px solid var(--border-rose);
        border-radius: 18px;
        padding: 32px 28px;
        height: 100%;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(100, 29, 56, 0.04);
        transition: all 0.25s ease;
    }
    .role-category-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(100, 29, 56, 0.08);
        border-color: var(--burgundy-focus);
    }
    .role-category-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: var(--burgundy-main);
    }

    .role-icon-box {
        width: 44px;
        height: 44px;
        background: var(--rose-soft);
        color: var(--burgundy-main);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .role-list-item {
        margin-bottom: 14px;
        display: flex;
        gap: 12px;
        color: var(--text-dark);
        font-size: 0.92rem;
        line-height: 1.55;
    }
    .role-list-item:last-child {
        margin-bottom: 0;
    }

    /* Anggota Section */
    .anggota-box {
        background: var(--pure-white);
        border: 1px solid var(--border-rose);
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(100, 29, 56, 0.04);
        margin-top: 56px;
    }

    .anggota-profile-card {
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid var(--border-rose);
        background: var(--pure-white);
        transition: all 0.25s ease;
    }
    .anggota-profile-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(100, 29, 56, 0.08);
        border-color: var(--burgundy-main);
    }
    .anggota-photo-area {
        height: 280px;
        background: var(--rose-soft);
        position: relative;
        overflow: hidden;
    }
    .anggota-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
    }

    /* Detail Org Chart Styles */
    .detail-org-chart {
        max-width: 960px;
        margin: 0 auto;
        position: relative;
    }
    .detail-card-row {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .detail-member-card {
        background: #ffffff;
        border: 1px solid var(--border-rose);
        border-radius: 16px;
        padding: 24px 20px 20px;
        text-align: center;
        box-shadow: 0 4px 18px rgba(100, 29, 56, 0.05);
        width: 100%;
        max-width: 260px;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        position: relative;
    }
    .detail-member-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(100, 29, 56, 0.12);
        border-color: var(--burgundy-main);
    }
    .detail-member-avatar-wrap {
        width: 96px;
        height: 96px;
        margin: 0 auto 14px;
        position: relative;
    }
    .detail-member-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        object-position: top center;
        border: 3px solid var(--border-rose);
        box-shadow: 0 4px 12px rgba(100, 29, 56, 0.1);
    }
    .detail-member-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: var(--rose-soft);
        color: var(--burgundy-main);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 46px;
        border: 3px solid var(--border-rose);
    }
    .detail-member-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .detail-member-badge {
        display: inline-block;
        background: var(--rose-soft);
        color: var(--burgundy-main);
        font-size: 0.78rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 50px;
        border: 1px solid var(--border-rose);
        letter-spacing: 0.3px;
        max-width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .detail-tree-line {
        width: 2px;
        height: 26px;
        background: var(--burgundy-main);
        margin: 0 auto;
    }
    .detail-split-bar {
        position: relative;
        width: 60%;
        margin: 0 auto;
        height: 2px;
        background: var(--burgundy-main);
    }
    .detail-split-bar::before,
    .detail-split-bar::after {
        content: '';
        position: absolute;
        top: 0;
        width: 2px;
        height: 18px;
        background: var(--burgundy-main);
    }
    .detail-split-bar::before { left: 0; }
    .detail-split-bar::after { right: 0; }
    .detail-tree-line-sub {
        height: 18px;
    }

    /* Dua Bagan Kelompok Divisi (Putra & Putri) */
    .divisi-kelompok-wrapper {
        background: #FFFFFF;
        border: 1px solid var(--border-rose);
        border-radius: 20px;
        padding: 30px 22px 34px;
        box-shadow: 0 4px 20px rgba(100, 29, 56, 0.04);
        transition: border-color 0.25s ease, box-shadow 0.25s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .divisi-kelompok-wrapper:hover {
        border-color: var(--burgundy-main);
        box-shadow: 0 8px 28px rgba(100, 29, 56, 0.08);
    }
    .divisi-kelompok-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--rose-soft);
        color: var(--burgundy-main);
        font-weight: 800;
        font-size: 0.96rem;
        letter-spacing: 0.5px;
        padding: 8px 24px;
        border-radius: 50px;
        border: 1.5px solid var(--border-rose);
        box-shadow: 0 2px 8px rgba(100, 29, 56, 0.06);
    }

    @media (max-width: 767.98px) {
        .divisi-kelompok-wrapper {
            padding: 22px 14px 26px;
            border-radius: 16px;
        }
        .divisi-kelompok-badge {
            font-size: 0.88rem;
            padding: 6px 18px;
        }
        .detail-member-card {
            max-width: 240px;
            padding: 20px 14px 16px;
        }
        .detail-member-avatar-wrap {
            width: 82px;
            height: 82px;
            margin: 0 auto 10px;
        }
        .detail-member-name {
            font-size: 0.98rem;
        }
        .detail-member-badge {
            font-size: 0.74rem;
        }
    }

    @media (max-width: 991.98px) {
        .hero-burgundy-card {
            flex-direction: column;
            padding: 32px 24px;
        }
        .hero-photo-col {
            width: 100%;
        }
        .hero-photo-wrap {
            min-height: 320px;
            max-height: 420px;
        }
        .hero-title-text {
            font-size: 2.1rem;
        }
    }
</style>

<div class="detail-wrapper">
    <div class="container">

        {{-- BREADCRUMB & BACK NAVIGATION --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <a href="{{ route('struktur-organisasi') }}" class="detail-back-link">
                <i class="fas fa-arrow-left"></i> <span>Kembali ke Struktur</span>
            </a>
            <div class="breadcrumb-nav">
                <a href="{{ route('home') }}">Beranda</a> / 
                <a href="{{ route('struktur-organisasi') }}">Struktur</a> / 
                <span style="color: var(--burgundy-main); font-weight: 700;">{{ $jabatan->position }}</span>
            </div>
        </div>

        {{-- MAIN BURGUNDY HERO CARD --}}
        <div class="hero-burgundy-card">
            <div class="hero-info-col">
                <span class="hero-badge-pill">DETAIL JABATAN RESMI</span>
                <h1 class="hero-title-text">{{ $jabatan->position }}</h1>
                
                @if($jabatan->name)
                <div class="hero-officer-name">
                    <i class="fas fa-id-badge"></i> {{ $jabatan->name }}
                </div>
                @endif

                <p class="hero-desc-text">
                    {{ $jabatan->description ?? 'Menjalankan tugas dan fungsi strategis dalam struktur kepengurusan HIMATIKA UNUJA periode 2026.' }}
                </p>

                @php
                    $isKaprodiPage = ($unitType ?? '') === 'kaprodi' 
                        || (isset($jabatan) && (
                            (int)$jabatan->id === 12 
                            || str_contains(strtolower($jabatan->position ?? ''), 'kaprodi') 
                            || str_contains(strtolower($jabatan->position ?? ''), 'program studi')
                            || str_contains(strtolower($jabatan->position ?? ''), 'pembina')
                        ));
                @endphp

                <div class="d-flex gap-3 flex-wrap {{ $isKaprodiPage ? 'mb-0' : 'mb-4' }}">
                    <div class="hero-stat-box">
                        <div class="hero-stat-num">{{ sprintf('%02d', $anggota->count() ?: 1) }}</div>
                        <span class="hero-stat-label">Anggota Aktif</span>
                    </div>
                    <div class="hero-stat-box">
                        <div class="hero-stat-num">{{ sprintf('%02d', count($roleData['tugas_utama'] ?? [1,2,3,4])) }}</div>
                        <span class="hero-stat-label">Tugas Utama</span>
                    </div>
                    <div class="hero-stat-box">
                        <div class="hero-stat-num">2026</div>
                        <span class="hero-stat-label">Periode Khidmat</span>
                    </div>
                </div>

                @if(!$isKaprodiPage && isset($terkait) && $terkait->count() > 0)
                <div class="mt-4 pt-2">
                    <div style="font-size: 0.76rem; text-transform: uppercase; letter-spacing: 1.5px; color: var(--rose-soft); margin-bottom: 8px; font-weight: 700;">
                        Jabatan Koordinasi Terkait:
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($terkait as $tk)
                        <a href="{{ route('struktur-organisasi.show', $tk->id) }}" class="terkait-chip">
                            <i class="fas fa-link me-1" style="font-size: 0.7rem; color: var(--rose-soft);"></i>
                            {{ $tk->position }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- OFFICIAL PHOTO COLUMN --}}
            <div class="hero-photo-col">
                <div class="hero-photo-wrap">
                    @if($heroUnitPhoto)
                        <img src="{{ $heroUnitPhoto }}" alt="{{ $jabatan->position }}" class="hero-photo-img">
                    @else
                        <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-white" style="min-height: 380px;">
                            <i class="fas fa-users" style="font-size: 80px; opacity: 0.5; margin-bottom: 12px;"></i>
                            <span style="font-size: 0.9rem; font-weight: 600; opacity: 0.85;">Foto Resmi Kepengurusan</span>
                        </div>
                    @endif
                    <div class="hero-photo-watermark">
                        HIMATIKA UNUJA
                    </div>
                </div>
            </div>
        </div>

        {{-- RUANG KERJA SECTION (Tugas Utama, Program, Tugas Teknis) --}}
        <div class="mb-5">
            <div class="mb-4">
                <span class="hero-badge-pill">RUANG KERJA</span>
                <h2 style="color: var(--text-dark); font-size: 1.9rem; font-weight: 800; margin-bottom: 6px;">
                    Arah kerja dalam satu pandangan.
                </h2>
                <p style="color: rgba(40,21,29,0.7); font-size: 0.95rem; margin-bottom: 0;">
                    Tugas, program, dan rincian teknis disusun agar peran jabatan ini mudah dipahami dan dilaksanakan secara optimal.
                </p>
            </div>

            <div class="row g-4">
                {{-- 1. Tugas Utama --}}
                <div class="col-lg-4 col-md-6">
                    <div class="role-category-card">
                        <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom: 1px solid var(--border-rose);">
                            <div class="role-icon-box">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div>
                                <span style="display: block; font-size: 0.7rem; color: rgba(40,21,29,0.6); text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">KATEGORI 01</span>
                                <h3 style="margin: 0; font-size: 1.15rem; color: var(--burgundy-main); font-weight: 700;">Tugas Utama</h3>
                            </div>
                        </div>
                        <div>
                            @foreach($roleData['tugas_utama'] as $tugas)
                            <div class="role-list-item">
                                <i class="fas fa-check-circle" style="color: var(--burgundy-main); margin-top: 3px; flex-shrink: 0;"></i>
                                <span>{{ $tugas }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- 2. Program Kerja --}}
                <div class="col-lg-4 col-md-6">
                    <div class="role-category-card">
                        <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom: 1px solid var(--border-rose);">
                            <div class="role-icon-box">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <div>
                                <span style="display: block; font-size: 0.7rem; color: rgba(40,21,29,0.6); text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">KATEGORI 02</span>
                                <h3 style="margin: 0; font-size: 1.15rem; color: var(--burgundy-main); font-weight: 700;">Program Kerja</h3>
                            </div>
                        </div>
                        <div>
                            @foreach($roleData['program'] as $prog)
                            <div class="role-list-item">
                                <div style="width: 8px; height: 8px; border-radius: 50%; background: var(--burgundy-focus); margin-top: 7px; flex-shrink: 0;"></div>
                                <span>{{ $prog }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- 3. Tugas Teknis --}}
                <div class="col-lg-4 col-md-12">
                    <div class="role-category-card">
                        <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom: 1px solid var(--border-rose);">
                            <div class="role-icon-box">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div>
                                <span style="display: block; font-size: 0.7rem; color: rgba(40,21,29,0.6); text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">KATEGORI 03</span>
                                <h3 style="margin: 0; font-size: 1.15rem; color: var(--burgundy-main); font-weight: 700;">Tugas Teknis</h3>
                            </div>
                        </div>
                        <div>
                            @foreach($roleData['tugas_teknis'] as $teknis)
                            <div class="role-list-item">
                                <div style="width: 14px; height: 3px; background: var(--burgundy-main); margin-top: 9px; flex-shrink: 0; border-radius: 2px;"></div>
                                <span>{{ $teknis }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION: STRUKTUR KEPENGURUSAN (BAGAN FOTO RESMI) --}}
        <div class="anggota-box">
            <div class="text-center mb-5">
                <span class="hero-badge-pill">BAGAN KEPENGURUSAN</span>
                <h3 style="color: var(--text-dark); font-size: 1.85rem; font-weight: 800; margin-bottom: 6px;">
                    Struktur Kepengurusan
                </h3>
                <p style="color: rgba(40,21,29,0.7); font-size: 0.92rem; margin: 0;">
                    Susunan hierarki resmi kepengurusan {{ $jabatan->position }} HIMATIKA UNUJA.
                </p>
            </div>

            @if($unitType === 'bpi_putra' || $unitType === 'bpi_putri')
                {{-- ================= BPI PHOTO CHART HIERARCHY ================= --}}
                <div class="detail-org-chart">
                    {{-- ROW 1: KETUA UMUM --}}
                    <div class="detail-card-row justify-content-center">
                        <div class="detail-member-card">
                            <div class="detail-member-avatar-wrap">
                                @if($bpiKetua?->photo)
                                    <img src="{{ asset('storage/' . $bpiKetua->photo) }}" alt="{{ $bpiKetua->name }}" class="detail-member-img">
                                @else
                                    <div class="detail-member-placeholder"><i class="fas fa-user-circle"></i></div>
                                @endif
                            </div>
                            <div class="detail-member-name" title="{{ $bpiKetua?->name ?? 'Belum terisi' }}">
                                {{ $bpiKetua?->name ?? 'Belum terisi' }}
                            </div>
                            <span class="detail-member-badge">
                                {{ $unitType === 'bpi_putri' ? 'Ketua Umum Putri' : 'Ketua Umum Putra' }}
                            </span>
                        </div>
                    </div>

                    {{-- CONNECTOR KETUA -> WAKIL --}}
                    <div class="detail-tree-line"></div>

                    {{-- ROW 2: WAKIL KETUA --}}
                    <div class="detail-card-row justify-content-center">
                        <div class="detail-member-card">
                            <div class="detail-member-avatar-wrap">
                                @if($bpiWakil?->photo)
                                    <img src="{{ asset('storage/' . $bpiWakil->photo) }}" alt="{{ $bpiWakil->name }}" class="detail-member-img">
                                @else
                                    <div class="detail-member-placeholder"><i class="fas fa-user-circle"></i></div>
                                @endif
                            </div>
                            <div class="detail-member-name" title="{{ $bpiWakil?->name ?? 'Belum terisi' }}">
                                {{ $bpiWakil?->name ?? 'Belum terisi' }}
                            </div>
                            <span class="detail-member-badge">
                                {{ $unitType === 'bpi_putri' ? 'Wakil Ketua Umum Putri' : 'Wakil Ketua Umum Putra' }}
                            </span>
                        </div>
                    </div>

                    {{-- CONNECTOR WAKIL -> BENDAHARA & SEKRETARIS (BRANCH SPLIT) --}}
                    <div class="detail-tree-line"></div>
                    <div class="detail-split-bar d-none d-md-block"></div>
                    <div class="detail-tree-line-sub d-none d-md-block"></div>

                    {{-- ROW 3: BENDAHARA DI KIRI & SEKRETARIS DI KANAN --}}
                    <div class="row g-4 justify-content-center mt-1">
                        {{-- BENDAHARA DI KIRI --}}
                        <div class="col-md-5 col-lg-4 d-flex justify-content-center">
                            <div class="detail-member-card w-100">
                                <div class="detail-member-avatar-wrap">
                                    @if($bpiBendahara?->photo)
                                        <img src="{{ asset('storage/' . $bpiBendahara->photo) }}" alt="{{ $bpiBendahara->name }}" class="detail-member-img">
                                    @else
                                        <div class="detail-member-placeholder"><i class="fas fa-user-circle"></i></div>
                                    @endif
                                </div>
                                <div class="detail-member-name" title="{{ $bpiBendahara?->name ?? 'Belum terisi' }}">
                                    {{ $bpiBendahara?->name ?? 'Belum terisi' }}
                                </div>
                                <span class="detail-member-badge">
                                    {{ $unitType === 'bpi_putri' ? 'Bendahara Putri' : 'Bendahara Putra' }}
                                </span>
                            </div>
                        </div>

                        {{-- SEKRETARIS DI KANAN --}}
                        <div class="col-md-5 col-lg-4 d-flex justify-content-center">
                            <div class="detail-member-card w-100">
                                <div class="detail-member-avatar-wrap">
                                    @if($bpiSekretaris?->photo)
                                        <img src="{{ asset('storage/' . $bpiSekretaris->photo) }}" alt="{{ $bpiSekretaris->name }}" class="detail-member-img">
                                    @else
                                        <div class="detail-member-placeholder"><i class="fas fa-user-circle"></i></div>
                                    @endif
                                </div>
                                <div class="detail-member-name" title="{{ $bpiSekretaris?->name ?? 'Belum terisi' }}">
                                    {{ $bpiSekretaris?->name ?? 'Belum terisi' }}
                                </div>
                                <span class="detail-member-badge">
                                    {{ $unitType === 'bpi_putri' ? 'Sekretaris Putri' : 'Sekretaris Putra' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            @elseif($unitType === 'divisi')
                {{-- ================= DIVISI PHOTO CHART HIERARCHY (DUA KELOMPOK: PUTRA & PUTRI) ================= --}}
                @php
                    $hasPutra = !empty($divisiPutraData) && ($divisiPutraData['total'] ?? 0) > 0;
                    $hasPutri = !empty($divisiPutriData) && ($divisiPutriData['total'] ?? 0) > 0;
                @endphp

                @if($hasPutra && $hasPutri)
                    {{-- KEDUA KELOMPOK TERSEDIA: DESKTOP 2 KOLOM (KIRI PUTRA, KANAN PUTRI), HP STACKED (ATAS PUTRA, BAWAH PUTRI) --}}
                    <div class="row g-4 g-xl-5 justify-content-center">
                        {{-- 1. BAGAN KEPENGURUSAN PUTRA (KOLOM KIRI) --}}
                        <div class="col-12 col-lg-6">
                            <div class="divisi-kelompok-wrapper">
                                <div class="text-center mb-4">
                                    <span class="divisi-kelompok-badge">
                                        <i class="fas fa-mars me-1"></i> Kepengurusan Putra
                                    </span>
                                </div>
                                <div class="detail-org-chart">
                                    {{-- Koordinator / Co Putra di tengah atas --}}
                                    <div class="d-flex justify-content-center flex-wrap gap-3">
                                        @foreach($divisiPutraData['leaders'] as $ldr)
                                            <div class="detail-member-card">
                                                <div class="detail-member-avatar-wrap">
                                                    @if(!empty($ldr->photo))
                                                        <img src="{{ asset('storage/' . $ldr->photo) }}" alt="{{ $ldr->name }}" class="detail-member-img">
                                                    @else
                                                        <div class="detail-member-placeholder"><i class="fas fa-user-circle"></i></div>
                                                    @endif
                                                </div>
                                                <div class="detail-member-name" title="{{ $ldr->name ?? 'Belum terisi' }}">
                                                    {{ $ldr->name ?? 'Belum terisi' }}
                                                </div>
                                                <span class="detail-member-badge">
                                                    {{ $ldr->position ?? 'Koordinator Divisi' }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Garis penghubung ke Anggota/Staf Putra di bawahnya --}}
                                    @if(isset($divisiPutraData['staff']) && $divisiPutraData['staff']->count() > 0)
                                        <div class="detail-tree-line"></div>
                                        <div class="d-flex justify-content-center flex-wrap gap-3 mt-1">
                                            @foreach($divisiPutraData['staff'] as $stf)
                                                <div class="detail-member-card">
                                                    <div class="detail-member-avatar-wrap">
                                                        @if(!empty($stf->photo))
                                                            <img src="{{ asset('storage/' . $stf->photo) }}" alt="{{ $stf->name }}" class="detail-member-img">
                                                        @else
                                                            <div class="detail-member-placeholder"><i class="fas fa-user-circle"></i></div>
                                                        @endif
                                                    </div>
                                                    <div class="detail-member-name" title="{{ $stf->name ?? 'Belum terisi' }}">
                                                        {{ $stf->name ?? 'Belum terisi' }}
                                                    </div>
                                                    <span class="detail-member-badge">
                                                        {{ $stf->position ?? 'Anggota Divisi' }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- 2. BAGAN KEPENGURUSAN PUTRI (KOLOM KANAN) --}}
                        <div class="col-12 col-lg-6">
                            <div class="divisi-kelompok-wrapper">
                                <div class="text-center mb-4">
                                    <span class="divisi-kelompok-badge">
                                        <i class="fas fa-venus me-1"></i> Kepengurusan Putri
                                    </span>
                                </div>
                                <div class="detail-org-chart">
                                    {{-- Koordinator / Co Putri di tengah atas --}}
                                    <div class="d-flex justify-content-center flex-wrap gap-3">
                                        @foreach($divisiPutriData['leaders'] as $ldr)
                                            <div class="detail-member-card">
                                                <div class="detail-member-avatar-wrap">
                                                    @if(!empty($ldr->photo))
                                                        <img src="{{ asset('storage/' . $ldr->photo) }}" alt="{{ $ldr->name }}" class="detail-member-img">
                                                    @else
                                                        <div class="detail-member-placeholder"><i class="fas fa-user-circle"></i></div>
                                                    @endif
                                                </div>
                                                <div class="detail-member-name" title="{{ $ldr->name ?? 'Belum terisi' }}">
                                                    {{ $ldr->name ?? 'Belum terisi' }}
                                                </div>
                                                <span class="detail-member-badge">
                                                    {{ $ldr->position ?? 'Koordinator Divisi' }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Garis penghubung ke Anggota/Staf Putri di bawahnya --}}
                                    @if(isset($divisiPutriData['staff']) && $divisiPutriData['staff']->count() > 0)
                                        <div class="detail-tree-line"></div>
                                        <div class="d-flex justify-content-center flex-wrap gap-3 mt-1">
                                            @foreach($divisiPutriData['staff'] as $stf)
                                                <div class="detail-member-card">
                                                    <div class="detail-member-avatar-wrap">
                                                        @if(!empty($stf->photo))
                                                            <img src="{{ asset('storage/' . $stf->photo) }}" alt="{{ $stf->name }}" class="detail-member-img">
                                                        @else
                                                            <div class="detail-member-placeholder"><i class="fas fa-user-circle"></i></div>
                                                        @endif
                                                    </div>
                                                    <div class="detail-member-name" title="{{ $stf->name ?? 'Belum terisi' }}">
                                                        {{ $stf->name ?? 'Belum terisi' }}
                                                    </div>
                                                    <span class="detail-member-badge">
                                                        {{ $stf->position ?? 'Anggota Divisi' }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                @elseif($hasPutra)
                    {{-- HANYA KELOMPOK PUTRA TERSEDIA: DIPUSATKAN TANPA MENYISAKAN KOLOM KOSONG --}}
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-10 col-lg-7 col-xl-6">
                            <div class="divisi-kelompok-wrapper">
                                <div class="text-center mb-4">
                                    <span class="divisi-kelompok-badge">
                                        <i class="fas fa-mars me-1"></i> Kepengurusan Putra
                                    </span>
                                </div>
                                <div class="detail-org-chart">
                                    <div class="d-flex justify-content-center flex-wrap gap-3">
                                        @foreach($divisiPutraData['leaders'] as $ldr)
                                            <div class="detail-member-card">
                                                <div class="detail-member-avatar-wrap">
                                                    @if(!empty($ldr->photo))
                                                        <img src="{{ asset('storage/' . $ldr->photo) }}" alt="{{ $ldr->name }}" class="detail-member-img">
                                                    @else
                                                        <div class="detail-member-placeholder"><i class="fas fa-user-circle"></i></div>
                                                    @endif
                                                </div>
                                                <div class="detail-member-name" title="{{ $ldr->name ?? 'Belum terisi' }}">
                                                    {{ $ldr->name ?? 'Belum terisi' }}
                                                </div>
                                                <span class="detail-member-badge">
                                                    {{ $ldr->position ?? 'Koordinator Divisi' }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if(isset($divisiPutraData['staff']) && $divisiPutraData['staff']->count() > 0)
                                        <div class="detail-tree-line"></div>
                                        <div class="d-flex justify-content-center flex-wrap gap-3 mt-1">
                                            @foreach($divisiPutraData['staff'] as $stf)
                                                <div class="detail-member-card">
                                                    <div class="detail-member-avatar-wrap">
                                                        @if(!empty($stf->photo))
                                                            <img src="{{ asset('storage/' . $stf->photo) }}" alt="{{ $stf->name }}" class="detail-member-img">
                                                        @else
                                                            <div class="detail-member-placeholder"><i class="fas fa-user-circle"></i></div>
                                                        @endif
                                                    </div>
                                                    <div class="detail-member-name" title="{{ $stf->name ?? 'Belum terisi' }}">
                                                        {{ $stf->name ?? 'Belum terisi' }}
                                                    </div>
                                                    <span class="detail-member-badge">
                                                        {{ $stf->position ?? 'Anggota Divisi' }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                @elseif($hasPutri)
                    {{-- HANYA KELOMPOK PUTRI TERSEDIA: DIPUSATKAN TANPA MENYISAKAN KOLOM KOSONG --}}
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-10 col-lg-7 col-xl-6">
                            <div class="divisi-kelompok-wrapper">
                                <div class="text-center mb-4">
                                    <span class="divisi-kelompok-badge">
                                        <i class="fas fa-venus me-1"></i> Kepengurusan Putri
                                    </span>
                                </div>
                                <div class="detail-org-chart">
                                    <div class="d-flex justify-content-center flex-wrap gap-3">
                                        @foreach($divisiPutriData['leaders'] as $ldr)
                                            <div class="detail-member-card">
                                                <div class="detail-member-avatar-wrap">
                                                    @if(!empty($ldr->photo))
                                                        <img src="{{ asset('storage/' . $ldr->photo) }}" alt="{{ $ldr->name }}" class="detail-member-img">
                                                    @else
                                                        <div class="detail-member-placeholder"><i class="fas fa-user-circle"></i></div>
                                                    @endif
                                                </div>
                                                <div class="detail-member-name" title="{{ $ldr->name ?? 'Belum terisi' }}">
                                                    {{ $ldr->name ?? 'Belum terisi' }}
                                                </div>
                                                <span class="detail-member-badge">
                                                    {{ $ldr->position ?? 'Koordinator Divisi' }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if(isset($divisiPutriData['staff']) && $divisiPutriData['staff']->count() > 0)
                                        <div class="detail-tree-line"></div>
                                        <div class="d-flex justify-content-center flex-wrap gap-3 mt-1">
                                            @foreach($divisiPutriData['staff'] as $stf)
                                                <div class="detail-member-card">
                                                    <div class="detail-member-avatar-wrap">
                                                        @if(!empty($stf->photo))
                                                            <img src="{{ asset('storage/' . $stf->photo) }}" alt="{{ $stf->name }}" class="detail-member-img">
                                                        @else
                                                            <div class="detail-member-placeholder"><i class="fas fa-user-circle"></i></div>
                                                        @endif
                                                    </div>
                                                    <div class="detail-member-name" title="{{ $stf->name ?? 'Belum terisi' }}">
                                                        {{ $stf->name ?? 'Belum terisi' }}
                                                    </div>
                                                    <span class="detail-member-badge">
                                                        {{ $stf->position ?? 'Anggota Divisi' }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- CATATAN ADMIN JIKA ADA PENGURUS YANG BELUM DITENTUKAN KELOMPOKNYA --}}
                @if(isset($divisiUnassigned) && $divisiUnassigned->count() > 0)
                    <div class="alert alert-warning d-flex align-items-center gap-3 mt-4 mx-auto shadow-sm" style="max-width: 680px; border-radius: 14px; border-left: 4px solid #F59E0B;">
                        <i class="fas fa-exclamation-triangle text-warning fs-4"></i>
                        <div>
                            <div class="fw-bold">Perhatian Pengelola:</div>
                            <div class="small">
                                Terdapat {{ $divisiUnassigned->count() }} pengurus yang belum memiliki penanda kelompok (Putra / Putri): 
                                <em>{{ $divisiUnassigned->pluck('name')->implode(', ') }}</em>. 
                                Silakan tentukan kelompok pengurus melalui panel admin.
                            </div>
                        </div>
                    </div>
                @endif

            @else
                {{-- ================= KAPRODI / UMUM PHOTO CHART ================= --}}
                <div class="detail-org-chart">
                    <div class="detail-card-row justify-content-center">
                        <div class="detail-member-card">
                            <div class="detail-member-avatar-wrap">
                                @if($jabatan->photo)
                                    <img src="{{ asset('storage/' . $jabatan->photo) }}" alt="{{ $jabatan->name }}" class="detail-member-img">
                                @else
                                    <div class="detail-member-placeholder"><i class="fas fa-user-graduate"></i></div>
                                @endif
                            </div>
                            <div class="detail-member-name" title="{{ $jabatan->name ?? 'Belum terisi' }}">
                                {{ $jabatan->name ?? 'Mudakkir, S.Pd., MM.' }}
                            </div>
                            <span class="detail-member-badge">
                                {{ $jabatan->position ?? 'Ketua Program Studi' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
