@extends('layouts.app')
@section('title', 'Struktur Organisasi - HIMATIKA UNUJA 2026')
@section('content')

<style>
    /* ========================================================
       THEME VARIABLES & BASE
       ======================================================== */
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

    .breadcrumb-section {
        background: var(--rose-pale);
        padding: 96px 0 10px;
        border-bottom: 1px solid var(--border-rose);
    }
    .breadcrumb-section .breadcrumb {
        margin-bottom: 0;
        background: transparent;
        padding: 0;
    }
    .breadcrumb-section .breadcrumb-item a {
        color: var(--burgundy-main);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }
    .breadcrumb-section .breadcrumb-item a:hover {
        color: var(--burgundy-hover);
        text-decoration: underline;
    }
    .breadcrumb-section .breadcrumb-item.active {
        color: rgba(40, 21, 29, 0.7);
        font-size: 0.85rem;
    }
    .breadcrumb-section .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(113, 28, 53, 0.45);
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--burgundy-main);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }
    .back-link:hover {
        color: var(--burgundy-hover);
        transform: translateX(-2px);
    }

    .breadcrumb-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    /* ========================================================
       HERO BANNER
       ======================================================== */
    .hero-section {
        background: var(--rose-pale);
        padding: 24px 0 28px;
        position: relative;
        overflow: hidden;
    }
    .hero-section::before {
        content: '';
        position: absolute;
        top: -80px; right: -80px;
        width: 280px; height: 280px;
        background: radial-gradient(circle, rgba(113, 28, 53, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }
    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -60px; left: -60px;
        width: 220px; height: 220px;
        background: radial-gradient(circle, rgba(163, 59, 89, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }
    .hero-label {
        display: inline-block;
        background: var(--burgundy-main);
        color: #fff;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 2px;
        padding: 6px 18px;
        border-radius: 50px;
        margin-bottom: 10px;
        text-transform: uppercase;
    }
    .hero-heading {
        font-size: 2.1rem;
        font-weight: 800;
        color: var(--text-dark);
        line-height: 1.25;
        margin-bottom: 10px;
    }
    .hero-desc {
        font-size: 0.96rem;
        color: rgba(40, 21, 29, 0.72);
        max-width: 680px;
        line-height: 1.6;
        margin-bottom: 0;
    }

    /* ========================================================
       SWITCHER BUTTONS (PUTRA / PUTRI)
       ======================================================== */
    .struktur-tabs-section {
        background: var(--rose-pale);
        padding: 10px 0 24px;
        position: relative;
    }
    .struktur-tabs-wrapper {
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
    .struktur-tab-btn {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 40px;
        border: none;
        background: transparent;
        color: var(--burgundy-main);
        font-weight: 700;
        font-size: 0.92rem;
        letter-spacing: 1.5px;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        user-select: none;
    }
    .struktur-tab-btn:hover {
        color: var(--burgundy-hover);
        background: var(--rose-pale);
    }
    .struktur-tab-btn.active {
        background: linear-gradient(135deg, var(--burgundy-main) 0%, var(--burgundy-hover) 100%);
        color: #ffffff !important;
        box-shadow: 0 6px 18px rgba(113, 28, 53, 0.28);
        transform: translateY(-1px);
    }
    .struktur-tab-btn:focus-visible {
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
       ORG SECTION & CHART
       ======================================================== */
    .org-section {
        background: var(--rose-pale);
        padding: 10px 0 70px;
        position: relative;
    }

    .org-chart {
        position: relative;
        max-width: 1080px;
        margin: 0 auto;
    }

    /* Connectors */
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

    /* Branch Split Lines */
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

    /* Level Labels */
    .level-label {
        text-align: center;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--burgundy-main);
        margin-bottom: 8px;
    }

    .column-header-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.76rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--burgundy-main);
        background: var(--rose-soft);
        border: 1px solid var(--border-rose);
        padding: 6px 18px;
        border-radius: 50px;
        margin-bottom: 12px;
    }

    /* ========================================================
       CHART CARDS
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
        justify-content: flex-end;
        align-items: center;
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
        transform: translateX(3px);
    }

    .chart-card-center {
        max-width: 520px;
        margin: 0 auto;
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
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 28px;
    }

    @media (max-width: 991.98px) {
        .divisi-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 640px) {
        .divisi-grid {
            grid-template-columns: 1fr;
        }
    }

    .divisi-card {
        background: var(--pure-white);
        border: 1px solid var(--border-rose);
        border-radius: 14px;
        padding: 24px 22px;
        box-shadow: 0 3px 14px rgba(113, 28, 53, 0.04);
        transition: all 0.25s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }
    .divisi-card:hover {
        border-color: var(--burgundy-main);
        box-shadow: 0 8px 24px rgba(113, 28, 53, 0.1);
        transform: translateY(-3px);
    }
    .divisi-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: var(--burgundy-main);
    }

    .divisi-icon-wrap {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: var(--rose-soft);
        color: var(--burgundy-main);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 14px;
    }

    .divisi-card-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .divisi-card-desc {
        font-size: 0.85rem;
        color: rgba(40, 21, 29, 0.7);
        line-height: 1.55;
        margin-bottom: 16px;
        flex-grow: 1;
    }

    .btn-divisi {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: var(--burgundy-main);
        color: #ffffff !important;
        font-size: 0.83rem;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        border: 1px solid var(--burgundy-main);
        transition: all 0.2s ease;
        cursor: pointer;
        width: 100%;
    }
    .btn-divisi:hover {
        background: var(--burgundy-hover);
        border-color: var(--burgundy-hover);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(113, 28, 53, 0.2);
    }
    .btn-divisi:focus-visible {
        outline: 2px solid var(--burgundy-focus);
        outline-offset: 2px;
    }

    /* ========================================================
       POP-UP MODAL (DIVISI)
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
    .divisi-modal-close:focus-visible {
        outline: 2px solid var(--burgundy-focus);
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
    .slider-nav-btn:focus-visible {
        outline: 2px solid var(--burgundy-focus);
    }

    /* Mobile Responsive Tweaks */
    @media (max-width: 767.98px) {
        .branch-split-bar { display: none; }
        .hero-heading { font-size: 1.7rem; }
        .chart-card { margin-bottom: 16px; }
        .breadcrumb-row { flex-direction: column; align-items: flex-start; }
    }
    @media (max-width: 575.98px) {
        .struktur-tabs-wrapper {
            max-width: 100%;
            margin: 0 12px;
        }
        .struktur-tab-btn {
            padding: 10px 16px;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }
    }
</style>

{{-- ==================== BREADCRUMB ==================== --}}
<section class="breadcrumb-section">
    <div class="container">
        <div class="breadcrumb-row">
            <a href="{{ route('home') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('struktur-organisasi') }}">Tentang</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Struktur Organisasi</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- ==================== HERO BANNER ==================== --}}
<section class="hero-section">
    <div class="container" style="position:relative; z-index:1;">
        <span class="hero-label">STRUKTUR ORGANISASI</span>
        <h1 class="hero-heading">Struktur HIMATIKA<br>UNUJA 2026</h1>
        <p class="hero-desc">Kenali susunan kepengurusan, jalur koordinasi Putra &amp; Putri, serta lima divisi penggerak HIMATIKA FMIPA UNUJA periode 2026.</p>
    </div>
</section>

{{-- ==================== SWITCHER BUTTONS (PUTRA / PUTRI) ==================== --}}
<section class="struktur-tabs-section">
    <div class="container">
        <div class="struktur-tabs-wrapper" role="tablist" aria-label="Pilihan Struktur Kepengurusan">
            <button type="button" class="struktur-tab-btn active" id="tabBtnPutra" onclick="setStrukturTab('putra')" role="tab" aria-selected="true" aria-controls="panelStrukturPutra">
                <i class="fas fa-mars"></i>
                <span>PUTRA</span>
            </button>
            <button type="button" class="struktur-tab-btn" id="tabBtnPutri" onclick="setStrukturTab('putri')" role="tab" aria-selected="false" aria-controls="panelStrukturPutri">
                <i class="fas fa-venus"></i>
                <span>PUTRI</span>
            </button>
        </div>
        <div class="text-center mt-3">
            <span id="activeTabNotice" class="badge" style="background: var(--rose-soft); color: var(--burgundy-main); font-weight: 700; font-size: 0.82rem; padding: 7px 18px; border-radius: 50px; border: 1px solid var(--border-rose);">
                <i class="fas fa-user-tie me-1"></i> Menampilkan Susunan Kepengurusan <strong>PUTRA</strong>
            </span>
        </div>
    </div>
</section>

{{-- ==================== MAIN ORG CHART ==================== --}}
<section class="org-section">
    <div class="container">
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
                            <a href="{{ route('struktur-organisasi.show', $kaprodi?->id ?? 12) }}" class="link-detail">
                                Lihat Detail &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Vertical Connector to Ketua Umum Putra --}}
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
                            <a href="{{ route('struktur-organisasi.show', $ketuaPutra?->id ?? 1) }}" class="link-detail">
                                Lihat Detail &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                {{-- WAKIL KETUA UMUM PUTRA (Jika Ditentukan di Database) --}}
                @if($wakilPutra)
                    <div class="tree-connector h-20"></div>
                    <div class="level-label">WAKIL KETUA UMUM PUTRA</div>
                    <div class="chart-card-center mb-0">
                        <div class="chart-card">
                            <div class="d-flex align-items-start gap-3 mb-2">
                                @if($wakilPutra->photo)
                                    <img src="{{ asset('storage/' . $wakilPutra->photo) }}" alt="{{ $wakilPutra->name }}" class="chart-officer-photo">
                                @else
                                    <div class="chart-officer-placeholder"><i class="fas fa-user-tie"></i></div>
                                @endif
                                <div class="flex-grow-1">
                                    <span class="chart-badge">Badan Pengurus Harian</span>
                                    <h4 class="chart-title">{{ $wakilPutra->position }}</h4>
                                    <div class="chart-officer">{{ $wakilPutra->name }}</div>
                                </div>
                            </div>
                            <p class="chart-desc">{{ $wakilPutra->description }}</p>
                            <div class="chart-card-footer">
                                <a href="{{ route('struktur-organisasi.show', $wakilPutra->id) }}" class="link-detail">
                                    Lihat Detail &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Branch Split Bar to Sekretaris & Bendahara Putra --}}
                <div class="tree-connector h-20 d-none d-md-block"></div>
                <div class="branch-split-bar d-none d-md-block"></div>
                <div class="tree-connector h-16 d-none d-md-block"></div>

                {{-- LEVEL 3: SEKRETARIS & BENDAHARA PUTRA --}}
                <div class="row g-4 mt-0">
                    {{-- Sekretaris Putra --}}
                    <div class="col-md-6">
                        <div class="chart-card">
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
                            <div class="chart-card-footer">
                                <a href="{{ route('struktur-organisasi.show', $sekretarisPutra?->id ?? 3) }}" class="link-detail">
                                    Lihat Detail &rarr;
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Bendahara Putra --}}
                    <div class="col-md-6">
                        <div class="chart-card">
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
                            <div class="chart-card-footer">
                                <a href="{{ route('struktur-organisasi.show', $bendaharaPutra?->id ?? 11) }}" class="link-detail">
                                    Lihat Detail &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Connector to Divisi Putra --}}
                <div class="tree-connector h-30 mt-3"></div>

                {{-- LEVEL 4: 5 DIVISI PENGGERAK HIMATIKA PUTRA --}}
                <div class="divisi-section-wrap mt-0">
                    <div class="text-center mb-2">
                        <span class="hero-label">DIVISI HIMATIKA PUTRA</span>
                        <h2 class="fw-bold mt-2" style="font-size: 1.55rem; color: var(--text-dark);">Lima Divisi Penggerak HIMATIKA (Putra)</h2>
                        <p class="text-secondary small mb-0">Unit kerja strategis penggerak keilmuan, kaderisasi, relasi, riset organisasi, dan publikasi informasi kepengurusan Putra.</p>
                    </div>

                    <div class="divisi-grid">
                        @foreach($divisiPutra as $divKey => $div)
                            <div class="divisi-card">
                                <div>
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="divisi-icon-wrap mb-0">
                                            <i class="{{ $div['icon'] }}"></i>
                                        </div>
                                        <span class="badge" style="background: var(--rose-soft); color: var(--burgundy-main); font-weight: 700; font-size: 0.74rem; padding: 5px 10px; border-radius: 50px;">
                                            <i class="fas fa-users me-1"></i> {{ $div['member_count'] }} Anggota
                                        </span>
                                    </div>

                                    <h3 class="divisi-card-title mt-2">{{ $div['name'] }}</h3>
                                    <p class="divisi-card-desc">{{ $div['description'] }}</p>

                                    {{-- Pengurus / Kepala Divisi Putra --}}
                                    <div class="d-flex align-items-center gap-2 pt-2 mb-3 border-top" style="border-color: rgba(233,205,213,0.5) !important;">
                                        @if($div['leader_photo'])
                                            <img src="{{ $div['leader_photo'] }}" alt="{{ $div['leader_name'] }}" style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 1.5px solid var(--burgundy-main); flex-shrink: 0;">
                                        @else
                                            <div style="width: 34px; height: 34px; border-radius: 50%; background: var(--rose-soft); color: var(--burgundy-main); display: flex; align-items: center; justify-content: center; font-size: 0.85rem; flex-shrink: 0;">
                                                <i class="fas fa-user-tie"></i>
                                            </div>
                                        @endif
                                        <div class="overflow-hidden">
                                            <div class="fw-bold text-dark text-truncate" style="font-size: 0.82rem;">{{ $div['leader_name'] }}</div>
                                            <div class="text-muted" style="font-size: 0.72rem;">{{ $div['leader_position'] }}</div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn-divisi" onclick="openDivisiModal('{{ $divKey }}', this, 'putra')">
                                    Lihat Divisi &rarr;
                                </button>
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
                            <a href="{{ route('struktur-organisasi.show', $kaprodi?->id ?? 12) }}" class="link-detail">
                                Lihat Detail &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Vertical Connector to Ketua Umum Putri --}}
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
                            <a href="{{ route('struktur-organisasi.show', $ketuaPutri?->id ?? 2) }}" class="link-detail">
                                Lihat Detail &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                {{-- WAKIL KETUA UMUM PUTRI (Jika Ditentukan di Database) --}}
                @if($wakilPutri)
                    <div class="tree-connector h-20"></div>
                    <div class="level-label">WAKIL KETUA UMUM PUTRI</div>
                    <div class="chart-card-center mb-0">
                        <div class="chart-card">
                            <div class="d-flex align-items-start gap-3 mb-2">
                                @if($wakilPutri->photo)
                                    <img src="{{ asset('storage/' . $wakilPutri->photo) }}" alt="{{ $wakilPutri->name }}" class="chart-officer-photo">
                                @else
                                    <div class="chart-officer-placeholder"><i class="fas fa-user-circle"></i></div>
                                @endif
                                <div class="flex-grow-1">
                                    <span class="chart-badge">Badan Pengurus Harian</span>
                                    <h4 class="chart-title">{{ $wakilPutri->position }}</h4>
                                    <div class="chart-officer">{{ $wakilPutri->name }}</div>
                                </div>
                            </div>
                            <p class="chart-desc">{{ $wakilPutri->description }}</p>
                            <div class="chart-card-footer">
                                <a href="{{ route('struktur-organisasi.show', $wakilPutri->id) }}" class="link-detail">
                                    Lihat Detail &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Branch Split Bar to Sekretaris & Bendahara Putri --}}
                <div class="tree-connector h-20 d-none d-md-block"></div>
                <div class="branch-split-bar d-none d-md-block"></div>
                <div class="tree-connector h-16 d-none d-md-block"></div>

                {{-- LEVEL 3: SEKRETARIS & BENDAHARA PUTRI --}}
                <div class="row g-4 mt-0">
                    {{-- Sekretaris Putri --}}
                    <div class="col-md-6">
                        <div class="chart-card">
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
                            <p class="chart-desc">{{ $sekretarisPutri?->description ?? 'Mengoordinasikan administrasi, pengarsipan berkas kegiatan, dan dokumentasi musyawarah kepengurusan HIMATIKA UNUJA Putri secara rapi dan akurat.' }}</p>
                            <div class="chart-card-footer">
                                <a href="{{ route('struktur-organisasi.show', $sekretarisPutri?->id ?? 10) }}" class="link-detail">
                                    Lihat Detail &rarr;
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Bendahara Putri --}}
                    <div class="col-md-6">
                        <div class="chart-card">
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
                            <p class="chart-desc">{{ $bendaharaPutri?->description ?? 'Mengoordinasikan pengelolaan kas dan kebendaharaan putri, memvalidasi anggaran program kerja, serta menyajikan laporan keuangan secara transparan.' }}</p>
                            <div class="chart-card-footer">
                                <a href="{{ route('struktur-organisasi.show', $bendaharaPutri?->id ?? 4) }}" class="link-detail">
                                    Lihat Detail &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Connector to Divisi Putri --}}
                <div class="tree-connector h-30 mt-3"></div>

                {{-- LEVEL 4: 5 DIVISI PENGGERAK HIMATIKA PUTRI --}}
                <div class="divisi-section-wrap mt-0">
                    <div class="text-center mb-2">
                        <span class="hero-label">DIVISI HIMATIKA PUTRI</span>
                        <h2 class="fw-bold mt-2" style="font-size: 1.55rem; color: var(--text-dark);">Lima Divisi Penggerak HIMATIKA (Putri)</h2>
                        <p class="text-secondary small mb-0">Unit kerja strategis penggerak keilmuan, kaderisasi, relasi, riset organisasi, dan publikasi informasi kepengurusan Putri.</p>
                    </div>

                    <div class="divisi-grid">
                        @foreach($divisiPutri as $divKey => $div)
                            <div class="divisi-card">
                                <div>
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="divisi-icon-wrap mb-0">
                                            <i class="{{ $div['icon'] }}"></i>
                                        </div>
                                        <span class="badge" style="background: var(--rose-soft); color: var(--burgundy-main); font-weight: 700; font-size: 0.74rem; padding: 5px 10px; border-radius: 50px;">
                                            <i class="fas fa-users me-1"></i> {{ $div['member_count'] }} Anggota
                                        </span>
                                    </div>

                                    <h3 class="divisi-card-title mt-2">{{ $div['name'] }}</h3>
                                    <p class="divisi-card-desc">{{ $div['description'] }}</p>

                                    {{-- Pengurus / Kepala Divisi Putri --}}
                                    <div class="d-flex align-items-center gap-2 pt-2 mb-3 border-top" style="border-color: rgba(233,205,213,0.5) !important;">
                                        @if($div['leader_photo'])
                                            <img src="{{ $div['leader_photo'] }}" alt="{{ $div['leader_name'] }}" style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 1.5px solid var(--burgundy-main); flex-shrink: 0;">
                                        @else
                                            <div style="width: 34px; height: 34px; border-radius: 50%; background: var(--rose-soft); color: var(--burgundy-main); display: flex; align-items: center; justify-content: center; font-size: 0.85rem; flex-shrink: 0;">
                                                <i class="fas fa-user-circle"></i>
                                            </div>
                                        @endif
                                        <div class="overflow-hidden">
                                            <div class="fw-bold text-dark text-truncate" style="font-size: 0.82rem;">{{ $div['leader_name'] }}</div>
                                            <div class="text-muted" style="font-size: 0.72rem;">{{ $div['leader_position'] }}</div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn-divisi" onclick="openDivisiModal('{{ $divKey }}', this, 'putri')">
                                    Lihat Divisi &rarr;
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

{{-- ==================== POP-UP MODAL DETAIL DIVISI ==================== --}}
<div id="divisiModal" class="divisi-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="modalDivisiTitle">
    <div class="divisi-modal-dialog">
        {{-- Close Button --}}
        <button type="button" class="divisi-modal-close" id="btnModalClose" onclick="closeDivisiModal()" aria-label="Tutup pop-up">
            <i class="fas fa-times"></i>
        </button>

        {{-- Modal Header --}}
        <span class="chart-badge">DIVISI HIMATIKA</span>
        <h2 id="modalDivisiTitle" style="color: var(--text-dark); font-size: 1.55rem; font-weight: 700; margin: 4px 0 10px;">Divisi HIMATIKA</h2>
        <p id="modalDivisiDesc" style="color: rgba(40,21,29,0.75); font-size: 0.88rem; line-height: 1.6; margin-bottom: 16px;"></p>

        {{-- Member Profile Card (Supports slider with photos) --}}
        <div class="modal-member-card">
            <div id="modalPhotoContainer">
                {{-- Injected dynamically --}}
            </div>
            <h4 id="modalMemberName" style="color: var(--text-dark); font-weight: 700; font-size: 1.15rem; margin-bottom: 4px;">Nama Pengurus</h4>
            <span id="modalMemberPosition" class="chart-badge" style="background: var(--pure-white); border: 1px solid var(--border-rose);">Kepala Divisi</span>
            <p id="modalMemberBio" style="color: rgba(40,21,29,0.65); font-size: 0.82rem; margin-top: 8px; margin-bottom: 0; line-height: 1.5;"></p>

            {{-- Slider Controls (for multiple members) --}}
            <div id="sliderControlsWrap" style="display: none; align-items: center; justify-content: center; gap: 14px; margin-top: 16px; padding-top: 12px; border-top: 1px solid var(--border-rose);">
                <button type="button" class="slider-nav-btn" onclick="modalSlidePrev()">
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </button>
                <span id="sliderCounterText" style="font-size: 0.82rem; font-weight: 700; color: var(--burgundy-main);">1 / 1</span>
                <button type="button" class="slider-nav-btn" onclick="modalSlideNext()">
                    Berikutnya <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        {{-- Modal Footer --}}
        <div class="d-flex justify-content-between align-items-center mt-4 pt-3" style="border-top: 1px solid var(--border-rose);">
            <button type="button" class="btn btn-sm btn-outline-secondary px-3 py-2" onclick="closeDivisiModal()" style="border-radius: 8px;">
                Tutup
            </button>
            <a id="modalDetailDivisiLink" href="#" class="btn-divisi" style="width: auto; padding: 8px 18px;">
                Lihat Detail Divisi &rarr;
            </a>
        </div>
    </div>
</div>

<script>
    // Data divisi yang disiapkan per kelompok dari controller
    const divisiDataMap = @json($divisiModalData ?? []);
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

        renderModalMember();

        const modal = document.getElementById('divisiModal');
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';

        // Focus the close button for accessibility
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

        if (window.history && window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.set('tab', currentKelompok);
            window.history.replaceState({}, '', url);
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

    // Keyboard navigation (Esc key to close, Left/Right arrow for slider)
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('divisiModal');
        if (!modal.classList.contains('show')) return;

        if (e.key === 'Escape') {
            closeDivisiModal();
        } else if (e.key === 'ArrowLeft') {
            modalSlidePrev();
        } else if (e.key === 'ArrowRight') {
            modalSlideNext();
        }
    });

    // Close when clicking on backdrop
    document.getElementById('divisiModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDivisiModal();
        }
    });

    // Check URL parameter on load
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');
        if (tab === 'putri') {
            setStrukturTab('putri');
        } else {
            setStrukturTab('putra');
        }
    });
</script>

@endsection
