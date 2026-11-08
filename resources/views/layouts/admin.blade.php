<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - HIMATIKA FMIPA UNUJA</title>

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
            --him-primary: #1565C0;
            --him-primary-dark: #0D47A1;
            --him-primary-hover: #1976D2;
            --him-accent: #3B82F6;
            --him-bg: #EFF6FF;
            --him-bg-alt: #DBEAFE;
            --him-border: #BFDBFE;
            --him-text: #0F172A;
            --him-text-muted: #475569;
            --him-card: #FFFFFF;
            --sidebar-width: 270px;
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
            background: linear-gradient(180deg, #0A3275 0%, #0D47A1 45%, #1565C0 100%);
            color: #FFFFFF;
            z-index: 1045;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 24px rgba(13, 71, 161, 0.15);
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
            padding: 1rem 0.75rem 2rem;
        }

        .sidebar-nav-scroll::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar-nav-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .nav-group-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.5);
            padding: 1rem 0.75rem 0.4rem;
        }

        .admin-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.7rem 0.85rem;
            color: rgba(255, 255, 255, 0.82);
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 2px;
            position: relative;
        }

        .admin-nav-item i {
            width: 22px;
            font-size: 1rem;
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
            background: #1976D2;
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(25, 118, 210, 0.4);
        }

        .admin-nav-item.active i {
            color: #FFFFFF;
        }

        .nav-badge-pill {
            margin-left: auto;
            font-size: 0.72rem;
            padding: 0.2rem 0.55rem;
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
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.15);
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
            box-shadow: 0 2px 10px rgba(13, 71, 161, 0.04);
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
            padding: 2rem 1.75rem 3rem;
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
            body.sidebar-collapsed .sidebar-footer-text {
                display: none;
            }

            body.sidebar-collapsed .admin-nav-item {
                justify-content: center;
                padding: 0.85rem 0;
                margin: 4px 10px;
            }

            body.sidebar-collapsed .admin-nav-item i {
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
            box-shadow: 0 4px 16px rgba(13, 71, 161, 0.04);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: box-shadow 0.2s ease;
        }

        .him-card:hover {
            box-shadow: 0 6px 20px rgba(13, 71, 161, 0.07);
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
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--him-primary-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .him-card-title i {
            color: var(--him-primary);
        }

        .btn-him-primary {
            background: var(--him-primary);
            color: #FFFFFF;
            border: none;
            padding: 0.55rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-him-primary:hover {
            background: var(--him-primary-hover);
            color: #FFFFFF;
            box-shadow: 0 4px 12px rgba(21, 101, 192, 0.3);
            transform: translateY(-1px);
        }

        .btn-him-outline {
            background: transparent;
            color: var(--him-primary);
            border: 1px solid var(--him-primary);
            padding: 0.55rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-him-outline:hover {
            background: var(--him-bg);
            color: var(--him-primary-dark);
        }

        .table-him {
            border-collapse: separate;
            border-spacing: 0;
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
            border-bottom: 1px solid rgba(191, 219, 254, 0.4);
            font-size: 0.88rem;
        }

        .table-him tr:hover td {
            background: rgba(239, 246, 255, 0.6);
        }

        .badge-status-published {
            background: #DCFCE7;
            color: #15803D;
            border: 1px solid #BBF7D0;
            padding: 0.3rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .badge-status-draft {
            background: #FEF3C7;
            color: #B45309;
            border: 1px solid #FDE68A;
            padding: 0.3rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .badge-status-archived {
            background: #F1F5F9;
            color: #64748B;
            border: 1px solid #E2E8F0;
            padding: 0.3rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
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
                    @if($globalProfile && $globalProfile->logo)
                        <img src="{{ asset('storage/' . $globalProfile->logo) }}" alt="Logo" style="width: 28px; height: 28px; object-fit: contain;">
                    @else
                        <span>H</span>
                    @endif
                </div>
                <div class="brand-text-group">
                    <span class="brand-text-name">HIMATIKA</span>
                    <span class="brand-text-sub">Admin Panel</span>
                </div>
            </a>
            <button class="btn btn-sm text-white d-lg-none" onclick="toggleMobileSidebar()" aria-label="Tutup Menu">
                <i class="fas fa-times fs-5"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="sidebar-nav-scroll">
            <div class="nav-group-title">Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i>
                <span class="nav-item-label">Dashboard</span>
            </a>

            <div class="nav-group-title">Tampilan Website</div>
            <a href="{{ route('admin.beranda.edit') }}" class="admin-nav-item {{ request()->routeIs('admin.beranda.*') ? 'active' : '' }}">
                <i class="fas fa-sliders-h"></i>
                <span class="nav-item-label">Beranda & Hero</span>
            </a>
            <a href="{{ route('admin.profil.edit') }}" class="admin-nav-item {{ request()->routeIs('admin.profil.*') ? 'active' : '' }}">
                <i class="fas fa-university"></i>
                <span class="nav-item-label">Profil & Sejarah</span>
            </a>
            <a href="{{ route('admin.visi-misi.edit') }}" class="admin-nav-item {{ request()->routeIs('admin.visi-misi.*') ? 'active' : '' }}">
                <i class="fas fa-bullseye"></i>
                <span class="nav-item-label">Visi, Misi & Tujuan</span>
            </a>

            <div class="nav-group-title">Organisasi</div>
            <a href="{{ route('admin.struktur-organisasi.index') }}" class="admin-nav-item {{ request()->routeIs('admin.struktur-*') ? 'active' : '' }}">
                <i class="fas fa-sitemap"></i>
                <span class="nav-item-label">Struktur Organisasi</span>
            </a>
            <a href="{{ route('admin.pengurus.index') }}" class="admin-nav-item {{ request()->routeIs('admin.pengurus.*') ? 'active' : '' }}">
                <i class="fas fa-user-friends"></i>
                <span class="nav-item-label">Anggota & Pengurus</span>
            </a>
            <a href="{{ route('admin.program-kerja.index') }}" class="admin-nav-item {{ request()->routeIs('admin.program-*') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i>
                <span class="nav-item-label">Program Kerja</span>
            </a>
            <a href="{{ route('admin.prestasi.index') }}" class="admin-nav-item {{ request()->routeIs('admin.prestasi.*') ? 'active' : '' }}">
                <i class="fas fa-trophy"></i>
                <span class="nav-item-label">Prestasi</span>
            </a>

            <div class="nav-group-title">Konten & Publikasi</div>
            <a href="{{ route('admin.berita.index') }}" class="admin-nav-item {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                <i class="fas fa-newspaper"></i>
                <span class="nav-item-label">Berita & Informasi</span>
            </a>
            <a href="{{ route('admin.agenda.index') }}" class="admin-nav-item {{ request()->routeIs('admin.agenda.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>
                <span class="nav-item-label">Agenda Kegiatan</span>
            </a>
            <a href="{{ route('admin.galeri.index') }}" class="admin-nav-item {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                <i class="fas fa-photo-video"></i>
                <span class="nav-item-label">Galeri Foto</span>
            </a>
            <a href="{{ route('admin.download.index') }}" class="admin-nav-item {{ request()->routeIs('admin.download.*') ? 'active' : '' }}">
                <i class="fas fa-globe-americas"></i>
                <span class="nav-item-label">Galeri Website & Berkas</span>
            </a>

            <div class="nav-group-title">Layanan & Interaksi</div>
            <a href="{{ route('admin.aspirasi.index') }}" class="admin-nav-item {{ request()->routeIs('admin.aspirasi.*') ? 'active' : '' }}">
                <i class="fas fa-comment-dots"></i>
                <span class="nav-item-label">Aspirasi Mahasiswa</span>
                @php
                    $newAspirationsCount = \App\Models\Aspiration::where('status', 'Baru')->count();
                @endphp
                @if($newAspirationsCount > 0)
                    <span class="nav-badge-pill badge-accent">{{ $newAspirationsCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.pesan.index') }}" class="admin-nav-item {{ request()->routeIs('admin.pesan.*') ? 'active' : '' }}">
                <i class="fas fa-envelope-open-text"></i>
                <span class="nav-item-label">Pesan Kontak</span>
                @php
                    $unreadMessagesCount = \App\Models\Message::where('is_read', false)->count();
                @endphp
                @if($unreadMessagesCount > 0)
                    <span class="nav-badge-pill badge-accent">{{ $unreadMessagesCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.pendaftaran.index') }}" class="admin-nav-item {{ request()->routeIs('admin.pendaftaran.*') ? 'active' : '' }}">
                <i class="fas fa-user-plus"></i>
                <span class="nav-item-label">Pendaftaran Anggota</span>
            </a>

            <div class="nav-group-title">Sistem & Akses</div>
            <a href="{{ route('admin.pengaturan.edit') }}" class="admin-nav-item {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
                <i class="fas fa-cogs"></i>
                <span class="nav-item-label">Pengaturan Website</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="admin-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-user-shield"></i>
                <span class="nav-item-label">Kelola Akun Admin</span>
            </a>
            <a href="{{ route('admin.logs.index') }}" class="admin-nav-item {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
                <i class="fas fa-history"></i>
                <span class="nav-item-label">Log Aktivitas</span>
            </a>
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
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                            @else
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="admin-user-info d-none d-md-flex">
                            <span class="admin-user-name">{{ auth()->user()->name }}</span>
                            <span class="admin-user-role">Administrator</span>
                        </div>
                        <i class="fas fa-chevron-down text-muted" style="font-size: 0.7rem;"></i>
                    </div>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2" style="border-radius: 12px; min-width: 210px;">
                        <li class="px-3 py-2 border-bottom">
                            <div class="fw-bold text-dark">{{ auth()->user()->name }}</div>
                            <div class="small text-muted">{{ auth()->user()->email }}</div>
                            <span class="badge bg-primary-subtle text-primary mt-1">Role: Admin</span>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('admin.users.edit', auth()->user()->id) }}">
                                <i class="fas fa-user-edit text-primary me-2"></i>Edit Akun Saya
                            </a>
                        </li>
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
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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

        // Restore collapsed state
        document.addEventListener('DOMContentLoaded', function () {
            if (window.innerWidth >= 992) {
                const savedState = localStorage.getItem('himatika_admin_sidebar_collapsed');
                if (savedState === '1') {
                    document.body.classList.add('sidebar-collapsed');
                }
            }

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
                        const originalHtml = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...';
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
