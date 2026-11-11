<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda') - {{ $globalProfile->title ?? 'HIMATIKA UNUJA 2026' }}</title>
    <meta name="description" content="@yield('description', $globalProfile->meta_description ?? 'Website resmi HIMATIKA FMIPA Universitas Nurul Jadid - Himpunan Mahasiswa Matematika')">
    @if(!empty($siteSettings['site_meta_keywords']))
        <meta name="keywords" content="{{ $siteSettings['site_meta_keywords'] }}">
    @endif

    <!-- Dynamic Favicon -->
    @php
        $publicFavicon = null;
        if (($siteSettings['favicon_custom'] ?? '0') === '1' && !empty($siteSettings['favicon_file'])) {
            $publicFavicon = asset('storage/' . $siteSettings['favicon_file']);
        } elseif (!empty($siteSettings['main_favicon'])) {
            $publicFavicon = asset('storage/' . $siteSettings['main_favicon']);
        } elseif ($globalProfile && $globalProfile->favicon) {
            $publicFavicon = asset('storage/' . $globalProfile->favicon);
        }
    @endphp
    @if($publicFavicon)
        <link rel="icon" type="image/x-icon" href="{{ $publicFavicon }}">
        <link rel="shortcut icon" href="{{ $publicFavicon }}">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}" rel="stylesheet">
    @stack('styles')
    <style>
        /* ==================== DROPDOWNS (TENTANG & INFORMASI) ==================== */
        .tentang-dropdown-wrapper,
        .informasi-dropdown-wrapper {
            position: relative;
        }
        .tentang-dropdown-toggle-btn,
        .informasi-dropdown-toggle-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            font-family: inherit;
            color: #1e293b !important;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.45rem 1rem !important;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 9999px;
            transition: all 0.25s ease;
            outline: none;
        }
        .tentang-dropdown-toggle-btn:hover,
        .tentang-dropdown-toggle-btn:focus-visible,
        .informasi-dropdown-toggle-btn:hover,
        .informasi-dropdown-toggle-btn:focus-visible {
            color: #711C35 !important;
            background: rgba(113, 28, 53, 0.06);
        }
        .tentang-dropdown-wrapper.active .tentang-dropdown-toggle-btn,
        .tentang-dropdown-toggle-btn.active,
        .informasi-dropdown-wrapper.active .informasi-dropdown-toggle-btn,
        .informasi-dropdown-toggle-btn.active {
            color: #ffffff !important;
            background: #711C35 !important;
            font-weight: 600;
            padding: 0.45rem 1.4rem !important;
            box-shadow: 0 4px 12px rgba(113, 28, 53, 0.25);
        }
        .tentang-dropdown-wrapper.show .tentang-dropdown-toggle-btn:not(.active),
        .informasi-dropdown-wrapper.show .informasi-dropdown-toggle-btn:not(.active) {
            color: #711C35 !important;
            background: rgba(113, 28, 53, 0.08);
        }
        .tentang-chevron,
        .informasi-chevron {
            font-size: 0.72rem;
            transition: transform 0.25s ease;
            margin-left: 2px;
        }
        .tentang-dropdown-wrapper.show .tentang-chevron,
        .informasi-dropdown-wrapper.show .informasi-chevron {
            transform: rotate(180deg);
        }
        .tentang-dropdown-menu,
        .informasi-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 220px;
            background: #1A0A0F;
            border: 1px solid #711C35;
            border-radius: 12px;
            padding: 8px;
            margin: 6px 0 0 0;
            list-style: none;
            box-shadow: 0 10px 28px rgba(26, 10, 15, 0.35);
            display: none;
            flex-direction: column;
            gap: 4px;
            z-index: 1050;
        }
        .tentang-dropdown-wrapper.show .tentang-dropdown-menu,
        .informasi-dropdown-wrapper.show .informasi-dropdown-menu {
            display: flex;
        }
        .tentang-dropdown-item,
        .informasi-dropdown-item {
            display: block;
            padding: 8px 14px;
            color: #FFFFFF;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .tentang-dropdown-item:hover,
        .tentang-dropdown-item:focus,
        .informasi-dropdown-item:hover,
        .informasi-dropdown-item:focus {
            background: rgba(255, 255, 255, 0.12);
            color: #F4D6DE;
            padding-left: 18px;
            outline: none;
        }
        .tentang-dropdown-item.active,
        .informasi-dropdown-item.active {
            background: #711C35;
            color: #FFFFFF;
            font-weight: 600;
            border-left: 3px solid #A33B59;
        }
        @media (max-width: 991.98px) {
            .tentang-dropdown-wrapper,
            .informasi-dropdown-wrapper {
                width: 100%;
            }
            .tentang-dropdown-toggle-btn,
            .informasi-dropdown-toggle-btn {
                width: 100%;
                justify-content: space-between;
                padding: 0.75rem 1rem !important;
                border-radius: 8px;
            }
            .tentang-dropdown-menu,
            .informasi-dropdown-menu {
                position: static;
                width: 100%;
                background: #1A0A0F;
                border-radius: 8px;
                box-shadow: none;
                margin-top: 4px;
                margin-bottom: 8px;
                padding: 6px;
            }
            .tentang-dropdown-wrapper.show .tentang-dropdown-menu,
            .informasi-dropdown-wrapper.show .informasi-dropdown-menu {
                display: flex;
            }
        }
    </style>
</head>
<body>
    {{-- ==================== NAVBAR ==================== --}}
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand navbar-brand-custom" href="{{ route('home') }}">
                <span class="brand-logo">
                    @php
                        $navLogo = null;
                        $navAlt = $siteSettings['logo_nav_desktop_alt'] ?? 'Logo HIMATIKA';
                        if (($siteSettings['logo_nav_desktop_custom'] ?? '0') === '1' && !empty($siteSettings['logo_nav_desktop_file'])) {
                            $navLogo = asset('storage/' . $siteSettings['logo_nav_desktop_file']);
                        } elseif (!empty($siteSettings['main_logo'])) {
                            $navLogo = asset('storage/' . $siteSettings['main_logo']);
                        } elseif ($globalProfile && $globalProfile->logo) {
                            $navLogo = asset('storage/' . $globalProfile->logo);
                        }
                    @endphp
                    @if($navLogo)
                        <img src="{{ $navLogo }}" alt="{{ $navAlt }}" style="width: 100%; height: 100%; object-fit: contain;">
                    @else
                        <i class="fas fa-infinity" style="color: #711C35;"></i>
                    @endif
                </span>
                <span class="brand-text">
                    <span class="brand-name">{{ $siteSettings['site_short_title'] ?? 'HIMATIKA' }} UNUJA 2026</span>
                    <span class="brand-tagline">{{ $globalProfile->motto ?? 'Synchronized Growth, Reaching New Heights' }}</span>
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
                    <li class="nav-item dropdown tentang-dropdown-wrapper {{ request()->routeIs('profil*', 'tentang*', 'sejarah*', 'sambutan*', 'visi-misi*', 'struktur-organisasi*') ? 'active' : '' }}">
                        <button type="button" class="nav-link tentang-dropdown-toggle-btn {{ request()->routeIs('profil*', 'tentang*', 'sejarah*', 'sambutan*', 'visi-misi*', 'struktur-organisasi*') ? 'active' : '' }}" id="tentangDropdownBtn" aria-expanded="false" aria-haspopup="true">
                            <i class="fas fa-circle-info me-1"></i>
                            <span>Tentang</span>
                            <i class="fas fa-chevron-down ms-1 tentang-chevron"></i>
                        </button>
                        <ul class="tentang-dropdown-menu" id="tentangDropdownMenu" aria-labelledby="tentangDropdownBtn">
                            <li>
                                <a class="tentang-dropdown-item {{ request()->routeIs('profil*') || request()->routeIs('tentang*') ? 'active' : '' }}" href="{{ request()->routeIs('home') ? '#tentang' : route('profil') }}">
                                    Profil HIMATIKA
                                </a>
                            </li>
                            <li>
                                <a class="tentang-dropdown-item {{ request()->routeIs('sejarah*') ? 'active' : '' }}" href="{{ route('sejarah') }}">
                                    Sejarah
                                </a>
                            </li>
                            <li>
                                <a class="tentang-dropdown-item {{ request()->routeIs('sambutan*') ? 'active' : '' }}" href="{{ route('sambutan') }}">
                                    Sambutan Kaprodi
                                </a>
                            </li>
                            <li>
                                <a class="tentang-dropdown-item {{ request()->routeIs('visi-misi*') ? 'active' : '' }}" href="{{ route('visi-misi') }}">
                                    Visi dan Misi
                                </a>
                            </li>
                            <li>
                                <a class="tentang-dropdown-item {{ request()->routeIs('struktur-organisasi*') ? 'active' : '' }}" id="navLinkStruktur" href="{{ route('struktur-organisasi') }}">
                                    Struktur Organisasi
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown informasi-dropdown-wrapper {{ request()->routeIs('berita*') ? 'active' : '' }}">
                        <button type="button" class="nav-link informasi-dropdown-toggle-btn {{ request()->routeIs('berita*') ? 'active' : '' }}" id="informasiDropdownBtn" aria-expanded="false" aria-haspopup="true">
                            <i class="fas fa-newspaper me-1"></i>
                            <span>Informasi</span>
                            <i class="fas fa-chevron-down ms-1 informasi-chevron"></i>
                        </button>
                        <ul class="informasi-dropdown-menu" id="informasiDropdownMenu" aria-labelledby="informasiDropdownBtn">
                            <li>
                                <a class="informasi-dropdown-item {{ request()->routeIs('berita*') && !request()->filled('category') ? 'active' : '' }}" href="{{ route('berita') }}" data-category="">
                                    Semua kategori
                                </a>
                            </li>
                            <li>
                                <a class="informasi-dropdown-item {{ request()->routeIs('berita*') && request('category') === 'Kegiatan' ? 'active' : '' }}" href="{{ route('berita', ['category' => 'Kegiatan']) }}" data-category="Kegiatan">
                                    Kegiatan
                                </a>
                            </li>
                            <li>
                                <a class="informasi-dropdown-item {{ request()->routeIs('berita*') && request('category') === 'Pengumuman' ? 'active' : '' }}" href="{{ route('berita', ['category' => 'Pengumuman']) }}" data-category="Pengumuman">
                                    Pengumuman
                                </a>
                            </li>
                            <li>
                                <a class="informasi-dropdown-item {{ request()->routeIs('berita*') && request('category') === 'Prestasi' ? 'active' : '' }}" href="{{ route('berita', ['category' => 'Prestasi']) }}" data-category="Prestasi">
                                    Prestasi
                                </a>
                            </li>
                            <li>
                                <a class="informasi-dropdown-item {{ request()->routeIs('berita*') && request('category') === 'Berita' ? 'active' : '' }}" href="{{ route('berita', ['category' => 'Berita']) }}" data-category="Berita">
                                    Berita
                                </a>
                            </li>
                            <li>
                                <a class="informasi-dropdown-item {{ request()->routeIs('berita*') && request('category') === 'Agenda' ? 'active' : '' }}" href="{{ route('berita', ['category' => 'Agenda']) }}" data-category="Agenda">
                                    Agenda
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('galeri*') ? 'active' : '' }}" href="{{ route('galeri') }}"><i class="fas fa-images me-1"></i> Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('download*') ? 'active' : '' }}" href="{{ route('download') }}"><i class="fas fa-file-alt me-1"></i> Dokumen</a>
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
                            @php
                                $footerLogo = null;
                                $footerAlt = $siteSettings['logo_footer_alt'] ?? 'Logo Footer HIMATIKA';
                                if (($siteSettings['logo_footer_custom'] ?? '0') === '1' && !empty($siteSettings['logo_footer_file'])) {
                                    $footerLogo = asset('storage/' . $siteSettings['logo_footer_file']);
                                } elseif (!empty($siteSettings['main_logo'])) {
                                    $footerLogo = asset('storage/' . $siteSettings['main_logo']);
                                } elseif ($globalProfile && $globalProfile->logo) {
                                    $footerLogo = asset('storage/' . $globalProfile->logo);
                                }
                            @endphp
                            @if($footerLogo)
                                <img src="{{ $footerLogo }}" alt="{{ $footerAlt }}" style="width: 40px; height: 40px; object-fit: contain;">
                            @else
                                <i class="fas fa-infinity"></i>
                            @endif
                        </span>
                        <div class="brand-text-footer">
                            <span class="brand-name-footer">{{ $globalProfile->title ?? 'HIMATIKA FMIPA UNUJA' }}</span>
                            <span class="brand-period-footer">HIMATIKA UNUJA 2026</span>
                        </div>
                    </div>
                    <p class="footer-desc">{{ $globalProfile->footer_text ?? 'Website resmi HIMATIKA FMIPA UNUJA periode 2026.' }}</p>
                    <div class="d-flex gap-3 mt-3">
                        @if($globalProfile && $globalProfile->instagram)
                            <a href="{{ $globalProfile->instagram }}" target="_blank" class="footer-social"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if($globalProfile && $globalProfile->tiktok)
                            <a href="{{ $globalProfile->tiktok }}" target="_blank" class="footer-social"><i class="fab fa-tiktok"></i></a>
                        @endif
                        @if($globalProfile && $globalProfile->facebook)
                            <a href="{{ $globalProfile->facebook }}" target="_blank" class="footer-social"><i class="fab fa-facebook"></i></a>
                        @endif
                        @if($globalProfile && $globalProfile->youtube)
                            <a href="{{ $globalProfile->youtube }}" target="_blank" class="footer-social"><i class="fab fa-youtube"></i></a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-2">
                    <h5 class="footer-heading">NAVIGASI</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('profil') }}">Tentang</a></li>
                        <li><a href="{{ route('sejarah') }}">Sejarah</a></li>
                        <li><a href="{{ route('struktur-organisasi') }}">Struktur</a></li>
                        <li><a href="{{ route('agenda') }}">Agenda</a></li>
                        <li><a href="{{ route('berita') }}">Informasi</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5 class="footer-heading">LAYANAN</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ route('galeri') }}">Galeri</a></li>
                        <li><a href="{{ route('download') }}">Galeri Website</a></li>
                        <li><a href="{{ route('prestasi') }}">Prestasi</a></li>
                        <li><a href="{{ route('kegiatan') }}">Kegiatan</a></li>
                        <li><a href="{{ route('pendaftaran.index') }}">Pendaftaran</a></li>
                        <li><a href="{{ route('aspirasi.index') }}">Kirim Aspirasi</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5 class="footer-heading">TEMUI KAMI</h5>
                    <p class="footer-contact-text">{{ $globalProfile->address ?? 'Sekretariat HIMATIKA UNUJA' }}</p>
                    <p class="footer-contact-text"><a href="mailto:{{ $globalProfile->email ?? 'himatika@unuja.ac.id' }}">{{ $globalProfile->email ?? 'himatika@unuja.ac.id' }}</a></p>
                    @php
                        $mapsEmbed = $siteSettings['footer_maps_embed'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.1234567890!2d113.1234567890!3d-7.1234567890!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDcnMjQuNCJTIDExM8KwMDcnMjQuNCJF!5e0!3m2!1sid!2sid!4v1234567890';
                    @endphp
                    @if($mapsEmbed)
                    <div class="footer-map-placeholder mt-3">
                        <iframe src="{{ $mapsEmbed }}" width="100%" height="120" style="border:0; border-radius: 8px;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                    @endif
                    <a href="https://maps.google.com" target="_blank" class="footer-map-link mt-2 d-inline-block">Buka peta &rarr;</a>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <span>{{ $siteSettings['footer_copyright'] ?? '© 2026 HIMATIKA UNUJA 2026.' }}</span>
                    <span class="footer-tagline">{{ $globalProfile->motto ?? 'Synchronized Growth, Reaching New Heights.' }}</span>
                    <span>{{ $siteSettings['footer_managed_by'] ?? 'Dikelola oleh Tim Website HIMATIKA' }}</span>
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

        // Dropdown Interactions (Tentang & Informasi)
        (function() {
            var tentangWrapper = document.querySelector('.tentang-dropdown-wrapper');
            var tentangBtn = document.getElementById('tentangDropdownBtn');
            var tentangMenu = document.getElementById('tentangDropdownMenu');
            
            var infoWrapper = document.querySelector('.informasi-dropdown-wrapper');
            var infoBtn = document.getElementById('informasiDropdownBtn');
            var infoMenu = document.getElementById('informasiDropdownMenu');
            
            // Toggle Tentang
            if (tentangBtn && tentangWrapper) {
                tentangBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (infoWrapper) {
                        infoWrapper.classList.remove('show');
                        if (infoBtn) infoBtn.setAttribute('aria-expanded', 'false');
                    }
                    var isOpen = tentangWrapper.classList.toggle('show');
                    tentangBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                });
                
                if (tentangMenu) {
                    tentangMenu.querySelectorAll('.tentang-dropdown-item').forEach(function(item) {
                        item.addEventListener('click', function() {
                            tentangWrapper.classList.remove('show');
                            tentangBtn.setAttribute('aria-expanded', 'false');
                        });
                    });
                }
            }
            
            // Toggle Informasi
            if (infoBtn && infoWrapper) {
                infoBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (tentangWrapper) {
                        tentangWrapper.classList.remove('show');
                        if (tentangBtn) tentangBtn.setAttribute('aria-expanded', 'false');
                    }
                    var isOpen = infoWrapper.classList.toggle('show');
                    infoBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                });
                
                if (infoMenu) {
                    infoMenu.querySelectorAll('.informasi-dropdown-item').forEach(function(item) {
                        item.addEventListener('click', function(e) {
                            var filterForm = document.getElementById('beritaFilterForm');
                            var categoryInput = document.getElementById('filterCategoryInput');
                            
                            // Jika berada di halaman Pusat Informasi (ada filterForm)
                            if (filterForm && categoryInput) {
                                e.preventDefault();
                                var catVal = this.getAttribute('data-category') || '';
                                categoryInput.value = catVal;
                                
                                // Update active state pada menu item
                                infoMenu.querySelectorAll('.informasi-dropdown-item').forEach(function(el) {
                                    el.classList.remove('active');
                                });
                                this.classList.add('active');
                                
                                // Tutup dropdown
                                infoWrapper.classList.remove('show');
                                infoBtn.setAttribute('aria-expanded', 'false');
                                
                                // Trigger AJAX form submit
                                if (window.jQuery) {
                                    window.jQuery('#beritaFilterForm').trigger('submit');
                                } else {
                                    filterForm.dispatchEvent(new Event('submit', { cancelable: true }));
                                }
                            } else {
                                // Jika di halaman lain, navigasi normal melalui link href
                                infoWrapper.classList.remove('show');
                                infoBtn.setAttribute('aria-expanded', 'false');
                            }
                        });
                    });
                }
            }
            
            // Tutup saat mengeklik di luar menu
            document.addEventListener('click', function(e) {
                if (tentangWrapper && !tentangWrapper.contains(e.target)) {
                    tentangWrapper.classList.remove('show');
                    if (tentangBtn) tentangBtn.setAttribute('aria-expanded', 'false');
                }
                if (infoWrapper && !infoWrapper.contains(e.target)) {
                    infoWrapper.classList.remove('show');
                    if (infoBtn) infoBtn.setAttribute('aria-expanded', 'false');
                }
            });
            
            // Tutup saat menekan tombol Esc
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (tentangWrapper && tentangWrapper.classList.contains('show')) {
                        tentangWrapper.classList.remove('show');
                        if (tentangBtn) {
                            tentangBtn.setAttribute('aria-expanded', 'false');
                            tentangBtn.focus();
                        }
                    }
                    if (infoWrapper && infoWrapper.classList.contains('show')) {
                        infoWrapper.classList.remove('show');
                        if (infoBtn) {
                            infoBtn.setAttribute('aria-expanded', 'false');
                            infoBtn.focus();
                        }
                    }
                }
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
