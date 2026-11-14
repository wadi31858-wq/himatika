@extends('layouts.app')
@section('title', 'Sejarah & ID Card Anggota | HIMATIKA UNUJA')

@section('content')

{{-- ==================== HERO BANNER SEJARAH & ID CARD ==================== --}}
<section class="sejarah-hero-banner">
    <div class="sejarah-hero-glow"></div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10 col-md-11">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3 sejarah-badge-pill">
                    <i class="fas fa-landmark text-warning"></i>
                    <span>KILAS BALIK &amp; IDENTITAS RESMI</span>
                </div>
                <h1 class="sejarah-hero-title">{{ $siteSettings['history_title'] ?? 'Sejarah & ID Card Anggota' }}</h1>
                <p class="sejarah-hero-subtitle">
                    {{ $siteSettings['history_subtitle'] ?? 'Perjalanan panjang dedikasi, karya nyata, dan transformasi digital mahasiswa Informatika Universitas Nurul Jadid.' }}
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                    <a href="#sejarah-organisasi" class="btn-sejarah-nav-primary">
                        <i class="fas fa-book-open me-1"></i> Sejarah Organisasi
                    </a>
                    <a href="#id-card-anggota" class="btn-sejarah-nav-gold">
                        <i class="fas fa-id-card me-1"></i> Kartu Tanda Anggota (ID Card)
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== MAIN CONTENT ==================== --}}
<section class="py-5" style="background: var(--burgundy-lightest);">
    <div class="container">
        @if(($siteSettings['history_is_visible'] ?? '1') === '0')
            <div class="text-center py-5">
                <div class="p-5 bg-white rounded-4 border shadow-sm mx-auto" style="max-width: 620px;">
                    <div class="mb-3 text-muted">
                        <i class="fas fa-eye-slash fa-3x" style="color: var(--burgundy-accent);"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: var(--burgundy-darkest);">Halaman Sejarah Sedang Dinonaktifkan</h3>
                    <p class="text-muted mb-4">Informasi Sejarah saat ini sedang diperbarui oleh administrator organisasi.</p>
                    <a href="{{ route('home') }}" class="btn px-4 py-2 text-white rounded-pill" style="background: var(--burgundy-main);">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        @else

        <div class="sejarah-page-layout mx-auto" style="max-width: 1040px;">

            {{-- 1. CARD SEJARAH HIMATIKA UNUJA --}}
            <div class="card-sejarah-premium mb-5" id="sejarah-organisasi">
                
                {{-- Header Card --}}
                <div class="card-sejarah-header">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="sejarah-header-bar"></span>
                            <span class="sejarah-header-tag">DEDIKASI &amp; PERJALANAN</span>
                        </div>
                        <span class="sejarah-year-tag"><i class="fas fa-calendar-check me-1"></i> 2020 - 2026</span>
                    </div>
                    <h2 class="sejarah-main-heading mt-2">Sejarah HIMATIKA UNUJA</h2>
                </div>

                {{-- Banner Foto Sejarah --}}
                @php
                    $historyImg = null;
                    if (!empty($siteSettings['history_image']) && file_exists(public_path('storage/' . $siteSettings['history_image']))) {
                        $historyImg = asset('storage/' . $siteSettings['history_image']);
                    } elseif (file_exists(public_path('images/hero-bg-unuja.jpg'))) {
                        $historyImg = asset('images/hero-bg-unuja.jpg');
                    } elseif (!empty($profile->image) && file_exists(public_path('storage/' . $profile->image))) {
                        $historyImg = asset('storage/' . $profile->image);
                    } else {
                        $historyImg = asset('images/unuja-campus-banner.jpg');
                    }
                @endphp
                <div class="sejarah-banner-box">
                    <img src="{{ $historyImg }}" alt="Kampus Universitas Nurul Jadid - HIMATIKA UNUJA" class="sejarah-banner-img">
                    <div class="sejarah-banner-caption">
                        <i class="fas fa-university me-1 text-warning"></i>
                        Kampus Universitas Nurul Jadid • Pusat Pergerakan Intelektual Mahasiswa Informatika
                    </div>
                </div>

                {{-- Narasi Sejarah --}}
                <div class="sejarah-body-text">
                    <p class="sejarah-lead-p">
                        Himpunan Mahasiswa Informatika (HIMATIKA) Universitas Nurul Jadid (UNUJA) lahir dari inisiatif luhur dan cita-cita luhur mahasiswa angkatan perdana Program Studi Informatika Fakultas Teknik Universitas Nurul Jadid, Paiton, Probolinggo.
                    </p>
                    <p>
                        Sebagai bagian dari lingkungan Pondok Pesantren Nurul Jadid, pendirian HIMATIKA dilandasi kesadaran mendalam bahwa kemajuan pesat revolusi teknologi digital dan rekayasa perangkat lunak harus diimbangi dengan fondasi karakter spiritual, integritas moral, dan etika Islam yang kuat. HIMATIKA dirancang sebagai rumah berkarya, inkubator kepemimpinan, dan wadah persatuan seluruh civitas akademika mahasiswa Informatika.
                    </p>
                    <p>
                        Dari awal berdirinya dengan segala keterbatasan, himpunan terus bertransformasi menjadi organisasi kemahasiswaan yang progresif, adaptif, dan berprestasi. HIMATIKA konsisten menyelenggarakan pelatihan keahlian komputasi, seminar teknologi terapan, pembinaan riset aplikasi, hingga peluncuran galeri website karya mahasiswa sebagai bukti nyata kontribusi teknologi bagi kemaslahatan masyarakat dan pesantren.
                    </p>
                </div>

                {{-- Timeline Milestones --}}
                <div class="sejarah-milestones-area mt-4 pt-4 border-top">
                    <h3 class="sejarah-subheading mb-4">
                        <i class="fas fa-stream me-2 text-warning"></i>
                        Tonggak Sejarah &amp; Perkembangan
                    </h3>

                    <div class="timeline-step-list">
                        <div class="timeline-step-item">
                            <div class="timeline-step-marker">2020</div>
                            <div class="timeline-step-content">
                                <h4 class="timeline-step-title">Inisiasi &amp; Deklarasi Pendirian</h4>
                                <p class="timeline-step-desc">
                                    Didirikan oleh angkatan perdana Program Studi Informatika Universitas Nurul Jadid sebagai wadah representasi akademis dan aspirasi mahasiswa.
                                </p>
                            </div>
                        </div>

                        <div class="timeline-step-item">
                            <div class="timeline-step-marker">2021</div>
                            <div class="timeline-step-content">
                                <h4 class="timeline-step-title">Pekan Teknologi &amp; Seminar Perdana</h4>
                                <p class="timeline-step-desc">
                                    Penyelenggaraan Pekan Teknologi Informatika dan Seminar Nasional Software Architecture yang melibatkan peserta dari berbagai kampus Jawa Timur.
                                </p>
                            </div>
                        </div>

                        <div class="timeline-step-item">
                            <div class="timeline-step-marker">2022</div>
                            <div class="timeline-step-content">
                                <h4 class="timeline-step-title">Penataan Divisi &amp; Biro Keorganisasian</h4>
                                <p class="timeline-step-desc">
                                    Pemekaran struktur organisasi dengan membentuk Divisi Litbang Komputasi, Divisi Kominfo, serta Biro Administrasi &amp; Keuangan Mandiri.
                                </p>
                            </div>
                        </div>

                        <div class="timeline-step-item">
                            <div class="timeline-step-marker">2023</div>
                            <div class="timeline-step-content">
                                <h4 class="timeline-step-title">Pengukuhan AD/ART &amp; Legalitas Terpadu</h4>
                                <p class="timeline-step-desc">
                                    Penyusunan dan pengesahan Anggaran Dasar dan Anggaran Rumah Tangga (AD/ART) resmi tingkat fakultas dan universitas.
                                </p>
                            </div>
                        </div>

                        <div class="timeline-step-item">
                            <div class="timeline-step-marker">2024</div>
                            <div class="timeline-step-content">
                                <h4 class="timeline-step-title">Galeri Website Mahasiswa &amp; Inkubasi Digital</h4>
                                <p class="timeline-step-desc">
                                    Peluncuran ruang pamer digital proyek website mahasiswa Informatika UNUJA untuk menautkan karya kuliah langsung dengan publik.
                                </p>
                            </div>
                        </div>

                        <div class="timeline-step-item">
                            <div class="timeline-step-marker">2025</div>
                            <div class="timeline-step-content">
                                <h4 class="timeline-step-title">Transformasi Digital &amp; Pengabdian Pesantren</h4>
                                <p class="timeline-step-desc">
                                    Digitalisasi sistem administrasi himpunan dan pelaksanaan bakti sosial literasi teknologi untuk madrasah dan santri.
                                </p>
                            </div>
                        </div>

                        <div class="timeline-step-item active-period">
                            <div class="timeline-step-marker">2026</div>
                            <div class="timeline-step-content">
                                <h4 class="timeline-step-title">Synchronized Growth, Reaching New Heights</h4>
                                <p class="timeline-step-desc">
                                    Periode kepengurusan aktif berfokus pada kolaborasi lintas sektor, sertifikasi keahlian, dan penerbitan ID Card keanggotaan pintar berbasis QR Code.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. SECTION KHUSUS: KARTU TANDA ANGGOTA (ID CARD) ANGGOTA HIMATIKA --}}
            <div class="card-idcard-showcase mb-5" id="id-card-anggota">
                <div class="idcard-showcase-header text-center mb-4">
                    <span class="badge px-3 py-1 mb-2 rounded-pill" style="background: rgba(229, 169, 60, 0.2); color: #E5A93C; font-weight: 700; letter-spacing: 1.2px; font-size: 0.78rem;">
                        IDENTITAS RESMI KEANGGOTAAN
                    </span>
                    <h2 class="idcard-showcase-title">Kartu Tanda Anggota (ID Card) HIMATIKA</h2>
                    <p class="idcard-showcase-subtitle mx-auto">
                        Simbol kebanggaan, legalitas keorganisasian, dan paspor akses fasilitas resmi bagi setiap mahasiswa Informatika Universitas Nurul Jadid.
                    </p>
                </div>

                <div class="row align-items-center g-4 my-2">
                    {{-- Visual ID Card Mockup (Left Column) --}}
                    <div class="col-lg-6">
                        <div class="idcard-mockup-wrapper">
                            <div class="idcard-mockup-container">
                                {{-- FRONT SIDE CARD --}}
                                <div class="idcard-front-face">
                                    <div class="idcard-glow-bg"></div>
                                    <div class="idcard-top-row">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="idcard-emblem-wrap">
                                                <img src="{{ !empty($profile->logo) ? asset('storage/' . $profile->logo) : asset('images/logo.png') }}" alt="HIMATIKA UNUJA" class="idcard-emblem">
                                            </div>
                                            <div>
                                                <div class="idcard-org-name">HIMATIKA UNUJA</div>
                                                <div class="idcard-uni-name">UNIVERSITAS NURUL JADID</div>
                                            </div>
                                        </div>
                                        <div class="idcard-chip-icon">
                                            <i class="fas fa-microchip"></i>
                                        </div>
                                    </div>

                                    <div class="idcard-card-title">
                                        <span>KARTU TANDA ANGGOTA</span>
                                        <small>MEMBER IDENTIFICATION CARD</small>
                                    </div>

                                    <div class="idcard-body-row">
                                        <div class="idcard-photo-box">
                                            <div class="idcard-photo-placeholder">
                                                <i class="fas fa-user-graduate"></i>
                                            </div>
                                            <span class="idcard-active-pill">AKTIF 2026</span>
                                        </div>
                                        <div class="idcard-info-box">
                                            <div class="idcard-info-item">
                                                <label>NAMA LENGKAP</label>
                                                <strong>AHMAD FAIZAL EFENDI</strong>
                                            </div>
                                            <div class="idcard-info-item">
                                                <label>NOMOR INDUK ANGGOTA (NIA)</label>
                                                <strong class="text-gold">NIA.2024.IF.048</strong>
                                            </div>
                                            <div class="idcard-info-item">
                                                <label>STATUS KEANGGOTAAN</label>
                                                <span>Anggota Utama (Penuh)</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="idcard-bottom-row">
                                        <div class="idcard-motto-tag">Synchronized Growth, Reaching New Heights</div>
                                        <div class="idcard-qr-box">
                                            <i class="fas fa-qrcode"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <small class="text-white-50" style="font-size: 0.78rem;">
                                    <i class="fas fa-shield-alt text-warning me-1"></i> Desain Resmi ID Card HIMATIKA UNUJA Format ISO CR80
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- Card Specifications & Privileges (Right Column) --}}
                    <div class="col-lg-6">
                        <div class="idcard-specs-panel p-4 rounded-4" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15);">
                            <h4 class="fw-bold text-white mb-3" style="font-size: 1.25rem;">
                                <i class="fas fa-id-badge text-warning me-2"></i>
                                Ketentuan &amp; Spesifikasi ID Card
                            </h4>

                            <ul class="idcard-specs-list list-unstyled mb-4 text-white-50 small">
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="fas fa-check-circle text-warning mt-1"></i>
                                    <div><strong class="text-white">Format NIA Resmi:</strong> Format penomoran terdiri atas [Tahun Masuk].[Kode Prodi IF].[Nomor Urut Registrasi].</div>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="fas fa-check-circle text-warning mt-1"></i>
                                    <div><strong class="text-white">Autentikasi Terverifikasi:</strong> Dilengkapi QR Code dinamis yang langsung terhubung ke basis data keanggotaan resmi.</div>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="fas fa-check-circle text-warning mt-1"></i>
                                    <div><strong class="text-white">Masa Berlaku:</strong> Berlaku selama mahasiswa berstatus aktif di Program Studi Informatika UNUJA.</div>
                                </li>
                            </ul>

                            <h5 class="fw-bold text-white mb-3" style="font-size: 1.05rem;">
                                <i class="fas fa-star text-warning me-2"></i>
                                Hak Istimewa Pemilik ID Card
                            </h5>

                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <div class="p-2 rounded-3 bg-white bg-opacity-10 text-white small h-100">
                                        <i class="fas fa-vote-yea text-warning me-1"></i>
                                        <strong>Hak Suara Penuh</strong> dalam Musyawarah Besar (MUBES).
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-2 rounded-3 bg-white bg-opacity-10 text-white small h-100">
                                        <i class="fas fa-laptop-code text-warning me-1"></i>
                                        <strong>Akses Fasilitas</strong> Lab Komputasi &amp; Coworking Space.
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-2 rounded-3 bg-white bg-opacity-10 text-white small h-100">
                                        <i class="fas fa-ticket-alt text-warning me-1"></i>
                                        <strong>Prioritas Kuota</strong> Bootcamp &amp; Workshop Teknologi.
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-2 rounded-3 bg-white bg-opacity-10 text-white small h-100">
                                        <i class="fas fa-certificate text-warning me-1"></i>
                                        <strong>Rekomendasi Resmi</strong> Delegasi Kompetisi &amp; Hackathon.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4 pt-3 border-top border-white-50 border-opacity-25">
                    <p class="small text-white-50 mb-3">
                        Belum memiliki atau ingin memperbarui Kartu Tanda Anggota (ID Card) HIMATIKA UNUJA?
                    </p>
                    <a href="{{ route('pendaftaran.index') }}" class="btn-idcard-action">
                        <i class="fas fa-user-plus me-1"></i> Ajukan Permohonan / Cek Status ID Card
                    </a>
                </div>
            </div>

            {{-- 3. CARD DOKUMENTASI SEJARAH --}}
            <div class="card-sejarah-dok mb-4">
                <div class="row align-items-center g-3">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center gap-3">
                            <div class="sejarah-dok-icon">
                                <i class="fas fa-images"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-1" style="color: var(--burgundy-darkest); font-size: 1.25rem;">
                                    Arsip &amp; Galeri Dokumentasi Kegiatan
                                </h4>
                                <p class="text-muted small mb-0">
                                    {{ $siteSettings['history_doc_desc'] ?? 'Jelajahi rekaman perjalanan, momen bersejarah, dan dokumentasi kegiatan kepengurusan HIMATIKA UNUJA.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end text-start">
                        <a href="{{ $siteSettings['history_doc_url'] ?? route('galeri') }}" class="btn-sejarah-dok">
                            <span>{{ $siteSettings['history_doc_text'] ?? 'Buka Galeri Dokumentasi' }}</span>
                            <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        @endif
    </div>
</section>

@endsection

@push('styles')
<style>
    /* Styling Hero Sejarah */
    .sejarah-hero-banner {
        position: relative;
        background: linear-gradient(135deg, #250D17 0%, #641D38 60%, #8A3151 100%);
        padding: 85px 0 65px;
        color: #FFF7FA;
        overflow: hidden;
    }
    .sejarah-hero-glow {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 20% 20%, rgba(229, 169, 60, 0.18), transparent 45%),
                    radial-gradient(circle at 80% 80%, rgba(138, 49, 81, 0.35), transparent 50%);
        pointer-events: none;
    }
    .sejarah-badge-pill {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #FFF7FA;
        font-size: 0.78rem;
        letter-spacing: 1.2px;
        font-weight: 700;
    }
    .sejarah-hero-title {
        font-size: clamp(2.2rem, 4.5vw, 3.4rem);
        font-weight: 800;
        letter-spacing: -0.5px;
        color: #FFF7FA;
        margin-bottom: 1rem;
    }
    .sejarah-hero-subtitle {
        font-size: clamp(1rem, 2vw, 1.2rem);
        color: rgba(255, 247, 250, 0.88);
        line-height: 1.6;
        max-width: 760px;
        margin: 0 auto;
    }
    .btn-sejarah-nav-primary {
        display: inline-flex;
        align-items: center;
        padding: 12px 28px;
        border-radius: 9999px;
        background: #E5A93C;
        color: #250D17;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
        min-height: 46px;
    }
    .btn-sejarah-nav-primary:hover {
        background: #f1b74f;
        color: #250D17;
        transform: translateY(-2px);
    }
    .btn-sejarah-nav-gold {
        display: inline-flex;
        align-items: center;
        padding: 12px 28px;
        border-radius: 9999px;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(229, 169, 60, 0.6);
        color: #FFF7FA;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
        min-height: 46px;
    }
    .btn-sejarah-nav-gold:hover {
        background: #E5A93C;
        color: #250D17;
        transform: translateY(-2px);
    }

    /* Card Utama Sejarah */
    .card-sejarah-premium {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid rgba(138, 49, 81, 0.15);
        box-shadow: 0 10px 30px rgba(100, 29, 56, 0.06);
        padding: 40px;
    }
    .sejarah-header-bar {
        display: inline-block;
        width: 24px;
        height: 3px;
        border-radius: 2px;
        background: var(--burgundy-accent);
    }
    .sejarah-header-tag {
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        color: var(--burgundy-accent);
    }
    .sejarah-year-tag {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--burgundy-main);
        background: var(--burgundy-light);
        padding: 4px 12px;
        border-radius: 9999px;
    }
    .sejarah-main-heading {
        font-size: clamp(1.8rem, 3.2vw, 2.5rem);
        font-weight: 800;
        color: var(--burgundy-darkest);
        line-height: 1.25;
    }
    .sejarah-banner-box {
        margin: 25px 0 30px;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(138, 49, 81, 0.12);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    }
    .sejarah-banner-img {
        width: 100%;
        height: auto;
        max-height: 420px;
        object-fit: cover;
        display: block;
    }
    .sejarah-banner-caption {
        padding: 10px 18px;
        background: #250D17;
        color: #FFF7FA;
        font-size: 0.82rem;
        font-weight: 500;
    }
    .sejarah-body-text {
        color: #3B242F;
        font-size: 1rem;
        line-height: 1.85;
    }
    .sejarah-lead-p {
        font-size: 1.12rem;
        font-weight: 500;
        color: var(--burgundy-darkest);
        line-height: 1.75;
    }
    .sejarah-subheading {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--burgundy-darkest);
    }

    /* Timeline Milestones */
    .timeline-step-list {
        position: relative;
        padding-left: 20px;
    }
    .timeline-step-list::before {
        content: '';
        position: absolute;
        top: 10px;
        bottom: 10px;
        left: 54px;
        width: 2px;
        background: rgba(138, 49, 81, 0.2);
    }
    .timeline-step-item {
        position: relative;
        display: flex;
        align-items: flex-start;
        gap: 22px;
        margin-bottom: 24px;
    }
    .timeline-step-marker {
        position: relative;
        z-index: 2;
        width: 68px;
        min-width: 68px;
        padding: 6px 0;
        border-radius: 8px;
        background: var(--burgundy-light);
        color: var(--burgundy-main);
        font-weight: 800;
        font-size: 0.88rem;
        text-align: center;
        border: 1px solid rgba(138, 49, 81, 0.2);
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .timeline-step-item.active-period .timeline-step-marker {
        background: var(--burgundy-main);
        color: #FFF7FA;
        border-color: #E5A93C;
    }
    .timeline-step-content {
        flex: 1;
        background: var(--burgundy-lightest);
        padding: 16px 20px;
        border-radius: 12px;
        border: 1px solid rgba(138, 49, 81, 0.12);
    }
    .timeline-step-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--burgundy-darkest);
        margin-bottom: 4px;
    }
    .timeline-step-desc {
        font-size: 0.9rem;
        color: #553A47;
        margin-bottom: 0;
        line-height: 1.6;
    }

    /* Showcase Card ID Card */
    .card-idcard-showcase {
        background: linear-gradient(135deg, #250D17 0%, #461426 50%, #641D38 100%);
        border-radius: 24px;
        padding: 45px 40px;
        box-shadow: 0 16px 40px rgba(37, 13, 23, 0.35);
        border: 1px solid rgba(229, 169, 60, 0.3);
        color: #FFF7FA;
    }
    .idcard-showcase-title {
        font-size: clamp(1.8rem, 3.2vw, 2.4rem);
        font-weight: 800;
        color: #FFF7FA;
        margin-bottom: 0.6rem;
    }
    .idcard-showcase-subtitle {
        font-size: 0.98rem;
        color: rgba(255, 247, 250, 0.8);
        max-width: 650px;
        line-height: 1.65;
    }

    /* Realistic Card Front Face */
    .idcard-mockup-wrapper {
        perspective: 1000px;
    }
    .idcard-mockup-container {
        max-width: 380px;
        margin: 0 auto;
    }
    .idcard-front-face {
        position: relative;
        border-radius: 16px;
        background: linear-gradient(135deg, #1A0810 0%, #3B0F20 60%, #641D38 100%);
        border: 1.5px solid #E5A93C;
        padding: 22px;
        color: #FFF7FA;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.5), inset 0 0 20px rgba(229, 169, 60, 0.15);
        overflow: hidden;
    }
    .idcard-glow-bg {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 90% 10%, rgba(229, 169, 60, 0.25), transparent 50%);
        pointer-events: none;
    }
    .idcard-top-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        position: relative;
        z-index: 1;
    }
    .idcard-emblem-wrap {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #ffffff;
        padding: 2px;
        border: 1.5px solid #E5A93C;
    }
    .idcard-emblem {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }
    .idcard-org-name {
        font-size: 0.85rem;
        font-weight: 800;
        letter-spacing: 0.8px;
        color: #FFF7FA;
        line-height: 1.1;
    }
    .idcard-uni-name {
        font-size: 0.65rem;
        font-weight: 600;
        color: #E5A93C;
        letter-spacing: 0.5px;
    }
    .idcard-chip-icon {
        color: #E5A93C;
        font-size: 1.6rem;
    }
    .idcard-card-title {
        border-top: 1px solid rgba(229, 169, 60, 0.3);
        border-bottom: 1px solid rgba(229, 169, 60, 0.3);
        padding: 4px 0;
        margin-bottom: 14px;
        text-align: center;
        position: relative;
        z-index: 1;
    }
    .idcard-card-title span {
        display: block;
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 1.5px;
        color: #FFF7FA;
    }
    .idcard-card-title small {
        display: block;
        font-size: 0.58rem;
        color: rgba(255, 247, 250, 0.7);
        letter-spacing: 1px;
    }
    .idcard-body-row {
        display: flex;
        gap: 16px;
        align-items: center;
        position: relative;
        z-index: 1;
        margin-bottom: 16px;
    }
    .idcard-photo-box {
        width: 82px;
        min-width: 82px;
        height: 105px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.1);
        border: 1.5px solid rgba(229, 169, 60, 0.7);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    .idcard-photo-placeholder {
        font-size: 2.4rem;
        color: rgba(255, 255, 255, 0.5);
    }
    .idcard-active-pill {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: #E5A93C;
        color: #250D17;
        font-size: 0.55rem;
        font-weight: 800;
        text-align: center;
        padding: 2px 0;
        letter-spacing: 0.5px;
    }
    .idcard-info-box {
        flex: 1;
    }
    .idcard-info-item {
        margin-bottom: 6px;
    }
    .idcard-info-item label {
        display: block;
        font-size: 0.58rem;
        font-weight: 600;
        color: rgba(255, 247, 250, 0.65);
        letter-spacing: 0.5px;
        margin-bottom: 1px;
    }
    .idcard-info-item strong {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: #FFF7FA;
        line-height: 1.2;
    }
    .idcard-info-item span {
        font-size: 0.75rem;
        color: rgba(255, 247, 250, 0.9);
    }
    .text-gold {
        color: #E5A93C !important;
    }
    .idcard-bottom-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        padding-top: 8px;
        position: relative;
        z-index: 1;
    }
    .idcard-motto-tag {
        font-size: 0.65rem;
        font-style: italic;
        color: rgba(255, 247, 250, 0.75);
    }
    .idcard-qr-box {
        font-size: 1.5rem;
        color: #FFF7FA;
    }
    .btn-idcard-action {
        display: inline-flex;
        align-items: center;
        padding: 12px 30px;
        border-radius: 9999px;
        background: #E5A93C;
        color: #250D17;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
        min-height: 46px;
    }
    .btn-idcard-action:hover {
        background: #f1b74f;
        color: #250D17;
        transform: translateY(-2px);
    }

    /* Card Dokumentasi Sejarah */
    .card-sejarah-dok {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(138, 49, 81, 0.15);
        padding: 28px 32px;
        box-shadow: 0 4px 16px rgba(100, 29, 56, 0.05);
    }
    .sejarah-dok-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: var(--burgundy-light);
        color: var(--burgundy-main);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .btn-sejarah-dok {
        display: inline-flex;
        align-items: center;
        padding: 12px 24px;
        border-radius: 9999px;
        background: var(--burgundy-main);
        color: #FFF7FA;
        font-weight: 600;
        font-size: 0.92rem;
        text-decoration: none;
        transition: all 0.25s ease;
        min-height: 44px;
    }
    .btn-sejarah-dok:hover {
        background: var(--burgundy-accent);
        color: #ffffff;
        transform: translateY(-2px);
    }

    @media (max-width: 767.98px) {
        .card-sejarah-premium {
            padding: 24px 18px;
        }
        .card-idcard-showcase {
            padding: 30px 18px;
        }
        .timeline-step-list::before {
            left: 28px;
        }
        .timeline-step-item {
            gap: 12px;
        }
        .timeline-step-marker {
            width: 54px;
            min-width: 54px;
            font-size: 0.78rem;
            padding: 4px 0;
        }
        .btn-sejarah-nav-primary,
        .btn-sejarah-nav-gold,
        .btn-idcard-action,
        .btn-sejarah-dok {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush
