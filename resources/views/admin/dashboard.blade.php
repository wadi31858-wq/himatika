@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<h4 class="fw-bold mb-4">Dashboard</h4>
<div class="row g-4 mb-4">
    <div class="col-md-4 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                <h3 class="mb-0">{{ $totalMembers }}</h3>
                <small class="text-muted">Pengurus</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="fas fa-newspaper fa-2x text-success mb-2"></i>
                <h3 class="mb-0">{{ $totalNews }}</h3>
                <small class="text-muted">Berita</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="fas fa-calendar fa-2x text-info mb-2"></i>
                <h3 class="mb-0">{{ $totalActivities }}</h3>
                <small class="text-muted">Kegiatan</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="fas fa-tasks fa-2x text-warning mb-2"></i>
                <h3 class="mb-0">{{ $totalPrograms }}</h3>
                <small class="text-muted">Program Kerja</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="fas fa-trophy fa-2x text-danger mb-2"></i>
                <h3 class="mb-0">{{ $totalAchievements }}</h3>
                <small class="text-muted">Prestasi</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="fas fa-images fa-2x text-purple mb-2"></i>
                <h3 class="mb-0">{{ $totalGalleries }}</h3>
                <small class="text-muted">Galeri</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="fas fa-envelope fa-2x text-secondary mb-2"></i>
                <h3 class="mb-0">{{ $totalMessages }}</h3>
                <small class="text-muted">Pesan ({{ $unreadMessages }} belum dibaca)</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="fas fa-user-plus fa-2x text-info mb-2"></i>
                <h3 class="mb-0">{{ $totalRegistrations }}</h3>
                <small class="text-muted">Pendaftar ({{ $pendingRegistrations }} menunggu)</small>
            </div>
        </div>
    </div>
</div>
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold"><i class="fas fa-envelope me-2"></i>Pesan Terbaru</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <tbody>
                            @forelse($recentMessages as $m)
                            <tr>
                                <td>
                                    <strong>{{ $m->name }}</strong>
                                    <br><small class="text-muted">{{ $m->subject }}</small>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.pesan.show', $m) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr><td class="text-center py-3 text-muted">Tidak ada pesan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold"><i class="fas fa-newspaper me-2"></i>Berita Terbaru</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <tbody>
                            @forelse($recentNews as $n)
                            <tr>
                                <td>
                                    <strong>{{ $n->title }}</strong>
                                    <br><small class="text-muted">{{ $n->published_at?->format('d M Y') }}</small>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.berita.edit', $n) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr><td class="text-center py-3 text-muted">Tidak ada berita.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
