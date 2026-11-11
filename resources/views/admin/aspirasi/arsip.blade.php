@extends('layouts.admin')

@section('title', 'Arsip Aspirasi')
@section('page_title', 'Arsip Aspirasi')
@section('page_subtitle', 'Daftar aspirasi yang telah diarsipkan dan dapat dipulihkan sewaktu-waktu')

@section('content')
<div class="him-card">
    <div class="him-card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
            <h2 class="him-card-title mb-0">
                <i class="fas fa-archive text-warning"></i> Arsip Aspirasi Mahasiswa
            </h2>
            <small class="text-muted">Total tersimpan di arsip: <strong>{{ $totalArchived }}</strong> pesan</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Kotak Masuk
            </a>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <form method="GET" action="{{ route('admin.aspirasi.arsip') }}" class="row g-2 mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari judul, nama, atau isi di arsip..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-him-outline w-100">Cari</button>
        </div>
        @if(request('search'))
            <div class="col-md-2">
                <a href="{{ route('admin.aspirasi.arsip') }}" class="btn btn-light w-100">Reset</a>
            </div>
        @endif
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-him align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Pengirim</th>
                    <th>Judul Aspirasi</th>
                    <th>Kategori</th>
                    <th>Status Saat Diarsipkan</th>
                    <th>Waktu Masuk</th>
                    <th class="text-end" style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aspirations as $index => $asp)
                <tr>
                    <td>{{ $aspirations->firstItem() + $index }}</td>
                    <td>
                        <div class="fw-bold text-dark">{{ $asp->name ?: 'Anonim' }}</div>
                        <small class="text-muted">{{ $asp->nim ?: 'NIM tidak dicantumkan' }}</small>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark text-truncate" style="max-width: 280px;">
                            {{ $asp->title }}
                        </div>
                        <small class="text-muted text-truncate d-block" style="max-width: 280px;">
                            {{ Str::limit($asp->message, 70) }}
                        </small>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">{{ $asp->category ?: 'Umum' }}</span>
                    </td>
                    <td>
                        <span class="badge bg-secondary-subtle text-secondary">{{ $asp->status }}</span>
                    </td>
                    <td class="small text-muted text-nowrap">
                        {{ $asp->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            <form action="{{ route('admin.aspirasi.restore', $asp) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-success" title="Pulihkan ke Kotak Masuk" onclick="return confirm('Pulihkan aspirasi ini ke kotak masuk aktif?')">
                                    <i class="fas fa-undo me-1"></i> Pulihkan
                                </button>
                            </form>
                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteConfirmModal" 
                                    data-action="{{ route('admin.aspirasi.destroy', $asp) }}" 
                                    data-title="Aspirasi dari {{ $asp->name }} ({{ $asp->title }})"
                                    title="Hapus Permanen">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-box-open fs-1 d-block mb-2 text-muted"></i>
                        Arsip kosong. Tidak ada pesan aspirasi yang diarsipkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $aspirations->links() }}
    </div>
</div>
@endsection

