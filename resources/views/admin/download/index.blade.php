@extends('layouts.admin')

@section('title', 'Galeri Website & Berkas')
@section('page_title', 'Kelola Galeri Website Mahasiswa & Dokumen')
@section('page_subtitle', 'Tautan website karya mahasiswa dan pusat berkas/dokumen HIMATIKA')

@section('content')
<div class="him-card">
    <div class="him-card-header">
        <div>
            <h2 class="him-card-title">
                <i class="fas fa-globe-americas"></i> Galeri Website & Berkas
            </h2>
            <div class="d-flex gap-2 mt-1">
                <span class="badge bg-primary-subtle text-primary">{{ $counts['websites'] }} Website Mahasiswa</span>
                <span class="badge bg-info-subtle text-info">{{ $counts['files'] }} Dokumen Berkas</span>
                <span class="badge bg-light text-muted">Total: {{ $counts['total'] }}</span>
            </div>
        </div>
        <a href="{{ route('admin.download.create') }}" class="btn btn-him-primary">
            <i class="fas fa-plus"></i> Tambah Karya / Berkas Baru
        </a>
    </div>

    <!-- Filter & Search Toolbar -->
    <form method="GET" action="{{ route('admin.download.index') }}" class="row g-2 mb-4">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari judul karya, pembuat, atau kategori..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="type" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Jenis Konten</option>
                <option value="website" {{ request('type') === 'website' ? 'selected' : '' }}>Website Mahasiswa</option>
                <option value="file" {{ request('type') === 'file' ? 'selected' : '' }}>Berkas / Dokumen File</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-him-outline w-100">Filter</button>
        </div>
        @if(request()->hasAny(['search', 'type']))
            <div class="col-md-2">
                <a href="{{ route('admin.download.index') }}" class="btn btn-light w-100">Reset</a>
            </div>
        @endif
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-him align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Judul Karya / Dokumen</th>
                    <th>Jenis & Kategori</th>
                    <th>Pembuat / Pengarang</th>
                    <th>Akses / Tautan</th>
                    <th>Status</th>
                    <th class="text-end" style="width: 130px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($downloads as $index => $d)
                <tr>
                    <td>{{ $downloads->firstItem() + $index }}</td>
                    <td>
                        <div class="fw-bold text-dark">{{ $d->title }}</div>
                        @if($d->description)
                            <small class="text-muted d-block text-truncate" style="max-width: 250px;">{{ $d->description }}</small>
                        @endif
                    </td>
                    <td>
                        @if($d->website_url)
                            <span class="badge bg-primary-subtle text-primary mb-1">
                                <i class="fas fa-globe me-1"></i> Website Mahasiswa
                            </span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary mb-1">
                                <i class="fas fa-file-alt me-1"></i> Berkas {{ strtoupper($d->file_type ?: 'File') }}
                            </span>
                        @endif
                        @if($d->category)
                            <div class="small text-muted">{{ $d->category }}</div>
                        @endif
                    </td>
                    <td>
                        <span class="text-dark small">{{ $d->author_name ?: 'Mahasiswa UNUJA' }}</span>
                    </td>
                    <td>
                        @if($d->website_url)
                            <a href="{{ $d->website_url }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Buka Website">
                                <i class="fas fa-external-link-alt me-1"></i> Kunjungi
                            </a>
                        @elseif($d->file)
                            <a href="{{ asset('storage/' . $d->file) }}" target="_blank" class="btn btn-sm btn-outline-success" title="Unduh Berkas">
                                <i class="fas fa-download me-1"></i> Unduh ({{ $d->file_size ?: 'File' }})
                            </a>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                    <td>
                        @if($d->status === 'published')
                            <span class="badge-status-published">Terbit</span>
                        @else
                            <span class="badge-status-draft">Draft</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('admin.download.edit', $d) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteConfirmModal" 
                                    data-action="{{ route('admin.download.destroy', $d) }}" 
                                    data-title="{{ $d->title }}"
                                    title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-folder-open fs-1 d-block mb-2 text-muted"></i>
                        Belum ada karya website atau berkas dokumen yang tersimpan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $downloads->links() }}
    </div>
</div>
@endsection
