@extends('layouts.app')
@section('title', 'Tentang HIMATIKA FMIPA UNUJA')
@section('content')

<style>
    /* ========================================================
       HALAMAN TENTANG - HIMATIKA FMIPA UNUJA
       ======================================================== */

    .tentang-page-wrapper {
        background-color: #ffffff;
        padding-bottom: 90px;
    }

    /* TOP BANNER HORIZONTAL */
    .tentang-banner {
        position: relative;
        background: linear-gradient(105deg, #1A0A0F 0%, #711C35 50%, #541326 100%);
        min-height: 220px;
        display: flex;
        align-items: center;
        overflow: hidden;
        margin-bottom: 50px;
        box-shadow: 0 4px 20px rgba(26, 10, 15, 0.25);
    }
    .tentang-banner-img-wrap {
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        width: 55%;
        overflow: hidden;
        pointer-events: none;
    }
    .tentang-banner-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center right;
        mask-image: linear-gradient(to right, transparent 0%, rgba(0,0,0,0.3) 25%, black 65%);
        -webkit-mask-image: linear-gradient(to right, transparent 0%, rgba(0,0,0,0.3) 25%, black 65%);
    }
    .tentang-banner-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(to right, #1A0A0F 0%, rgba(26, 10, 15, 0.88) 35%, transparent 70%);
        pointer-events: none;
    }
    .tentang-banner-content {
        position: relative;
        z-index: 2;
        padding: 48px 0;
    }
    .tentang-banner-title {
        color: #ffffff;
        font-size: 2.8rem;
        font-weight: 800;
        line-height: 1.15;
        margin-bottom: 6px;
        letter-spacing: -0.5px;
    }
    .tentang-banner-subtitle {
        color: rgba(255, 255, 255, 0.92);
        font-size: 1.15rem;
        font-weight: 500;
        letter-spacing: 0.5px;
        margin-bottom: 0;
    }

    /* SECTION SPACING & CONTAINER */
    .content-container {
        max-width: 1040px;
        margin: 0 auto;
    }
    .section-gap {
        margin-bottom: 45px;
    }

    /* TENTANG CONTENT CARDS (SEJARAH & SAMBUTAN) */
    .tentang-card {
        background: #ffffff;
        border: 1px solid #E9CDD5;
        border-radius: 16px;
        padding: 28px 32px;
        box-shadow: 0 4px 18px rgba(26, 10, 15, 0.05);
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .tentang-card:hover {
        box-shadow: 0 8px 26px rgba(26, 10, 15, 0.08);
    }

    .tentang-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #FFF7F9;
    }

    .card-header-icon-box {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #FFF7F9;
        border: 1px solid #E9CDD5;
        color: #711C35;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }

    .card-header-divider {
        color: #94A3B8;
        font-size: 1.35rem;
        font-weight: 300;
        line-height: 1;
    }

    .card-header-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #0F172A;
        margin: 0;
        letter-spacing: -0.2px;
    }

    /* SEJARAH CONTENT */
    .sejarah-text {
        font-size: 0.98rem;
        line-height: 1.75;
        color: #334155;
    }
    .sejarah-text p {
        margin-bottom: 12px;
    }
    .sejarah-text p:last-child {
        margin-bottom: 0;
    }
    .sejarah-timeline {
        font-size: 0.94rem;
        line-height: 1.7;
        color: #475569;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px dashed #E9CDD5;
    }

    /* SAMBUTAN KAPRODI - PHOTO CARD */
    .kaprodi-photo-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 24px;
    }
    .kaprodi-photo-wrap {
        position: relative;
        width: 100%;
        max-width: 220px;
        aspect-ratio: 4/5;
        border-radius: 14px;
        overflow: hidden;
        background: #FFF7F9;
        border: 1px solid #E9CDD5;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 14px rgba(26, 10, 15, 0.08);
        margin-bottom: 16px;
    }
    .kaprodi-photo-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
        display: block;
    }
    .kaprodi-photo-placeholder {
        background: linear-gradient(145deg, #FFF7F9 0%, #F4D6DE 100%);
        border: 2px dashed #E9CDD5;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .kaprodi-avatar-icon {
        font-size: 3.5rem;
        color: #711C35;
        opacity: 0.85;
    }
    .kaprodi-photo-badge {
        position: absolute;
        bottom: 12px;
        left: 50%;
        transform: translateX(-50%);
        background: #711C35;
        color: #ffffff;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 4px 18px;
        border-radius: 20px;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(113, 28, 53, 0.35);
        white-space: nowrap;
    }

    /* SAMBUTAN SPEECH BODY */
    .speech-salutation {
        font-weight: 600;
        color: #0F172A;
        font-size: 1rem;
        margin-bottom: 10px;
    }
    .speech-text {
        font-size: 0.96rem;
        line-height: 1.75;
        color: #334155;
    }
    .speech-placeholder-box {
        padding: 4px 0;
    }
    .speech-status-pill {
        display: inline-flex;
        align-items: center;
        background: #FFF7F9;
        border: 1px dashed #E9CDD5;
        color: #711C35;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        margin-top: 14px;
    }

    /* HORIZONTAL BAR HEADERS (VISI & MISI) */
    .section-bar-header {
        background-color: #711C35;
        color: #ffffff;
        font-weight: 700;
        font-size: 1.05rem;
        text-align: center;
        padding: 9px 24px;
        border-radius: 6px;
        margin-bottom: 22px;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 6px rgba(26, 10, 15, 0.25);
    }

    .section-center-bar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background-color: #711C35;
        color: #ffffff;
        font-weight: 700;
        font-size: 1.05rem;
        padding: 9px 36px;
        border-radius: 6px;
        margin-bottom: 28px;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 6px rgba(26, 10, 15, 0.25);
    }

    /* ITEM WITH VERTICAL LINE */
    .item-with-line {
        border-left: 2.5px solid #711C35;
        padding-left: 14px;
        margin-bottom: 15px;
        font-size: 0.95rem;
        line-height: 1.68;
        color: #334155;
    }
    .item-with-line:last-child {
        margin-bottom: 0;
    }

    .vision-text {
        font-size: 0.95rem;
        line-height: 1.75;
        color: #334155;
        text-align: justify;
        margin-bottom: 0;
    }

    /* STRUKTUR ORGANISASI IMAGE & ZOOM */
    .org-image-wrapper {
        background: #ffffff;
        border: 1px solid #E9CDD5;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(26, 10, 15, 0.05);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .org-image-wrapper:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(26, 10, 15, 0.12);
    }
    .org-image-wrapper:hover .org-zoom-hint {
        opacity: 1;
        transform: translateY(0);
    }
    .org-image {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 8px;
    }
    .org-zoom-hint {
        position: absolute;
        bottom: 24px;
        right: 24px;
        background: rgba(26, 10, 15, 0.92);
        color: #ffffff;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        opacity: 0;
        transform: translateY(6px);
        transition: all 0.25s ease;
        pointer-events: none;
        backdrop-filter: blur(4px);
    }

    /* LIGHTBOX MODAL */
    .structure-modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.88);
        backdrop-filter: blur(8px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .structure-modal-overlay.active {
        display: flex;
        opacity: 1;
    }
    .structure-modal-container {
        position: relative;
        max-width: 95vw;
        max-height: 90vh;
        background: #ffffff;
        border-radius: 16px;
        padding: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        overflow: auto;
    }
    .structure-modal-img {
        width: 100%;
        max-width: 1200px;
        height: auto;
        display: block;
        border-radius: 8px;
    }
    .structure-modal-close {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #711C35;
        color: #ffffff;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        font-size: 22px;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        transition: transform 0.2s, background-color 0.2s;
        z-index: 10;
    }
    .structure-modal-close:hover {
        background: #711C35;
        transform: scale(1.1);
    }

    /* RESPONSIVE DESIGN */
    @media (max-width: 767.98px) {
        .tentang-banner {
            min-height: 180px;
            margin-bottom: 35px;
        }
        .tentang-banner-content {
            padding: 36px 0;
        }
        .tentang-banner-title {
            font-size: 2.1rem;
        }
        .tentang-banner-subtitle {
            font-size: 1rem;
        }
        .tentang-banner-img-wrap {
            width: 70%;
            opacity: 0.45;
        }
        .section-gap {
            margin-bottom: 32px;
        }
        .tentang-card {
            padding: 20px 18px;
            border-radius: 14px;
        }
        .card-header-title {
            font-size: 1.1rem;
        }
        .card-header-icon-box {
            width: 34px;
            height: 34px;
            font-size: 1rem;
        }
        .kaprodi-photo-wrap {
            max-width: 180px;
        }
        .section-bar-header, .section-center-bar {
            font-size: 0.95rem;
            padding: 8px 18px;
        }
        .org-zoom-hint {
            opacity: 1;
            transform: translateY(0);
            bottom: 14px;
            right: 14px;
            font-size: 0.72rem;
            padding: 6px 12px;
        }
    }
</style>

<div class="tentang-page-wrapper">
    
    {{-- 1. BANNER HORIZONTAL --}}
    <section class="tentang-banner">
        <div class="tentang-banner-img-wrap">
            <img src="{{ asset('images/unuja-campus-banner.jpg') }}" alt="Kampus UNUJA" class="tentang-banner-img">
        </div>
        <div class="tentang-banner-overlay"></div>
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="tentang-banner-content">
                        <h1 class="tentang-banner-title">Tentang</h1>
                        <p class="tentang-banner-subtitle">HIMATIKA FMIPA UNUJA</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- KONTEN UTAMA --}}
    <div class="container">
        <div class="content-container">

            {{-- 2. CARD BESAR SEJARAH SINGKAT HIMATIKA --}}
            <div class="section-gap">
                <div class="tentang-card">
                    <div class="tentang-card-header">
                        <div class="card-header-icon-box">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <span class="card-header-divider">|</span>
                        <h2 class="card-header-title">Sejarah Singkat HIMATIKA</h2>
                    </div>

                    <div class="sejarah-content">
                        @if(!empty($profile->content) && trim(strip_tags($profile->content)) !== '')
                            <div class="sejarah-text mb-2">
                                {!! $profile->content !!}
                            </div>
                        @endif

                        @if(!empty($profile->history) && trim(strip_tags($profile->history)) !== '')
                            <div class="sejarah-timeline">
                                {!! $profile->history !!}
                            </div>
                        @elseif(empty($profile->content) || trim(strip_tags($profile->content)) === '')
                            <p class="text-muted fst-italic mb-0">Konten sejarah singkat akan dilengkapi.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 3. SAMBUTAN KAPRODI (CARD FOTO DI KIRI & CARD SAMBUTAN DI KANAN) --}}
            <div class="row g-4 section-gap">
                {{-- Card Kiri: Foto Kaprodi --}}
                <div class="col-lg-4 col-md-5 col-12">
                    <div class="tentang-card kaprodi-photo-card">
                        @if($kaprodi && $kaprodi->photo)
                            <div class="kaprodi-photo-wrap">
                                <img src="{{ asset('storage/' . $kaprodi->photo) }}" alt="{{ $kaprodi->name }}" class="kaprodi-photo-img">
                                <span class="kaprodi-photo-badge">Kaprodi</span>
                            </div>
                            <h5 class="fw-bold mb-1" style="color: #711C35; font-size: 1.05rem;">{{ $kaprodi->name }}</h5>
                            <p class="text-muted small mb-0">{{ $kaprodi->position ?? 'Ketua Program Studi Matematika' }}</p>
                        @else
                            <div class="kaprodi-photo-wrap kaprodi-photo-placeholder">
                                <div class="kaprodi-avatar-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <span class="kaprodi-photo-badge">Kaprodi</span>
                            </div>
                            <h5 class="fw-bold mb-1" style="color: #711C35; font-size: 1.05rem;">Ketua Program Studi</h5>
                            <p class="text-muted small mb-1">Matematika FMIPA UNUJA</p>
                            <span class="badge bg-light text-secondary border px-2 py-1 mt-1" style="font-size: 0.75rem;">
                                Foto resmi akan dilengkapi
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Card Kanan: Judul Sambutan Kaprodi & Isi Sambutan --}}
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="tentang-card">
                        <div class="tentang-card-header">
                            <div class="card-header-icon-box">
                                <i class="fas fa-user"></i>
                            </div>
                            <span class="card-header-divider">|</span>
                            <h2 class="card-header-title">Sambutan Kaprodi</h2>
                        </div>

                        <div class="speech-placeholder-box">
                            @if($kaprodi && !empty($kaprodi->bio))
                                <div class="speech-text">
                                    {!! nl2br(e($kaprodi->bio)) !!}
                                </div>
                            @else
                                <p class="speech-salutation">Assalamu’alaikum Warahmatullahi Wabarakatuh,</p>
                                <p class="speech-text mb-2">
                                    Selamat datang di laman resmi <strong>HIMATIKA FMIPA Universitas Nurul Jadid (UNUJA)</strong>.
                                </p>
                                <p class="speech-text text-secondary mb-0">
                                    Teks sambutan resmi dari Ketua Program Studi Matematika Fakultas Matematika dan Ilmu Pengetahuan Alam UNUJA belum tersedia atau sedang dalam proses penyusunan. Konten sambutan akan segera diperbarui melalui sistem administrasi.
                                </p>
                                <div class="speech-status-pill">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    <span>Teks sambutan resmi akan dilengkapi</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4. VISI DAN MISI (DUA KOLOM BERDAMPINGAN) --}}
            <div class="row g-4 section-gap">
                {{-- Kolom Visi --}}
                <div class="col-md-6 col-12">
                    <div class="section-bar-header">Visi</div>
                    <div class="px-2">
                        <p class="vision-text">
                            {{ $vm->vision ?? 'Menjadi organisasi mahasiswa Matematika yang aktif, inovatif, kolaboratif, dan unggul dalam pengembangan ilmu matematika serta sumber daya mahasiswa.' }}
                        </p>
                    </div>
                </div>

                {{-- Kolom Misi --}}
                <div class="col-md-6 col-12">
                    <div class="section-bar-header">Misi</div>
                    <div class="px-2">
                        @if(!empty($mission) && is_array($mission) && count($mission) > 0)
                            @foreach($mission as $m)
                                <div class="item-with-line">{{ $m }}</div>
                            @endforeach
                        @else
                            <div class="item-with-line">Meningkatkan kemampuan akademik dan non-akademik mahasiswa Matematika.</div>
                            <div class="item-with-line">Mendorong kreativitas dan inovasi dalam bidang matematika terapan.</div>
                            <div class="item-with-line">Membangun solidaritas antar mahasiswa Matematika.</div>
                            <div class="item-with-line">Menyelenggarakan kegiatan edukatif dan kompetitif.</div>
                            <div class="item-with-line">Membangun kerja sama dengan pihak internal dan eksternal kampus.</div>
                            <div class="item-with-line">Mengembangkan potensi mahasiswa Matematika UNUJA.</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 5. STRUKTUR ORGANISASI (SECTION KONTEN TERAKHIR SEBELUM FOOTER) --}}
            <div id="struktur" style="scroll-margin-top: 100px;">
                <div class="text-center">
                    <div class="section-center-bar">
                        <i class="fas fa-sitemap"></i>
                        <span>Struktur Organisasi</span>
                    </div>
                </div>

                <div class="org-image-wrapper" onclick="openStructureModal()" title="Klik untuk memperbesar gambar">
                    <img src="{{ asset('images/struktur-organisasi-himatika.svg') }}" alt="Struktur Organisasi HIMATIKA FMIPA UNUJA" class="org-image img-fluid">
                    <div class="org-zoom-hint">
                        <i class="fas fa-search-plus"></i> Klik untuk memperbesar
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- MODAL ZOOM LIGHTBOX --}}
<div id="structureModal" class="structure-modal-overlay" onclick="closeStructureModal(event)">
    <div class="structure-modal-container">
        <button type="button" class="structure-modal-close" onclick="closeStructureModal()" aria-label="Tutup">&times;</button>
        <img src="{{ asset('images/struktur-organisasi-himatika.svg') }}" alt="Struktur Organisasi HIMATIKA FMIPA UNUJA (Besar)" class="structure-modal-img">
    </div>
</div>

<script>
    function openStructureModal() {
        var modal = document.getElementById('structureModal');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeStructureModal(event) {
        if (!event || event.target.id === 'structureModal' || event.target.classList.contains('structure-modal-close')) {
            var modal = document.getElementById('structureModal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeStructureModal();
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        if (window.location.hash === '#struktur') {
            setTimeout(function() {
                var el = document.getElementById('struktur');
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth' });
                }
            }, 300);
        }
    });
</script>

@endsection
