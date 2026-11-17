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

        /* ========================================================
           BRANCH CONVERGE LINES (KE DIVISI PUBLIK)
           ======================================================== */
        .branch-converge-wrapper {
            position: relative;
            width: 100%;
            margin: 0 auto;
        }
        .branch-converge-bar {
            position: relative;
            width: 60%;
            margin: 12px auto 0;
            height: 2px;
            background: var(--burgundy-main);
        }
        .branch-converge-bar::before,
        .branch-converge-bar::after {
            content: '';
            position: absolute;
            bottom: 0;
            width: 2px;
            height: 18px;
            background: var(--burgundy-main);
        }
        .branch-converge-bar::before { left: 0; }
        .branch-converge-bar::after { right: 0; }
        .branch-converge-drop {
            width: 2px;
            height: 24px;
            margin: 0 auto;
            background: var(--burgundy-main);
        }

        /* ========================================================
           UNIT MANAGEMENT CARD & CONTROLS
           ======================================================== */
        .unit-manage-card {
            border: 1.5px solid var(--border-rose);
            border-radius: 16px;
            background: #FFFFFF;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(113, 28, 53, 0.05);
            margin-bottom: 2rem;
        }
        .unit-manage-header {
            background: linear-gradient(135deg, #FFF7F9 0%, #FFFFFF 100%);
            border-bottom: 1px solid var(--border-rose);
            padding: 1.25rem 1.5rem;
        }
        .unit-manage-badge {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 50px;
            background: var(--rose-soft);
            color: var(--burgundy-main);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .unit-manage-photo-box {
            background: var(--rose-pale);
            border: 1px solid var(--border-rose);
            border-radius: 12px;
            padding: 1rem;
        }
        .unit-manage-photo-img {
            max-height: 160px;
            width: auto;
            border-radius: 8px;
            border: 1px solid var(--border-rose);
            object-fit: cover;
        }
        .unit-reorder-btn {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: 1px solid var(--border-rose);
            background: #FFFFFF;
            color: var(--burgundy-main);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            transition: all 0.2s ease;
        }
        .unit-reorder-btn:hover {
            background: var(--rose-soft);
            color: var(--burgundy-hover);
            border-color: var(--burgundy-focus);
        }

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

    {{-- ========================================================
         KARTU PENGELOLAAN UNIT (SESUAI SUBMENU AKTIF)
         ======================================================== --}}
    <div class="unit-manage-card">
        <div class="unit-manage-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="unit-manage-badge">
                        <i class="{{ $currentUnit['icon'] }}"></i> {{ strtoupper($currentUnit['key']) }}
                    </span>
                    <span class="badge {{ $activeKelompok === 'putra' ? 'bg-primary-subtle text-primary border border-primary-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }} px-2 py-1" style="font-size: 0.75rem;">
                        <i class="fas {{ $activeKelompok === 'putra' ? 'fa-mars' : 'fa-venus' }} me-1"></i> Kelompok {{ ucfirst($activeKelompok) }}
                    </span>
                </div>
                <h3 class="fw-bold mb-1" style="font-size: 1.25rem; color: var(--text-dark);">
                    Kelola {{ $currentUnit['name'] }}
                </h3>
                <p class="text-secondary small mb-0">{{ $currentUnit['desc'] }}</p>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                {{-- Switcher Putra / Putri untuk Unit Ini --}}
                <div class="btn-group" role="group" aria-label="Pilihan Kelompok Unit">
                    <a href="{{ route('admin.struktur-organisasi.index', ['unit' => $activeUnitKey, 'kelompok' => 'putra']) }}" 
                       class="btn btn-sm {{ $activeKelompok === 'putra' ? 'btn-him-primary' : 'btn-outline-secondary' }} px-3 fw-semibold">
                        <i class="fas fa-mars me-1"></i> Putra
                    </a>
                    <a href="{{ route('admin.struktur-organisasi.index', ['unit' => $activeUnitKey, 'kelompok' => 'putri']) }}" 
                       class="btn btn-sm {{ $activeKelompok === 'putri' ? 'btn-him-primary' : 'btn-outline-secondary' }} px-3 fw-semibold">
                        <i class="fas fa-venus me-1"></i> Putri
                    </a>
                </div>

                {{-- Tombol + Tambah dengan Pilihan Jabatan Langsung --}}
                <div class="dropdown">
                    <button class="btn btn-sm btn-him-primary dropdown-toggle px-3 fw-semibold" type="button" id="dropdownTambahUnit" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-plus me-1"></i> Tambah Pengurus
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border" aria-labelledby="dropdownTambahUnit" style="min-width: 220px;">
                        @if($currentUnit['type'] === 'bpi')
                            <li><h6 class="dropdown-header text-uppercase small text-muted">Pilih Jabatan BPI ({{ ucfirst($activeKelompok) }})</h6></li>
                            @foreach($bpiPositions as $posKey => $pos)
                                <li>
                                    @if($pos['model'])
                                        <a class="dropdown-item py-2" href="{{ route('admin.struktur-organisasi.edit', $pos['model']->id) }}">
                                            <i class="fas fa-user-edit text-primary me-2"></i> {{ $pos['action_title'] }}
                                        </a>
                                    @else
                                        <a class="dropdown-item py-2" href="{{ route('admin.struktur-organisasi.create', ['kelompok' => $activeKelompok, 'position' => $pos['default_position']]) }}">
                                            <i class="fas fa-plus-circle text-success me-2"></i> {{ $pos['action_title'] }}
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        @else
                            <li><h6 class="dropdown-header text-uppercase small text-muted">Pilih Jabatan ({{ ucfirst($activeKelompok) }})</h6></li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('admin.struktur-organisasi.create', ['division' => $currentUnit['division_name'], 'kelompok' => $activeKelompok, 'position' => 'Koordinator Divisi (Co)', 'unit' => $activeUnitKey, 'return_unit' => $activeUnitKey]) }}">
                                    <i class="fas fa-user-tie text-primary me-2"></i> Tambah Co / Koordinator
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('admin.struktur-organisasi.create', ['division' => $currentUnit['division_name'], 'kelompok' => $activeKelompok, 'position' => 'Anggota ' . $currentUnit['division_name'], 'unit' => $activeUnitKey, 'return_unit' => $activeUnitKey]) }}">
                                    <i class="fas fa-user-plus text-success me-2"></i> Tambah Anggota Divisi
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="p-3 p-md-4">
            <div class="row g-4 mb-4">
                {{-- Foto Bersama Unit --}}
                <div class="col-lg-5">
                    <div class="unit-manage-photo-box h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-bold small text-dark">
                                    <i class="fas fa-camera text-primary me-1"></i> Foto Bersama Unit ({{ ucfirst($activeKelompok) }})
                                </span>
                                @if($currentGroupPhoto)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.68rem;">Tersedia</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border" style="font-size: 0.68rem;">Belum ada foto</span>
                                @endif
                            </div>

                            <div class="text-center my-3">
                                @if($currentGroupPhoto)
                                    <img src="{{ $currentGroupPhoto }}" alt="Foto Bersama {{ $currentUnit['name'] }}" class="unit-manage-photo-img shadow-sm" style="max-height: 140px; width: 100%; object-fit: cover;">
                                @else
                                    <div class="py-4 border rounded bg-white text-muted">
                                        <i class="fas fa-users-rectangle fs-2 d-block mb-1 text-secondary opacity-50"></i>
                                        <span class="small">Belum mengunggah foto bersama untuk kelompok ini.</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($unitStruct)
                            <form action="{{ route('admin.struktur-organisasi.upload-group-photo') }}" method="POST" enctype="multipart/form-data" class="mt-2 pt-2 border-top">
                                @csrf
                                <input type="hidden" name="unit" value="{{ $activeUnitKey }}">
                                <input type="hidden" name="unit_id" value="{{ $unitStruct->id }}">
                                <input type="hidden" name="kelompok" value="{{ $activeKelompok }}">
                                <label class="form-label small fw-semibold text-dark mb-1">Unggah / Ganti Foto Bersama</label>
                                <div class="input-group input-group-sm">
                                    <input type="file" name="photo" class="form-control" accept="image/png,image/jpeg,image/webp" required>
                                    <button type="submit" class="btn btn-him-primary">
                                        <i class="fas fa-upload me-1"></i> Simpan
                                    </button>
                                </div>
                                <div class="form-text" style="font-size: 0.72rem;">Format: JPG, PNG, WebP (maks. 5MB)</div>
                            </form>
                        @endif
                    </div>
                </div>

                {{-- Deskripsi & Ringkasan Pengurus Unit --}}
                <div class="col-lg-7">
                    <div class="border rounded-3 p-3 bg-white h-100 d-flex flex-column justify-content-between" style="border-color: var(--border-rose) !important;">
                        <div>
                            <h5 class="fw-bold mb-2 text-dark" style="font-size: 1rem;">
                                <i class="fas fa-info-circle text-primary me-1"></i> Informasi Unit &amp; Tugas
                            </h5>
                            <p class="text-secondary small mb-3" style="line-height: 1.6;">
                                {{ $unitStruct?->description ?: $currentUnit['desc'] }}
                            </p>
                        </div>
                        <div class="p-2 rounded bg-light border d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="small">
                                <span class="text-muted">Total Pengurus {{ ucfirst($activeKelompok) }}:</span>
                                <strong class="text-dark ms-1">
                                    @if($currentUnit['type'] === 'bpi')
                                        4 Posisi Inti
                                    @else
                                        {{ $leaders->count() + $staff->count() }} Anggota Aktif
                                    @endif
                                </strong>
                            </div>
                            @if($unitStruct)
                                <a href="{{ route('admin.struktur-organisasi.edit', $unitStruct->id) }}" class="btn btn-sm btn-outline-secondary py-1 px-2" style="font-size: 0.78rem;">
                                    <i class="fas fa-edit me-1"></i> Edit Deskripsi &amp; Data Unit
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Daftar Pengurus Unit --}}
            <div class="border rounded-3 overflow-hidden bg-white" style="border-color: var(--border-rose) !important;">
                <div class="p-3 bg-light border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="fw-bold text-dark small">
                        <i class="fas fa-users text-primary me-1"></i> DAFTAR PENGURUS {{ strtoupper($currentUnit['name']) }} ({{ strtoupper($activeKelompok) }})
                    </div>
                    <span class="badge bg-secondary-subtle text-secondary small">
                        @if($currentUnit['type'] === 'bpi')
                            Hirarki Jabatan Tetap
                        @else
                            Gunakan tombol Naik/Turun untuk mengatur urutan
                        @endif
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted small">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Pejabat / Pengurus</th>
                                <th>Jabatan</th>
                                <th>Status</th>
                                @if($currentUnit['type'] !== 'bpi')
                                    <th class="text-center" style="width: 130px;">Atur Urutan</th>
                                @endif
                                <th class="text-end" style="width: 140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($currentUnit['type'] === 'bpi')
                                {{-- BPI: 4 POSISI TETAP --}}
                                @php $bpiIdx = 1; @endphp
                                @foreach($bpiPositions as $bpiKey => $bpiPos)
                                    @php $m = $bpiPos['model']; @endphp
                                    <tr>
                                        <td class="text-muted fw-semibold">{{ $bpiIdx++ }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded-circle overflow-hidden bg-light border d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; flex-shrink: 0;">
                                                    @if($m?->photo)
                                                        <img src="{{ asset('storage/' . $m->photo) }}" alt="{{ $m->name }}" class="w-100 h-100" style="object-fit: cover;">
                                                    @else
                                                        <i class="fas fa-user-circle text-muted"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $m?->name ?? 'Belum ditentukan' }}</div>
                                                    <small class="text-muted">{{ $bpiPos['default_position'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: var(--rose-soft); color: var(--burgundy-main); font-weight: 700;">
                                                {{ $bpiPos['label'] }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($m?->is_active ?? true)
                                                <span class="badge bg-success-subtle text-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if($m)
                                                <a href="{{ route('admin.struktur-organisasi.edit', $m->id) }}" class="btn btn-sm btn-him-primary py-1 px-3">
                                                    <i class="fas fa-pencil-alt me-1"></i> Edit
                                                </a>
                                            @else
                                                <a href="{{ route('admin.struktur-organisasi.create', ['kelompok' => $activeKelompok, 'position' => $bpiPos['default_position']]) }}" class="btn btn-sm btn-outline-primary py-1 px-3">
                                                    <i class="fas fa-plus me-1"></i> Tambah
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                {{-- DIVISI: KOORDINATOR (CO) DI ATAS, ANGGOTA DI BAWAH --}}
                                @php $divIdx = 1; @endphp
                                
                                {{-- Baris Koordinator / Co --}}
                                @forelse($leaders as $co)
                                    <tr class="table-warning bg-opacity-25">
                                        <td class="text-muted fw-semibold">{{ $divIdx++ }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded-circle overflow-hidden bg-light border d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; flex-shrink: 0;">
                                                    @if($co->photo)
                                                        <img src="{{ asset('storage/' . $co->photo) }}" alt="{{ $co->name }}" class="w-100 h-100" style="object-fit: cover;">
                                                    @else
                                                        <i class="fas fa-user-tie text-muted"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $co->name }}</div>
                                                    <small class="text-muted">NIM: {{ $co->nim ?: '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: var(--rose-soft); color: var(--burgundy-main); font-weight: 700;">
                                                <i class="fas fa-star text-warning me-1"></i> {{ $co->position }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $co->is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                                {{ $co->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td class="text-center text-muted small">
                                            <em>Pimpinan Divisi</em>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex gap-1">
                                                <a href="{{ route('admin.pengurus.edit', ['penguru' => $co->id, 'unit' => $activeUnitKey, 'return_unit' => $activeUnitKey]) }}" class="btn btn-sm btn-outline-primary py-1 px-2" title="Edit Data">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteConfirmModal" 
                                                        data-action="{{ route('admin.pengurus.destroy', ['penguru' => $co->id, 'return_unit' => $activeUnitKey]) }}" 
                                                        data-title="{{ $co->name }} ({{ $co->position }})"
                                                        title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    {{-- Tidak ada pimpinan terdaftar secara khusus --}}
                                @endforelse

                                {{-- Baris Anggota Divisi (Berurutan dengan tombol Naik & Turun) --}}
                                @forelse($staff as $st)
                                    <tr>
                                        <td class="text-muted fw-semibold">{{ $divIdx++ }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded-circle overflow-hidden bg-light border d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; flex-shrink: 0;">
                                                    @if($st->photo)
                                                        <img src="{{ asset('storage/' . $st->photo) }}" alt="{{ $st->name }}" class="w-100 h-100" style="object-fit: cover;">
                                                    @else
                                                        <i class="fas fa-user text-muted"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $st->name }}</div>
                                                    <small class="text-muted">NIM: {{ $st->nim ?: '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                {{ $st->position }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $st->is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                                {{ $st->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-flex align-items-center gap-1">
                                                @if(!$loop->first)
                                                    <form action="{{ route('admin.struktur-organisasi.reorder', $st) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="unit" value="{{ $activeUnitKey }}">
                                                        <input type="hidden" name="direction" value="up">
                                                        <button type="submit" class="unit-reorder-btn" title="Naikkan Urutan">
                                                            <i class="fas fa-arrow-up"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="unit-reorder-btn opacity-25" style="cursor: not-allowed;"><i class="fas fa-arrow-up"></i></span>
                                                @endif

                                                <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 0.75rem;">#{{ $st->order_num }}</span>

                                                @if(!$loop->last)
                                                    <form action="{{ route('admin.struktur-organisasi.reorder', $st) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="unit" value="{{ $activeUnitKey }}">
                                                        <input type="hidden" name="direction" value="down">
                                                        <button type="submit" class="unit-reorder-btn" title="Turunkan Urutan">
                                                            <i class="fas fa-arrow-down"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="unit-reorder-btn opacity-25" style="cursor: not-allowed;"><i class="fas fa-arrow-down"></i></span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex gap-1">
                                                <a href="{{ route('admin.pengurus.edit', ['penguru' => $st->id, 'unit' => $activeUnitKey, 'return_unit' => $activeUnitKey]) }}" class="btn btn-sm btn-outline-primary py-1 px-2" title="Edit Data">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteConfirmModal" 
                                                        data-action="{{ route('admin.pengurus.destroy', ['penguru' => $st->id, 'return_unit' => $activeUnitKey]) }}" 
                                                        data-title="{{ $st->name }} ({{ $st->position }})"
                                                        title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    @if($leaders->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">
                                                <i class="fas fa-users fs-3 d-block mb-2 text-muted opacity-50"></i>
                                                Belum ada pengurus {{ $currentUnit['name'] }} untuk kelompok {{ $activeKelompok }}.
                                            </td>
                                        </tr>
                                    @endif
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

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

                    @if($activeUnitKey === 'bpi')
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
                                        <h3 class="chart-title">{{ $kaprodi?->position ?? 'Ketua Program Studi' }}</h3>
                                        <div class="chart-officer">{{ $kaprodi?->name ?? 'Mudakkir, S.Pd., MM.' }}</div>
                                    </div>
                                </div>
                                <p class="chart-desc">{{ $kaprodi?->description ?? 'Memberikan bimbingan, arahan, dan pembinaan dalam pelaksanaan kegiatan akademik serta pengembangan organisasi kemahasiswaan Program Studi Informatika UNUJA.' }}</p>
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
                    @else
                        {{-- ================= DIVISI PUTRA ================= --}}
                        @if(($unitChartPutra['total'] ?? 0) > 0)
                            <div class="level-label text-center">{{ strtoupper($currentUnit['name'] ?? 'DIVISI') }} (PUTRA)</div>

                            {{-- Koordinator / Co Putra di tengah atas --}}
                            <div class="d-flex justify-content-center flex-wrap gap-3">
                                @foreach($unitChartPutra['leaders'] as $ldr)
                                    <div class="chart-card" style="width: 100%; max-width: 420px;">
                                        <div class="d-flex align-items-start gap-3 mb-2">
                                            @if(!empty($ldr->photo))
                                                <img src="{{ asset('storage/' . $ldr->photo) }}" alt="{{ $ldr->name }}" class="chart-officer-photo">
                                            @else
                                                <div class="chart-officer-placeholder"><i class="fas fa-user-circle"></i></div>
                                            @endif
                                            <div class="flex-grow-1 min-w-0">
                                                <span class="chart-badge"><i class="{{ $currentUnit['icon'] ?? 'fas fa-sitemap' }} me-1"></i> {{ strtoupper($currentUnit['division_name'] ?? 'DIVISI') }}</span>
                                                <h4 class="chart-title">{{ $ldr->position ?? 'Koordinator Divisi' }}</h4>
                                                <div class="chart-officer">{{ $ldr->name ?? 'Belum terisi' }}</div>
                                            </div>
                                        </div>
                                        @if(!empty($ldr->bio) || !empty($ldr->description))
                                            <p class="chart-desc">{{ $ldr->bio ?? $ldr->description }}</p>
                                        @endif
                                        <div class="chart-card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                                            <span class="badge {{ ($ldr->is_active ?? true) ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border' }}" style="font-size: 0.72rem;">
                                                <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>{{ ($ldr->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ route('struktur-organisasi.show', $currentUnit['struct_id'] ?? 5) }}" target="_blank" class="link-detail" style="font-size: 0.78rem;">
                                                    Pratinjau <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7rem;"></i>
                                                </a>
                                                @if(!empty($ldr->is_structure))
                                                    <a href="{{ route('admin.struktur-organisasi.edit', $ldr->id) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                                        <i class="fas fa-pencil-alt me-1"></i> Edit Posisi
                                                    </a>
                                                @else
                                                    <a href="{{ route('admin.pengurus.edit', ['penguru' => $ldr->id, 'unit' => $activeUnitKey, 'kelompok' => 'putra']) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                                        <i class="fas fa-pencil-alt me-1"></i> Edit Pengurus
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Garis penghubung hanya jika kedua jabatan (Leader & Staff) terlihat pada bagan aktif --}}
                            @if(isset($unitChartPutra['staff']) && $unitChartPutra['staff']->count() > 0)
                                <div class="tree-connector h-24 my-2"></div>
                                <div class="level-label text-center">ANGGOTA / STAF (PUTRA)</div>
                                <div class="row g-3 justify-content-center mt-0">
                                    @foreach($unitChartPutra['staff'] as $stf)
                                        <div class="col-md-6 col-lg-4 d-flex">
                                            <div class="chart-card w-100 d-flex flex-column justify-content-between">
                                                <div>
                                                    <div class="d-flex align-items-start gap-3 mb-2">
                                                        @if(!empty($stf->photo))
                                                            <img src="{{ asset('storage/' . $stf->photo) }}" alt="{{ $stf->name }}" class="chart-officer-photo">
                                                        @else
                                                            <div class="chart-officer-placeholder"><i class="fas fa-user"></i></div>
                                                        @endif
                                                        <div class="flex-grow-1 min-w-0">
                                                            <span class="chart-badge">Anggota Divisi</span>
                                                            <h4 class="chart-title">{{ $stf->position ?? 'Anggota Divisi' }}</h4>
                                                            <div class="chart-officer">{{ $stf->name ?? 'Belum terisi' }}</div>
                                                        </div>
                                                    </div>
                                                    @if(!empty($stf->bio) || !empty($stf->description))
                                                        <p class="chart-desc">{{ $stf->bio ?? $stf->description }}</p>
                                                    @endif
                                                </div>
                                                <div class="chart-card-footer mt-auto d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                    <span class="badge {{ ($stf->is_active ?? true) ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border' }}" style="font-size: 0.72rem;">
                                                        <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>{{ ($stf->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}
                                                    </span>
                                                    <div class="d-flex align-items-center gap-2">
                                                        @if(!empty($stf->is_structure))
                                                            <a href="{{ route('admin.struktur-organisasi.edit', $stf->id) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                                                <i class="fas fa-pencil-alt me-1"></i> Edit Posisi
                                                            </a>
                                                        @else
                                                            <a href="{{ route('admin.pengurus.edit', ['penguru' => $stf->id, 'unit' => $activeUnitKey, 'kelompok' => 'putra']) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                                                <i class="fas fa-pencil-alt me-1"></i> Edit Pengurus
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="text-center py-5">
                                <p class="text-muted fw-semibold mb-0" style="font-size: 0.95rem;">Belum ada susunan pengurus untuk divisi ini.</p>
                            </div>
                        @endif
                    @endif

                </div>

{{-- ==================== PANEL STRUKTUR PUTRI ==================== --}}
                <div id="panelStrukturPutri" class="panel-fade" style="display: none;" role="tabpanel" aria-labelledby="tabBtnPutri">

                    @if($activeUnitKey === 'bpi')
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
                                        <h3 class="chart-title">{{ $kaprodi?->position ?? 'Ketua Program Studi' }}</h3>
                                        <div class="chart-officer">{{ $kaprodi?->name ?? 'Mudakkir, S.Pd., MM.' }}</div>
                                    </div>
                                </div>
                                <p class="chart-desc">{{ $kaprodi?->description ?? 'Memberikan bimbingan, arahan, dan pembinaan dalam pelaksanaan kegiatan akademik serta pengembangan organisasi kemahasiswaan Program Studi Informatika UNUJA.' }}</p>
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
                                        <div class="chart-officer-placeholder"><i class="fas fa-user-tie"></i></div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <span class="chart-badge">Badan Pengurus Harian</span>
                                        <h4 class="chart-title">{{ $ketuaPutri?->position ?? 'Ketua Umum Putri' }}</h4>
                                        <div class="chart-officer">{{ $ketuaPutri?->name ?? 'Nadiratul Laili' }}</div>
                                    </div>
                                </div>
                                <p class="chart-desc">{{ $ketuaPutri?->description ?? 'Memimpin dan mengoordinasikan seluruh jajaran kepengurusan HIMATIKA UNUJA Putri, memperkuat sinergi dan keharmonisan kepengurusan putri, serta mewakili himpunan dalam kegiatan kemahasiswaan putri.' }}</p>
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
                                        <div class="chart-officer-placeholder"><i class="fas fa-user-tie"></i></div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <span class="chart-badge">Badan Pengurus Harian</span>
                                        <h4 class="chart-title">{{ $wakilPutri?->position ?? 'Wakil Ketua Umum Putri' }}</h4>
                                        <div class="chart-officer">{{ $wakilPutri?->name ?? 'Siti Nurhaliza' }}</div>
                                    </div>
                                </div>
                                <p class="chart-desc">{{ $wakilPutri?->description ?? 'Membantu Ketua Umum Putri dalam memimpin roda organisasi kepengurusan putri, mengoordinasikan seluruh bidang kerja kepengurusan putri, serta mewakili Ketua Umum jika berhalangan.' }}</p>
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
                                                <div class="chart-officer">{{ $sekretarisPutri?->name ?? 'Fafi Rahmatullah' }}</div>
                                            </div>
                                        </div>
                                        <p class="chart-desc">{{ $sekretarisPutri?->description ?? 'Mengatur seluruh agenda tertulis, arsip kepengurusan dan dokumentasi kegiatan kepengurusan HIMATIKA UNUJA Putri.' }}</p>
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
                                                <div class="chart-officer">{{ $bendaharaPutri?->name ?? 'Novelia Putri Fadilah' }}</div>
                                            </div>
                                        </div>
                                        <p class="chart-desc">{{ $bendaharaPutri?->description ?? 'Mengurus sirkulasi keuangan serta transparansi anggaran HIMATIKA UNUJA Putri.' }}</p>
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
                    @else
                        {{-- ================= DIVISI PUTRI ================= --}}
                        @if(($unitChartPutri['total'] ?? 0) > 0)
                            <div class="level-label text-center">{{ strtoupper($currentUnit['name'] ?? 'DIVISI') }} (PUTRI)</div>

                            {{-- Koordinator / Co Putri di tengah atas --}}
                            <div class="d-flex justify-content-center flex-wrap gap-3">
                                @foreach($unitChartPutri['leaders'] as $ldr)
                                    <div class="chart-card" style="width: 100%; max-width: 420px;">
                                        <div class="d-flex align-items-start gap-3 mb-2">
                                            @if(!empty($ldr->photo))
                                                <img src="{{ asset('storage/' . $ldr->photo) }}" alt="{{ $ldr->name }}" class="chart-officer-photo">
                                            @else
                                                <div class="chart-officer-placeholder"><i class="fas fa-user-circle"></i></div>
                                            @endif
                                            <div class="flex-grow-1 min-w-0">
                                                <span class="chart-badge"><i class="{{ $currentUnit['icon'] ?? 'fas fa-sitemap' }} me-1"></i> {{ strtoupper($currentUnit['division_name'] ?? 'DIVISI') }}</span>
                                                <h4 class="chart-title">{{ $ldr->position ?? 'Koordinator Divisi' }}</h4>
                                                <div class="chart-officer">{{ $ldr->name ?? 'Belum terisi' }}</div>
                                            </div>
                                        </div>
                                        @if(!empty($ldr->bio) || !empty($ldr->description))
                                            <p class="chart-desc">{{ $ldr->bio ?? $ldr->description }}</p>
                                        @endif
                                        <div class="chart-card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                                            <span class="badge {{ ($ldr->is_active ?? true) ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border' }}" style="font-size: 0.72rem;">
                                                <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>{{ ($ldr->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ route('struktur-organisasi.show', $currentUnit['struct_id'] ?? 5) }}" target="_blank" class="link-detail" style="font-size: 0.78rem;">
                                                    Pratinjau <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7rem;"></i>
                                                </a>
                                                @if(!empty($ldr->is_structure))
                                                    <a href="{{ route('admin.struktur-organisasi.edit', $ldr->id) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                                        <i class="fas fa-pencil-alt me-1"></i> Edit Posisi
                                                    </a>
                                                @else
                                                    <a href="{{ route('admin.pengurus.edit', ['penguru' => $ldr->id, 'unit' => $activeUnitKey, 'kelompok' => 'putri']) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                                        <i class="fas fa-pencil-alt me-1"></i> Edit Pengurus
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Garis penghubung hanya jika kedua jabatan (Leader & Staff) terlihat pada bagan aktif --}}
                            @if(isset($unitChartPutri['staff']) && $unitChartPutri['staff']->count() > 0)
                                <div class="tree-connector h-24 my-2"></div>
                                <div class="level-label text-center">ANGGOTA / STAF (PUTRI)</div>
                                <div class="row g-3 justify-content-center mt-0">
                                    @foreach($unitChartPutri['staff'] as $stf)
                                        <div class="col-md-6 col-lg-4 d-flex">
                                            <div class="chart-card w-100 d-flex flex-column justify-content-between">
                                                <div>
                                                    <div class="d-flex align-items-start gap-3 mb-2">
                                                        @if(!empty($stf->photo))
                                                            <img src="{{ asset('storage/' . $stf->photo) }}" alt="{{ $stf->name }}" class="chart-officer-photo">
                                                        @else
                                                            <div class="chart-officer-placeholder"><i class="fas fa-user"></i></div>
                                                        @endif
                                                        <div class="flex-grow-1 min-w-0">
                                                            <span class="chart-badge">Anggota Divisi</span>
                                                            <h4 class="chart-title">{{ $stf->position ?? 'Anggota Divisi' }}</h4>
                                                            <div class="chart-officer">{{ $stf->name ?? 'Belum terisi' }}</div>
                                                        </div>
                                                    </div>
                                                    @if(!empty($stf->bio) || !empty($stf->description))
                                                        <p class="chart-desc">{{ $stf->bio ?? $stf->description }}</p>
                                                    @endif
                                                </div>
                                                <div class="chart-card-footer mt-auto d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                    <span class="badge {{ ($stf->is_active ?? true) ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border' }}" style="font-size: 0.72rem;">
                                                        <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>{{ ($stf->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}
                                                    </span>
                                                    <div class="d-flex align-items-center gap-2">
                                                        @if(!empty($stf->is_structure))
                                                            <a href="{{ route('admin.struktur-organisasi.edit', $stf->id) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                                                <i class="fas fa-pencil-alt me-1"></i> Edit Posisi
                                                            </a>
                                                        @else
                                                            <a href="{{ route('admin.pengurus.edit', ['penguru' => $stf->id, 'unit' => $activeUnitKey, 'kelompok' => 'putri']) }}" class="btn btn-sm btn-him-primary py-1 px-2 fw-semibold" style="font-size: 0.8rem;">
                                                                <i class="fas fa-pencil-alt me-1"></i> Edit Pengurus
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="text-center py-5">
                                <p class="text-muted fw-semibold mb-0" style="font-size: 0.95rem;">Belum ada susunan pengurus untuk divisi ini.</p>
                            </div>
                        @endif
                    @endif

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

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab') || urlParams.get('kelompok');
        if (tab === 'putri') {
            setStrukturTab('putri');
        }
    });

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
