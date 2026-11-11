<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - HIMATIKA FMIPA UNUJA</title>

    <!-- Dynamic Favicon -->
    @php
        $faviconPath = null;
        if (($siteSettings['favicon_custom'] ?? '0') === '1' && !empty($siteSettings['favicon_file'])) {
            $faviconPath = asset('storage/' . $siteSettings['favicon_file']);
        } elseif (!empty($siteSettings['main_favicon'])) {
            $faviconPath = asset('storage/' . $siteSettings['main_favicon']);
        } elseif ($globalProfile && $globalProfile->favicon) {
            $faviconPath = asset('storage/' . $globalProfile->favicon);
        }
    @endphp
    @if($faviconPath)
        <link rel="icon" type="image/x-icon" href="{{ $faviconPath }}">
        <link rel="shortcut icon" href="{{ $faviconPath }}">
    @endif

    <!-- Google Fonts & Font Awesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Base Stylesheet -->
    <link href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}" rel="stylesheet">

    <style>
        :root {
            --him-primary: #711C35;
            --him-primary-dark: #1A0A0F;
            --him-primary-hover: #541326;
            --him-accent: #A33B59;
            --him-bg: #FFF7F9;
            --him-bg-alt: #F4D6DE;
            --him-border: #E9CDD5;
            --him-text: #28151D;
            --him-text-muted: #5C4B51;
            --him-card: #FFFFFF;
            --sidebar-width: 275px;
            --sidebar-collapsed-width: 80px;
            --topbar-height: 70px;
        }

        body.admin-body {
            background-color: var(--him-bg);
            color: var(--him-text);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .admin-sidebar-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1A0A0F 0%, #3B0E1B 45%, #711C35 100%);
            color: #FFFFFF;
            z-index: 1045;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 24px rgba(26, 10, 15, 0.25);
        }

        .sidebar-header {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #FFFFFF;
        }

        .brand-logo-circle {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #FFFFFF;
            color: var(--him-primary-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            flex-shrink: 0;
            overflow: hidden;
        }

        .brand-text-group {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
            overflow: hidden;
        }

        .brand-text-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 1.05rem;
            letter-spacing: -0.3px;
        }

        .brand-text-sub {
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .sidebar-nav-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 0.75rem 0.65rem 2rem;
        }

        .sidebar-nav-scroll::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar-nav-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .nav-group-title {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.45);
            padding: 0.85rem 0.75rem 0.35rem;
        }

        .admin-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.65rem 0.85rem;
            color: rgba(255, 255, 255, 0.82);
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 2px;
            position: relative;
        }

        .admin-nav-item i {
            width: 22px;
            font-size: 0.95rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.75);
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .admin-nav-item:hover {
            color: #FFFFFF;
            background: rgba(255, 255, 255, 0.12);
            transform: translateX(3px);
        }

        .admin-nav-item:hover i {
            color: #FFFFFF;
        }

        .admin-nav-item.active {
            color: #FFFFFF;
            background: #711C35;
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(113, 28, 53, 0.4);
        }

        .admin-nav-item.active i {
            color: #FFFFFF;
        }

        /* Collapsible Dropdown in Sidebar */
        .sidebar-dropdown-group {
            margin-bottom: 2px;
        }

        .sidebar-dropdown-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0.65rem 0.85rem;
            color: rgba(255, 255, 255, 0.85);
            background: transparent;
            border: none;
            border-radius: 10px;
            font-size: 0.88rem;
            font-weight: 500;
            text-align: left;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .sidebar-dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #FFFFFF;
        }

        .sidebar-dropdown-toggle.parent-active {
            background: rgba(255, 255, 255, 0.12);
            color: #FFFFFF;
            font-weight: 600;
            border-left: 3px solid #F4D6DE;
        }

        .sidebar-dropdown-toggle .toggle-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-dropdown-toggle .toggle-left i {
            width: 22px;
            text-align: center;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.75);
            flex-shrink: 0;
        }

        .sidebar-dropdown-toggle .chevron-icon {
            font-size: 0.72rem;
            transition: transform 0.25s ease;
            opacity: 0.7;
        }

        .sidebar-dropdown-toggle[aria-expanded="true"] .chevron-icon {
            transform: rotate(180deg);
        }

        .sidebar-sub-menu {
            list-style: none;
            padding: 0.3rem 0 0.4rem 1.75rem;
            margin: 0;
            border-left: 1px solid rgba(255, 255, 255, 0.15);
            margin-left: 1.35rem;
        }

        .sidebar-sub-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0.45rem 0.75rem;
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.82rem;
            transition: all 0.2s ease;
            margin-bottom: 1px;
        }

        .sidebar-sub-item:hover {
            color: #FFFFFF;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(3px);
        }

        .sidebar-sub-item.active {
            color: #FFFFFF;
            background: #711C35;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(113, 28, 53, 0.4);
        }

        .nav-badge-pill {
            margin-left: auto;
            font-size: 0.7rem;
            padding: 0.15rem 0.5rem;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.2);
            color: #FFFFFF;
            font-weight: 600;
        }

        .nav-badge-pill.badge-accent {
            background: #EF4444;
            color: #FFFFFF;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 0.85rem 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.18);
        }

        /* Main Content Container */
        .admin-main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Topbar */
        .admin-topbar-wrapper {
            height: var(--topbar-height);
            background: #FFFFFF;
            border-bottom: 1px solid var(--him-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.75rem;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 2px 10px rgba(26, 10, 15, 0.04);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-sidebar-toggle {
            background: var(--him-bg);
            border: 1px solid var(--him-border);
            color: var(--him-primary-dark);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-sidebar-toggle:hover {
            background: var(--him-primary);
            color: #FFFFFF;
            border-color: var(--him-primary);
        }

        .topbar-page-info {
            display: flex;
            flex-direction: column;
        }

        .topbar-page-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 1.15rem;
            color: var(--him-text);
            margin: 0;
            line-height: 1.2;
        }

        .topbar-breadcrumb {
            font-size: 0.78rem;
            color: var(--him-text-muted);
            margin: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-view-site {
            background: #FFFFFF;
            border: 1px solid var(--him-border);
            color: var(--him-primary);
            padding: 0.45rem 1rem;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-view-site:hover {
            background: var(--him-bg);
            color: var(--him-primary-dark);
            border-color: var(--him-primary);
        }

        /* User Profile Pill Dropdown */
        .admin-profile-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.35rem 0.75rem 0.35rem 0.45rem;
            background: var(--him-bg);
            border: 1px solid var(--him-border);
            border-radius: 40px;
            cursor: pointer;
            text-decoration: none;
            color: var(--him-text);
            transition: all 0.2s ease;
        }

        .admin-profile-pill:hover {
            background: var(--him-bg-alt);
        }

        .admin-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--him-primary);
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.88rem;
            border: 2px solid #FFFFFF;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .admin-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .admin-user-info {
            display: flex;
            flex-direction: column;
            text-align: left;
            line-height: 1.15;
            padding-right: 4px;
        }

        .admin-user-name {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--him-text);
        }

        .admin-user-role {
            font-size: 0.7rem;
            color: var(--him-primary);
            font-weight: 600;
        }

        /* Content Area */
        .admin-content-body {
            flex: 1;
            padding: 1.75rem 1.75rem 3rem;
        }

        /* Responsive Layout Behavior */
        @media (max-width: 991.98px) {
            .admin-sidebar-wrapper {
                transform: translateX(-100%);
            }

            .admin-sidebar-wrapper.show {
                transform: translateX(0);
            }

            .admin-main-wrapper {
                margin-left: 0;
            }

            .sidebar-backdrop {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(15, 23, 42, 0.5);
                backdrop-filter: blur(2px);
                z-index: 1040;
            }

            .sidebar-backdrop.show {
                display: block;
            }
        }

        /* Desktop Collapsed Sidebar */
        @media (min-width: 992px) {
            body.sidebar-collapsed .admin-sidebar-wrapper {
                width: var(--sidebar-collapsed-width);
            }

            body.sidebar-collapsed .sidebar-header {
                justify-content: center;
                padding: 0;
            }

            body.sidebar-collapsed .brand-text-group,
            body.sidebar-collapsed .nav-group-title,
            body.sidebar-collapsed .nav-item-label,
            body.sidebar-collapsed .nav-badge-pill,
            body.sidebar-collapsed .sidebar-footer-text,
            body.sidebar-collapsed .chevron-icon,
            body.sidebar-collapsed .sidebar-sub-menu {
                display: none !important;
            }

            body.sidebar-collapsed .admin-nav-item,
            body.sidebar-collapsed .sidebar-dropdown-toggle {
                justify-content: center;
                padding: 0.85rem 0;
                margin: 4px 10px;
            }

            body.sidebar-collapsed .admin-nav-item i,
            body.sidebar-collapsed .sidebar-dropdown-toggle .toggle-left i {
                margin: 0;
                font-size: 1.2rem;
            }

            body.sidebar-collapsed .admin-main-wrapper {
                margin-left: var(--sidebar-collapsed-width);
            }
        }

        /* Modern UI Components in Admin */
        .him-card {
            background: #FFFFFF;
            border: 1px solid var(--him-border);
            border-radius: 14px;
            box-shadow: 0 4px 16px rgba(113, 28, 53, 0.04);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: box-shadow 0.2s ease;
        }

        .him-card:hover {
            box-shadow: 0 6px 20px rgba(113, 28, 53, 0.08);
        }

        .him-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            padding-bottom: 0.85rem;
            border-bottom: 1px solid var(--him-border);
        }

        .him-card-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--him-text);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-him-primary {
            background: var(--him-primary);
            color: #FFFFFF;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 0.55rem 1.25rem;
            transition: all 0.2s ease;
        }

        .btn-him-primary:hover {
            background: var(--him-primary-hover);
            color: #FFFFFF;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(113, 28, 53, 0.3);
        }

        .btn-him-outline {
            background: transparent;
            color: var(--him-primary);
            border: 1px solid var(--him-primary);
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 0.5rem 1.15rem;
            transition: all 0.2s ease;
        }

        .btn-him-outline:hover {
            background: var(--him-primary);
            color: #FFFFFF;
        }

        .table-him {
            width: 100%;
        }

        .table-him th {
            background: var(--him-bg);
            color: var(--him-primary-dark);
            font-weight: 700;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--him-border);
        }

        .table-him td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(233, 205, 213, 0.5);
            font-size: 0.88rem;
        }

        .table-him tr:hover td {
            background: rgba(244, 214, 222, 0.3);
        }
    </style>
    @stack('styles')
</head>
<body class="admin-body">

    <!-- Mobile Drawer Backdrop -->
    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleMobileSidebar()"></div>

    <!-- ==================== SIDEBAR ==================== -->
    <aside class="admin-sidebar-wrapper" id="adminSidebar">
        <!-- Brand Header -->
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand-link">
                <div class="brand-logo-circle">
                    @php
                        $sidebarLogo = null;
                        if (($siteSettings['logo_admin_sidebar_custom'] ?? '0') === '1' && !empty($siteSettings['logo_admin_sidebar_file'])) {
                            $sidebarLogo = asset('storage/' . $siteSettings['logo_admin_sidebar_file']);
                        } elseif (!empty($siteSettings['main_logo'])) {
                            $sidebarLogo = asset('storage/' . $siteSettings['main_logo']);
                        } elseif ($globalProfile && $globalProfile->logo) {
                            $sidebarLogo = asset('storage/' . $globalProfile->logo);
                        }
                    @endphp
                    @if($sidebarLogo)
                        <img src="{{ $sidebarLogo }}" alt="{{ $siteSettings['logo_admin_sidebar_alt'] ?? 'Logo Admin' }}" style="width: 28px; height: 28px; object-fit: contain;">
                    @else
                        <span>H</span>
                    @endif
                </div>
                <div class="brand-text-group">
                    <span class="brand-text-name">{{ $siteSettings['site_short_title'] ?? 'HIMATIKA' }}</span>
                    <span class="brand-text-sub">Admin Panel</span>
                </div>
            </a>
            <button class="btn btn-sm text-white d-lg-none" onclick="toggleMobileSidebar()" aria-label="Tutup Menu">
                <i class="fas fa-times fs-5"></i>
            </button>
        </div>

        <!-- Navigation Links (Modular Accordion / Dropdowns) -->
        <nav class="sidebar-nav-scroll">
            <!-- 1. DASHBOARD -->
            <div class="nav-group-title">Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i>
                <span class="nav-item-label">Dashboard</span>
            </a>

            <!-- 2. BERANDA DROPDOWN -->
            <div class="sidebar-dropdown-group">
                @php
                    $isBerandaActive = request()->routeIs('admin.beranda.*');
                @endphp
                <button type="button" class="sidebar-dropdown-toggle {{ $isBerandaActive ? 'parent-active' : '' }}" data-bs-toggle="collapse" data-bs-target="#dropdownBeranda" aria-expanded="{{ $isBerandaActive ? 'true' : 'false' }}">
                    <div class="toggle-left">
                        <i class="fas fa-home"></i>
                        <span class="nav-item-label">Beranda</span>
                    </div>
                    <i class="fas fa-chevron-down chevron-icon"></i>
                </button>
                <div class="collapse {{ $isBerandaActive ? 'show' : '' }}" id="dropdownBeranda">
                    <ul class="sidebar-sub-menu">
                        <li>
                            <a href="{{ route('admin.beranda.hero') }}" class="sidebar-sub-item {{ request()->routeIs('admin.beranda.hero') ? 'active' : '' }}">
                                <i class="fas fa-bullhorn small"></i> Hero
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.beranda.tentang') }}" class="sidebar-sub-item {{ request()->routeIs('admin.beranda.tentang') ? 'active' : '' }}">
                                <i class="fas fa-info-circle small"></i> Tentang HIMATIKA
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.beranda.berita') }}" class="sidebar-sub-item {{ request()->routeIs('admin.beranda.berita') ? 'active' : '' }}">
                                <i class="fas fa-newspaper small"></i> Berita & Info Terkini
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.beranda.berdampak') }}" class="sidebar-sub-item {{ request()->routeIs('admin.beranda.berdampak') ? 'active' : '' }}">
                                <i class="fas fa-hand-holding-heart small"></i> HIMATIKA Berdampak
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.beranda.momen') }}" class="sidebar-sub-item {{ request()->routeIs('admin.beranda.momen') ? 'active' : '' }}">
                                <i class="fas fa-camera-retro small"></i> Dokumentasi Momen
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- 3. TENTANG DROPDOWN -->
            <div class="sidebar-dropdown-group">
                @php
                    $isTentangActive = request()->routeIs('admin.tentang.*') || request()->routeIs('admin.visi-misi.*') || request()->routeIs('admin.struktur-*') || request()->routeIs('admin.pengurus.*') || request()->routeIs('admin.profil.*');
                @endphp
                <button type="button" class="sidebar-dropdown-toggle {{ $isTentangActive ? 'parent-active' : '' }}" data-bs-toggle="collapse" data-bs-target="#dropdownTentang" aria-expanded="{{ $isTentangActive ? 'true' : 'false' }}">
                    <div class="toggle-left">
                        <i class="fas fa-university"></i>
                        <span class="nav-item-label">Tentang</span>
                    </div>
                    <i class="fas fa-chevron-down chevron-icon"></i>
                </button>
                <div class="collapse {{ $isTentangActive ? 'show' : '' }}" id="dropdownTentang">
                    <ul class="sidebar-sub-menu">
                        <li>
                            <a href="{{ route('admin.tentang.sejarah') }}" class="sidebar-sub-item {{ request()->routeIs('admin.tentang.sejarah*') ? 'active' : '' }}">
                                <i class="fas fa-landmark small"></i> Sejarah
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.tentang.sambutan') }}" class="sidebar-sub-item {{ request()->routeIs('admin.tentang.sambutan*') ? 'active' : '' }}">
                                <i class="fas fa-user-tie small"></i> Sambutan Kaprodi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.visi-misi.edit') }}" class="sidebar-sub-item {{ request()->routeIs('admin.visi-misi.*') ? 'active' : '' }}">
                                <i class="fas fa-bullseye small"></i> Visi dan Misi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.struktur-organisasi.index') }}" class="sidebar-sub-item {{ request()->routeIs('admin.struktur-*') ? 'active' : '' }}">
                                <i class="fas fa-sitemap small"></i> Struktur Organisasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pengurus.index') }}" class="sidebar-sub-item {{ request()->routeIs('admin.pengurus.*') ? 'active' : '' }}">
                                <i class="fas fa-user-friends small"></i> Anggota Pengurus
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- 4. INFORMASI DROPDOWN -->
            <div class="sidebar-dropdown-group">
                @php
                    $isInformasiActive = request()->routeIs('admin.berita.*') || request()->routeIs('admin.kegiatan.*') || request()->routeIs('admin.agenda.*') || request()->routeIs('admin.prestasi.*') || request()->routeIs('admin.program-*') || request()->routeIs('admin.informasi.*');
                @endphp
                <button type="button" class="sidebar-dropdown-toggle {{ $isInformasiActive ? 'parent-active' : '' }}" data-bs-toggle="collapse" data-bs-target="#dropdownInformasi" aria-expanded="{{ $isInformasiActive ? 'true' : 'false' }}">
                    <div class="toggle-left">
                        <i class="fas fa-newspaper"></i>
                        <span class="nav-item-label">Informasi</span>
                    </div>
                    <i class="fas fa-chevron-down chevron-icon"></i>
                </button>
                <div class="collapse {{ $isInformasiActive ? 'show' : '' }}" id="dropdownInformasi">
                    <ul class="sidebar-sub-menu">
                        <li>
                            <a href="{{ route('admin.berita.index') }}" class="sidebar-sub-item {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                                <i class="fas fa-newspaper small"></i> Semua Berita & Info
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.kegiatan.index') }}" class="sidebar-sub-item {{ request()->routeIs('admin.kegiatan.*') ? 'active' : '' }}">
                                <i class="fas fa-calendar-check small"></i> Kegiatan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.agenda.index') }}" class="sidebar-sub-item {{ request()->routeIs('admin.agenda.*') ? 'active' : '' }}">
                                <i class="fas fa-calendar-alt small"></i> Agenda
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.prestasi.index') }}" class="sidebar-sub-item {{ request()->routeIs('admin.prestasi.*') ? 'active' : '' }}">
                                <i class="fas fa-trophy small"></i> Prestasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.program-kerja.index') }}" class="sidebar-sub-item {{ request()->routeIs('admin.program-*') ? 'active' : '' }}">
                                <i class="fas fa-tasks small"></i> Program Kerja
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.informasi.kategori.index') }}" class="sidebar-sub-item {{ request()->routeIs('admin.informasi.kategori.*') ? 'active' : '' }}">
                                <i class="fas fa-tags small"></i> Kelola Kategori
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- 5. GALERI DROPDOWN -->
            <div class="sidebar-dropdown-group">
                @php
                    $isGaleriActive = request()->routeIs('admin.galeri.*');
                @endphp
                <button type="button" class="sidebar-dropdown-toggle {{ $isGaleriActive ? 'parent-active' : '' }}" data-bs-toggle="collapse" data-bs-target="#dropdownGaleri" aria-expanded="{{ $isGaleriActive ? 'true' : 'false' }}">
                    <div class="toggle-left">
                        <i class="fas fa-photo-video"></i>
                        <span class="nav-item-label">Galeri</span>
                    </div>
                    <i class="fas fa-chevron-down chevron-icon"></i>
                </button>
                <div class="collapse {{ $isGaleriActive ? 'show' : '' }}" id="dropdownGaleri">
                    <ul class="sidebar-sub-menu">
                        <li>
                            <a href="{{ route('admin.galeri.pengaturan') }}" class="sidebar-sub-item {{ request()->routeIs('admin.galeri.pengaturan') ? 'active' : '' }}">
                                <i class="fas fa-cog small"></i> Pengaturan Halaman
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.galeri.index') }}" class="sidebar-sub-item {{ request()->routeIs('admin.galeri.index') || request()->routeIs('admin.galeri.create') || request()->routeIs('admin.galeri.edit') ? 'active' : '' }}">
                                <i class="fas fa-images small"></i> Album Dokumentasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.galeri.media') }}" class="sidebar-sub-item {{ request()->routeIs('admin.galeri.media') ? 'active' : '' }}">
                                <i class="fas fa-camera small"></i> Foto dan Video
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- 6. DOKUMEN & KARYA DROPDOWN -->
            <div class="sidebar-dropdown-group">
                @php
                    $isDownloadActive = request()->routeIs('admin.download.*');
                @endphp
                <button type="button" class="sidebar-dropdown-toggle {{ $isDownloadActive ? 'parent-active' : '' }}" data-bs-toggle="collapse" data-bs-target="#dropdownDownload" aria-expanded="{{ $isDownloadActive ? 'true' : 'false' }}">
                    <div class="toggle-left">
                        <i class="fas fa-layer-group"></i>
                        <span class="nav-item-label">Dokumen & Karya</span>
                    </div>
                    <i class="fas fa-chevron-down chevron-icon"></i>
                </button>
                <div class="collapse {{ $isDownloadActive ? 'show' : '' }}" id="dropdownDownload">
                    <ul class="sidebar-sub-menu">
                        <li>
                            <a href="{{ route('admin.download.index', ['type' => 'website']) }}" class="sidebar-sub-item {{ request('type') === 'website' ? 'active' : '' }}">
                                <i class="fas fa-globe small"></i> Galeri Website Mahasiswa
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.download.index', ['type' => 'file']) }}" class="sidebar-sub-item {{ request('type') === 'file' ? 'active' : '' }}">
                                <i class="fas fa-file-download small"></i> Dokumen Unduhan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.download.index') }}" class="sidebar-sub-item {{ !request()->filled('type') && request()->routeIs('admin.download.index') ? 'active' : '' }}">
                                <i class="fas fa-list small"></i> Semua Karya & Berkas
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- 7. ASPIRASI DROPDOWN -->
            <div class="sidebar-dropdown-group">
                @php
                    $isAspirasiActive = request()->routeIs('admin.aspirasi.*') || request()->routeIs('admin.pesan.*');
                    $newAspirationsCount = \App\Models\Aspiration::where('is_archived', false)->where('status', 'Baru')->count();
                @endphp
                <button type="button" class="sidebar-dropdown-toggle {{ $isAspirasiActive ? 'parent-active' : '' }}" data-bs-toggle="collapse" data-bs-target="#dropdownAspirasi" aria-expanded="{{ $isAspirasiActive ? 'true' : 'false' }}">
                    <div class="toggle-left">
                        <i class="fas fa-comment-dots"></i>
                        <span class="nav-item-label">Aspirasi</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        @if($newAspirationsCount > 0)
                            <span class="nav-badge-pill badge-accent">{{ $newAspirationsCount }}</span>
                        @endif
                        <i class="fas fa-chevron-down chevron-icon"></i>
                    </div>
                </button>
                <div class="collapse {{ $isAspirasiActive ? 'show' : '' }}" id="dropdownAspirasi">
                    <ul class="sidebar-sub-menu">
                        <li>
                            <a href="{{ route('admin.aspirasi.index') }}" class="sidebar-sub-item {{ request()->routeIs('admin.aspirasi.index') ? 'active' : '' }}">
                                <i class="fas fa-inbox small"></i> Kotak Masuk
                                @if($newAspirationsCount > 0)
                                    <span class="badge bg-danger ms-auto" style="font-size: 0.65rem;">{{ $newAspirationsCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.aspirasi.arsip') }}" class="sidebar-sub-item {{ request()->routeIs('admin.aspirasi.arsip') ? 'active' : '' }}">
                                <i class="fas fa-archive small"></i> Arsip
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.aspirasi.pengaturan') }}" class="sidebar-sub-item {{ request()->routeIs('admin.aspirasi.pengaturan*') ? 'active' : '' }}">
                                <i class="fas fa-sliders-h small"></i> Pengaturan Formulir
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pesan.index') }}" class="sidebar-sub-item {{ request()->routeIs('admin.pesan.*') ? 'active' : '' }}">
                                <i class="fas fa-envelope-open-text small"></i> Pesan Kontak
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pendaftaran.index') }}" class="sidebar-sub-item {{ request()->routeIs('admin.pendaftaran.*') ? 'active' : '' }}">
                                <i class="fas fa-user-plus small"></i> Pendaftaran Anggota
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- 8. TAMPILAN WEBSITE DROPDOWN -->
            <div class="sidebar-dropdown-group">
                @php
                    $isTampilanActive = request()->routeIs('admin.tampilan.*') || request()->routeIs('admin.pengaturan.*');
                @endphp
                <button type="button" class="sidebar-dropdown-toggle {{ $isTampilanActive ? 'parent-active' : '' }}" data-bs-toggle="collapse" data-bs-target="#dropdownTampilan" aria-expanded="{{ $isTampilanActive ? 'true' : 'false' }}">
                    <div class="toggle-left">
                        <i class="fas fa-paint-brush"></i>
                        <span class="nav-item-label">Tampilan Website</span>
                    </div>
                    <i class="fas fa-chevron-down chevron-icon"></i>
                </button>
                <div class="collapse {{ $isTampilanActive ? 'show' : '' }}" id="dropdownTampilan">
                    <ul class="sidebar-sub-menu">
                        <li>
                            <a href="{{ route('admin.tampilan.identitas') }}" class="sidebar-sub-item {{ request()->routeIs('admin.tampilan.identitas*') || request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
                                <i class="fas fa-id-card small"></i> Identitas Website
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.tampilan.logo-favicon') }}" class="sidebar-sub-item {{ request()->routeIs('admin.tampilan.logo-favicon*') ? 'active' : '' }}">
                                <i class="fas fa-certificate small"></i> Logo & Favicon
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.tampilan.navbar') }}" class="sidebar-sub-item {{ request()->routeIs('admin.tampilan.navbar*') ? 'active' : '' }}">
                                <i class="fas fa-bars small"></i> Navbar & Submenu
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.tampilan.footer') }}" class="sidebar-sub-item {{ request()->routeIs('admin.tampilan.footer*') ? 'active' : '' }}">
                                <i class="fas fa-shoe-prints small"></i> Footer & Kontak
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.tampilan.media') }}" class="sidebar-sub-item {{ request()->routeIs('admin.tampilan.media*') ? 'active' : '' }}">
                                <i class="fas fa-photo-video small"></i> Pustaka Media
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- 9. PENGGUNA & AKSES DROPDOWN -->
            <div class="sidebar-dropdown-group">
                @php
                    $isUsersActive = request()->routeIs('admin.users.*') || request()->routeIs('admin.logs.*');
                @endphp
                <button type="button" class="sidebar-dropdown-toggle {{ $isUsersActive ? 'parent-active' : '' }}" data-bs-toggle="collapse" data-bs-target="#dropdownUsers" aria-expanded="{{ $isUsersActive ? 'true' : 'false' }}">
                    <div class="toggle-left">
                        <i class="fas fa-user-shield"></i>
                        <span class="nav-item-label">Pengguna & Akses</span>
                    </div>
                    <i class="fas fa-chevron-down chevron-icon"></i>
                </button>
                <div class="collapse {{ $isUsersActive ? 'show' : '' }}" id="dropdownUsers">
                    <ul class="sidebar-sub-menu">
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="sidebar-sub-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <i class="fas fa-users-cog small"></i> Kelola Akun Admin
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.logs.index') }}" class="sidebar-sub-item {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
                                <i class="fas fa-history small"></i> Log Aktivitas
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Sidebar Bottom Footer -->
        <div class="sidebar-footer">
            <div class="d-flex align-items-center justify-content-between">
                <div class="sidebar-footer-text">
                    <div class="small fw-semibold text-white">HIMATIKA UNUJA</div>
                    <div class="text-white-50" style="font-size: 0.7rem;">Sistem Informasi &copy; {{ date('Y') }}</div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light border-0" title="Keluar dari Panel">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- ==================== MAIN CONTENT ==================== -->
    <div class="admin-main-wrapper">
        <!-- Topbar -->
        <header class="admin-topbar-wrapper">
            <div class="topbar-left">
                <button class="btn-sidebar-toggle" onclick="toggleSidebar()" aria-label="Toggle Menu Sidebar" title="Buka/Tutup Sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="topbar-page-info">
                    <h1 class="topbar-page-title">@yield('page_title', 'Dashboard')</h1>
                    <p class="topbar-breadcrumb">@yield('page_subtitle', 'Panel Pengelolaan HIMATIKA FMIPA UNUJA')</p>
                </div>
            </div>

            <div class="topbar-right">
                <a href="{{ route('home') }}" target="_blank" class="btn-view-site" title="Buka website publik di tab baru">
                    <i class="fas fa-external-link-alt"></i>
                    <span class="d-none d-sm-inline">Lihat Website</span>
                </a>

                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <div class="admin-profile-pill" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="admin-avatar">
                            @if(auth()->user() && auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                            @elseif(auth()->user())
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            @else
                                A
                            @endif
                        </div>
                        <div class="admin-user-info d-none d-md-flex">
                            <span class="admin-user-name">{{ auth()->user()->name ?? 'Admin' }}</span>
                            <span class="admin-user-role">Administrator</span>
                        </div>
                        <i class="fas fa-chevron-down text-muted" style="font-size: 0.7rem;"></i>
                    </div>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2" style="border-radius: 12px; min-width: 210px;">
                        <li class="px-3 py-2 border-bottom">
                            <div class="fw-bold text-dark">{{ auth()->user()->name ?? 'Admin' }}</div>
                            <div class="small text-muted">{{ auth()->user()->email ?? '' }}</div>
                            <span class="badge bg-primary-subtle text-primary mt-1">Role: Admin</span>
                        </li>
                        @if(auth()->user())
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('admin.users.edit', auth()->user()->id) }}">
                                <i class="fas fa-user-edit text-primary me-2"></i>Edit Akun Saya
                            </a>
                        </li>
                        @endif
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('admin.logs.index') }}">
                                <i class="fas fa-history text-secondary me-2"></i>Log Aktivitas Saya
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Keluar / Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Flash Notifications -->
        <main class="admin-content-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert" style="border-radius: 12px; border-left: 4px solid #16A34A;">
                    <i class="fas fa-check-circle fs-5 text-success me-3"></i>
                    <div>
                        <strong>Berhasil!</strong> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert" style="border-radius: 12px; border-left: 4px solid #DC2626;">
                    <i class="fas fa-exclamation-triangle fs-5 text-danger me-3"></i>
                    <div>
                        <strong>Peringatan!</strong> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 12px; border-left: 4px solid #DC2626;">
                    <div class="d-flex align-items-center mb-1">
                        <i class="fas fa-exclamation-circle fs-5 text-danger me-2"></i>
                        <strong>Terdapat beberapa kesalahan pengisian formulir:</strong>
                    </div>
                    <ul class="mb-0 ps-4 small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- ==================== SHARED DELETE CONFIRMATION MODAL ==================== -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-body text-center p-4 pt-5">
                    <div class="mb-3">
                        <div class="d-inline-flex align-items-center justify-content-center bg-danger-subtle text-danger rounded-circle" style="width: 64px; height: 64px;">
                            <i class="fas fa-trash-alt fs-3"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold text-dark mb-2" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                    <p class="text-muted small mb-3">
                        Apakah Anda yakin ingin menghapus <strong id="deleteModalItemTitle" class="text-dark">data ini</strong>?
                        <br>
                        <span class="text-danger">Tindakan ini tidak dapat dibatalkan.</span>
                    </p>
                    <form id="deleteConfirmForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex justify-content-center gap-2 mt-4">
                            <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-danger px-4 rounded-pill">
                                <i class="fas fa-trash-alt me-1"></i> Ya, Hapus Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Desktop Collapse & Mobile Toggle
        function toggleSidebar() {
            if (window.innerWidth < 992) {
                toggleMobileSidebar();
            } else {
                document.body.classList.toggle('sidebar-collapsed');
                const isCollapsed = document.body.classList.contains('sidebar-collapsed');
                localStorage.setItem('himatika_admin_sidebar_collapsed', isCollapsed ? '1' : '0');
            }
        }

        function toggleMobileSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('show');
            backdrop.classList.toggle('show');
        }

        // Restore collapsed state and setup accordion keyboard support
        document.addEventListener('DOMContentLoaded', function () {
            if (window.innerWidth >= 992) {
                const savedState = localStorage.getItem('himatika_admin_sidebar_collapsed');
                if (savedState === '1') {
                    document.body.classList.add('sidebar-collapsed');
                }
            }

            // Keyboard accessibility for sidebar dropdown toggles (Space / Enter)
            document.querySelectorAll('.sidebar-dropdown-toggle').forEach(btn => {
                btn.addEventListener('keydown', function (e) {
                    if (e.key === ' ' || e.key === 'Spacebar') {
                        e.preventDefault();
                        this.click();
                    }
                });
            });

            // Global Delete Confirmation Modal Handler
            const deleteModal = document.getElementById('deleteConfirmModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const actionUrl = button.getAttribute('data-action');
                    const itemTitle = button.getAttribute('data-title') || 'data ini';

                    const form = document.getElementById('deleteConfirmForm');
                    const titleHolder = document.getElementById('deleteModalItemTitle');

                    form.setAttribute('action', actionUrl);
                    titleHolder.textContent = `"${itemTitle}"`;
                });
            }

            // Global Form Double-Submission Prevention
            document.querySelectorAll('form:not(.no-double-submit)').forEach(form => {
                form.addEventListener('submit', function (e) {
                    if (this.dataset.submitting === 'true') {
                        e.preventDefault();
                        return false;
                    }
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        this.dataset.submitting = 'true';
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...';
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
