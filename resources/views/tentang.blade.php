@extends('layouts.app')
@section('title', 'Tentang Kami | HIMATIKA UNUJA')

@section('content')

{{-- ==================== HERO BANNER TENTANG KAMI ==================== --}}
<section class="tentang-page-hero">
    <div class="tentang-hero-overlay"></div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center text-center">
            <div class="col-lg-9 col-md-11">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3 tentang-hero-pill">
                    <i class="fas fa-university text-warning"></i>
                    <span>PROFIL RESMI ORGANISASI</span>
                </div>
                <h1 class="tentang-hero-title">Tentang HIMATIKA UNUJA</h1>
                <p class="tentang-hero-subtitle">
                    Himpunan Mahasiswa Informatika Universitas Nurul Jadid — Wadah Dedikasi, Kreativitas, Riset Teknologi, dan Ruang Tumbuh Bersama.
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
                    <a href="#profil" class="btn-tentang-hero-primary">
                        <i class="fas fa-id-card-alt me-1"></i> Profil Organisasi
                    </a>
                    <a href="{{ route('sejarah') }}" class="btn-tentang-hero-outline">
                        <i class="fas fa-history me-1"></i> Sejarah &amp; ID Card
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== SECTION 1: PROFIL SINGKAT & STATISTIK ==================== --}}
<section class="py-5" id="profil" style="background: #ffffff;">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="pe-lg-3">
                    <div class="tentang-top-label mb-2">
                        <span class="tentang-label-bar"></span>
                        <span>MENGENAL LEBIH DEKAT</span>
                    </div>
                    <h2 class="fw-bold mb-3" style="color: var(--burgundy-darkest); font-size: clamp(1.6rem, 3vw, 2.3rem); line-height: 1.3;">
                        Membangun Generasi Informatika yang Berdaya Saing Global &amp; Berakhlak Mulia
                    </h2>
                    <p class="lead mb-3" style="color: var(--burgundy-main); font-size: 1.05rem; font-weight: 500;">
                        {{ $profile->motto ?? 'Synchronized Growth, Reaching New Heights' }}
                    </p>
                    <div class="tentang-lead-paragraphs mb-4" style="color: #4A303D; font-size: 0.96rem; line-height: 1.75;">
                        <p>
                            {{ $profile->content ?? 'Himpunan Mahasiswa Informatika (HIMATIKA) Universitas Nurul Jadid (UNUJA) adalah organisasi kemahasiswaan resmi yang menaungi seluruh mahasiswa Program Studi Informatika di lingkungan Fakultas Teknik Universitas Nurul Jadid, Paiton, Probolinggo.' }}
                        </p>
                        <p class="mb-0">
                            Sebagai himpunan yang berada di bawah naungan Pondok Pesantren Nurul Jadid, HIMATIKA mengintegrasikan keunggulan sains dan teknologi informasi mutakhir dengan fondasi nilai-nilai keislaman, integritas, dan pengabdian nyata kepada masyarakat luas.
                        </p>
                    </div>

                    {{-- Quick Badges --}}
                    <div class="d-flex flex-wrap gap-2 pt-2 border-top">
                        <span class="badge px-3 py-2" style="background: var(--burgundy-light); color: var(--burgundy-darkest); font-size: 0.85rem; font-weight: 600;">
                            <i class="fas fa-map-marker-alt text-danger me-1"></i> Kampus UNUJA Paiton
                        </span>
                        <span class="badge px-3 py-2" style="background: var(--burgundy-light); color: var(--burgundy-darkest); font-size: 0.85rem; font-weight: 600;">
                            <i class="fas fa-calendar-alt text-primary me-1"></i> Berdiri Sejak 2020
                        </span>
                        <span class="badge px-3 py-2" style="background: var(--burgundy-light); color: var(--burgundy-darkest); font-size: 0.85rem; font-weight: 600;">
                            <i class="fas fa-check-circle text-success me-1"></i> Terakreditasi &amp; Terdaftar
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="tentang-stats-card p-4 p-md-5 rounded-4 shadow-sm" style="background: linear-gradient(135deg, #FFF7FA 0%, #F6E9EE 100%); border: 1px solid rgba(138, 49, 81, 0.2);">
                    <div class="text-center mb-4">
                        <div class="tentang-logo-wrap mx-auto mb-3">
                            <img src="{{ !empty($profile->logo) ? asset('storage/' . $profile->logo) : asset('images/logo.png') }}" alt="Logo HIMATIKA UNUJA" class="tentang-org-logo">
                        </div>
                        <h4 class="fw-bold mb-1" style="color: var(--burgundy-darkest);">HIMATIKA UNUJA</h4>
                        <p class="text-muted small mb-0">Universitas Nurul Jadid • Paiton, Probolinggo</p>
                    </div>

                    <div class="row g-3 text-center">
                        <div class="col-4">
                            <div class="p-3 bg-white rounded-3 shadow-xs h-100 border">
                                <div class="fw-extrabold" style="font-size: 1.7rem; color: var(--burgundy-main);">{{ $statsPengurus ?? 68 }}</div>
                                <div class="small fw-semibold text-muted" style="font-size: 0.76rem;">PENGURUS AKTIF</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 bg-white rounded-3 shadow-xs h-100 border">
                                <div class="fw-extrabold" style="font-size: 1.7rem; color: var(--burgundy-main);">{{ $statsBidang ?? 6 }}</div>
                                <div class="small fw-semibold text-muted" style="font-size: 0.76rem;">DIVISI UTAMA</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 bg-white rounded-3 shadow-xs h-100 border">
                                <div class="fw-extrabold" style="font-size: 1.7rem; color: var(--burgundy-main);">{{ $statsBiro ?? 4 }}</div>
                                <div class="small fw-semibold text-muted" style="font-size: 0.76rem;">BIRO ORGANISASI</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top text-center">
                        <p class="small text-muted mb-0">
                            <i class="fas fa-quote-left text-muted me-1"></i>
                            <em>"Menjadikan setiap baris kode sebagai ladang ibadah, inovasi, dan kemaslahatan ummat."</em>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== SECTION 2: SAMBUTAN DOSEN / KAPRODI ==================== --}}
<section class="py-5" style="background: var(--burgundy-lightest); border-top: 1px solid rgba(138, 49, 81, 0.1); border-bottom: 1px solid rgba(138, 49, 81, 0.1);">
    <div class="container">
        @php
            $kaprodiName = !empty($siteSettings['sambutan_name']) ? $siteSettings['sambutan_name'] : ($kaprodi->name ?? 'MUDAKKIR, S.Pd., MM.');
            $kaprodiRole = !empty($siteSettings['sambutan_title']) ? $siteSettings['sambutan_title'] : ($kaprodi->position ?? 'Ketua Program Studi');
            $kaprodiQuote = !empty($siteSettings['sambutan_quote']) ? $siteSettings['sambutan_quote'] : 'Mewujudkan generasi mahasiswa Informatika yang berdaya saing tinggi, berakhlak mulia, dan siap berkontribusi nyata dalam perkembangan teknologi masa depan.';
            $kaprodiContent = !empty($siteSettings['sambutan_content']) ? $siteSettings['sambutan_content'] : ($profile->sambutan_content ?? 'Puji syukur ke hadirat Allah SWT atas limpahan rahmat dan hidayah-Nya. Keberadaan HIMATIKA UNUJA menjadi episentrum akselerasi talenta muda digital mahasiswa Informatika.');
            
            $kaprodiPhoto = null;
            if (!empty($siteSettings['sambutan_photo']) && file_exists(public_path('storage/' . $siteSettings['sambutan_photo']))) {
                $kaprodiPhoto = asset('storage/' . $siteSettings['sambutan_photo']);
            } elseif ($kaprodi && $kaprodi->photo && file_exists(public_path('storage/' . $kaprodi->photo))) {
                $kaprodiPhoto = asset('storage/' . $kaprodi->photo);
            } else {
                $kaprodiPhoto = asset('storage/profile/sambutan_1794400568_4jRmDkAS3by8fJdumt7yXqA03XvRNJdCIiK1z8KM.png');
            }
        @endphp

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff; border: 1px solid rgba(138, 49, 81, 0.15) !important;">
            <div class="row g-0 align-items-center">
                <div class="col-lg-4 col-md-5 text-center p-4 p-lg-5" style="background: linear-gradient(180deg, #F6E9EE 0%, #FFFFFF 100%);">
                    <div class="sambutan-portrait-frame-lg mx-auto mb-3">
                        <img src="{{ $kaprodiPhoto }}" alt="{{ $kaprodiName }}" class="sambutan-portrait-img">
                    </div>
                    <span class="badge px-3 py-1 mb-2" style="background: var(--burgundy-main); color: #fff; font-size: 0.75rem; letter-spacing: 1px;">
                        {{ $siteSettings['sambutan_badge'] ?? 'PESAN PIMPINAN' }}
                    </span>
                    <h4 class="fw-bold mb-1" style="color: var(--burgundy-darkest); font-size: 1.15rem;">{{ $kaprodiName }}</h4>
                    <p class="text-muted small mb-0">{{ $kaprodiRole }}</p>
                </div>
                <div class="col-lg-8 col-md-7 p-4 p-lg-5">
                    <div class="sambutan-lead-quote mb-4 p-3 rounded-3" style="background: var(--burgundy-light); border-left: 4px solid var(--burgundy-accent);">
                        <p class="mb-0 fw-medium fst-italic" style="color: var(--burgundy-darkest); font-size: 1.05rem;">
                            “{{ $kaprodiQuote }}”
                        </p>
                    </div>
                    <div class="sambutan-body-text mb-4" style="color: #4A303D; line-height: 1.8; font-size: 0.95rem;">
                        {!! nl2br(e($kaprodiContent)) !!}
                    </div>
                    <div class="d-flex align-items-center justify-content-between pt-3 border-top flex-wrap gap-2">
                        <div class="small text-muted">
                            <i class="fas fa-check-circle text-success me-1"></i> Pesan Resmi Program Studi Informatika UNUJA
                        </div>
                        <a href="{{ route('sambutan') }}" class="btn btn-sm px-3 py-2 rounded-pill fw-semibold text-white" style="background: var(--burgundy-accent);">
                            Baca Sambutan Penuh <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== SECTION 3: VISI & MISI TERPADU ==================== --}}
<section class="py-5" style="background: #ffffff;">
    <div class="container">
        <div class="text-center mb-5">
            <div class="tentang-top-label mb-2 justify-content-center">
                <span class="tentang-label-bar"></span>
                <span>PEDOMAN STRATEGIS</span>
                <span class="tentang-label-bar"></span>
            </div>
            <h2 class="fw-bold" style="color: var(--burgundy-darkest); font-size: clamp(1.6rem, 3vw, 2.2rem);">
                Visi &amp; Misi HIMATIKA UNUJA
            </h2>
            <p class="text-muted mx-auto" style="max-width: 650px;">
                Landasan cita-cita, arah perjuangan, dan komitmen aksi nyata dalam memajukan peradaban teknologi di kalangan mahasiswa.
            </p>
        </div>

        <div class="row g-4 align-items-stretch">
            {{-- Kartu Visi --}}
            <div class="col-lg-5">
                <div class="h-100 p-4 p-md-5 rounded-4 shadow-sm d-flex flex-column justify-content-between" style="background: linear-gradient(135deg, #250D17 0%, #641D38 100%); color: #FFF7FA;">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge px-3 py-1 text-uppercase" style="background: #E5A93C; color: #250D17; font-weight: 700; font-size: 0.78rem; letter-spacing: 1px;">
                                VISI UTAMA
                            </span>
                            <span class="small text-white-50"><i class="fas fa-compass text-warning me-1"></i> Kompas Gerak</span>
                        </div>
                        <h3 class="fw-bold mb-4 text-white" style="font-size: 1.45rem;">Arah &amp; Cita-cita Strategis</h3>
                        <div class="vm-quote-wrap mb-4">
                            <i class="fas fa-quote-left fa-2x mb-3 text-warning opacity-75"></i>
                            <p class="lead fw-medium mb-0" style="color: #FFF7FA; font-size: 1.15rem; line-height: 1.65;">
                                “{{ $vm->vision ?? 'Menjadi himpunan mahasiswa Informatika yang unggul, inovatif, berdaya saing global, dan berintegritas tinggi berlandaskan nilai-nilai kepesantrenan Universitas Nurul Jadid.' }}”
                            </p>
                        </div>
                    </div>
                    <div class="pt-3 border-top border-white-50 d-flex align-items-center justify-content-between">
                        <small class="text-white-50">Periode 2026 - Synchronized Growth</small>
                        <i class="fas fa-award text-warning"></i>
                    </div>
                </div>
            </div>

            {{-- Kartu Misi --}}
            <div class="col-lg-7">
                <div class="h-100 p-4 p-md-5 rounded-4 shadow-sm border" style="background: #FFF7FA; border-color: rgba(138, 49, 81, 0.2) !important;">
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <span class="badge px-3 py-1 text-uppercase" style="background: var(--burgundy-main); color: #FFF7FA; font-weight: 700; font-size: 0.78rem; letter-spacing: 1px;">
                            MISI ORGANISASI
                        </span>
                        <span class="small text-muted"><i class="fas fa-tasks text-primary me-1"></i> Aksi Nyata &amp; Program Kerja</span>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        @foreach($missions as $idx => $m)
                            <div class="d-flex align-items-start gap-3 p-3 bg-white rounded-3 border shadow-xs">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold text-white flex-shrink-0" style="width: 28px; height: 28px; background: var(--burgundy-accent); font-size: 0.85rem;">
                                    {{ $idx + 1 }}
                                </span>
                                <span class="fw-medium" style="color: var(--burgundy-text); font-size: 0.95rem; line-height: 1.5;">
                                    {{ $m }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== SECTION 4: KILAS SEJARAH & ID CARD TEASER ==================== --}}
<section class="py-5" style="background: var(--burgundy-lightest); border-top: 1px solid rgba(138, 49, 81, 0.1);">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <div class="pe-lg-4">
                    <div class="tentang-top-label mb-2">
                        <span class="tentang-label-bar"></span>
                        <span>JEJAK PERJALANAN</span>
                    </div>
                    <h2 class="fw-bold mb-3" style="color: var(--burgundy-darkest); font-size: clamp(1.6rem, 3vw, 2.2rem);">
                        Kilas Sejarah &amp; Kartu Tanda Anggota (ID Card)
                    </h2>
                    <p class="text-muted mb-4" style="line-height: 1.7;">
                        HIMATIKA UNUJA tumbuh dari semangat kolaboratif mahasiswa perdana Informatika dalam membangun wadah representasi akademis, pengembangan minat bakat perangkat lunak, dan pengabdian masyarakat berbasis komputasi.
                    </p>

                    {{-- Timeline preview --}}
                    <div class="timeline-teaser mb-4">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <span class="badge py-1 px-2 rounded" style="background: var(--burgundy-main); color: #fff;">2020</span>
                            <div>
                                <strong style="color: var(--burgundy-darkest);">Pendirian HIMATIKA UNUJA</strong>
                                <p class="small text-muted mb-0">Didirikan oleh angkatan perdana Program Studi Informatika Universitas Nurul Jadid.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <span class="badge py-1 px-2 rounded" style="background: var(--burgundy-main); color: #fff;">2024</span>
                            <div>
                                <strong style="color: var(--burgundy-darkest);">Inovasi Galeri Website &amp; Karya Digital</strong>
                                <p class="small text-muted mb-0">Peluncuran wadah showcase karya web mahasiswa dan penguatan riset aplikasi.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3">
                            <span class="badge py-1 px-2 rounded" style="background: var(--burgundy-main); color: #fff;">2026</span>
                            <div>
                                <strong style="color: var(--burgundy-darkest);">Synchronized Growth, Reaching New Heights</strong>
                                <p class="small text-muted mb-0">Transformasi tata kelola modern, digitalisasi ID Card keanggotaan terintegrasi.</p>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('sejarah') }}" class="btn px-4 py-2 rounded-pill fw-semibold text-white shadow-sm" style="background: var(--burgundy-main);">
                        <i class="fas fa-book-reader me-1"></i> Baca Sejarah Lengkap &amp; Info ID Card
                    </a>
                </div>
            </div>

            <div class="col-lg-5">
                {{-- ID Card Mockup Preview Card --}}
                <div class="p-4 rounded-4 shadow-sm border bg-white text-center">
                    <span class="badge px-3 py-1 mb-3" style="background: var(--burgundy-light); color: var(--burgundy-main); font-weight: 700; font-size: 0.75rem;">
                        IDENTITAS RESMI MAHASISWA
                    </span>
                    <h5 class="fw-bold mb-2" style="color: var(--burgundy-darkest);">Kartu Tanda Anggota (ID Card)</h5>
                    <p class="small text-muted mb-3">
                        Setiap anggota resmi HIMATIKA UNUJA dibekali kartu identitas pintar dengan NIA resmi dan akses hak suara organisasi.
                    </p>

                    <div class="id-card-preview-box p-3 rounded-3 text-start mx-auto mb-3" style="max-width: 320px; background: linear-gradient(135deg, #250D17 0%, #641D38 100%); color: #FFF7FA; border: 1px solid #E5A93C;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="font-size: 0.68rem; letter-spacing: 1px; color: #E5A93C; font-weight: 700;">HIMATIKA UNUJA</span>
                            <i class="fas fa-microchip text-warning"></i>
                        </div>
                        <div class="fw-bold text-white" style="font-size: 0.95rem;">KARTU TANDA ANGGOTA</div>
                        <div class="small text-white-50" style="font-size: 0.72rem;">INFORMATIKA • UNIVERSITAS NURUL JADID</div>
                        <div class="mt-3 pt-2 border-top border-white-50 d-flex justify-content-between align-items-end">
                            <div>
                                <div class="text-white fw-bold" style="font-size: 0.8rem;">AHMAD FAIZAL EFENDI</div>
                                <div class="text-white-50" style="font-size: 0.7rem;">NIA.2024.IF.048</div>
                            </div>
                            <i class="fas fa-qrcode text-white" style="font-size: 1.4rem;"></i>
                        </div>
                    </div>

                    <a href="{{ route('sejarah') }}#id-card" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                        Pelajari Spesifikasi &amp; Hak Anggota <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== SECTION 5: NILAI-NILAI ORGANISASI ==================== --}}
<section class="py-5" style="background: #ffffff;">
    <div class="container">
        <div class="text-center mb-5">
            <div class="tentang-top-label mb-2 justify-content-center">
                <span class="tentang-label-bar"></span>
                <span>BUDAYA &amp; KARAKTER</span>
                <span class="tentang-label-bar"></span>
            </div>
            <h2 class="fw-bold" style="color: var(--burgundy-darkest); font-size: clamp(1.6rem, 3vw, 2.2rem);">
                4 Nilai Utama Mahasiswa Informatika
            </h2>
            <p class="text-muted mx-auto" style="max-width: 650px;">
                Nilai luhur yang menjadi pedoman etika, inovasi, dan pergaulan seluruh civitas akademika HIMATIKA UNUJA.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="p-4 rounded-4 h-100 border text-center shadow-xs" style="background: var(--burgundy-lightest); border-color: rgba(138, 49, 81, 0.15) !important;">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 58px; height: 58px; background: var(--burgundy-light); color: var(--burgundy-main); font-size: 1.4rem;">
                        <i class="fas fa-mosque"></i>
                    </div>
                    <h5 class="fw-bold mb-2" style="color: var(--burgundy-darkest);">Integritas Pesantren</h5>
                    <p class="small text-muted mb-0">
                        Menjunjung tinggi adab, akhlakul karimah, kejujuran intelektual, dan kesantunan dalam setiap karya teknologi.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="p-4 rounded-4 h-100 border text-center shadow-xs" style="background: var(--burgundy-lightest); border-color: rgba(138, 49, 81, 0.15) !important;">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 58px; height: 58px; background: var(--burgundy-light); color: var(--burgundy-main); font-size: 1.4rem;">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h5 class="fw-bold mb-2" style="color: var(--burgundy-darkest);">Inovasi Digital</h5>
                    <p class="small text-muted mb-0">
                        Terus bereksplorasi menciptakan solusi teknologi perangkat lunak yang relevan dengan perkembangan industri global.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="p-4 rounded-4 h-100 border text-center shadow-xs" style="background: var(--burgundy-lightest); border-color: rgba(138, 49, 81, 0.15) !important;">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 58px; height: 58px; background: var(--burgundy-light); color: var(--burgundy-main); font-size: 1.4rem;">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h5 class="fw-bold mb-2" style="color: var(--burgundy-darkest);">Solidaritas Kolaboratif</h5>
                    <p class="small text-muted mb-0">
                        Mengedepankan gotong royong, kebersamaan, dan saling mendukung tanpa membedakan latar belakang.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="p-4 rounded-4 h-100 border text-center shadow-xs" style="background: var(--burgundy-lightest); border-color: rgba(138, 49, 81, 0.15) !important;">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 58px; height: 58px; background: var(--burgundy-light); color: var(--burgundy-main); font-size: 1.4rem;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h5 class="fw-bold mb-2" style="color: var(--burgundy-darkest);">Keunggulan Akademik</h5>
                    <p class="small text-muted mb-0">
                        Berkomitmen tinggi dalam pencapaian prestasi akademik, riset teknologi, dan kompetisi di tingkat nasional.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== SECTION 6: STRUKTUR ORGANISASI PREVIEW & CTA ==================== --}}
<section class="py-5" style="background: linear-gradient(135deg, #250D17 0%, #641D38 100%); color: #FFF7FA;">
    <div class="container text-center py-4">
        <span class="badge px-3 py-1 mb-3 rounded-pill" style="background: rgba(255, 255, 255, 0.15); color: #FFF7FA; letter-spacing: 1.2px; font-size: 0.78rem;">
            TATA KELOLA KEPENGURUSAN
        </span>
        <h2 class="fw-bold mb-3 text-white" style="font-size: clamp(1.7rem, 3.2vw, 2.4rem);">
            Struktur Kepengurusan HIMATIKA UNUJA
        </h2>
        <p class="text-white-50 mx-auto mb-4" style="max-width: 640px; font-size: 1rem; line-height: 1.7;">
            Dikelola oleh insan-insan muda berdedikasi tinggi yang terbagi dalam divisi dan biro fungsional guna melayani seluruh mahasiswa Informatika UNUJA.
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('struktur-organisasi') }}" class="btn px-4 py-2 rounded-pill fw-semibold text-white shadow-sm" style="background: var(--burgundy-accent); font-size: 0.95rem;">
                <i class="fas fa-sitemap me-1"></i> Buka Bagan Struktur Lengkap
            </a>
            <a href="{{ route('pengurus') }}" class="btn btn-outline-light px-4 py-2 rounded-pill fw-semibold" style="font-size: 0.95rem;">
                <i class="fas fa-users me-1"></i> Daftar Pengurus Aktif
            </a>
            <a href="{{ route('kontak') }}" class="btn btn-light px-4 py-2 rounded-pill fw-semibold" style="color: var(--burgundy-darkest); font-size: 0.95rem;">
                <i class="fas fa-envelope me-1"></i> Hubungi Kami
            </a>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* Styling Khusus Halaman Tentang Kami */
    .tentang-page-hero {
        position: relative;
        background: linear-gradient(135deg, #250D17 0%, #641D38 60%, #8A3151 100%);
        padding: 85px 0 65px;
        color: #FFF7FA;
        overflow: hidden;
    }
    .tentang-hero-overlay {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 80% 20%, rgba(229, 169, 60, 0.15), transparent 40%),
                    radial-gradient(circle at 15% 85%, rgba(138, 49, 81, 0.25), transparent 50%);
        pointer-events: none;
    }
    .tentang-hero-pill {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #FFF7FA;
        font-size: 0.78rem;
        letter-spacing: 1.2px;
        font-weight: 700;
    }
    .tentang-hero-title {
        font-size: clamp(2.2rem, 4.5vw, 3.4rem);
        font-weight: 800;
        letter-spacing: -0.5px;
        color: #FFF7FA;
        margin-bottom: 1rem;
    }
    .tentang-hero-subtitle {
        font-size: clamp(1rem, 2vw, 1.2rem);
        color: rgba(255, 247, 250, 0.85);
        line-height: 1.6;
        max-width: 720px;
        margin: 0 auto;
    }
    .btn-tentang-hero-primary {
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
    .btn-tentang-hero-primary:hover {
        background: #f1b74f;
        color: #250D17;
        transform: translateY(-2px);
    }
    .btn-tentang-hero-outline {
        display: inline-flex;
        align-items: center;
        padding: 12px 28px;
        border-radius: 9999px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.35);
        color: #FFF7FA;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
        min-height: 46px;
    }
    .btn-tentang-hero-outline:hover {
        background: #FFF7FA;
        color: var(--burgundy-darkest);
        transform: translateY(-2px);
    }

    .tentang-top-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        color: var(--burgundy-accent);
        text-transform: uppercase;
    }
    .tentang-label-bar {
        display: inline-block;
        width: 24px;
        height: 3px;
        border-radius: 2px;
        background: var(--burgundy-accent);
    }

    .tentang-org-logo {
        width: 82px;
        height: 82px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #ffffff;
        box-shadow: 0 4px 14px rgba(100, 29, 56, 0.15);
    }

    .sambutan-portrait-frame-lg {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        padding: 4px;
        background: linear-gradient(135deg, var(--burgundy-main) 0%, #E5A93C 100%);
        box-shadow: 0 8px 24px rgba(100, 29, 56, 0.2);
    }
    .sambutan-portrait-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        background: #ffffff;
    }

    @media (max-width: 767.98px) {
        .tentang-page-hero {
            padding: 55px 0 45px;
        }
        .btn-tentang-hero-primary,
        .btn-tentang-hero-outline {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush
