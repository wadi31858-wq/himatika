@extends('layouts.admin')

@section('title', 'Struktur Organisasi')
@section('page_title', 'Kelola Struktur Organisasi')
@section('page_subtitle', 'Hirarki kepengurusan, divisi/bidang, dan susunan jabatan HIMATIKA')

@section('content')
<style>
/* Responsive horizontal scroll wrapper */
.him-tree-scroll-wrapper {
    overflow-x: auto;
    overflow-y: hidden;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
    min-height: 220px;
    background: #fcfcfd;
    border: 1px solid #ebd3da;
    border-radius: 12px;
    padding: 1.5rem 1rem 2rem 1rem;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.02);
}

.him-tree-scroll-wrapper::-webkit-scrollbar {
    height: 9px;
}
.him-tree-scroll-wrapper::-webkit-scrollbar-track {
    background: #f5e8ec;
    border-radius: 6px;
}
.him-tree-scroll-wrapper::-webkit-scrollbar-thumb {
    background: #a33b59;
    border-radius: 6px;
}
.him-tree-scroll-wrapper::-webkit-scrollbar-thumb:hover {
    background: #711c35;
}

/* Org Tree Layout & Connectors */
.him-org-tree,
.him-org-tree ul {
    display: inline-flex;
    justify-content: center;
    list-style-type: none;
    margin: 0 auto;
    padding: 0;
    position: relative;
    white-space: nowrap;
}

.him-tree-children {
    padding-top: 30px !important;
}

/* Downward vertical connector line from parent card to horizontal line */
.him-tree-children::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    border-left: 2px solid #711C35;
    width: 0;
    height: 30px;
    transform: translateX(-50%);
}

.him-tree-item {
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    padding: 30px 14px 0 14px;
}

/* Horizontal connector line branching to siblings */
.him-tree-item::before,
.him-tree-item::after {
    content: '';
    position: absolute;
    top: 0;
    right: 50%;
    border-top: 2px solid #711C35;
    width: 50%;
    height: 30px;
}

.him-tree-item::after {
    right: auto;
    left: 50%;
    border-left: 2px solid #711C35;
}

/* Single child case */
.him-tree-item:only-child::after {
    display: none;
}
.him-tree-item:only-child::before {
    border-top: none;
    border-left: 2px solid #711C35;
    left: 50%;
    right: auto;
    width: 0;
    height: 30px;
}

/* First child connector */
.him-tree-item:first-child::before {
    border: 0 none;
}
.him-tree-item:first-child::after {
    border-top: 2px solid #711C35;
    border-left: 2px solid #711C35;
    border-top-left-radius: 8px;
}

/* Last child connector */
.him-tree-item:last-child::after {
    border: 0 none;
}
.him-tree-item:last-child::before {
    border-top: 2px solid #711C35;
    border-right: 2px solid #711C35;
    border-top-right-radius: 8px;
}

/* Top-level root items do not have parent connectors above them */
.him-org-root-level > .him-tree-item {
    padding-top: 0 !important;
}
.him-org-root-level > .him-tree-item::before,
.him-org-root-level > .him-tree-item::after {
    display: none !important;
}

/* Node Card */
.him-org-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 10px 12px;
    width: 205px;
    min-width: 205px;
    max-width: 205px;
    box-sizing: border-box;
    text-align: center;
    transition: transform 0.18s ease, box-shadow 0.18s ease;
    z-index: 2;
    position: relative;
    white-space: normal;
}

.him-org-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(113, 28, 53, 0.12) !important;
    border-color: #cbd5e1;
}

.him-org-avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    flex-shrink: 0;
}

.him-org-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.him-org-card-title {
    font-size: 0.82rem;
    line-height: 1.25;
}
</style>

<!-- BAGAN HIRARKI ORGANISASI VISUAL -->
<div class="him-card mb-4">
    <div class="him-card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
            <h2 class="him-card-title mb-1">
                <i class="fas fa-sitemap text-primary"></i> Bagan Hirarki Organisasi (Pohon Jabatan)
            </h2>
            <small class="text-muted">Diagram visual susunan atasan–bawahan. Geser ke samping untuk melihat seluruh cabang bagan.</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-light text-dark border px-2 py-1"><i class="fas fa-arrows-left-right me-1 text-primary"></i> Geser Horizontal</span>
            <a href="{{ route('admin.struktur-organisasi.create') }}" class="btn btn-sm btn-him-primary">
                <i class="fas fa-plus"></i> Tambah Posisi
            </a>
        </div>
    </div>

    <!-- Tree Scroll Container -->
    <div class="him-tree-scroll-wrapper text-center">
        @if($roots->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="fas fa-sitemap fs-1 d-block mb-2 text-muted"></i>
                Belum ada struktur organisasi tersimpan.
            </div>
        @else
            <div class="him-org-tree">
                @if($roots->count() === 1)
                    <ul class="him-org-root-level p-0">
                        @foreach($roots as $root)
                            @include('admin.struktur._tree_node', ['node' => $root, 'groupedByParent' => $groupedByParent])
                        @endforeach
                    </ul>
                @else
                    <div class="d-flex flex-wrap justify-content-center gap-4">
                        @foreach($roots as $root)
                            <div class="him-org-tree-branch">
                                <ul class="him-org-root-level p-0">
                                    @include('admin.struktur._tree_node', ['node' => $root, 'groupedByParent' => $groupedByParent])
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- TABEL DATA STRUKTUR -->
<div class="him-card">
    <div class="him-card-header">
        <div>
            <h2 class="him-card-title">
                <i class="fas fa-list-ul"></i> Daftar Data Struktur & Jabatan
            </h2>
            <small class="text-muted">Total: <strong>{{ $structures->total() }}</strong> posisi/jabatan</small>
        </div>
        <a href="{{ route('admin.struktur-organisasi.create') }}" class="btn btn-him-primary">
            <i class="fas fa-plus"></i> Tambah Posisi / Divisi Baru
        </a>
    </div>

    <!-- Filter & Search Toolbar -->
    <form method="GET" action="{{ route('admin.struktur-organisasi.index') }}" class="row g-2 mb-4">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama, jabatan, atau divisi..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="kelompok" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Kelompok</option>
                <option value="putra" {{ request('kelompok') === 'putra' ? 'selected' : '' }}>Putra</option>
                <option value="putri" {{ request('kelompok') === 'putri' ? 'selected' : '' }}>Putri</option>
                <option value="semua" {{ request('kelompok') === 'semua' ? 'selected' : '' }}>Semua / Umum</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-him-outline w-100">Filter</button>
        </div>
        @if(request()->hasAny(['search', 'kelompok']))
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
                    <th>Kelompok</th>
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
                                <div class="d-flex align-items-center gap-1 flex-wrap">
                                    <small class="text-primary fw-semibold">{{ $s->position }}</small>
                                    @if($s->group_photo)
                                        <span class="badge bg-success-subtle text-success py-0 px-1" style="font-size: 0.68rem;" title="Foto bersama divisi tersedia"><i class="fas fa-users-rectangle"></i> Foto Bersama</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($s->kelompok === 'putra')
                            <span class="badge bg-primary-subtle text-primary"><i class="fas fa-mars me-1"></i> Putra</span>
                        @elseif($s->kelompok === 'putri')
                            <span class="badge bg-danger-subtle text-danger"><i class="fas fa-venus me-1"></i> Putri</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary"><i class="fas fa-users me-1"></i> Semua</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">{{ $s->division ?: '-' }}</span>
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
                    <td colspan="8" class="text-center py-5 text-muted">
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
