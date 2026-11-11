@extends('layouts.app')

@section('title', $jabatan->position . ' - HIMATIKA UNUJA 2026')

@section('content')
<style>
    :root {
        --bg-dark: #1A0A0F;
        --burgundy-main: #711C35;
        --burgundy-hover: #541326;
        --burgundy-focus: #A33B59;
        --rose-soft: #F4D6DE;
        --rose-pale: #FFF7F9;
        --text-dark: #28151D;
        --border-rose: #E9CDD5;
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
        background: linear-gradient(135deg, #711C35 0%, #1A0A0F 100%);
        border-radius: 24px;
        padding: 48px;
        color: #ffffff;
        display: flex;
        gap: 40px;
        position: relative;
        overflow: hidden;
        margin-bottom: 56px;
        box-shadow: 0 16px 40px rgba(26, 10, 15, 0.2);
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
        box-shadow: 0 4px 16px rgba(113, 28, 53, 0.04);
        transition: all 0.25s ease;
    }
    .role-category-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(113, 28, 53, 0.08);
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
        box-shadow: 0 4px 20px rgba(113, 28, 53, 0.04);
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
        box-shadow: 0 10px 24px rgba(113, 28, 53, 0.08);
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
                <i class="fas fa-arrow-left"></i> &larr; Kembali ke Struktur
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
                    {{ $jabatan->description ?? 'Menjalankan tugas dan fungsi strategis dalam struktur kepengurusan HIMATIKA FMIPA UNUJA periode 2026.' }}
                </p>

                <div class="d-flex gap-3 mb-4 flex-wrap">
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

                @if(isset($terkait) && $terkait->count() > 0)
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
                    @if($jabatan->photo)
                        <img src="{{ asset('storage/' . $jabatan->photo) }}" alt="{{ $jabatan->name }}" class="hero-photo-img">
                    @else
                        <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-white" style="min-height: 380px;">
                            <i class="fas fa-user-circle" style="font-size: 90px; opacity: 0.5; margin-bottom: 12px;"></i>
                            <span style="font-size: 0.9rem; font-weight: 600; opacity: 0.85;">Foto Resmi Kepengurusan</span>
                        </div>
                    @endif
                    <div class="hero-photo-watermark">
                        HIMATIKA 2026
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

        {{-- SECTION: ANGGOTA DALAM JABATAN INI --}}
        <div class="anggota-box">
            <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
                <div>
                    <span class="hero-badge-pill">ANGGOTA UNIT</span>
                    <h3 style="color: var(--text-dark); font-size: 1.75rem; font-weight: 800; margin-bottom: 4px;">
                        Anggota dalam jabatan ini
                    </h3>
                    <p style="color: rgba(40,21,29,0.7); font-size: 0.92rem; margin: 0;">
                        Orang-orang yang bergerak bersama menjalankan amanah pada unit ini.
                    </p>
                </div>
                <div style="background: var(--rose-soft); color: var(--burgundy-main); font-weight: 700; font-size: 0.82rem; padding: 6px 16px; border-radius: 50px;">
                    {{ $anggota->count() }} Anggota Aktif
                </div>
            </div>

            <div class="row g-4">
                @forelse($anggota as $agt)
                <div class="col-lg-4 col-md-6">
                    <div class="anggota-profile-card">
                        <div class="anggota-photo-area">
                            @if(isset($agt->photo) && $agt->photo)
                                <img src="{{ asset('storage/' . $agt->photo) }}" alt="{{ $agt->name }}" class="anggota-img">
                            @else
                                <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-secondary">
                                    <i class="fas fa-user-circle" style="font-size: 70px; opacity: 0.45; margin-bottom: 8px;"></i>
                                    <span style="font-size: 0.8rem; font-weight: 600;">HIMATIKA 2026</span>
                                </div>
                            @endif
                        </div>
                        <div style="padding: 20px 22px;">
                            <h4 style="color: var(--text-dark); font-size: 1.15rem; font-weight: 700; margin-bottom: 4px;">
                                {{ $agt->name ?? 'Nama Pengurus' }}
                            </h4>
                            <span style="color: var(--burgundy-main); font-size: 0.82rem; font-weight: 700; display: inline-block; margin-bottom: 8px;">
                                {{ $agt->position ?? $jabatan->position }}
                            </span>
                            @if(isset($agt->bio) && $agt->bio)
                            <p style="color: rgba(40,21,29,0.65); font-size: 0.82rem; line-height: 1.5; margin: 0;">
                                {{ $agt->bio }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-4 text-muted">
                        <p class="mb-0">Data anggota tambahan dalam jabatan ini sedang dilengkapi.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
