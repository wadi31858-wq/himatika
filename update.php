<?php
$content = file_get_contents('resources/views/home.blade.php');
$start = strpos($content, '{{-- ==================== BAGIAN 4: LAYANAN MAHASISWA (Akademik) ==================== --}}');
$end = strpos($content, '{{-- ==================== BAGIAN 3: KABAR TERBARU ==================== --}}');

$newHtml = <<<HTML
{{-- ==================== BAGIAN 4: LAYANAN MAHASISWA (Terpadu) ==================== --}}
<section class="section-cream" id="layanan-mahasiswa">
    <div class="container position-relative">
        <div class="row align-items-start justify-content-between mb-5">
            <div class="col-lg-6">
                <span class="section-label">LAYANAN MAHASISWA</span>
                <h2 class="section-title">Akses yang paling<br>sering dibutuhkan.</h2>
            </div>
            <div class="col-lg-auto mt-4 mt-lg-0">
                <div class="floating-help-card">
                    <span class="floating-help-title">Butuh bantuan?</span>
                    <a href="{{ route('kontak') }}" class="floating-help-link">Hubungi kami <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        {{-- Subheader Akademik --}}
        <div class="service-subheader mt-0">
            <span class="service-subheader-text">AKADEMIK</span>
            <div class="service-subheader-line"></div>
        </div>
        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('download') }}" class="text-decoration-none">
                    <div class="service-card new-service-card">
                        <div class="service-card-watermark">&sum;</div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="service-card-badge">01</span>
                            <h3 class="service-card-title mb-0">Bank Soal</h3>
                        </div>
                        <p class="service-card-desc">Kumpulan soal dan bahan belajar mahasiswa.</p>
                        <div class="service-card-btn-wrap">
                            <div class="service-card-btn"><i class="fas fa-arrow-right"></i></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('download') }}" class="text-decoration-none">
                    <div class="service-card new-service-card">
                        <div class="service-card-watermark">&pi;</div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="service-card-badge">02</span>
                            <h3 class="service-card-title mb-0">Buku MODUS</h3>
                        </div>
                        <p class="service-card-desc">Modul pendamping belajar Matematika.</p>
                        <div class="service-card-btn-wrap">
                            <div class="service-card-btn"><i class="fas fa-arrow-right"></i></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('download') }}" class="text-decoration-none">
                    <div class="service-card new-service-card">
                        <div class="service-card-watermark">&infin;</div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="service-card-badge">03</span>
                            <h3 class="service-card-title mb-0">Aksioma</h3>
                        </div>
                        <p class="service-card-desc">Arsip publikasi dan karya mahasiswa.</p>
                        <div class="service-card-btn-wrap">
                            <div class="service-card-btn"><i class="fas fa-arrow-right"></i></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        {{-- Subheader Informasi dan Database --}}
        <div class="service-subheader">
            <span class="service-subheader-text">INFORMASI DAN DATABASE</span>
            <div class="service-subheader-line"></div>
        </div>
        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('agenda') }}" class="text-decoration-none">
                    <div class="service-card new-service-card">
                        <div class="service-card-watermark">&int;</div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="service-card-badge">01</span>
                            <h3 class="service-card-title mb-0">Kalender HIMATIKA</h3>
                        </div>
                        <p class="service-card-desc">Agenda organisasi dan tanggal penting.</p>
                        <div class="service-card-btn-wrap">
                            <div class="service-card-btn"><i class="fas fa-arrow-right"></i></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('pengurus') }}" class="text-decoration-none">
                    <div class="service-card new-service-card">
                        <div class="service-card-watermark">&Delta;</div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="service-card-badge">02</span>
                            <h3 class="service-card-title mb-0">Database Mahasiswa</h3>
                        </div>
                        <p class="service-card-desc">Akses layanan data mahasiswa.</p>
                        <div class="service-card-btn-wrap">
                            <div class="service-card-btn"><i class="fas fa-arrow-right"></i></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('struktur-organisasi') }}" class="text-decoration-none">
                    <div class="service-card new-service-card">
                        <div class="service-card-watermark">&radic;</div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="service-card-badge">03</span>
                            <h3 class="service-card-title mb-0">Database Alumni</h3>
                        </div>
                        <p class="service-card-desc">Jejaring dan informasi alumni.</p>
                        <div class="service-card-btn-wrap">
                            <div class="service-card-btn"><i class="fas fa-arrow-right"></i></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        {{-- Subheader Layanan Mahasiswa --}}
        <div class="service-subheader">
            <span class="service-subheader-text">LAYANAN MAHASISWA</span>
            <div class="service-subheader-line"></div>
        </div>
        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('aspirasi.index') }}" class="text-decoration-none">
                    <div class="service-card new-service-card">
                        <div class="service-card-watermark">&sum;</div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="service-card-badge">01</span>
                            <h3 class="service-card-title mb-0">Aspirasi Mahasiswa</h3>
                        </div>
                        <p class="service-card-desc">Sampaikan aspirasi melalui kanal resmi.</p>
                        <div class="service-card-btn-wrap">
                            <div class="service-card-btn"><i class="fas fa-arrow-right"></i></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('profil') }}" class="text-decoration-none">
                    <div class="service-card new-service-card">
                        <div class="service-card-watermark">&pi;</div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="service-card-badge">02</span>
                            <h3 class="service-card-title mb-0">Matematika Peduli</h3>
                        </div>
                        <p class="service-card-desc">Gerakan solidaritas mahasiswa Matematika.</p>
                        <div class="service-card-btn-wrap">
                            <div class="service-card-btn"><i class="fas fa-arrow-right"></i></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

HTML;

$p1 = substr($content, 0, $start);
$p2 = substr($content, $end);
file_put_contents('resources/views/home.blade.php', $p1 . $newHtml . $p2);
