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
        background: linear-gradient(105deg, #0d3832 0%, #114232 45%, #155C57 100%);
        min-height: 220px;
        display: flex;
        align-items: center;
        overflow: hidden;
        margin-bottom: 50px;
        box-shadow: 0 4px 20px rgba(17, 66, 50, 0.12);
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
        background: linear-gradient(to right, #0d3832 0%, rgba(13,56,50,0.85) 35%, transparent 70%);
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

    /* HORIZONTAL BAR HEADERS */
    .section-bar-header {
        background-color: var(--dark-green, #114232);
        color: #ffffff;
        font-weight: 700;
        font-size: 1.05rem;
        text-align: center;
        padding: 9px 24px;
        border-radius: 6px;
        margin-bottom: 22px;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 6px rgba(17, 66, 50, 0.15);
    }

    .section-center-bar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background-color: var(--dark-green, #114232);
        color: #ffffff;
        font-weight: 700;
        font-size: 1.05rem;
        padding: 9px 36px;
        border-radius: 6px;
        margin-bottom: 28px;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 6px rgba(17, 66, 50, 0.15);
    }

    /* ITEM WITH VERTICAL LINE */
    .item-with-line {
        border-left: 2.5px solid var(--primary-green, #155C57);
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

    /* SECTION SPACING */
    .content-container {
        max-width: 1040px;
        margin: 0 auto;
    }
    .section-gap {
        margin-bottom: 50px;
    }

    /* STRUKTUR ORGANISASI IMAGE & ZOOM */
    .org-image-wrapper {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .org-image-wrapper:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(17, 66, 50, 0.1);
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
        background: rgba(17, 66, 50, 0.9);
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
        background: rgba(10, 38, 29, 0.88);
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
        background: var(--dark-green, #11423C);
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
        background: var(--primary-green, #155C57);
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
            margin-bottom: 35px;
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

            {{-- 2. VISI DAN MISI (DUA KOLOM BERDAMPINGAN) --}}
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

            {{-- 3. TUJUAN (LEBAR PENUH DI BAWAH VISI DAN MISI) --}}
            <div class="section-gap">
                <div class="section-bar-header">Tujuan</div>
                <div class="px-2">
                    <div class="item-with-line">
                        Membentuk insan akademis yang bertakwa kepada Tuhan Yang Maha Esa, berintegritas, mandiri, kritis, dan berwawasan kebangsaan.
                    </div>
                    <div class="item-with-line">
                        Mewadahi komunikasi, aspirasi, serta mempererat rasa kekeluargaan dan solidaritas antar mahasiswa Program Studi Matematika UNUJA.
                    </div>
                    <div class="item-with-line">
                        Mengembangkan potensi, kreativitas, kepemimpinan, dan keilmuan mahasiswa di bidang matematika murni, terapan, maupun teknologi.
                    </div>
                    <div class="item-with-line">
                        Mendorong terwujudnya kegiatan akademis, riset keilmuan, dan pengabdian kepada masyarakat yang memberi manfaat nyata bagi lingkungan kampus dan masyarakat luas.
                    </div>
                </div>
            </div>

            {{-- 4. STRUKTUR ORGANISASI --}}
            <div>
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

{{-- 5. MODAL ZOOM LIGHTBOX --}}
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
</script>

@endsection
