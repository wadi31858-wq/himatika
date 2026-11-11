@extends('layouts.admin')

@section('title', 'Struktur Organisasi')
@section('page_title', 'Kelola Struktur Organisasi')
@section('page_subtitle', 'Hirarki kepengurusan, divisi/bidang, dan susunan jabatan HIMATIKA')

@section('content')
<div class="admin-bagan-wrapper">
    <style>
        /* ========================================================
           ADMIN BAGAN THEME & VARIABLES
           ======================================================== */
        .admin-bagan-wrapper {
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

        /* ========================================================
           RESPONSIVE HORIZONTAL SCROLL CONTAINER
           ======================================================== */
        .admin-bagan-scroll-wrap {
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            background: var(--rose-pale);
            border: 1px solid var(--border-rose);
            border-radius: 14px;
            padding: 24px 20px 40px 20px;
            box-shadow: inset 0 1px 4px rgba(113, 28, 53, 0.03);
            margin-bottom: 2rem;
        }
        .admin-bagan-scroll-wrap::-webkit-scrollbar {
            height: 9px;
        }
        .admin-bagan-scroll-wrap::-webkit-scrollbar-track {
            background: #f5e8ec;
            border-radius: 6px;
        }
        .admin-bagan-scroll-wrap::-webkit-scrollbar-thumb {
            background: #a33b59;
            border-radius: 6px;
        }
        .admin-bagan-scroll-wrap::-webkit-scrollbar-thumb:hover {
            background: #711c35;
        }

        .admin-bagan-scroll-wrap .org-chart {
            min-width: 720px;
            max-width: 1080px;
            margin: 0 auto;
            position: relative;
        }

        /* ========================================================
           SWITCHER BUTTONS (PUTRA / PUTRI)
           ======================================================== */
        .admin-struktur-tabs {
            margin-bottom: 24px;
        }
        .admin-struktur-tabs-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            max-width: 440px;
            margin: 0 auto;
            background: #ffffff;
            padding: 6px;
            border-radius: 50px;
            border: 1.5px solid var(--border-rose);
            box-shadow: 0 4px 18px rgba(113, 28, 53, 0.06);
        }
        .admin-tab-btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 40px;
            border: none;
            background: transparent;
            color: var(--burgundy-main);
            font-weight: 700;
            font-size: 0.90rem;
            letter-spacing: 1.5px;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            user-select: none;
        }
        .admin-tab-btn:hover {
            color: var(--burgundy-hover);
            background: var(--rose-pale);
        }
        .admin-tab-btn.active {
            background: linear-gradient(135deg, var(--burgundy-main) 0%, var(--burgundy-hover) 100%);
            color: #ffffff !important;
            box-shadow: 0 6px 18px rgba(113, 28, 53, 0.28);
            transform: translateY(-1px);
        }
        .admin-tab-btn:focus-visible {
            outline: 2px solid var(--burgundy-focus);
            outline-offset: 2px;
        }

        .panel-fade {
            animation: fadeInStruktur 0.3s ease-in-out;
        }
        @keyframes fadeInStruktur {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ========================================================
           CONNECTORS & BRANCH SPLIT LINES
           ======================================================== */
        .tree-connector {
            width: 2px;
            margin: 0 auto;
            background-color: var(--burgundy-main);
            position: relative;
        }
        .tree-connector.dashed {
            background-color: transparent;
            border-left: 2px dashed var(--burgundy-focus);
        }
        .tree-connector.h-16 { height: 16px; }
        .tree-connector.h-20 { height: 20px; }
        .tree-connector.h-24 { height: 24px; }
        .tree-connector.h-30 { height: 30px; }

        .branch-split-bar {
            position: relative;
            width: 60%;
            margin: 0 auto;
            height: 2px;
            background: var(--burgundy-main);
        }
        .branch-split-bar::before,
        .branch-split-bar::after {
            content: '';
            position: absolute;
            top: 0;
            width: 2px;
            height: 16px;
            background: var(--burgundy-main);
        }
        .branch-split-bar::before { left: 0; }
        .branch-split-bar::after { right: 0; }

        .level-label {
            text-align: center;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--burgundy-main);
            margin-bottom: 8px;
        }

        /* ========================================================
           CHART CARDS (PIMPINAN & BPH)
           ======================================================== */
        .chart-card {
            background: var(--pure-white);
            border: 1px solid var(--border-rose);
            border-radius: 14px;
            padding: 20px 22px;
            box-shadow: 0 4px 16px rgba(113, 28, 53, 0.04);
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
            text-align: left;
        }
        .chart-card:hover {
            box-shadow: 0 8px 24px rgba(113, 28, 53, 0.09);
            transform: translateY(-2px);
            border-color: var(--burgundy-focus);
        }
        .chart-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3.5px;
            background: linear-gradient(90deg, var(--burgundy-main), var(--burgundy-focus));
        }
        .chart-card.gold-top::before {
            background: linear-gradient(90deg, #D4AF37, var(--burgundy-main));
        }

        .chart-officer-photo {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            object-fit: cover;
            border: 2.5px solid var(--burgundy-main);
            flex-shrink: 0;
            box-shadow: 0 3px 8px rgba(113, 28, 53, 0.12);
            background: var(--rose-soft);
        }
        .chart-officer-placeholder {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: var(--rose-soft);
            color: var(--burgundy-main);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            border: 2px solid var(--border-rose);
            flex-shrink: 0;
        }

        .chart-badge {
            display: inline-block;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 50px;
            background: var(--rose-soft);
            color: var(--burgundy-main);
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .chart-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .chart-officer {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--burgundy-main);
            margin-bottom: 6px;
        }

        .chart-desc {
            font-size: 0.83rem;
            color: rgba(40, 21, 29, 0.7);
            line-height: 1.55;
            margin-bottom: 14px;
        }

        .chart-card-footer {
            border-top: 1px solid rgba(233, 205, 213, 0.6);
            padding-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .chart-card-center {
            max-width: 520px;
            margin: 0 auto;
        }

        .link-detail {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--burgundy-main);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s ease;
        }
        .link-detail:hover {
            color: var(--burgundy-hover);
            text-decoration: none;
            transform: translateX(2px);
        }

        /* ========================================================
           DIVISI SECTION & 5 CARDS
           ======================================================== */
        .divisi-section-wrap {
            margin-top: 40px;
            padding-top: 36px;
            border-top: 1px solid var(--border-rose);
            position: relative;
        }

        .divisi-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
            margin-top: 28px;
        }

        .divisi-card {
            background: var(--pure-white);
            border: 1px solid var(--border-rose);
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(113, 28, 53, 0.05);
            transition: all 0.28s ease;
            display: flex;
            flex-direction: row;
            align-items: stretch;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            min-height: 195px;
            text-align: left;
        }
        .divisi-card:hover {
            border-color: var(--burgundy-main);
            box-shadow: 0 10px 28px rgba(113, 28, 53, 0.12);
            transform: translateY(-3px);
        }
        .divisi-card:focus-visible {
            outline: 2px solid var(--burgundy-focus);
            outline-offset: 2px;
        }

        /* Sisi Kiri: Foto Bersama Anggota */
        .divisi-photo-box {
            width: 190px;
            min-width: 190px;
            position: relative;
            overflow: hidden;
            background: var(--rose-pale);
            display: flex;
            align-items: center;
            justify-content: center;
            border-right: 1px solid rgba(233, 205, 213, 0.6);
        }
        .divisi-group-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
        }
        .divisi-card:hover .divisi-group-photo {
            transform: scale(1.05);
        }

        /* Placeholder Foto Bersama */
        .divisi-photo-placeholder {
            width: 100%;
            height: 100%;
            min-height: 195px;
            background: linear-gradient(135deg, #FFF7F9 0%, #F4D6DE 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 16px;
            text-align: center;
        }
        .divisi-placeholder-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--pure-white);
            color: var(--burgundy-main);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            box-shadow: 0 4px 10px rgba(113, 28, 53, 0.1);
            transition: transform 0.25s ease;
        }
        .divisi-card:hover .divisi-placeholder-icon {
            transform: scale(1.1);
        }
        .divisi-placeholder-tag {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--burgundy-main);
            background: rgba(255, 255, 255, 0.85);
            padding: 3px 10px;
            border-radius: 50px;
            border: 1px solid var(--border-rose);
        }

        /* Sisi Kanan: Konten Informasi */
        .divisi-info-box {
            padding: 20px 22px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-grow: 1;
            min-width: 0;
        }

        .divisi-top-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
        }
        .divisi-badge-tag {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: var(--burgundy-main);
            background: var(--rose-soft);
            padding: 3px 10px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .divisi-card-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
            line-height: 1.35;
        }

        .divisi-card-desc {
            font-size: 0.85rem;
            color: rgba(40, 21, 29, 0.72);
            line-height: 1.55;
            margin-bottom: 16px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Bagian Bawah: Jumlah Anggota & Tombol Aksi */
        .divisi-card-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 12px;
            border-top: 1px solid rgba(233, 205, 213, 0.6);
            margin-top: auto;
            gap: 8px;
            flex-wrap: wrap;
        }

        .divisi-members-count {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-dark);
            background: var(--rose-pale);
            padding: 5px 12px;
            border-radius: 50px;
            border: 1px solid var(--border-rose);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .divisi-members-count i {
            color: var(--burgundy-main);
        }

        .divisi-arrow-btn {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--burgundy-main);
            color: #ffffff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            transition: all 0.25s ease;
            box-shadow: 0 3px 8px rgba(113, 28, 53, 0.2);
            flex-shrink: 0;
        }
        .divisi-card:hover .divisi-arrow-btn {
            background: var(--burgundy-hover);
            transform: translateX(3px);
        }

        /* ========================================================
           POP-UP MODAL (DETAIL DIVISI DI ADMIN)
           ======================================================== */
        .divisi-modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            width: 100%; height: 100%;
            background: rgba(26, 10, 15, 0.65);
            backdrop-filter: blur(4px);
            z-index: 1050;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
            opacity: 0;
            transition: opacity 0.25s ease;
        }
        .divisi-modal-overlay.show {
            display: flex;
            opacity: 1;
        }

        .divisi-modal-dialog {
            background: var(--pure-white);
            width: 100%;
            max-width: 540px;
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 18px;
            padding: 32px 28px 24px;
            position: relative;
            box-shadow: 0 16px 40px rgba(26, 10, 15, 0.25);
            border: 1px solid var(--border-rose);
            transform: translateY(20px);
            transition: transform 0.25s ease;
            text-align: left;
        }
        .divisi-modal-overlay.show .divisi-modal-dialog {
            transform: translateY(0);
        }

        .divisi-modal-close {
            position: absolute;
            top: 18px;
            right: 18px;
            background: var(--rose-pale);
            border: 1px solid var(--border-rose);
            color: var(--text-dark);
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.2s ease;
        }
        .divisi-modal-close:hover {
            background: var(--rose-soft);
            color: var(--burgundy-main);
        }

        .modal-member-card {
            background: var(--rose-pale);
            border: 1px solid var(--border-rose);
            border-radius: 14px;
            padding: 20px;
            text-align: center;
            margin-top: 16px;
        }
        .modal-photo-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 12px;
            border: 3px solid var(--burgundy-main);
            display: block;
            background: var(--rose-soft);
        }
        .modal-photo-placeholder {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto 12px;
            border: 3px solid var(--border-rose);
            background: var(--rose-soft);
            color: var(--burgundy-main);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
        }

        .slider-nav-btn {
            background: var(--pure-white);
            border: 1px solid var(--border-rose);
            color: var(--burgundy-main);
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .slider-nav-btn:hover {
            background: var(--rose-soft);
            color: var(--burgundy-hover);
            border-color: var(--burgundy-focus);
        }
    </style>

    <!-- BAGAN HIRARKI STRUKTUR ORGANISASI (MIRIP HALAMAN PUBLIK) -->
    <div class="him-card mb-4">
        <div class="him-card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                <h2 class="him-card-title mb-1">
                    <i class="fas fa-sitemap text-primary"></i> Bagan Struktur Organisasi HIMATIKA
                </h2>
                <small class="text-muted">Desain dan susunan hierarki sama persis dengan halaman publik. Dilengkapi tombol edit langsung per jabatan &amp; divisi.</small>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('struktur-organisasi') }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-external-link-alt me-1"></i> Buka Halaman Publik
                </a>
                <a href="{{ route('admin.struktur-organisasi.create') }}" class="btn btn-sm btn-him-primary">
                    <i class="fas fa-plus"></i> Tambah Posisi Baru
                </a>
            </div>
        </div>

        <!-- Switcher Tombol PUTRA / PUTRI -->
        <div class="admin-struktur-tabs text-center pt-3">
            <div class="admin-struktur-tabs-wrapper" role="tablist" aria-label="Pilihan Struktur Kepengurusan">
                <button type="button" class="admin-tab-btn active" id="tabBtnPutra" onclick="setStrukturTab('putra')" role="tab" aria-selected="true" aria-controls="panelStrukturPutra">
                    <i class="fas fa-mars"></i>
                    <span>PUTRA</span>
                </button>
                <button type="button" class="admin-tab-btn" id="tabBtnPutri" onclick="setStrukturTab('putri')" role="tab" aria-selected="false" aria-controls="panelStrukturPutri">
                    <i class="fas fa-venus"></i>
                    <span>PUTRI</span>
                </button>
            </div>
            <div class="mt-2">
                <span id="activeTabNotice" class="badge" style="background: var(--rose-soft); color: var(--burgundy-main); font-weight: 700; font-size: 0.80rem; padding: 6px 16px; border-radius: 50px; border: 1px solid var(--border-rose);">
                    <i class="fas fa-user-tie me-1"></i> Menampilkan Susunan Kepengurusan <strong>PUTRA</strong>
                </span>
            </div>
        </div>

        <!-- Scroll Wrapper: Gulir horizontal aman untuk layar HP & Tablet -->
        <div class="admin-bagan-scroll-wrap">
            <div class="org-chart">

                {{-- ==================== PANEL STRUKTUR PUTRA ==================== --}}
                <div id="panelStrukturPutra" class="panel-fade" role="tabpanel" aria-labelledby="tabBtnPutra">

                    {{-- LEVEL 1: BADAN PENGAWAS / KAPRODI (PUTRA) --}}
                    <div class="level-label">BADAN PENGAWAS / KETUA PROGRAM STUDI</div>
                    <div class="chart-card-center mb-0">
                        <div class="chart-card gold-top">
                            <div class="d-flex align-items-start gap-3 mb-2">
                                @if($kaprodi?->photo)
                                    <img src="{{ asset('storage/' . $kaprodi->photo) }}" alt="{{ $kaprodi->name }}" class="chart-officer-photo">
                                @else
                                    <div class="chart-officer-placeholder"><i class="fas fa-user-graduate"></i></div>
                                @endif
                                <div class="flex-grow-1">
                                    <span class="chart-badge">Pembina / Kaprodi</span>
                                    <h3 class="chart-title">{{ $kaprodi?->position ?? 'Ketua Program Studi Matematika' }}</h3>
                                    <div class="chart-officer">{{ $kaprodi?->name ?? 'Mudakkir, S.Pd., MM.' }}</div>
                                </div>
                            </div>
                            <p class="chart-desc">{{ $kaprodi?->description ?? 'Memberikan bimbingan, arahan, dan pembinaan dalam pelaksanaan kegiatan akademik serta pengembangan organisasi kemahasiswaan Program Studi Matematika FMIPA UNUJA.' }}</p>
                            <div class="chart-card-footer">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge {{ $kaprodi?->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border' }}" style="font-size: 0.72rem;">
                                        <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>{{ $kaprodi?->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('struktur-organisasi.show', $kaprodi?->id ?? 12) }}" target="_blank" class="link-detail" style="font-size: 0.78rem;">
                                        Pratinjau <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7rem;"></i>
                                    </a>
                                    <a href="{{ route('admin.struktur-organisasi.edit', $kaprodi?->id ?? 12) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                        <i class="fas fa-pencil-alt me-1"></i> Edit Posisi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Connector dashed to Ketua Umum Putra --}}
                    <div class="tree-connector dashed h-24"></div>

                    {{-- LEVEL 2: KETUA UMUM PUTRA --}}
                    <div class="level-label">KETUA UMUM PUTRA</div>
                    <div class="chart-card-center mb-0">
                        <div class="chart-card">
                            <div class="d-flex align-items-start gap-3 mb-2">
                                @if($ketuaPutra?->photo)
                                    <img src="{{ asset('storage/' . $ketuaPutra->photo) }}" alt="{{ $ketuaPutra->name }}" class="chart-officer-photo">
                                @else
                                    <div class="chart-officer-placeholder"><i class="fas fa-user-tie"></i></div>
                                @endif
                                <div class="flex-grow-1">
                                    <span class="chart-badge">Badan Pengurus Harian</span>
                                    <h4 class="chart-title">{{ $ketuaPutra?->position ?? 'Ketua Umum Putra' }}</h4>
                                    <div class="chart-officer">{{ $ketuaPutra?->name ?? 'Ahmad Rizki' }}</div>
                                </div>
                            </div>
                            <p class="chart-desc">{{ $ketuaPutra?->description ?? 'Memimpin dan mengoordinasikan seluruh jajaran kepengurusan HIMATIKA UNUJA Putra serta bertanggung jawab penuh atas arah gerak organisasi kemahasiswaan putra.' }}</p>
                            <div class="chart-card-footer">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge {{ $ketuaPutra?->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border' }}" style="font-size: 0.72rem;">
                                        <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>{{ $ketuaPutra?->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('struktur-organisasi.show', $ketuaPutra?->id ?? 1) }}" target="_blank" class="link-detail" style="font-size: 0.78rem;">
                                        Pratinjau <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7rem;"></i>
                                    </a>
                                    <a href="{{ route('admin.struktur-organisasi.edit', $ketuaPutra?->id ?? 1) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                        <i class="fas fa-pencil-alt me-1"></i> Edit Posisi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- WAKIL KETUA UMUM PUTRA --}}
                    <div class="tree-connector h-20"></div>
                    <div class="level-label">WAKIL KETUA UMUM PUTRA</div>
                    <div class="chart-card-center mb-0">
                        <div class="chart-card">
                            <div class="d-flex align-items-start gap-3 mb-2">
                                @if($wakilPutra?->photo)
                                    <img src="{{ asset('storage/' . $wakilPutra->photo) }}" alt="{{ $wakilPutra->name }}" class="chart-officer-photo">
                                @else
                                    <div class="chart-officer-placeholder"><i class="fas fa-user-tie"></i></div>
                                @endif
                                <div class="flex-grow-1">
                                    <span class="chart-badge">Badan Pengurus Harian</span>
                                    <h4 class="chart-title">{{ $wakilPutra?->position ?? 'Wakil Ketua Umum Putra' }}</h4>
                                    <div class="chart-officer">{{ $wakilPutra?->name ?? 'M. Ilham Wahyudi' }}</div>
                                </div>
                            </div>
                            <p class="chart-desc">{{ $wakilPutra?->description ?? 'Membantu Ketua Umum Putra dalam memimpin roda organisasi, mengoordinasikan pelaksanaan program kerja divisi putra, serta mewakili Ketua Umum jika berhalangan.' }}</p>
                            <div class="chart-card-footer">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge {{ ($wakilPutra?->is_active ?? true) ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border' }}" style="font-size: 0.72rem;">
                                        <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>{{ ($wakilPutra?->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    @if($wakilPutra)
                                        <a href="{{ route('struktur-organisasi.show', $wakilPutra->id) }}" target="_blank" class="link-detail" style="font-size: 0.78rem;">
                                            Pratinjau <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7rem;"></i>
                                        </a>
                                        <a href="{{ route('admin.struktur-organisasi.edit', $wakilPutra->id) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                            <i class="fas fa-pencil-alt me-1"></i> Edit Posisi
                                        </a>
                                    @else
                                        <a href="{{ route('admin.struktur-organisasi.create') }}?kelompok=putra&position=Wakil+Ketua+Umum+Putra" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                            <i class="fas fa-plus me-1"></i> Tambah Posisi
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Branch Split Bar to Sekretaris & Bendahara Putra --}}
                    <div class="tree-connector h-20"></div>
                    <div class="branch-split-bar"></div>
                    <div class="tree-connector h-16"></div>

                    {{-- LEVEL 3: SEKRETARIS & BENDAHARA PUTRA (2 Kolom Sejajar) --}}
                    <div class="row g-4 mt-0">
                        {{-- Sekretaris Putra --}}
                        <div class="col-6">
                            <div class="chart-card h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex align-items-start gap-3 mb-2">
                                        @if($sekretarisPutra?->photo)
                                            <img src="{{ asset('storage/' . $sekretarisPutra->photo) }}" alt="{{ $sekretarisPutra->name }}" class="chart-officer-photo">
                                        @else
                                            <div class="chart-officer-placeholder"><i class="fas fa-user"></i></div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <span class="chart-badge">Badan Pengurus Harian</span>
                                            <h4 class="chart-title">{{ $sekretarisPutra?->position ?? 'Sekretaris Putra' }}</h4>
                                            <div class="chart-officer">{{ $sekretarisPutra?->name ?? 'Budi Santoso' }}</div>
                                        </div>
                                    </div>
                                    <p class="chart-desc">{{ $sekretarisPutra?->description ?? 'Mengoordinasikan tata kelola kesekretariatan, administrasi persuratan, notulensi rapat, dan tertib arsip digital kepengurusan HIMATIKA UNUJA Putra.' }}</p>
                                </div>
                                <div class="chart-card-footer mt-auto">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge {{ $sekretarisPutra?->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border' }}" style="font-size: 0.72rem;">
                                            <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>{{ $sekretarisPutra?->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('struktur-organisasi.show', $sekretarisPutra?->id ?? 3) }}" target="_blank" class="link-detail" style="font-size: 0.78rem;">
                                            Pratinjau <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7rem;"></i>
                                        </a>
                                        <a href="{{ route('admin.struktur-organisasi.edit', $sekretarisPutra?->id ?? 3) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                            <i class="fas fa-pencil-alt me-1"></i> Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Bendahara Putra --}}
                        <div class="col-6">
                            <div class="chart-card h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex align-items-start gap-3 mb-2">
                                        @if($bendaharaPutra?->photo)
                                            <img src="{{ asset('storage/' . $bendaharaPutra->photo) }}" alt="{{ $bendaharaPutra->name }}" class="chart-officer-photo">
                                        @else
                                            <div class="chart-officer-placeholder"><i class="fas fa-user"></i></div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <span class="chart-badge">Badan Pengurus Harian</span>
                                            <h4 class="chart-title">{{ $bendaharaPutra?->position ?? 'Bendahara Putra' }}</h4>
                                            <div class="chart-officer">{{ $bendaharaPutra?->name ?? 'M. Farhan' }}</div>
                                        </div>
                                    </div>
                                    <p class="chart-desc">{{ $bendaharaPutra?->description ?? 'Mengoordinasikan kebendaharaan, pencatatan transaksi kas masuk dan keluar, serta penyusunan anggaran dan laporan keuangan HIMATIKA UNUJA Putra.' }}</p>
                                </div>
                                <div class="chart-card-footer mt-auto">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge {{ $bendaharaPutra?->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border' }}" style="font-size: 0.72rem;">
                                            <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>{{ $bendaharaPutra?->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('struktur-organisasi.show', $bendaharaPutra?->id ?? 11) }}" target="_blank" class="link-detail" style="font-size: 0.78rem;">
                                            Pratinjau <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7rem;"></i>
                                        </a>
                                        <a href="{{ route('admin.struktur-organisasi.edit', $bendaharaPutra?->id ?? 11) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                            <i class="fas fa-pencil-alt me-1"></i> Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Connector down to 5 Divisi --}}
                    <div class="tree-connector h-30 mt-3"></div>

                    {{-- LEVEL 4: 5 DIVISI PENGGERAK HIMATIKA PUTRA --}}
                    <div class="divisi-section-wrap mt-0">
                        <div class="text-center mb-2">
                            <span class="chart-badge">DIVISI HIMATIKA PUTRA</span>
                            <h3 class="fw-bold mt-2" style="font-size: 1.45rem; color: var(--text-dark);">Lima Divisi Penggerak HIMATIKA (Putra)</h3>
                            <p class="text-secondary small mb-0">Klik pada card untuk melihat detail anggota, atau klik tombol <strong>Edit Divisi</strong> untuk memperbarui data / foto bersama.</p>
                        </div>

                        <div class="divisi-grid">
                            @foreach($divisiPutra as $divKey => $div)
                                <div class="divisi-card" onclick="openDivisiModal('{{ $divKey }}', this, 'putra')" role="button" tabindex="0" onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();openDivisiModal('{{ $divKey }}', this, 'putra');}">
                                    <div class="divisi-photo-box">
                                        @if(!empty($div['group_photo']))
                                            <img src="{{ $div['group_photo'] }}" alt="{{ $div['clean_name'] }}" class="divisi-group-photo" loading="lazy">
                                        @else
                                            <div class="divisi-photo-placeholder">
                                                <div class="divisi-placeholder-icon">
                                                    <i class="{{ $div['icon'] }}"></i>
                                                </div>
                                                <span class="divisi-placeholder-tag">Foto Bersama</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="divisi-info-box">
                                        <div>
                                            <div class="divisi-top-meta">
                                                <span class="divisi-badge-tag"><i class="{{ $div['icon'] }}"></i> DIVISI</span>
                                                @if(isset($div['structure']) && $div['structure']?->is_active)
                                                    <span class="badge bg-success-subtle text-success py-0 px-2" style="font-size: 0.68rem;">Aktif</span>
                                                @endif
                                            </div>
                                            <h4 class="divisi-card-title">{{ $div['name'] }}</h4>
                                            <p class="divisi-card-desc">{{ $div['description'] }}</p>
                                        </div>

                                        <div class="divisi-card-bottom">
                                            <div class="divisi-members-count">
                                                <i class="fas fa-users"></i>
                                                <span><strong>{{ $div['member_count'] }}</strong> Anggota</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ $div['edit_url'] }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" onclick="event.stopPropagation();" title="Edit Divisi & Foto Bersama" style="font-size: 0.78rem;">
                                                    <i class="fas fa-pencil-alt me-1"></i> Edit Divisi
                                                </a>
                                                <div class="divisi-arrow-btn" title="Buka Detail Anggota">
                                                    <i class="fas fa-arrow-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                {{-- ==================== PANEL STRUKTUR PUTRI ==================== --}}
                <div id="panelStrukturPutri" class="panel-fade" style="display: none;" role="tabpanel" aria-labelledby="tabBtnPutri">

                    {{-- LEVEL 1: BADAN PENGAWAS / KAPRODI (PUTRI) --}}
                    <div class="level-label">BADAN PENGAWAS / KETUA PROGRAM STUDI</div>
                    <div class="chart-card-center mb-0">
                        <div class="chart-card gold-top">
                            <div class="d-flex align-items-start gap-3 mb-2">
                                @if($kaprodi?->photo)
                                    <img src="{{ asset('storage/' . $kaprodi->photo) }}" alt="{{ $kaprodi->name }}" class="chart-officer-photo">
                                @else
                                    <div class="chart-officer-placeholder"><i class="fas fa-user-graduate"></i></div>
                                @endif
                                <div class="flex-grow-1">
                                    <span class="chart-badge">Pembina / Kaprodi</span>
                                    <h3 class="chart-title">{{ $kaprodi?->position ?? 'Ketua Program Studi Matematika' }}</h3>
                                    <div class="chart-officer">{{ $kaprodi?->name ?? 'Mudakkir, S.Pd., MM.' }}</div>
                                </div>
                            </div>
                            <p class="chart-desc">{{ $kaprodi?->description ?? 'Memberikan bimbingan, arahan, dan pembinaan dalam pelaksanaan kegiatan akademik serta pengembangan organisasi kemahasiswaan Program Studi Matematika FMIPA UNUJA.' }}</p>
                            <div class="chart-card-footer">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge {{ $kaprodi?->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border' }}" style="font-size: 0.72rem;">
                                        <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>{{ $kaprodi?->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('struktur-organisasi.show', $kaprodi?->id ?? 12) }}" target="_blank" class="link-detail" style="font-size: 0.78rem;">
                                        Pratinjau <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7rem;"></i>
                                    </a>
                                    <a href="{{ route('admin.struktur-organisasi.edit', $kaprodi?->id ?? 12) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                        <i class="fas fa-pencil-alt me-1"></i> Edit Posisi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Connector dashed to Ketua Umum Putri --}}
                    <div class="tree-connector dashed h-24"></div>

                    {{-- LEVEL 2: KETUA UMUM PUTRI --}}
                    <div class="level-label">KETUA UMUM PUTRI</div>
                    <div class="chart-card-center mb-0">
                        <div class="chart-card">
                            <div class="d-flex align-items-start gap-3 mb-2">
                                @if($ketuaPutri?->photo)
                                    <img src="{{ asset('storage/' . $ketuaPutri->photo) }}" alt="{{ $ketuaPutri->name }}" class="chart-officer-photo">
                                @else
                                    <div class="chart-officer-placeholder"><i class="fas fa-user-circle"></i></div>
                                @endif
                                <div class="flex-grow-1">
                                    <span class="chart-badge">Badan Pengurus Harian</span>
                                    <h4 class="chart-title">{{ $ketuaPutri?->position ?? 'Ketua Umum Putri' }}</h4>
                                    <div class="chart-officer">{{ $ketuaPutri?->name ?? 'Siti Nurhaliza' }}</div>
                                </div>
                            </div>
                            <p class="chart-desc">{{ $ketuaPutri?->description ?? 'Memimpin dan mengoordinasikan seluruh jajaran kepengurusan HIMATIKA UNUJA Putri, memperkuat sinergi dan keharmonisan kepengurusan putri, serta mewakili himpunan.' }}</p>
                            <div class="chart-card-footer">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge {{ $ketuaPutri?->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border' }}" style="font-size: 0.72rem;">
                                        <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>{{ $ketuaPutri?->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('struktur-organisasi.show', $ketuaPutri?->id ?? 2) }}" target="_blank" class="link-detail" style="font-size: 0.78rem;">
                                        Pratinjau <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7rem;"></i>
                                    </a>
                                    <a href="{{ route('admin.struktur-organisasi.edit', $ketuaPutri?->id ?? 2) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                        <i class="fas fa-pencil-alt me-1"></i> Edit Posisi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- WAKIL KETUA UMUM PUTRI --}}
                    <div class="tree-connector h-20"></div>
                    <div class="level-label">WAKIL KETUA UMUM PUTRI</div>
                    <div class="chart-card-center mb-0">
                        <div class="chart-card">
                            <div class="d-flex align-items-start gap-3 mb-2">
                                @if($wakilPutri?->photo)
                                    <img src="{{ asset('storage/' . $wakilPutri->photo) }}" alt="{{ $wakilPutri->name }}" class="chart-officer-photo">
                                @else
                                    <div class="chart-officer-placeholder"><i class="fas fa-user-circle"></i></div>
                                @endif
                                <div class="flex-grow-1">
                                    <span class="chart-badge">Badan Pengurus Harian</span>
                                    <h4 class="chart-title">{{ $wakilPutri?->position ?? 'Wakil Ketua Umum Putri' }}</h4>
                                    <div class="chart-officer">{{ $wakilPutri?->name ?? 'Siti Nurhaliza' }}</div>
                                </div>
                            </div>
                            <p class="chart-desc">{{ $wakilPutri?->description ?? 'Membantu Ketua Umum Putri dalam memimpin roda kepengurusan putri, mengoordinasikan seluruh bidang kerja keputrian, serta mewakili Ketua Umum jika berhalangan.' }}</p>
                            <div class="chart-card-footer">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge {{ ($wakilPutri?->is_active ?? true) ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border' }}" style="font-size: 0.72rem;">
                                        <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>{{ ($wakilPutri?->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    @if($wakilPutri)
                                        <a href="{{ route('struktur-organisasi.show', $wakilPutri->id) }}" target="_blank" class="link-detail" style="font-size: 0.78rem;">
                                            Pratinjau <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7rem;"></i>
                                        </a>
                                        <a href="{{ route('admin.struktur-organisasi.edit', $wakilPutri->id) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                            <i class="fas fa-pencil-alt me-1"></i> Edit Posisi
                                        </a>
                                    @else
                                        <a href="{{ route('admin.struktur-organisasi.create') }}?kelompok=putri&position=Wakil+Ketua+Umum+Putri" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                            <i class="fas fa-plus me-1"></i> Tambah Posisi
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Branch Split Bar to Sekretaris & Bendahara Putri --}}
                    <div class="tree-connector h-20"></div>
                    <div class="branch-split-bar"></div>
                    <div class="tree-connector h-16"></div>

                    {{-- LEVEL 3: SEKRETARIS & BENDAHARA PUTRI (2 Kolom Sejajar) --}}
                    <div class="row g-4 mt-0">
                        {{-- Sekretaris Putri --}}
                        <div class="col-6">
                            <div class="chart-card h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex align-items-start gap-3 mb-2">
                                        @if($sekretarisPutri?->photo)
                                            <img src="{{ asset('storage/' . $sekretarisPutri->photo) }}" alt="{{ $sekretarisPutri->name }}" class="chart-officer-photo">
                                        @else
                                            <div class="chart-officer-placeholder"><i class="fas fa-user"></i></div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <span class="chart-badge">Badan Pengurus Harian</span>
                                            <h4 class="chart-title">{{ $sekretarisPutri?->position ?? 'Sekretaris Putri' }}</h4>
                                            <div class="chart-officer">{{ $sekretarisPutri?->name ?? 'Nurul Aini' }}</div>
                                        </div>
                                    </div>
                                    <p class="chart-desc">{{ $sekretarisPutri?->description ?? 'Mengoordinasikan tata kelola kesekretariatan, administrasi persuratan, notulensi rapat, dan tertib arsip digital kepengurusan HIMATIKA UNUJA Putri.' }}</p>
                                </div>
                                <div class="chart-card-footer mt-auto">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge {{ $sekretarisPutri?->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border' }}" style="font-size: 0.72rem;">
                                            <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>{{ $sekretarisPutri?->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('struktur-organisasi.show', $sekretarisPutri?->id ?? 10) }}" target="_blank" class="link-detail" style="font-size: 0.78rem;">
                                            Pratinjau <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7rem;"></i>
                                        </a>
                                        <a href="{{ route('admin.struktur-organisasi.edit', $sekretarisPutri?->id ?? 10) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                            <i class="fas fa-pencil-alt me-1"></i> Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Bendahara Putri --}}
                        <div class="col-6">
                            <div class="chart-card h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex align-items-start gap-3 mb-2">
                                        @if($bendaharaPutri?->photo)
                                            <img src="{{ asset('storage/' . $bendaharaPutri->photo) }}" alt="{{ $bendaharaPutri->name }}" class="chart-officer-photo">
                                        @else
                                            <div class="chart-officer-placeholder"><i class="fas fa-user"></i></div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <span class="chart-badge">Badan Pengurus Harian</span>
                                            <h4 class="chart-title">{{ $bendaharaPutri?->position ?? 'Bendahara Putri' }}</h4>
                                            <div class="chart-officer">{{ $bendaharaPutri?->name ?? 'Dewi Lestari' }}</div>
                                        </div>
                                    </div>
                                    <p class="chart-desc">{{ $bendaharaPutri?->description ?? 'Mengoordinasikan kebendaharaan, pencatatan transaksi kas masuk dan keluar, serta penyusunan anggaran dan laporan keuangan HIMATIKA UNUJA Putri.' }}</p>
                                </div>
                                <div class="chart-card-footer mt-auto">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge {{ $bendaharaPutri?->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border' }}" style="font-size: 0.72rem;">
                                            <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>{{ $bendaharaPutri?->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('struktur-organisasi.show', $bendaharaPutri?->id ?? 4) }}" target="_blank" class="link-detail" style="font-size: 0.78rem;">
                                            Pratinjau <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7rem;"></i>
                                        </a>
                                        <a href="{{ route('admin.struktur-organisasi.edit', $bendaharaPutri?->id ?? 4) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                            <i class="fas fa-pencil-alt me-1"></i> Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Connector down to 5 Divisi --}}
                    <div class="tree-connector h-30 mt-3"></div>

                    {{-- LEVEL 4: 5 DIVISI PENGGERAK HIMATIKA PUTRI --}}
                    <div class="divisi-section-wrap mt-0">
                        <div class="text-center mb-2">
                            <span class="chart-badge">DIVISI HIMATIKA PUTRI</span>
                            <h3 class="fw-bold mt-2" style="font-size: 1.45rem; color: var(--text-dark);">Lima Divisi Penggerak HIMATIKA (Putri)</h3>
                            <p class="text-secondary small mb-0">Klik pada card untuk melihat detail anggota, atau klik tombol <strong>Edit Divisi</strong> untuk memperbarui data / foto bersama.</p>
                        </div>

                        <div class="divisi-grid">
                            @foreach($divisiPutri as $divKey => $div)
                                <div class="divisi-card" onclick="openDivisiModal('{{ $divKey }}', this, 'putri')" role="button" tabindex="0" onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();openDivisiModal('{{ $divKey }}', this, 'putri');}">
                                    <div class="divisi-photo-box">
                                        @if(!empty($div['group_photo']))
                                            <img src="{{ $div['group_photo'] }}" alt="{{ $div['clean_name'] }}" class="divisi-group-photo" loading="lazy">
                                        @else
                                            <div class="divisi-photo-placeholder">
                                                <div class="divisi-placeholder-icon">
                                                    <i class="{{ $div['icon'] }}"></i>
                                                </div>
                                                <span class="divisi-placeholder-tag">Foto Bersama</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="divisi-info-box">
                                        <div>
                                            <div class="divisi-top-meta">
                                                <span class="divisi-badge-tag"><i class="{{ $div['icon'] }}"></i> DIVISI</span>
                                                @if(isset($div['structure']) && $div['structure']?->is_active)
                                                    <span class="badge bg-success-subtle text-success py-0 px-2" style="font-size: 0.68rem;">Aktif</span>
                                                @endif
                                            </div>
                                            <h4 class="divisi-card-title">{{ $div['name'] }}</h4>
                                            <p class="divisi-card-desc">{{ $div['description'] }}</p>
                                        </div>

                                        <div class="divisi-card-bottom">
                                            <div class="divisi-members-count">
                                                <i class="fas fa-users"></i>
                                                <span><strong>{{ $div['member_count'] }}</strong> Anggota</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ $div['edit_url'] }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" onclick="event.stopPropagation();" title="Edit Divisi & Foto Bersama" style="font-size: 0.78rem;">
                                                    <i class="fas fa-pencil-alt me-1"></i> Edit Divisi
                                                </a>
                                                <div class="divisi-arrow-btn" title="Buka Detail Anggota">
                                                    <i class="fas fa-arrow-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                {{-- JIKA ADA POSISI TAMBAHAN DI LUAR STRUKTUR UTAMA --}}
                @if(isset($extraStructures) && $extraStructures->isNotEmpty())
                    <div class="divisi-section-wrap mt-4">
                        <div class="text-center mb-3">
                            <span class="chart-badge">POSISI / JABATAN TAMBAHAN</span>
                            <h4 class="fw-bold mt-1" style="font-size: 1.25rem; color: var(--text-dark);">Posisi Tambahan Tersimpan</h4>
                        </div>
                        <div class="row g-3">
                            @foreach($extraStructures as $extra)
                                <div class="col-md-6 col-lg-4">
                                    <div class="chart-card">
                                        <div class="d-flex align-items-start gap-3 mb-2">
                                            @if($extra->photo)
                                                <img src="{{ asset('storage/' . $extra->photo) }}" alt="{{ $extra->name }}" class="chart-officer-photo" style="width: 48px; height: 48px;">
                                            @else
                                                <div class="chart-officer-placeholder" style="width: 48px; height: 48px;"><i class="fas fa-user text-muted"></i></div>
                                            @endif
                                            <div class="flex-grow-1">
                                                <span class="chart-badge">{{ ucfirst($extra->kelompok) }}</span>
                                                <h5 class="chart-title" style="font-size: 0.95rem;">{{ $extra->position }}</h5>
                                                <div class="chart-officer" style="font-size: 0.85rem;">{{ $extra->name }}</div>
                                            </div>
                                        </div>
                                        @if($extra->description)
                                            <p class="chart-desc" style="font-size: 0.8rem;">{{ Str::limit($extra->description, 100) }}</p>
                                        @endif
                                        <div class="chart-card-footer">
                                            <span class="badge {{ $extra->is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}" style="font-size: 0.70rem;">
                                                {{ $extra->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                            <a href="{{ route('admin.struktur-organisasi.edit', $extra->id) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.78rem;">
                                                <i class="fas fa-pencil-alt me-1"></i> Edit
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- TABEL DATA STRUKTUR (PENCARIAN, FILTER, PAGINASI, AKSI) -->
    <div class="him-card">
        <div class="him-card-header">
            <div>
                <h2 class="him-card-title">
                    <i class="fas fa-list-ul"></i> Daftar Data Struktur &amp; Jabatan
                </h2>
                <small class="text-muted">Total: <strong>{{ $structures->total() }}</strong> posisi/jabatan tersimpan</small>
            </div>
            <a href="{{ route('admin.struktur-organisasi.create') }}" class="btn btn-him-primary">
                <i class="fas fa-plus"></i> Tambah Posisi / Divisi Baru
            </a>
        </div>

        <!-- Filter & Search Toolbar -->
        <form method="GET" action="{{ route('admin.struktur-organisasi.index') }}" class="row g-2 mb-4">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama, jabatan, atau divisi..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="kelompok" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Kelompok</option>
                    <option value="putra" {{ request('kelompok') === 'putra' ? 'selected' : '' }}>Putra</option>
                    <option value="putri" {{ request('kelompok') === 'putri' ? 'selected' : '' }}>Putri</option>
                    <option value="semua" {{ request('kelompok') === 'semua' ? 'selected' : '' }}>Semua / Umum</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-him-outline w-100">Filter</button>
            </div>
            @if(request()->hasAny(['search', 'kelompok']))
                <div class="col-md-2">
                    <a href="{{ route('admin.struktur-organisasi.index') }}" class="btn btn-light w-100">Reset</a>
                </div>
            @endif
        </form>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-him align-middle">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Pejabat / Jabatan</th>
                        <th>Kelompok</th>
                        <th>Bidang / Divisi</th>
                        <th>Atasan Langsung</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($structures as $index => $s)
                    <tr>
                        <td>{{ $structures->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle overflow-hidden bg-light border d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; flex-shrink: 0;">
                                    @if($s->photo)
                                        <img src="{{ asset('storage/' . $s->photo) }}" alt="{{ $s->name }}" class="w-100 h-100" style="object-fit: cover;">
                                    @else
                                        <i class="fas fa-user text-muted small"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $s->name }}</div>
                                    <div class="d-flex align-items-center gap-1 flex-wrap">
                                        <small class="text-primary fw-semibold">{{ $s->position }}</small>
                                        @if($s->group_photo)
                                            <span class="badge bg-success-subtle text-success py-0 px-1" style="font-size: 0.68rem;" title="Foto bersama divisi tersedia"><i class="fas fa-users-rectangle"></i> Foto Bersama</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($s->kelompok === 'putra')
                                <span class="badge bg-primary-subtle text-primary"><i class="fas fa-mars me-1"></i> Putra</span>
                            @elseif($s->kelompok === 'putri')
                                <span class="badge bg-danger-subtle text-danger"><i class="fas fa-venus me-1"></i> Putri</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary"><i class="fas fa-users me-1"></i> Semua</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $s->division ?: '-' }}</span>
                        </td>
                        <td>
                            <span class="text-dark small">{{ $s->parent->name ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-muted small">{{ $s->period ?: '-' }}</span>
                        </td>
                        <td>
                            @if($s->is_active)
                                <span class="badge bg-success-subtle text-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.struktur-organisasi.edit', $s) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteConfirmModal" 
                                        data-action="{{ route('admin.struktur-organisasi.destroy', $s) }}" 
                                        data-title="{{ $s->position }} - {{ $s->name }}"
                                        title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-sitemap fs-1 d-block mb-2 text-muted"></i>
                            Belum ada struktur organisasi tersimpan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $structures->links() }}
        </div>
    </div>
</div>

{{-- ==================== POP-UP MODAL ANGGOTA DIVISI ==================== --}}
<div class="divisi-modal-overlay" id="divisiModal" role="dialog" aria-modal="true" aria-labelledby="modalDivisiTitle">
    <div class="divisi-modal-dialog">
        <button type="button" class="divisi-modal-close" onclick="closeDivisiModal()" aria-label="Tutup Detail Divisi" id="btnModalClose">
            <i class="fas fa-times"></i>
        </button>

        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge" style="background: var(--rose-soft); color: var(--burgundy-main); font-weight: 700; font-size: 0.75rem; letter-spacing: 1px; padding: 5px 12px; border-radius: 50px;">
                DETAIL DIVISI
            </span>
        </div>

        <h3 class="fw-bold mb-2" id="modalDivisiTitle" style="font-size: 1.4rem; color: var(--text-dark);">
            Nama Divisi
        </h3>

        <div class="d-flex flex-wrap align-items-center gap-2 mb-3" id="modalDivisiBadges"></div>

        <p class="text-secondary small mb-3" id="modalDivisiDesc" style="line-height: 1.6;">
            Deskripsi tugas divisi.
        </p>

        <!-- Card Anggota Divisi yang Aktif -->
        <div class="modal-member-card">
            <div id="modalPhotoContainer"></div>
            <h4 class="fw-bold mb-1" id="modalMemberName" style="font-size: 1.15rem; color: var(--text-dark);">
                Nama Pengurus
            </h4>
            <div class="fw-semibold mb-2" id="modalMemberPosition" style="color: var(--burgundy-main); font-size: 0.88rem;">
                Jabatan
            </div>
            <p class="text-muted small mb-0 px-2" id="modalMemberBio" style="line-height: 1.5;">
                Bio pengurus.
            </p>
        </div>

        <!-- Slider Navigasi Anggota -->
        <div class="d-flex align-items-center justify-content-between mt-3 pt-2" id="sliderControlsWrap" style="display: none;">
            <button type="button" class="slider-nav-btn" onclick="modalSlidePrev()">
                <i class="fas fa-chevron-left"></i> Sebelumnya
            </button>
            <span class="small fw-semibold text-muted" id="sliderCounterText">1 / 1</span>
            <button type="button" class="slider-nav-btn" onclick="modalSlideNext()">
                Selanjutnya <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
            <a href="#" id="modalEditDivisiLink" class="btn btn-sm btn-him-primary">
                <i class="fas fa-pencil-alt me-1"></i> Edit Data Divisi Ini
            </a>
            <a href="#" id="modalDetailDivisiLink" target="_blank" class="link-detail">
                Lihat di Halaman Publik &rarr;
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const divisiDataMap = @json($divisiModalData);
    let currentKelompok = 'putra';
    let currentDivisiKey = null;
    let currentMemberIndex = 0;
    let lastActiveTrigger = null;

    function openDivisiModal(key, triggerEl, kelompok) {
        lastActiveTrigger = triggerEl || document.activeElement;
        currentKelompok = kelompok || currentKelompok || 'putra';
        const groupData = divisiDataMap[currentKelompok] || {};
        const data = groupData[key];
        if (!data) return;

        currentDivisiKey = key;
        currentMemberIndex = 0;

        document.getElementById('modalDivisiTitle').textContent = data.name;
        document.getElementById('modalDivisiDesc').textContent = data.description;
        document.getElementById('modalDetailDivisiLink').href = data.detail_url;

        const editLink = document.getElementById('modalEditDivisiLink');
        if (editLink) {
            if (data.edit_url) {
                editLink.href = data.edit_url;
                editLink.style.display = 'inline-flex';
            } else {
                editLink.style.display = 'none';
            }
        }

        const badgesWrap = document.getElementById('modalDivisiBadges');
        if (badgesWrap) {
            badgesWrap.innerHTML = `
                <span class="badge" style="background: var(--rose-soft); color: var(--burgundy-main); font-weight: 700; font-size: 0.78rem; padding: 6px 12px; border-radius: 50px; border: 1px solid var(--border-rose);">
                    <i class="fas fa-crown text-warning me-1"></i> ${data.leader_position || 'Kepala Divisi'}: <strong>${data.leader_name}</strong>
                </span>
                <span class="badge" style="background: var(--rose-pale); color: var(--text-dark); font-weight: 600; font-size: 0.78rem; padding: 6px 12px; border-radius: 50px; border: 1px solid var(--border-rose);">
                    <i class="fas fa-users text-primary me-1"></i> Total <strong>${data.members.length}</strong> Pengurus
                </span>
            `;
        }

        renderModalMember();

        const modal = document.getElementById('divisiModal');
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            const closeBtn = document.getElementById('btnModalClose');
            if (closeBtn) closeBtn.focus();
        }, 50);
    }

    function renderModalMember() {
        const groupData = divisiDataMap[currentKelompok] || {};
        const data = groupData[currentDivisiKey];
        if (!data) return;

        const members = data.members || [];
        const sliderWrap = document.getElementById('sliderControlsWrap');
        const photoContainer = document.getElementById('modalPhotoContainer');
        const nameEl = document.getElementById('modalMemberName');
        const posEl = document.getElementById('modalMemberPosition');
        const bioEl = document.getElementById('modalMemberBio');
        const counterEl = document.getElementById('sliderCounterText');

        if (members.length === 0) {
            photoContainer.innerHTML = '<div class="modal-photo-placeholder"><i class="fas fa-users"></i></div>';
            nameEl.textContent = 'Data Anggota Sedang Dilengkapi';
            posEl.textContent = data.name;
            bioEl.textContent = 'Belum ada anggota ' + (currentKelompok === 'putra' ? 'Putra' : 'Putri') + ' yang terdaftar di divisi ini.';
            sliderWrap.style.display = 'none';
            return;
        }

        const member = members[currentMemberIndex];
        nameEl.textContent = member.name;
        posEl.textContent = member.position;
        bioEl.textContent = member.bio || 'Pengurus aktif HIMATIKA UNUJA.';

        if (member.photo) {
            photoContainer.innerHTML = `<img src="${member.photo}" alt="${member.name}" class="modal-photo-circle">`;
        } else {
            photoContainer.innerHTML = '<div class="modal-photo-placeholder"><i class="fas fa-user"></i></div>';
        }

        if (members.length > 1) {
            sliderWrap.style.display = 'flex';
            counterEl.textContent = `${currentMemberIndex + 1} / ${members.length}`;
        } else {
            sliderWrap.style.display = 'none';
        }
    }

    function modalSlidePrev() {
        const groupData = divisiDataMap[currentKelompok] || {};
        const data = groupData[currentDivisiKey];
        if (!data || !data.members || data.members.length <= 1) return;
        currentMemberIndex = (currentMemberIndex - 1 + data.members.length) % data.members.length;
        renderModalMember();
    }

    function modalSlideNext() {
        const groupData = divisiDataMap[currentKelompok] || {};
        const data = groupData[currentDivisiKey];
        if (!data || !data.members || data.members.length <= 1) return;
        currentMemberIndex = (currentMemberIndex + 1) % data.members.length;
        renderModalMember();
    }

    function setStrukturTab(tab) {
        currentKelompok = (tab === 'putri') ? 'putri' : 'putra';
        const isPutra = (currentKelompok === 'putra');
        const btnPutra = document.getElementById('tabBtnPutra');
        const btnPutri = document.getElementById('tabBtnPutri');
        const panelPutra = document.getElementById('panelStrukturPutra');
        const panelPutri = document.getElementById('panelStrukturPutri');
        const notice = document.getElementById('activeTabNotice');

        if (isPutra) {
            btnPutra.classList.add('active');
            btnPutri.classList.remove('active');
            btnPutra.setAttribute('aria-selected', 'true');
            btnPutri.setAttribute('aria-selected', 'false');

            panelPutra.style.display = 'block';
            panelPutri.style.display = 'none';

            if (notice) {
                notice.innerHTML = '<i class="fas fa-user-tie me-1"></i> Menampilkan Susunan Kepengurusan <strong>PUTRA</strong>';
            }
        } else {
            btnPutri.classList.add('active');
            btnPutra.classList.remove('active');
            btnPutri.setAttribute('aria-selected', 'true');
            btnPutra.setAttribute('aria-selected', 'false');

            panelPutri.style.display = 'block';
            panelPutra.style.display = 'none';

            if (notice) {
                notice.innerHTML = '<i class="fas fa-user-circle me-1"></i> Menampilkan Susunan Kepengurusan <strong>PUTRI</strong>';
            }
        }
    }

    function closeDivisiModal() {
        const modal = document.getElementById('divisiModal');
        modal.classList.remove('show');
        document.body.style.overflow = '';

        if (lastActiveTrigger && typeof lastActiveTrigger.focus === 'function') {
            lastActiveTrigger.focus();
        }
    }

    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('divisiModal');
        if (!modal || !modal.classList.contains('show')) return;

        if (e.key === 'Escape') {
            closeDivisiModal();
        } else if (e.key === 'ArrowLeft') {
            modalSlidePrev();
        } else if (e.key === 'ArrowRight') {
            modalSlideNext();
        }
    });

    document.getElementById('divisiModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDivisiModal();
        }
    });
</script>
@endpush
@endsection
