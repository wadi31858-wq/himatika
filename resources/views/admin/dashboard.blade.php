@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Ringkasan Sistem')
@section('page_subtitle', 'Selamat datang di panel kendali HIMATIKA FMIPA UNUJA')

@section('content')
<!-- Quick Action Shortcuts -->
<div class="him-card mb-4 p-3 bg-white">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-2">
            <div class="p-2 bg-primary-subtle text-primary rounded-3">
                <i class="fas fa-bolt fs-5"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold text-dark">Aksi Cepat</h6>
                <small class="text-muted">Pintasan praktis untuk mengelola konten terbaru</small>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.beranda.edit') }}" class="btn btn-sm btn-him-outline">
                <i class="fas fa-sliders-h"></i> Atur Beranda
            </a>
            <a href="{{ route('admin.berita.create') }}" class="btn btn-sm btn-him-primary">
                <i class="fas fa-plus"></i> Tulis Berita
            </a>
            <a href="{{ route('admin.agenda.create') }}" class="btn btn-sm btn-him-outline">
                <i class="fas fa-calendar-plus"></i> Tambah Agenda
            </a>
            <a href="{{ route('admin.download.create') }}" class="btn btn-sm btn-him-outline">
                <i class="fas fa-globe"></i> Tambah Website/Berkas
            </a>
            <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-sm btn-outline-danger">
                <i class="fas fa-comment-dots"></i> Cek Aspirasi
            </a>
        </div>
    </div>
</div>

<!-- Main Stat Cards Grid -->
<div class="row g-3 mb-4">
    <!-- Card 1: Berita -->
    <div class="col-sm-6 col-xl-3">
        <div class="him-card p-3 h-100 mb-0">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold text-uppercase">Berita & Informasi</span>
                <div class="p-2 bg-primary-subtle text-primary rounded-3">
                    <i class="fas fa-newspaper"></i>
                </div>
            </div>
            <div class="d-flex align-items-baseline gap-2 mb-2">
                <h3 class="mb-0 fw-bold text-dark">{{ $totalNews }}</h3>
                <span class="small text-muted">Total</span>
            </div>
            <div class="d-flex gap-2 small">
                <span class="badge bg-success-subtle text-success">{{ $newsPublished }} Terbit</span>
                <span class="badge bg-warning-subtle text-warning-emphasis">{{ $newsDraft }} Draft</span>
            </div>
        </div>
    </div>

    <!-- Card 2: Agenda -->
    <div class="col-sm-6 col-xl-3">
        <div class="him-card p-3 h-100 mb-0">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold text-uppercase">Agenda Kegiatan</span>
                <div class="p-2 bg-info-subtle text-info rounded-3">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            <div class="d-flex align-items-baseline gap-2 mb-2">
                <h3 class="mb-0 fw-bold text-dark">{{ $totalAgendas }}</h3>
                <span class="small text-muted">Total</span>
            </div>
            <div class="d-flex gap-2 small">
                <span class="badge bg-success-subtle text-success">{{ $agendaPublished }} Terbit</span>
                <span class="badge bg-warning-subtle text-warning-emphasis">{{ $agendaDraft }} Draft</span>
            </div>
        </div>
    </div>

    <!-- Card 3: Aspirasi -->
    <div class="col-sm-6 col-xl-3">
        <div class="him-card p-3 h-100 mb-0">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold text-uppercase">Aspirasi Mahasiswa</span>
                <div class="p-2 bg-danger-subtle text-danger rounded-3">
                    <i class="fas fa-comment-dots"></i>
                </div>
            </div>
            <div class="d-flex align-items-baseline gap-2 mb-2">
                <h3 class="mb-0 fw-bold text-dark">{{ $totalAspirations }}</h3>
                <span class="small text-muted">Aspirasi</span>
            </div>
            <div class="d-flex gap-2 small">
                <span class="badge bg-danger-subtle text-danger">{{ $aspirasiBaru }} Baru</span>
                <span class="badge bg-primary-subtle text-primary">{{ $aspirasiDiproses }} Proses</span>
                <span class="badge bg-success-subtle text-success">{{ $aspirasiSelesai }} Selesai</span>
            </div>
        </div>
    </div>

    <!-- Card 4: Pengurus -->
    <div class="col-sm-6 col-xl-3">
        <div class="him-card p-3 h-100 mb-0">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold text-uppercase">Pengurus Aktif</span>
                <div class="p-2 bg-primary-subtle text-primary rounded-3">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="d-flex align-items-baseline gap-2 mb-2">
                <h3 class="mb-0 fw-bold text-dark">{{ $activeMembers }}</h3>
                <span class="small text-muted">Orang</span>
            </div>
            <div class="d-flex gap-2 small">
                <span class="badge bg-primary-subtle text-primary">{{ $totalGalleries }} Galeri</span>
                <span class="badge bg-info-subtle text-info">{{ $totalDownloads }} Berkas & Web</span>
            </div>
        </div>
    </div>
</div>

<!-- Content Tables Section -->
<div class="row g-4 mb-4">
    <!-- Left Column: Recent Aspirations -->
    <div class="col-lg-6">
        <div class="him-card h-100 mb-0">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-comment-dots"></i> Aspirasi Mahasiswa Terbaru
                </h2>
                <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                    Lihat Semua
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Pengirim / Judul</th>
                            <th>Status</th>
                            <th>Waktu</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAspirations as $asp)
                        <tr>
                            <td class="ps-3">
                                <div class="fw-bold text-dark">{{ $asp->title }}</div>
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i>{{ $asp->name ?: 'Anonim' }}
                                    @if($asp->nim) &bull; {{ $asp->nim }} @endif
                                </small>
                            </td>
                            <td>
                                @if($asp->status === 'Baru')
                                    <span class="badge bg-danger-subtle text-danger">Baru</span>
                                @elseif($asp->status === 'Diproses')
                                    <span class="badge bg-primary-subtle text-primary">Diproses</span>
                                @else
                                    <span class="badge bg-success-subtle text-success">Selesai</span>
                                @endif
                            </td>
                            <td class="small text-muted">
                                {{ $asp->created_at->diffForHumans() }}
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.aspirasi.show', $asp) }}" class="btn btn-sm btn-outline-primary rounded-circle" title="Tinjau & Tanggapi">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fs-4 d-block mb-2 text-muted"></i>
                                Belum ada data aspirasi masuk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Recent News -->
    <div class="col-lg-6">
        <div class="him-card h-100 mb-0">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-newspaper"></i> Publikasi Berita Terbaru
                </h2>
                <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                    Lihat Semua
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Judul Berita</th>
                            <th>Status</th>
                            <th>Tayangan</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentNews as $n)
                        <tr>
                            <td class="ps-3">
                                <div class="fw-bold text-dark text-truncate" style="max-width: 260px;">
                                    {{ $n->title }}
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-folder me-1"></i>{{ $n->category ?: 'Umum' }} &bull; {{ $n->published_at ? $n->published_at->format('d M Y') : '-' }}
                                </small>
                            </td>
                            <td>
                                @if($n->status === 'published')
                                    <span class="badge-status-published">Terbit</span>
                                @elseif($n->status === 'draft')
                                    <span class="badge-status-draft">Draft</span>
                                @else
                                    <span class="badge-status-archived">Arsip</span>
                                @endif
                            </td>
                            <td class="small text-muted">
                                <i class="fas fa-eye me-1"></i>{{ number_format($n->views ?? 0) }}
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.berita.edit', $n) }}" class="btn btn-sm btn-outline-secondary rounded-circle" title="Edit Berita">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                <i class="fas fa-newspaper fs-4 d-block mb-2 text-muted"></i>
                                Belum ada berita.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Section: Recent Admin Activity Logs -->
<div class="him-card mb-0">
    <div class="him-card-header">
        <h2 class="him-card-title">
            <i class="fas fa-history"></i> Log Aktivitas Terakhir
        </h2>
        <a href="{{ route('admin.logs.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
            Buka Audit Trail Lengkap
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">Waktu</th>
                    <th>Admin</th>
                    <th>Aksi</th>
                    <th>Keterangan Aktivitas</th>
                    <th class="text-end pe-3">Alamat IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentLogs as $log)
                <tr>
                    <td class="ps-3 small text-muted text-nowrap">
                        <i class="far fa-clock me-1"></i>{{ $log->created_at->format('d M Y, H:i') }}
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 28px; height: 28px; font-size: 0.75rem;">
                                {{ strtoupper(substr($log->user_name ?: 'A', 0, 1)) }}
                            </div>
                            <span class="fw-semibold text-dark small">{{ $log->user_name ?: 'Sistem' }}</span>
                        </div>
                    </td>
                    <td>
                        @php
                            $badgeClass = match($log->action) {
                                'create' => 'bg-success-subtle text-success',
                                'update' => 'bg-primary-subtle text-primary',
                                'delete' => 'bg-danger-subtle text-danger',
                                'login' => 'bg-info-subtle text-info',
                                'logout' => 'bg-secondary-subtle text-secondary',
                                default => 'bg-light text-dark'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }} text-uppercase" style="font-size: 0.72rem;">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="text-dark small">
                        {{ $log->description }}
                    </td>
                    <td class="text-end pe-3 font-monospace small text-muted">
                        {{ $log->ip_address ?: '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="fas fa-clipboard-list fs-4 d-block mb-2 text-muted"></i>
                        Belum ada aktivitas tercatat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
