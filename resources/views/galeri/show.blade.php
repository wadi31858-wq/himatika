@extends('layouts.app')
@section('title', $galeri->title)
@section('content')
<div class="breadcrumb-section">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('galeri') }}" class="text-decoration-none galeri-back-link">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Galeri
        </a>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('galeri') }}">Galeri</a></li>
                <li class="breadcrumb-item active">{{ Str::limit($galeri->title, 25) }}</li>
            </ol>
        </nav>
    </div>
</div>

<section class="section-padding" style="background: #FFF7F9; padding: 50px 0 80px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-semibold mb-3">
                        <i class="fas fa-images me-1"></i> ALBUM DOKUMENTASI
                    </span>
                    <h1 class="fw-bold text-dark mb-2" style="font-size: 2rem;">{{ $galeri->title }}</h1>
                    
                    @if($galeri->category)
                        <div class="text-muted mb-3 small"><i class="fas fa-tag me-1 text-primary"></i> {{ $galeri->category }}</div>
                    @endif

                    @if($galeri->description)
                        <p class="text-secondary mb-4" style="line-height: 1.8;">{{ $galeri->description }}</p>
                    @endif

                    <div class="d-flex align-items-center justify-content-between border-top pt-3 mb-4 text-muted small">
                        <span><i class="fas fa-calendar-alt me-1"></i> {{ $galeri->created_at->format('d F Y') }}</span>
                        <span><i class="fas fa-camera me-1"></i> {{ $galeri->photos->count() ?: 1 }} Foto</span>
                    </div>

                    <!-- Photos Grid -->
                    <div class="row g-3">
                        @if($galeri->photos->count() > 0)
                            @foreach($galeri->photos as $photo)
                                <div class="col-md-4 col-6">
                                    <div class="position-relative rounded-3 overflow-hidden shadow-sm border" style="cursor: pointer; aspect-ratio: 4/3;" onclick="openLightbox('{{ asset('storage/' . $photo->image) }}')">
                                        <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->alt_text ?? $galeri->title }}" class="w-100 h-100" style="object-fit: cover; transition: transform 0.3s ease;">
                                        <div class="position-absolute inset-0 bg-dark bg-opacity-25 opacity-0 hover-opacity-100 d-flex align-items-center justify-content-center transition">
                                            <i class="fas fa-search-plus text-white fs-4"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @elseif($galeri->image)
                            <div class="col-12">
                                <div class="rounded-3 overflow-hidden shadow-sm border" style="cursor: pointer;" onclick="openLightbox('{{ asset('storage/' . $galeri->image) }}')">
                                    <img src="{{ asset('storage/' . $galeri->image) }}" alt="{{ $galeri->title }}" class="w-100 h-auto d-block">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('galeri') }}" class="btn btn-outline-primary px-4 py-2 rounded-pill">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Semua Album
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Lightbox Modal -->
<div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 text-center position-relative">
                <button type="button" class="btn btn-light position-absolute top-0 end-0 m-3 rounded-circle shadow" data-bs-dismiss="modal" aria-label="Tutup">
                    <i class="fas fa-times"></i>
                </button>
                <img id="lightboxImage" src="" class="img-fluid rounded-4 shadow-lg" style="max-height: 85vh;">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openLightbox(src) {
        document.getElementById('lightboxImage').src = src;
        const modal = new bootstrap.Modal(document.getElementById('lightboxModal'));
        modal.show();
    }
</script>
@endpush
