@extends('layouts.admin')

@section('title', 'Berita & Artikel')
@section('page_title', 'Kelola Berita & Artikel')
@section('page_subtitle', 'Publikasi kabar terbaru, artikel, dan dokumentasi informasi HIMATIKA')

@section('content')
<div class="him-card">
    <div class="him-card-header">
        <div>
            <h2 class="him-card-title">
                <i class="fas fa-newspaper"></i> Daftar Berita
            </h2>
            <div class="d-flex gap-2 mt-1">
                <span class="badge bg-success-subtle text-success">{{ $counts['published'] }} Terbit</span>
                <span class="badge bg-warning-subtle text-warning-emphasis">{{ $counts['draft'] }} Draft</span>
                <span class="badge bg-light text-muted">Total: {{ $counts['total'] }}</span>
            </div>
        </div>
        <a href="{{ route('admin.berita.create') }}" class="btn btn-him-primary">
            <i class="fas fa-plus"></i> Tambah Berita Baru
        </a>
    </div>

    <!-- Filter & Search -->
    <form method="GET" action="{{ route('admin.berita.index') }}" class="row g-2 mb-4">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari judul, kategori, atau penulis..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Terbit (Published)</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Arsip</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-him-outline w-100">Filter</button>
        </div>
        @if(request()->hasAny(['search', 'status']))
            <div class="col-md-2">
                <a href="{{ route('admin.berita.index') }}" class="btn btn-light w-100">Reset</a>
            </div>
        @endif
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-him align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th style="width: 90px;">Thumbnail</th>
                    <th>Judul Berita</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Status</th>
                    <th>Tanggal Terbit</th>
                    <th class="text-end" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $index => $n)
                <tr>
                    <td>{{ $news->firstItem() + $index }}</td>
                    <td>
                        <div class="rounded-3 overflow-hidden bg-light border" style="width: 70px; height: 50px;">
                            @if($n->thumbnail)
                                <img src="{{ asset('storage/' . $n->thumbnail) }}" alt="{{ $n->title }}" class="w-100 h-100" style="object-fit: cover;">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ $n->title }}</div>
                        <small class="text-muted"><i class="fas fa-eye me-1"></i>{{ number_format($n->views ?? 0) }} tayangan</small>
                    </td>
                    <td>
                        <span class="badge bg-primary-subtle text-primary">{{ $n->category ?: 'Umum' }}</span>
                    </td>
                    <td class="small text-muted">{{ $n->author ?: 'Admin' }}</td>
                    <td>
                        @if($n->status === 'published')
                            <span class="badge-status-published">Terbit</span>
                        @elseif($n->status === 'draft')
                            <span class="badge-status-draft">Draft</span>
                        @else
                            <span class="badge-status-archived">Arsip</span>
                        @endif
                    </td>
                    <td class="small text-muted text-nowrap">
                        {{ $n->published_at ? $n->published_at->format('d M Y') : '-' }}
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            @if($n->status === 'published')
                                <a href="{{ route('berita.show', $n->slug) }}" target="_blank" class="btn btn-sm btn-outline-info" title="Lihat di Publik">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            @endif
                            <a href="{{ route('admin.berita.edit', $n) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteConfirmModal" 
                                    data-action="{{ route('admin.berita.destroy', $n) }}" 
                                    data-title="{{ $n->title }}"
                                    title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="fas fa-newspaper fs-1 d-block mb-2 text-muted"></i>
                        Tidak ada data berita yang cocok.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $news->links() }}
    </div>
</div>
@endsection
