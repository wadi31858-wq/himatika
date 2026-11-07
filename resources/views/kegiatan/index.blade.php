@extends('layouts.app')
@section('title', 'Kegiatan')
@section('content')
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Info Kegiatan</li>
            </ol>
        </nav>
    </div>
</div>
<section class="info-kegiatan-section" style="min-height: 80vh;">
    <div class="container info-kegiatan-content">
        <h2 class="info-kegiatan-title text-center mb-2">Info Kegiatan HIMATIKA UNUJA</h2>
        <p class="info-kegiatan-desc text-center mx-auto mb-5">Daftar kegiatan, program kerja, serta berbagai acara menarik yang telah dan akan diselenggarakan oleh HIMATIKA UNUJA.</p>
        <div class="row justify-content-center mb-5">
            <div class="col-md-6">
                <form action="{{ route('kegiatan') }}" method="GET">
                    <div class="input-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                        <input type="text" name="search" class="form-control border-0 px-4 py-3" placeholder="Cari kegiatan..." value="{{ request('search') }}">
                        <button class="btn btn-primary-custom px-4" type="submit" style="border-radius: 0;"><i class="fas fa-search"></i></button>
                        @if(request('search'))<a href="{{ route('kegiatan') }}" class="btn btn-light px-3 d-flex align-items-center" style="border-radius: 0; border-left: 1px solid #eee;"><i class="fas fa-times"></i></a>@endif
                    </div>
                </form>
            </div>
        </div>
        <div class="row g-4">
            @forelse($activities as $a)
            <div class="col-md-6 col-lg-4">
                <div class="card card-custom h-100 border-0">
                    <img src="{{ $a->image ? asset('storage/'.$a->image) : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=400' }}" alt="{{ $a->title }}" class="card-img-top">
                    <div class="card-body p-4">
                        <span class="badge-status badge-{{ $a->status === 'Selesai' ? 'selesai' : ($a->status === 'Sedang Berjalan' ? 'berjalan' : 'datang') }} mb-3 d-inline-block">{{ $a->status }}</span>
                        <h5 class="card-title fw-bold"><a href="{{ route('kegiatan.show', $a->slug) }}" class="text-decoration-none text-dark">{{ $a->title }}</a></h5>
                        <p class="card-text text-muted small mb-4">{{ Str::limit(strip_tags($a->description), 100) }}</p>
                        <div class="d-flex flex-column gap-2 text-muted small">
                            <span><i class="fas fa-calendar text-primary me-2"></i>{{ $a->date?->format('d M Y') }}</span>
                            <span><i class="fas fa-map-marker-alt text-primary me-2"></i>{{ $a->location }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-calendar fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada kegiatan.</p>
            </div>
            @endforelse
        </div>
        <div class="mt-5 d-flex justify-content-center">{{ $activities->links() }}</div>
    </div>
</section>
@endsection
