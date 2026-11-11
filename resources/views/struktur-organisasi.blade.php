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
        padding: 24px 0 36px;
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
       CHART CARDS (NO PHOTOS)
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
        max-width: 500px;
        margin: 0 auto;
    }

    /* ========================================================
       DIVISI SECTION & 5 CARDS
       ======================================================== */
    .divisi-section-wrap {
        margin-top: 50px;
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
        margin-bottom: 18px;
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

{{-- ==================== MAIN ORG CHART ==================== --}}
<section class="org-section">
    <div class="container">
        <div class="org-chart">

            {{-- LEVEL 1: PEMBINA / KAPRODI --}}
            <div class="level-label">PEMBINA / KETUA PROGRAM STUDI</div>
            <div class="chart-card-center mb-0">
                <div class="chart-card gold-top">
                    <span class="chart-badge">Pembina / Kaprodi</span>
                    <h3 class="chart-title">{{ $kaprodi?->position ?? 'Ketua Program Studi Matematika' }}</h3>
                    <div class="chart-officer">{{ $kaprodi?->name ?? 'Ketua Program Studi Matematika' }}</div>
                    <p class="chart-desc">{{ $kaprodi?->description ?? 'Memberikan bimbingan, arahan, dan pembinaan dalam pelaksanaan kegiatan akademik serta pengembangan organisasi kemahasiswaan Program Studi Matematika FMIPA UNUJA.' }}</p>
                    <div class="chart-card-footer">
                        <a href="{{ route('struktur-organisasi.show', $kaprodi?->id ?? 12) }}" class="link-detail">
                            Lihat Detail &rarr;
                        </a>
                    </div>
                </div>
            </div>

            {{-- Vertical Connector to Branch Split --}}
            <div class="tree-connector dashed h-24"></div>

            {{-- Branch Split Bar (Desktop) --}}
            <div class="branch-split-bar d-none d-md-block"></div>
            <div class="tree-connector h-16 d-none d-md-block"></div>

            {{-- LEVEL 2, 3, 4: TWO-COLUMN LAYOUT (KOLOM PUTRA & KOLOM PUTRI) --}}
            <div class="row g-4 mt-0">

                {{-- ==================== KOLOM PUTRA ==================== --}}
                <div class="col-md-6">
                    <div class="text-center mb-3">
                        <span class="column-header-badge">
                            <i class="fas fa-user-tie"></i> Kepengurusan Putra
                        </span>
                    </div>

                    {{-- Baris 1: Ketua Umum Putra --}}
                    <div class="chart-card mb-3">
                        <span class="chart-badge">Badan Pengurus Harian</span>
                        <h4 class="chart-title">Ketua Umum Putra</h4>
                        <div class="chart-officer">{{ $ketuaPutra?->name ?? 'Ahmad Rizki' }}</div>
                        <p class="chart-desc">{{ $ketuaPutra?->description ?? 'Memimpin dan mengoordinasikan seluruh jajaran kepengurusan HIMATIKA UNUJA Putra serta bertanggung jawab penuh atas arah gerak organisasi kemahasiswaan putra.' }}</p>
                        <div class="chart-card-footer">
                            <a href="{{ route('struktur-organisasi.show', $ketuaPutra?->id ?? 1) }}" class="link-detail">
                                Lihat Detail &rarr;
                            </a>
                        </div>
                    </div>

                    {{-- Connector to Sekretaris Putra --}}
                    <div class="tree-connector h-20"></div>

                    {{-- Baris 2: Sekretaris Putra --}}
                    <div class="chart-card mb-3">
                        <span class="chart-badge">Badan Pengurus Harian</span>
                        <h4 class="chart-title">Sekretaris Putra</h4>
                        <div class="chart-officer">{{ $sekretarisPutra?->name ?? 'Budi Santoso' }}</div>
                        <p class="chart-desc">{{ $sekretarisPutra?->description ?? 'Mengoordinasikan tata kelola kesekretariatan, administrasi persuratan, notulensi rapat, dan tertib arsip digital kepengurusan HIMATIKA UNUJA Putra.' }}</p>
                        <div class="chart-card-footer">
                            <a href="{{ route('struktur-organisasi.show', $sekretarisPutra?->id ?? 3) }}" class="link-detail">
                                Lihat Detail &rarr;
                            </a>
                        </div>
                    </div>

                    {{-- Connector to Bendahara Putra --}}
                    <div class="tree-connector h-20"></div>

                    {{-- Baris 3: Bendahara Putra --}}
                    <div class="chart-card">
                        <span class="chart-badge">Badan Pengurus Harian</span>
                        <h4 class="chart-title">Bendahara Putra</h4>
                        <div class="chart-officer">{{ $bendaharaPutra?->name ?? 'M. Farhan' }}</div>
                        <p class="chart-desc">{{ $bendaharaPutra?->description ?? 'Mengoordinasikan kebendaharaan, pencatatan transaksi kas masuk dan keluar, serta penyusunan anggaran dan laporan keuangan HIMATIKA UNUJA Putra.' }}</p>
                        <div class="chart-card-footer">
                            <a href="{{ route('struktur-organisasi.show', $bendaharaPutra?->id ?? 11) }}" class="link-detail">
                                Lihat Detail &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                {{-- ==================== KOLOM PUTRI ==================== --}}
                <div class="col-md-6">
                    <div class="text-center mb-3">
                        <span class="column-header-badge">
                            <i class="fas fa-user-circle"></i> Kepengurusan Putri
                        </span>
                    </div>

                    {{-- Baris 1: Ketua Umum Putri --}}
                    <div class="chart-card mb-3">
                        <span class="chart-badge">Badan Pengurus Harian</span>
                        <h4 class="chart-title">Ketua Umum Putri</h4>
                        <div class="chart-officer">{{ $ketuaPutri?->name ?? 'Siti Nurhaliza' }}</div>
                        <p class="chart-desc">{{ $ketuaPutri?->description ?? 'Memimpin dan mengoordinasikan seluruh jajaran kepengurusan HIMATIKA UNUJA Putri, memperkuat sinergi dan keharmonisan kepengurusan putri, serta mewakili himpunan.' }}</p>
                        <div class="chart-card-footer">
                            <a href="{{ route('struktur-organisasi.show', $ketuaPutri?->id ?? 2) }}" class="link-detail">
                                Lihat Detail &rarr;
                            </a>
                        </div>
                    </div>

                    {{-- Connector to Sekretaris Putri --}}
                    <div class="tree-connector h-20"></div>

                    {{-- Baris 2: Sekretaris Putri --}}
                    <div class="chart-card mb-3">
                        <span class="chart-badge">Badan Pengurus Harian</span>
                        <h4 class="chart-title">Sekretaris Putri</h4>
                        <div class="chart-officer">{{ $sekretarisPutri?->name ?? 'Nurul Aini' }}</div>
                        <p class="chart-desc">{{ $sekretarisPutri?->description ?? 'Mengoordinasikan administrasi, pengarsipan berkas kegiatan, dan dokumentasi musyawarah kepengurusan HIMATIKA UNUJA Putri secara rapi dan akurat.' }}</p>
                        <div class="chart-card-footer">
                            <a href="{{ route('struktur-organisasi.show', $sekretarisPutri?->id ?? 10) }}" class="link-detail">
                                Lihat Detail &rarr;
                            </a>
                        </div>
                    </div>

                    {{-- Connector to Bendahara Putri --}}
                    <div class="tree-connector h-20"></div>

                    {{-- Baris 3: Bendahara Putri --}}
                    <div class="chart-card">
                        <span class="chart-badge">Badan Pengurus Harian</span>
                        <h4 class="chart-title">Bendahara Putri</h4>
                        <div class="chart-officer">{{ $bendaharaPutri?->name ?? 'Dewi Lestari' }}</div>
                        <p class="chart-desc">{{ $bendaharaPutri?->description ?? 'Mengoordinasikan pengelolaan kas dan kebendaharaan putri, memvalidasi anggaran program kerja, serta menyajikan laporan keuangan secara transparan.' }}</p>
                        <div class="chart-card-footer">
                            <a href="{{ route('struktur-organisasi.show', $bendaharaPutri?->id ?? 4) }}" class="link-detail">
                                Lihat Detail &rarr;
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ==================== DIVISI HIMATIKA ==================== --}}
            <div class="divisi-section-wrap">
                <div class="text-center mb-2">
                    <span class="hero-label">DIVISI HIMATIKA</span>
                    <h2 class="fw-bold mt-2" style="font-size: 1.55rem; color: var(--text-dark);">Lima Divisi Penggerak HIMATIKA</h2>
                    <p class="text-secondary small mb-0">Unit kerja strategis yang mengawal program kerja, keilmuan, kaderisasi, relasi, litbang, dan publikasi informasi.</p>
                </div>

                <div class="divisi-grid">

                    {{-- 1. Divisi Keilmuan --}}
                    <div class="divisi-card">
                        <div>
                            <div class="divisi-icon-wrap">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h3 class="divisi-card-title">1. Divisi Keilmuan</h3>
                            <p class="divisi-card-desc">Mengembangkan kapasitas akademik mahasiswa melalui kajian sains matematika murni dan terapan, tutorial sebaya, workshop matematika, serta pembinaan kompetisi olimpiade sains.</p>
                        </div>
                        <button type="button" class="btn-divisi" onclick="openDivisiModal('keilmuan', this)">
                            Lihat Divisi &rarr;
                        </button>
                    </div>

                    {{-- 2. Divisi Kaderisasi --}}
                    <div class="divisi-card">
                        <div>
                            <div class="divisi-icon-wrap">
                                <i class="fas fa-users-cog"></i>
                            </div>
                            <h3 class="divisi-card-title">2. Divisi Kaderisasi</h3>
                            <p class="divisi-card-desc">Mengawal pembinaan karakter kepemimpinan, proses kaderisasi dan orientasi mahasiswa baru, upgrading kapasitas pengurus, serta penanaman integritas dan loyalitas organisasi.</p>
                        </div>
                        <button type="button" class="btn-divisi" onclick="openDivisiModal('kaderisasi', this)">
                            Lihat Divisi &rarr;
                        </button>
                    </div>

                    {{-- 3. Divisi Publik Relasi --}}
                    <div class="divisi-card">
                        <div>
                            <div class="divisi-icon-wrap">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <h3 class="divisi-card-title">3. Divisi Publik Relasi</h3>
                            <p class="divisi-card-desc">Membangun jejaring kolaborasi dan kemitraan eksternal kampus, menjalin hubungan erat dengan alumni, menyelenggarakan program bakti sosial, serta menjaga reputasi publik himpunan.</p>
                        </div>
                        <button type="button" class="btn-divisi" onclick="openDivisiModal('publik_relasi', this)">
                            Lihat Divisi &rarr;
                        </button>
                    </div>

                    {{-- 4. Divisi Litbang --}}
                    <div class="divisi-card">
                        <div>
                            <div class="divisi-icon-wrap">
                                <i class="fas fa-flask"></i>
                            </div>
                            <h3 class="divisi-card-title">4. Divisi Litbang</h3>
                            <p class="divisi-card-desc">Melaksanakan riset organisasi, survei aspirasi mahasiswa, pemantauan dan evaluasi mutu program kerja berkala, serta merumuskan inovasi strategis pengembangan HIMATIKA.</p>
                        </div>
                        <button type="button" class="btn-divisi" onclick="openDivisiModal('litbang', this)">
                            Lihat Divisi &rarr;
                        </button>
                    </div>

                    {{-- 5. Divisi Kominfo --}}
                    <div class="divisi-card">
                        <div>
                            <div class="divisi-icon-wrap">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <h3 class="divisi-card-title">5. Divisi Kominfo</h3>
                            <p class="divisi-card-desc">Mengelola ekosistem media komunikasi digital, produksi konten multimedia kreatif, pengelolaan website resmi dan media sosial, serta pusat informasi terkini HIMATIKA UNUJA.</p>
                        </div>
                        <button type="button" class="btn-divisi" id="btnDivisiKominfo" onclick="openDivisiModal('kominfo', this)">
                            Lihat Divisi &rarr;
                        </button>
                    </div>

                </div>
            </div>

            {{-- Diagram Bagan Alur Kepengurusan --}}
            <div class="mt-5 pt-4 text-center">
                <span class="column-header-badge mb-2"><i class="fas fa-project-diagram me-1"></i> Diagram Alur Kepengurusan</span>
                <h3 class="fw-bold mt-2" style="font-size: 1.35rem; color: var(--text-dark);">Bagan Alur Koordinasi HIMATIKA UNUJA</h3>
                <p class="text-secondary small mb-3">Diagram resmi alur koordinasi kepengurusan HIMATIKA FMIPA UNUJA periode 2026.</p>
                <div class="bg-white rounded-4 border shadow-sm p-3 p-md-4 mx-auto" style="max-width: 1040px; border-color: var(--border-rose) !important;">
                    <img src="{{ asset('images/struktur-organisasi-himatika.svg') }}" alt="Diagram Struktur Organisasi HIMATIKA FMIPA UNUJA" class="img-fluid rounded-3" style="width: 100%; height: auto;">
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
    // Data divisi yang disiapkan dari controller
    const divisiDataMap = @json($divisiData ?? []);
    let currentDivisiKey = null;
    let currentMemberIndex = 0;
    let lastActiveTrigger = null;

    function openDivisiModal(key, triggerEl) {
        lastActiveTrigger = triggerEl || document.activeElement;
        const data = divisiDataMap[key];
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
        const data = divisiDataMap[currentDivisiKey];
        if (!data) return;

        const members = data.members || [];
        const sliderWrap = document.getElementById('sliderControlsWrap');
        const photoContainer = document.getElementById('modalPhotoContainer');
        const nameEl = document.getElementById('modalMemberName');
        const posEl = document.getElementById('modalMemberPosition');
        const bioEl = document.getElementById('modalMemberBio');
        const counterEl = document.getElementById('sliderCounterText');

        if (members.length === 0) {
            photoContainer.innerHTML = '<div class="modal-photo-placeholder"><i class="fas fa-user"></i></div>';
            nameEl.textContent = 'Data Pengurus Sedang Dilengkapi';
            posEl.textContent = data.name;
            bioEl.textContent = 'Informasi resmi susunan kepengurusan unit ini akan diperbarui.';
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
        const data = divisiDataMap[currentDivisiKey];
        if (!data || !data.members || data.members.length <= 1) return;
        currentMemberIndex = (currentMemberIndex - 1 + data.members.length) % data.members.length;
        renderModalMember();
    }

    function modalSlideNext() {
        const data = divisiDataMap[currentDivisiKey];
        if (!data || !data.members || data.members.length <= 1) return;
        currentMemberIndex = (currentMemberIndex + 1) % data.members.length;
        renderModalMember();
    }

    function closeDivisiModal() {
        const modal = document.getElementById('divisiModal');
        modal.classList.remove('show');
        document.body.style.overflow = '';

        // Restore focus to the trigger link/button
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
</script>

@endsection
