@extends('layouts.admin')

@section('title', 'Struktur Organisasi')
@section('page_title', 'Kelola Struktur Organisasi')
@section('page_subtitle', 'Hirarki kepengurusan, divisi/bidang, dan susunan jabatan HIMATIKA')

@section('content')
<div class="him-card">
    <div class="him-card-header">
        <div>
            <h2 class="him-card-title">
                <i class="fas fa-sitemap"></i> Bagan & Hirarki Organisasi
            </h2>
            <small class="text-muted">Total: <strong>{{ $structures->total() }}</strong> posisi/jabatan</small>
        </div>
        <a href="{{ route('admin.struktur-organisasi.create') }}" class="btn btn-him-primary">
            <i class="fas fa-plus"></i> Tambah Posisi / Divisi Baru
        </a>
    </div>

    <!-- Filter & Search Toolbar -->
    <form method="GET" action="{{ route('admin.struktur-organisasi.index') }}" class="row g-2 mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama, jabatan, atau divisi..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-him-outline w-100">Filter</button>
        </div>
        @if(request('search'))
            <div class="col-md-2">
                <a href="{{ route('admin.struktur-organisasi.index') }}" class="btn btn-light w-100">Reset</a>
            </div>
        @endif
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-him align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Pejabat / Jabatan</th>
                    <th>Bidang / Divisi</th>
                    <th>Atasan Langsung</th>
                    <th>Periode</th>
                    <th>Status</th>
                    <th class="text-end" style="width: 130px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($structures as $index => $s)
                <tr>
                    <td>{{ $structures->firstItem() + $index }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle overflow-hidden bg-light border d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; flex-shrink: 0;">
                                @if($s->photo)
                                    <img src="{{ asset('storage/' . $s->photo) }}" alt="{{ $s->name }}" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <i class="fas fa-user text-muted small"></i>
                                @endif
                            </div>
                            <div>
                                <div class="fw-bold text-dark">{{ $s->name }}</div>
                                <small class="text-primary fw-semibold">{{ $s->position }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-primary-subtle text-primary">{{ $s->division ?: '-' }}</span>
                    </td>
                    <td>
                        <span class="text-dark small">{{ $s->parent->name ?? '-' }}</span>
                    </td>
                    <td>
                        <span class="text-muted small">{{ $s->period ?: '-' }}</span>
                    </td>
                    <td>
                        @if($s->is_active)
                            <span class="badge bg-success-subtle text-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('admin.struktur-organisasi.edit', $s) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteConfirmModal" 
                                    data-action="{{ route('admin.struktur-organisasi.destroy', $s) }}" 
                                    data-title="{{ $s->position }} - {{ $s->name }}"
                                    title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-sitemap fs-1 d-block mb-2 text-muted"></i>
                        Belum ada struktur organisasi tersimpan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $structures->links() }}
    </div>
</div>
@endsection
