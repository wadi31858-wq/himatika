@extends('layouts.app')
@section('title', 'Sambutan Kaprodi - HIMATIKA UNUJA')

@section('content')

{{-- ==================== BANNER SAMBUTAN ==================== --}}
<section class="sambutan-banner">
    <div class="container position-relative">
        <div class="sambutan-banner-content">
            <h1 class="sambutan-banner-title">Sambutan Kaprodi</h1>
            <p class="sambutan-banner-subtitle">Sambutan Ketua Program Studi Matematika UNUJA.</p>
        </div>
    </div>
</section>

{{-- ==================== KONTEN DUA KOLOM ==================== --}}
<section class="sambutan-content-section py-5">
    <div class="container">
        <div class="row g-4 align-items-start">
            
            {{-- KOLOM KIRI: PROFIL & KUTIPAN RESMI (~1/3 LEBAR) --}}
            <div class="col-lg-4 col-md-5 col-12">
                {{-- CARD PROFIL --}}
                <div class="card-profil-kaprodi p-4 bg-white rounded-4 border shadow-sm text-center mb-3">
                    <div class="kaprodi-photo-container mb-3">
                        @if($kaprodi && $kaprodi->photo)
                            <img src="{{ asset('storage/' . $kaprodi->photo) }}" alt="{{ $kaprodi->name }}" class="kaprodi-avatar-img">
                        @else
                            <div class="kaprodi-avatar-placeholder d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-user-tie fa-4x text-primary opacity-75 mb-2"></i>
                                <span class="badge bg-primary px-3 py-1 mt-1">Kaprodi</span>
                            </div>
                        @endif
                    </div>

                    <h4 class="fw-bold mb-1" style="color: #0D47A1; font-size: 1.15rem;">
                        {{ $kaprodi->name ?? 'Ketua Program Studi' }}
                    </h4>
                    <p class="text-secondary small mb-0">
                        {{ $kaprodi->position ?? 'Ketua Program Studi Matematika FMIPA UNUJA' }}
                    </p>
                </div>

                {{-- CARD KECIL KUTIPAN RESMI --}}
                <div class="card-kutipan-kaprodi p-3 p-md-4 bg-white rounded-4 border shadow-sm text-center">
                    <div class="quote-icon mb-2">
                        <i class="fas fa-quote-left text-primary" style="font-size: 1.5rem; opacity: 0.8;"></i>
                    </div>
                    <p class="quote-text mb-0">
                        "Mewujudkan generasi mahasiswa Matematika yang berkarakter islami, unggul dalam keilmuan, mandiri, dan berdaya saing global."
                    </p>
                </div>
            </div>

            {{-- KOLOM KANAN: SAMBUTAN DALAM PANEL BIRU MUDA (~2/3 LEBAR) --}}
            <div class="col-lg-8 col-md-7 col-12">
                <div class="card-sambutan-utama p-4 p-md-4 p-lg-5 bg-white rounded-4 border shadow-sm">
                    <div class="sambutan-gold-header mb-3">
                        <span class="gold-subtitle">Sambutan Kaprodi</span>
                    </div>

                    {{-- PANEL BERLATAR BIRU MUDA --}}
                    <div class="sambutan-inner-panel p-4 rounded-3">
                        <p class="sambutan-p">
                            Assalamu’alaikum Warahmatullahi Wabarakatuh,
                        </p>

                        <p class="sambutan-p">
                            Puji syukur ke hadirat Allah SWT atas segala limpahan rahmat dan karunia-Nya, sehingga website resmi Himpunan Mahasiswa Matematika (HIMATIKA) Fakultas Matematika dan Ilmu Pengetahuan Alam Universitas Nurul Jadid (UNUJA) dapat hadir sebagai media informasi, komunikasi, dan representasi positif civitas akademika.
                        </p>

                        <p class="sambutan-p">
                            Website ini kami sambut sebagai upaya strategis untuk memperkuat transparansi, memperluas jangkauan layanan akademik maupun kemahasiswaan, serta mempererat tali silaturahmi antara program studi, dosen, mahasiswa, alumni, dan masyarakat luas. Melalui kanal ini, seluruh kegiatan keilmuan, prestasi mahasiswa, agenda organisasi, hingga publikasi ilmiah dapat diakses secara cepat dan terintegrasi.
                        </p>

                        <p class="sambutan-p">
                            Kami senantiasa berpesan kepada seluruh pengurus dan anggota HIMATIKA untuk terus menumbuhkan semangat keilmuan matematika terapan, menjunjung tinggi integritas moral, serta berkolaborasi aktif demi kemajuan program studi dan almamater tercinta.
                        </p>

                        <p class="sambutan-p mb-4">
                            Semoga Allah SWT senantiasa memberikan kemudahan dan keberkahan dalam setiap ikhtiar kita bersama. Selamat berproses dan berkarya.
                        </p>

                        {{-- TANDA TANGAN / PENUTUP KANAN BAWAH --}}
                        <div class="text-end pt-3 border-top border-light-subtle">
                            <h6 class="fw-bold mb-0" style="color: #0D47A1;">
                                {{ $kaprodi->name ?? 'Ketua Program Studi Matematika' }}
                            </h6>
                            <small class="text-muted">
                                {{ $kaprodi->position ?? 'FMIPA Universitas Nurul Jadid (UNUJA)' }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* BANNER SAMBUTAN */
    .sambutan-banner {
        background: linear-gradient(105deg, #0D47A1 0%, #1565C0 55%, #1976D2 100%);
        padding: 70px 0 50px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid #BFDBFE;
    }
    .sambutan-banner-title {
        color: #ffffff;
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }
    .sambutan-banner-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.05rem;
        margin-bottom: 0;
        font-weight: 400;
    }

    /* CARD PROFIL */
    .card-profil-kaprodi {
        border: 1px solid #BFDBFE !important;
        border-radius: 16px;
    }
    .kaprodi-photo-container {
        width: 100%;
        max-width: 200px;
        aspect-ratio: 4/5;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #BFDBFE;
        background: #EFF6FF;
        margin: 0 auto;
    }
    .kaprodi-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
        display: block;
    }
    .kaprodi-avatar-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%);
    }

    /* CARD KUTIPAN */
    .card-kutipan-kaprodi {
        border: 1px solid #BFDBFE !important;
        border-radius: 14px;
        background: #FAFAFA;
    }
    .quote-text {
        font-size: 0.88rem;
        font-style: italic;
        color: #475569;
        line-height: 1.6;
    }

    /* CARD SAMBUTAN UTAMA */
    .card-sambutan-utama {
        border: 1px solid #BFDBFE !important;
        border-radius: 16px;
    }
    .gold-subtitle {
        font-size: 0.95rem;
        font-weight: 700;
        color: #B45309;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .sambutan-inner-panel {
        background: #EFF6FF;
        border: 1px solid #BFDBFE;
    }
    .sambutan-p {
        font-size: 0.95rem;
        line-height: 1.8;
        color: #334155;
        text-align: justify;
        margin-bottom: 1.15rem;
    }

    @media (max-width: 767.98px) {
        .sambutan-banner {
            padding: 50px 0 35px;
        }
        .sambutan-banner-title {
            font-size: 1.8rem;
        }
    }
</style>
@endpush
