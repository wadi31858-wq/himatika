@extends('layouts.admin')

@section('title', 'Anggota & Pengurus')
@section('page_title', 'Kelola Anggota & Pengurus')
@section('page_subtitle', 'Data anggota aktif, dewan pengurus harian, dan anggota divisi HIMATIKA')

@section('content')
<div class="him-card">
    <div class="him-card-header">
        <div>
            <h2 class="him-card-title">
                <i class="fas fa-users"></i> Daftar Anggota & Pengurus
            </h2>
            <small class="text-muted">Total: <strong>{{ $members->total() }}</strong> orang terdaftar</small>
        </div>
        <a href="{{ route('admin.pengurus.create') }}" class="btn btn-him-primary">
            <i class="fas fa-plus"></i> Tambah Pengurus Baru
        </a>
    </div>

    <!-- Filter & Search Toolbar -->
    <form method="GET" action="{{ route('admin.pengurus.index') }}" class="row g-2 mb-4">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama, NIM, jabatan, atau divisi..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-2">
            <select name="kelompok" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Kelompok</option>
                <option value="putra" {{ request('kelompok') === 'putra' ? 'selected' : '' }}>Putra</option>
                <option value="putri" {{ request('kelompok') === 'putri' ? 'selected' : '' }}>Putri</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="division" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Divisi / Bidang</option>
                @foreach($divisions as $d)
                    <option value="{{ $d }}" {{ request('division') === $d ? 'selected' : '' }}>{{ $d }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-him-outline w-100">Filter</button>
        </div>
        @if(request()->hasAny(['search', 'kelompok', 'division', 'status']))
            <div class="col-12 mt-1">
                <a href="{{ route('admin.pengurus.index') }}" class="btn btn-sm btn-light">Reset Filter</a>
            </div>
        @endif
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-him align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama & NIM</th>
                    <th>Kelompok</th>
                    <th>Jabatan & Divisi</th>
                    <th>Periode</th>
                    <th>Status</th>
                    <th class="text-end" style="width: 130px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $index => $m)
                <tr>
                    <td>{{ $members->firstItem() + $index }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle overflow-hidden bg-light border d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0;">
                                @if($m->photo)
                                    <img src="{{ asset('storage/' . $m->photo) }}" alt="{{ $m->name }}" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <i class="fas fa-user text-muted"></i>
                                @endif
                            </div>
                            <div>
                                <div class="fw-bold text-dark">{{ $m->name }}</div>
                                <small class="text-muted font-monospace">{{ $m->nim ?: '-' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($m->kelompok === 'putra')
                            <span class="badge bg-primary-subtle text-primary"><i class="fas fa-mars me-1"></i> Putra</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger"><i class="fas fa-venus me-1"></i> Putri</span>
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold text-primary">{{ $m->position }}</div>
                        <small class="badge bg-light text-dark border">{{ $m->division ?: 'Umum' }}</small>
                    </td>
                    <td>
                        <span class="text-dark small">{{ $m->period ?: '-' }}</span>
                    </td>
                    <td>
                        @if($m->is_active)
                            <span class="badge bg-success-subtle text-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('admin.pengurus.edit', $m) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteConfirmModal" 
                                    data-action="{{ route('admin.pengurus.destroy', $m) }}" 
                                    data-title="{{ $m->name }} ({{ $m->position }})"
                                    title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-users-slash fs-1 d-block mb-2 text-muted"></i>
                        Tidak ada data pengurus ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $members->links() }}
    </div>
</div>
@endsection
