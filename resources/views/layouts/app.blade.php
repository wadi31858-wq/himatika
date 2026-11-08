<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda') - HIMATIKA UNUJA 2026</title>
    <meta name="description" content="@yield('description', 'Website resmi HIMATIKA FMIPA Universitas Nahdlatul Ulama Jember - Himpunan Mahasiswa Matematika')">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    {{-- ==================== NAVBAR ==================== --}}
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand navbar-brand-custom" href="{{ route('home') }}">
                <span class="brand-logo">
                    @if($globalProfile && $globalProfile->logo)
                        <img src="{{ asset('storage/' . $globalProfile->logo) }}" alt="Logo HIMATIKA" style="width: 100%; height: 100%; object-fit: contain;">
                    @else
                        <i class="fas fa-infinity" style="color: #1565C0;"></i>
                    @endif
                </span>
                <span class="brand-text">
                    <span class="brand-name">HIMATIKA UNUJA 2026</span>
                    <span class="brand-tagline">Synchronized Growth, Reaching New Heights</span>
                    <span class="brand-accent-line"></span>
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}"><i class="fas fa-home me-1"></i> Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}" href="{{ route('profil') }}"><i class="fas fa-circle-info me-1"></i> Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('struktur-organisasi') ? 'active' : '' }}" href="{{ route('struktur-organisasi') }}"><i class="fas fa-sitemap me-1"></i> Struktur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('agenda') ? 'active' : '' }}" href="{{ route('agenda') }}"><i class="fas fa-calendar-alt me-1"></i> Agenda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('berita*') ? 'active' : '' }}" href="{{ route('berita') }}"><i class="fas fa-newspaper me-1"></i> Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('galeri') ? 'active' : '' }}" href="{{ route('galeri') }}"><i class="fas fa-images me-1"></i> Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('download') ? 'active' : '' }}" href="{{ route('download') }}"><i class="fas fa-file-alt me-1"></i> Dokumen</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="nav-link btn-nav-aspirasi {{ request()->routeIs('aspirasi*') ? 'active' : '' }}" href="{{ route('aspirasi.index') }}">
                            <i class="fas fa-paper-plane"></i> Kirim Aspirasi
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    {{-- ==================== FOOTER ==================== --}}
    <footer class="footer-custom">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center mb-3">
                        <span class="brand-logo-footer">
                            @if($globalProfile && $globalProfile->logo)
                                <img src="{{ asset('storage/' . $globalProfile->logo) }}" alt="Logo" style="width: 40px; height: 40px; object-fit: contain; filter: brightness(0) invert(1);">
                            @else
                                <i class="fas fa-infinity"></i>
                            @endif
                        </span>
                        <div class="brand-text-footer">
                            <span class="brand-name-footer">HIMATIKA FMIPA UNUJA</span>
                            <span class="brand-period-footer">HIMATIKA UNUJA 2026</span>
                        </div>
                    </div>
                    <p class="footer-desc">Website resmi HIMATIKA FMIPA UNUJA periode 2026.</p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="footer-social"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="footer-social"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="footer-social"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="footer-social"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <h5 class="footer-heading">NAVIGASI</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('profil') }}">Tentang</a></li>
                        <li><a href="{{ route('profil') }}#sejarah">Sejarah</a></li>
                        <li><a href="{{ route('struktur-organisasi') }}">Struktur</a></li>
                        <li><a href="{{ route('agenda') }}">Agenda</a></li>
                        <li><a href="{{ route('berita') }}">Berita</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5 class="footer-heading">LAYANAN</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ route('galeri') }}">Galeri</a></li>
                        <li><a href="{{ route('download') }}">Dokumen</a></li>
                        <li><a href="{{ route('download') }}">Aksioma</a></li>
                        <li><a href="{{ route('download') }}">Bank Soal</a></li>
                        <li><a href="{{ route('download') }}">MODUS</a></li>
                        <li><a href="{{ route('aspirasi.index') }}">Kirim Aspirasi</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5 class="footer-heading">TEMUI KAMI</h5>
                    <p class="footer-contact-text">Sekretariat HIMATIKA UNUJA</p>
                    <p class="footer-contact-text"><a href="mailto:himatika@unuja.ac.id">himatika@unuja.ac.id</a></p>
                    <div class="footer-map-placeholder mt-3">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.1234567890!2d113.1234567890!3d-7.1234567890!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDcnMjQuNCJTIDExM8KwMDcnMjQuNCJF!5e0!3m2!1sid!2sid!4v1234567890" width="100%" height="120" style="border:0; border-radius: 8px;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                    <a href="#" class="footer-map-link mt-2 d-inline-block">Buka peta &rarr;</a>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <span>&copy; 2026 HIMATIKA UNUJA 2026.</span>
                    <span class="footer-tagline">Synchronized Growth, Reaching New Heights.</span>
                    <span>Dikelola oleh Tim Website HIMATIKA</span>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('mainNav');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });
        
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
        });
    </script>
    @stack('scripts')
</body>
</html>
