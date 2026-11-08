@extends('layouts.admin')

@section('title', 'Galeri Foto')
@section('page_title', 'Kelola Galeri Foto')
@section('page_subtitle', 'Dokumentasi visual kegiatan dan momen penting HIMATIKA FMIPA UNUJA')

@section('content')
<div class="him-card">
    <div class="him-card-header">
        <div>
            <h2 class="him-card-title">
                <i class="fas fa-photo-video"></i> Koleksi Foto Galeri
            </h2>
            <small class="text-muted">Total: <strong>{{ $galleries->total() }}</strong> foto tersimpan</small>
        </div>
        <a href="{{ route('admin.galeri.create') }}" class="btn btn-him-primary">
            <i class="fas fa-plus"></i> Unggah Foto Baru
        </a>
    </div>

    <!-- Filter & Search Toolbar -->
    <form method="GET" action="{{ route('admin.galeri.index') }}" class="row g-2 mb-4">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari judul, kategori, atau deskripsi..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Terbit (Published)</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-him-outline w-100">Filter</button>
        </div>
        @if(request()->hasAny(['search', 'status']))
            <div class="col-md-2">
                <a href="{{ route('admin.galeri.index') }}" class="btn btn-light w-100">Reset</a>
            </div>
        @endif
    </form>

    <!-- Grid Cards -->
    <div class="row g-3">
        @forelse($galleries as $g)
        <div class="col-sm-6 col-md-4 col-xl-3">
            <div class="card h-100 border border-light-subtle shadow-sm overflow-hidden" style="border-radius: 12px;">
                <div class="position-relative" style="height: 180px; background: #E2E8F0;">
                    <img src="{{ asset('storage/' . $g->image) }}" alt="{{ $g->title }}" class="w-100 h-100" style="object-fit: cover;">
                    <div class="position-absolute top-0 end-0 m-2">
                        @if($g->status === 'published')
                            <span class="badge bg-success shadow-sm">Terbit</span>
                        @else
                            <span class="badge bg-warning text-dark shadow-sm">Draft</span>
                        @endif
                    </div>
                </div>

                <div class="card-body p-3 d-flex flex-column justify-content-between">
                    <div>
                        <h6 class="fw-bold text-dark mb-1 text-truncate" title="{{ $g->title }}">{{ $g->title }}</h6>
                        @if($g->category)
                            <span class="badge bg-primary-subtle text-primary mb-1">{{ $g->category }}</span>
                        @endif
                        @if($g->description)
                            <p class="small text-muted mb-0 text-truncate">{{ $g->description }}</p>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-2 mt-2 border-top">
                        <small class="text-muted"><i class="far fa-clock me-1"></i>{{ $g->created_at->format('d M Y') }}</small>
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('admin.galeri.edit', $g) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteConfirmModal" 
                                    data-action="{{ route('admin.galeri.destroy', $g) }}" 
                                    data-title="Foto {{ $g->title }}"
                                    title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="fas fa-images fs-1 d-block mb-3 text-muted"></i>
            Tidak ada foto galeri ditemukan.
        </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $galleries->links() }}
    </div>
</div>
@endsection
