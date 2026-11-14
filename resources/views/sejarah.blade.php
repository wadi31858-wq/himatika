@extends('layouts.app')
@section('title', 'Sejarah MAN 1 Probolinggo')

@section('content')

{{-- ==================== HALAMAN SEJARAH MAN 1 PROBOLINGGO ==================== --}}
<section class="sejarah-section-wrapper">
    <div class="container">
        <div class="sejarah-card-wrapper mx-auto">
            
            {{-- 1. CARD UTAMA SEJARAH --}}
            <div class="card-sejarah-main">
                
                {{-- 2. JUDUL SECTION (KUNING KEEMASAN) --}}
                <div class="sejarah-top-header">
                    <h2 class="sejarah-gold-title">Sejarah MAN 1 PROBOLINGGO</h2>
                </div>

                {{-- 3. GAMBAR SEKOLAH (GEDUNG MAN 1 PROBOLINGGO) --}}
                @php
                    $historyImg = asset('images/gedung-man1-probolinggo.jpg');
                    if (!empty($siteSettings['history_image']) && file_exists(public_path('storage/' . $siteSettings['history_image']))) {
                        $historyImg = asset('storage/' . $siteSettings['history_image']);
                    } elseif (file_exists(public_path('images/gedung-man1-probolinggo.jpg'))) {
                        $historyImg = asset('images/gedung-man1-probolinggo.jpg');
                    } elseif (!empty($profile->image) && file_exists(public_path('storage/' . $profile->image))) {
                        $historyImg = asset('storage/' . $profile->image);
                    }
                @endphp
                <div class="sejarah-img-container">
                    <img src="{{ $historyImg }}" alt="Gedung MAN 1 Probolinggo" class="sejarah-building-img">
                </div>

                {{-- 4. ISI SEJARAH --}}
                <div class="sejarah-body-content">
                    <h3 class="sejarah-content-heading">Sejarah MAN 1 Probolinggo</h3>
                    
                    @if($profile && !empty($profile->history) && (str_contains($profile->history, 'MAN 1 Probolinggo') || str_contains($profile->history, 'madrasah')))
                        <div class="sejarah-paragraphs">
                            {!! $profile->history !!}
                        </div>
                    @else
                        <div class="sejarah-paragraphs">
                            <p>
                                MAN 1 Probolinggo merupakan lembaga pendidikan Islam yang tumbuh dan berkembang dari semangat masyarakat dalam membangun pendidikan yang berlandaskan nilai-nilai keislaman. Cikal bakal berdirinya madrasah ini berawal dari peran Pondok Pesantren Nurul Jadid yang pada tahun 1969 M merintis lembaga pendidikan sebagai bagian dari upaya mencetak generasi yang berilmu, berakhlak mulia, dan memiliki pemahaman agama yang kuat.
                            </p>
                            <p>
                                Pada masa awal berdirinya, lembaga pendidikan ini berada di bawah naungan Pondok Pesantren Nurul Jadid. Seiring berjalannya waktu dan berkembangnya kebutuhan pendidikan masyarakat, lembaga ini mengalami perkembangan hingga menjadi madrasah negeri. Perubahan tersebut menjadi bagian penting dalam perjalanan madrasah untuk memperluas akses pendidikan serta meningkatkan kualitas pembelajaran bagi generasi muda.
                            </p>
                            <p>
                                Dalam perkembangannya, MAN 1 Probolinggo terus berupaya menyesuaikan diri dengan kemajuan zaman tanpa meninggalkan nilai-nilai keislaman yang menjadi landasan pendidikannya. Madrasah berkomitmen memadukan pendidikan agama, ilmu pengetahuan, teknologi, dan pembentukan karakter guna melahirkan peserta didik yang unggul dalam prestasi, kuat dalam iman, serta berakhlak mulia.
                            </p>
                            <p>
                                Hingga kini, MAN 1 Probolinggo terus berbenah dan berinovasi dalam meningkatkan mutu pendidikan, mengembangkan potensi peserta didik, serta membangun lingkungan belajar yang religius, disiplin, dan berorientasi pada masa depan. Dengan semangat tersebut, MAN 1 Probolinggo diharapkan terus menjadi lembaga pendidikan yang mampu melahirkan generasi yang berilmu, berintegritas, dan siap memberikan kontribusi positif bagi masyarakat, bangsa, dan agama.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- 5. CARD DOKUMENTASI SEJARAH (BAWAH) --}}
            <div class="card-dokumentasi-wrapper">
                <div class="dokumentasi-text">
                    <h4 class="dokumentasi-title">Dokumentasi Sejarah</h4>
                    <p class="dokumentasi-desc">
                        {{ $siteSettings['history_doc_desc'] ?? 'Jelajahi dokumentasi dan arsip sejarah perjalanan MAN 1 PROBOLINGGO dalam galeri kami.' }}
                    </p>
                </div>
                <div class="dokumentasi-btn-box">
                    <a href="{{ $siteSettings['history_doc_url'] ?? route('galeri') }}" class="btn-lihat-galeri">
                        <i class="fas fa-images"></i>
                        <span>{{ $siteSettings['history_doc_text'] ?? 'Lihat Galeri' }}</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* =========================================================
       HALAMAN SEJARAH MAN 1 PROBOLINGGO
       Sesuai Acuan Desain Referensi
       ========================================================= */

    /* Background Halaman: Putih sedikit krem */
    .sejarah-section-wrapper {
        background-color: #FAF8F5;
        min-height: calc(100vh - 120px);
        padding: 40px 0 60px;
    }

    /* Container Wrapper di Tengah */
    .sejarah-card-wrapper {
        max-width: 860px;
        width: 100%;
        padding: 0 15px;
    }

    /* 1. CARD UTAMA */
    .card-sejarah-main {
        background: #ffffff;
        border-radius: 20px;
        padding: 32px 34px 36px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.02);
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    /* 2. JUDUL SECTION (KUNING KEEMASAN) */
    .sejarah-top-header {
        margin-bottom: 16px;
    }
    .sejarah-gold-title {
        color: #D4AF37;
        font-size: 1.05rem;
        font-weight: 700;
        letter-spacing: 0.3px;
        margin: 0;
        line-height: 1.3;
    }

    /* 3. GAMBAR SEKOLAH */
    .sejarah-img-container {
        width: 100%;
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 24px;
        background-color: #f1f1f1;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }
    .sejarah-building-img {
        width: 100%;
        height: auto;
        max-height: 380px;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }

    /* 4. ISI SEJARAH */
    .sejarah-body-content {
        margin-top: 6px;
    }
    .sejarah-content-heading {
        color: #4A4A4A;
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 16px;
        line-height: 1.35;
    }
    .sejarah-paragraphs,
    .sejarah-paragraphs p {
        color: #666666;
        font-size: 0.865rem;
        line-height: 1.75;
        text-align: justify;
        text-justify: inter-word;
        margin-bottom: 16px;
    }
    .sejarah-paragraphs p:last-child {
        margin-bottom: 0;
    }

    /* 5. CARD DOKUMENTASI SEJARAH (BAWAH) */
    .card-dokumentasi-wrapper {
        background: #ffffff;
        border-radius: 16px;
        padding: 22px 30px;
        margin-top: 22px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.02);
        border: 1px solid rgba(0, 0, 0, 0.03);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }
    .dokumentasi-title {
        color: #2D3748;
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .dokumentasi-desc {
        color: #718096;
        font-size: 0.825rem;
        margin-bottom: 0;
        line-height: 1.5;
    }
    .btn-lihat-galeri {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #D4AF37;
        color: #ffffff !important;
        font-size: 0.85rem;
        font-weight: 600;
        padding: 9px 24px;
        border-radius: 9999px;
        text-decoration: none;
        white-space: nowrap;
        box-shadow: 0 2px 8px rgba(212, 175, 55, 0.35);
        transition: all 0.25s ease;
    }
    .btn-lihat-galeri:hover {
        background: #bfa030;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.45);
    }

    /* RESPONSIVE SMARTPHONE / ANDROID */
    @media (max-width: 767.98px) {
        .sejarah-section-wrapper {
            padding: 20px 0 40px;
        }
        .sejarah-card-wrapper {
            padding: 0 10px;
        }
        .card-sejarah-main {
            padding: 20px 16px 24px;
            border-radius: 16px;
        }
        .sejarah-gold-title {
            font-size: 0.95rem;
            margin-bottom: 12px;
        }
        .sejarah-img-container {
            border-radius: 10px;
            margin-bottom: 18px;
        }
        .sejarah-building-img {
            max-height: 220px;
        }
        .sejarah-content-heading {
            font-size: 1.15rem;
            margin-bottom: 12px;
        }
        .sejarah-paragraphs,
        .sejarah-paragraphs p {
            font-size: 0.84rem;
            line-height: 1.68;
            margin-bottom: 14px;
        }
        .card-dokumentasi-wrapper {
            flex-direction: column;
            align-items: flex-start;
            padding: 18px 16px;
            gap: 14px;
        }
        .dokumentasi-btn-box {
            width: 100%;
        }
        .btn-lihat-galeri {
            width: 100%;
        }
    }
</style>
@endpush
