<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - HIMATIKA UNUJA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}" rel="stylesheet">
</head>
<body>
    <div class="admin-sidebar" id="adminSidebar">
        <div class="p-3 border-bottom border-secondary">
            <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none fw-bold fs-5">
                <i class="fas fa-laptop-code me-2"></i>HIMATIKA UNUJA Admin
            </a>
        </div>
        <nav class="mt-3">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
            <a href="{{ route('admin.profil.edit') }}" class="nav-link {{ request()->routeIs('admin.profil.*') ? 'active' : '' }}"><i class="fas fa-building me-2"></i>Profil</a>
            <a href="{{ route('admin.visi-misi.edit') }}" class="nav-link {{ request()->routeIs('admin.visi-misi.*') ? 'active' : '' }}"><i class="fas fa-bullseye me-2"></i>Visi & Misi</a>
            <a href="{{ route('admin.struktur-organisasi.index') }}" class="nav-link {{ request()->routeIs('admin.struktur-*') ? 'active' : '' }}"><i class="fas fa-sitemap me-2"></i>Struktur</a>
            <a href="{{ route('admin.pengurus.index') }}" class="nav-link {{ request()->routeIs('admin.pengurus.*') ? 'active' : '' }}"><i class="fas fa-users me-2"></i>Pengurus</a>
            <a href="{{ route('admin.program-kerja.index') }}" class="nav-link {{ request()->routeIs('admin.program-*') ? 'active' : '' }}"><i class="fas fa-tasks me-2"></i>Program Kerja</a>
            <a href="{{ route('admin.kegiatan.index') }}" class="nav-link {{ request()->routeIs('admin.kegiatan.*') ? 'active' : '' }}"><i class="fas fa-calendar me-2"></i>Kegiatan</a>
            <a href="{{ route('admin.berita.index') }}" class="nav-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}"><i class="fas fa-newspaper me-2"></i>Berita</a>
            <a href="{{ route('admin.agenda.index') }}" class="nav-link {{ request()->routeIs('admin.agenda.*') ? 'active' : '' }}"><i class="fas fa-clock me-2"></i>Agenda</a>
            <a href="{{ route('admin.prestasi.index') }}" class="nav-link {{ request()->routeIs('admin.prestasi.*') ? 'active' : '' }}"><i class="fas fa-trophy me-2"></i>Prestasi</a>
            <a href="{{ route('admin.galeri.index') }}" class="nav-link {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}"><i class="fas fa-images me-2"></i>Galeri</a>
            <a href="{{ route('admin.download.index') }}" class="nav-link {{ request()->routeIs('admin.download.*') ? 'active' : '' }}"><i class="fas fa-download me-2"></i>Download</a>
            <a href="{{ route('admin.pesan.index') }}" class="nav-link {{ request()->routeIs('admin.pesan.*') ? 'active' : '' }}"><i class="fas fa-envelope me-2"></i>Pesan</a>
            <a href="{{ route('admin.pendaftaran.index') }}" class="nav-link {{ request()->routeIs('admin.pendaftaran.*') ? 'active' : '' }}"><i class="fas fa-user-plus me-2"></i>Pendaftaran</a>
            <a href="{{ route('admin.aspirasi.index') }}" class="nav-link {{ request()->routeIs('admin.aspirasi.*') ? 'active' : '' }}"><i class="fas fa-comment-dots me-2"></i>Aspirasi</a>
            <hr class="border-secondary mx-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link text-danger w-100 text-start"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
            </form>
        </nav>
    </div>

    <div class="admin-content">
        <div class="admin-topbar">
            <button class="btn btn-sm btn-outline-primary d-lg-none" onclick="document.getElementById('adminSidebar').classList.toggle('show')">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <span class="text-muted">Selamat datang, </span>
                <strong>{{ auth()->user()->name }}</strong>
            </div>
            <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-external-link-alt me-1"></i>Lihat Website</a>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
