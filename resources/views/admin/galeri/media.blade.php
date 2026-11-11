@extends('layouts.admin')

@section('title', 'Koleksi Foto & Video')
@section('page_title', 'Pustaka Foto & Media Galeri')
@section('page_subtitle', 'Seluruh foto dan media yang telah diunggah ke dalam album kegiatan')

@section('content')
<div class="him-card">
    <div class="him-card-header">
        <h2 class="him-card-title">
            <i class="fas fa-photo-video"></i> Seluruh Media Tersimpan ({{ $photos->total() }})
        </h2>
        <a href="{{ route('admin.galeri.create') }}" class="btn btn-sm btn-him-primary">
            <i class="fas fa-plus-circle me-1"></i> Unggah Album Baru
        </a>
    </div>

    <div class="row g-3">
        @forelse($photos as $photo)
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="card h-100 border shadow-sm rounded-3 overflow-hidden">
                    <img src="{{ asset('storage/' . $photo->image) }}" class="card-img-top" style="height: 140px; object-fit: cover;">
                    <div class="card-body p-2">
                        <div class="fw-semibold text-truncate small" title="{{ $photo->gallery->title ?? 'Album' }}">
                            {{ $photo->gallery->title ?? '-' }}
                        </div>
                        <div class="text-muted" style="font-size: 0.72rem;">
                            {{ $photo->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="fas fa-images fs-1 opacity-50 mb-2"></i>
                <div>Belum ada media tersimpan.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $photos->links() }}
    </div>
</div>
@endsection

