@extends('layouts.app')
@section('title', 'Sejarah HIMATIKA FMIPA UNUJA')

@section('content')

{{-- ==================== BANNER SEJARAH ==================== --}}
<section class="sejarah-banner">
    <div class="container position-relative">
        <div class="sejarah-banner-content">
            <h1 class="sejarah-banner-title">Sejarah HIMATIKA</h1>
            <p class="sejarah-banner-subtitle">Perjalanan HIMATIKA FMIPA UNUJA dari awal berdiri hingga sekarang.</p>
        </div>
    </div>
</section>

{{-- ==================== KONTEN SEJARAH ==================== --}}
<section class="sejarah-content-section py-5">
    <div class="container">
        <div class="sejarah-container mx-auto">
            
            {{-- CARD PUTIH BESAR UTAMA --}}
            <div class="card-sejarah-utama mb-4">
                <div class="sejarah-card-header mb-3">
                    <span class="sejarah-gold-title">Sejarah Singkat HIMATIKA</span>
                </div>

                {{-- FOTO HORIZONTAL MEMBULAT --}}
                <div class="sejarah-img-wrap mb-4">
                    <img src="{{ asset('images/unuja-campus-banner.jpg') }}" alt="Gedung Kampus UNUJA - Sejarah HIMATIKA" class="sejarah-horizontal-img">
                </div>

                {{-- TEKS SEJARAH DALAM PARAGRAF --}}
                <div class="sejarah-text-body">
                    <h3 class="sejarah-section-heading mb-3">Sejarah HIMATIKA UNUJA</h3>
                    
                    <p class="sejarah-p">
                        Himpunan Mahasiswa Matematika (HIMATIKA) Universitas Nurul Jadid (UNUJA) merupakan organisasi kemahasiswaan di tingkat Program Studi Matematika Fakultas Matematika dan Ilmu Pengetahuan Alam (FMIPA) yang berdiri sebagai wadah perjuangan, keilmuan, dan pengembangan diri bagi mahasiswa.
                    </p>
                    
                    <p class="sejarah-p">
                        Berdirinya HIMATIKA dilandasi oleh semangat kebersamaan dan kebutuhan akan sebuah rumah bersama yang mampu menaungi aspirasi, mempererat ukhuwah, serta memacu prestasi akademik maupun non-akademik mahasiswa Matematika. Sejak awal berdirinya, organisasi ini berkomitmen menciptakan lingkungan intelektual yang berakar pada nilai-nilai keislaman, kejujuran ilmiah, dan integritas tinggi.
                    </p>
                    
                    <p class="sejarah-p">
                        Dalam perjalanannya, HIMATIKA terus beradaptasi dan berinovasi dengan perkembangan zaman tanpa meninggalkan identitas moral dan akademis. Berbagai kegiatan strategis rutin diselenggarakan, mulai dari seminar keilmuan, workshop teknologi data dan komputasi, olimpiade matematika, hingga program pengabdian kepada masyarakat luas.
                    </p>
                    
                    <p class="sejarah-p mb-0">
                        Memasuki periode 2026 dengan mengusung tema <em>“Synchronized Growth, Reaching New Heights”</em>, HIMATIKA UNUJA terus melangkah mantap menjadi organisasi yang inklusif, adaptif, dan siap mencetak generasi insan cendekia yang berdaya saing global dan bermanfaat bagi peradaban.
                    </p>
                </div>
            </div>

            {{-- CARD RINGKAS DOKUMENTASI SEJARAH --}}
            <div class="card-dokumentasi-sejarah p-3 p-md-4 rounded-4 bg-white border shadow-sm d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h5 class="fw-bold mb-1" style="color: #0D47A1; font-size: 1.05rem;">Dokumentasi Sejarah</h5>
                    <p class="text-secondary small mb-0">Jelajahi dokumentasi dan arsip kegiatan perjalanan HIMATIKA di galeri kami.</p>
                </div>
                <div class="text-end">
                    <a href="{{ route('galeri') }}" class="btn-sejarah-galeri">
                        Lihat Galeri &rarr;
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* BANNER SEJARAH */
    .sejarah-banner {
        background: linear-gradient(105deg, #0D47A1 0%, #1565C0 55%, #1976D2 100%);
        padding: 70px 0 50px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid #BFDBFE;
    }
    .sejarah-banner-title {
        color: #ffffff;
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }
    .sejarah-banner-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.05rem;
        margin-bottom: 0;
        font-weight: 400;
    }

    /* CONTAINER */
    .sejarah-container {
        max-width: 960px;
    }

    /* CARD SEJARAH UTAMA */
    .card-sejarah-utama {
        background: #ffffff;
        border: 1px solid #BFDBFE;
        border-radius: 16px;
        padding: 36px 40px;
        box-shadow: 0 4px 20px rgba(13, 71, 161, 0.05);
    }
    .sejarah-gold-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #B45309;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .sejarah-img-wrap {
        width: 100%;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #BFDBFE;
        background: #EFF6FF;
    }
    .sejarah-horizontal-img {
        width: 100%;
        height: auto;
        max-height: 380px;
        object-fit: cover;
        display: block;
    }
    .sejarah-section-heading {
        color: #0D47A1;
        font-weight: 700;
        font-size: 1.4rem;
        letter-spacing: -0.3px;
    }
    .sejarah-p {
        font-size: 0.96rem;
        line-height: 1.8;
        color: #334155;
        text-align: justify;
        margin-bottom: 1.25rem;
    }

    /* CARD DOKUMENTASI */
    .card-dokumentasi-sejarah {
        border: 1px solid #BFDBFE !important;
        border-radius: 14px;
    }
    .btn-sejarah-galeri {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #1565C0;
        color: #ffffff;
        padding: 7px 18px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .btn-sejarah-galeri:hover {
        background: #0D47A1;
        color: #ffffff;
        transform: translateX(2px);
    }

    @media (max-width: 767.98px) {
        .sejarah-banner {
            padding: 50px 0 35px;
        }
        .sejarah-banner-title {
            font-size: 1.8rem;
        }
        .card-sejarah-utama {
            padding: 24px 20px;
        }
        .sejarah-section-heading {
            font-size: 1.2rem;
        }
    }
</style>
@endpush

