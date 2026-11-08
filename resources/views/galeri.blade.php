@extends('layouts.app')
@section('title', 'Galeri')
@section('content')

<div class="breadcrumb-section">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('home') }}" class="text-decoration-none galeri-back-link">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
        </a>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Galeri</li>
            </ol>
        </nav>
    </div>
</div>

<section class="section-cream galeri-hero">
    <div class="container text-center">
        <span class="galeri-hero-label">GALERI</span>
        <h1 class="galeri-hero-heading">Momen HIMATIKA UNUJA</h1>
        <p class="galeri-hero-desc">Dokumentasi kegiatan yang memperlihatkan semangat, kolaborasi, dan capaian HIMATIKA</p>
    </div>
</section>

<section class="section-off-white galeri-grid-section">
    <div class="container">
        @forelse($galleries as $g)
            @if($loop->first || ($loop->index % 2 === 0))
            <div class="row g-4 mb-4">
            @endif
                <div class="col-md-6">
                    <div class="galeri-card">
                        <div class="galeri-card-img" onclick="openLightbox('{{ asset('storage/' . ($g->cover_image ?? $g->image)) }}')">
                            @if($g->cover_image || $g->image)
                                <img src="{{ asset('storage/' . ($g->cover_image ?? $g->image)) }}" alt="{{ $g->title }}">
                            @else
                                <div class="galeri-placeholder">
                                    <i class="fas fa-camera"></i>
                                    <span>Dokumentasi</span>
                                </div>
                            @endif
                            <div class="galeri-card-overlay">
                                <i class="fas fa-expand"></i>
                            </div>
                        </div>
                        <div class="galeri-card-body">
                            <h3 class="galeri-card-title">{{ $g->title }}</h3>
                            @if($g->activity)
                                <span class="galeri-card-badge"><i class="fas fa-calendar-alt me-1"></i>{{ $g->activity->title }}</span>
                            @endif
                            @if($g->description)
                                <p class="galeri-card-desc">{{ Str::limit($g->description, 100) }}</p>
                            @endif
                            <a href="#" class="galeri-card-link" onclick="event.preventDefault(); openLightbox('{{ asset('storage/' . ($g->cover_image ?? $g->image)) }}');">Buka dokumentasi <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            @if($loop->last || ($loop->index % 2 === 1))
            </div>
            @endif
        @empty
            <div class="text-center py-5">
                <div class="galeri-empty-icon">
                    <i class="fas fa-images"></i>
                </div>
                <h5 class="galeri-empty-title">Belum ada foto galeri.</h5>
                <p class="galeri-empty-desc">Foto dan dokumentasi kegiatan akan ditampilkan di sini.</p>
            </div>
        @endforelse

        <div class="mt-4 d-flex justify-content-center">
            {{ $galleries->links() }}
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
.galeri-back-link{color:rgba(59, 130, 246, 0.8);font-weight:500;font-size:0.9rem;transition:color 0.3s}
.galeri-back-link:hover{color:var(--gold)}
.galeri-hero{padding:80px 0 60px}
.galeri-hero-label{color:var(--primary-green);font-size:0.72rem;font-weight:600;letter-spacing:2px;text-transform:uppercase;border:1px solid rgba(21, 101, 192, 0.25);border-radius:6px;display:inline-block;padding:0.35rem 1rem;margin-bottom:1rem}
.galeri-hero-heading{font-size:2.6rem;font-weight:700;color:var(--dark-text);margin-bottom:1rem}
.galeri-hero-desc{color:#666;font-size:1rem;max-width:560px;margin:0 auto;line-height:1.7}
.galeri-grid-section{padding:60px 0 80px}
.galeri-card{background:var(--white);border:1px solid rgba(0,0,0,0.06);border-radius:14px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.04);transition:all 0.3s ease;height:100%}
.galeri-card:hover{transform:translateY(-4px);box-shadow:0 12px 24px rgba(0,0,0,0.1)}
.galeri-card-img{position:relative;aspect-ratio:16/10;overflow:hidden;cursor:pointer}
.galeri-card-img img{width:100%;height:100%;object-fit:cover;transition:transform 0.5s ease}
.galeri-card:hover .galeri-card-img img{transform:scale(1.05)}
.galeri-placeholder{width:100%;height:100%;background:linear-gradient(135deg,#1565C0 0%,#0D47A1 50%,#0F172A 100%);display:flex;flex-direction:column;align-items:center;justify-content:center;color:var(--white);gap:0.5rem}
.galeri-placeholder i{font-size:2.5rem;opacity:0.5}
.galeri-placeholder span{font-size:0.85rem;font-weight:600;letter-spacing:1px;text-transform:uppercase;opacity:0.6}
.galeri-card-overlay{position:absolute;inset:0;background:rgba(13, 71, 161, 0.6);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity 0.3s ease}
.galeri-card-overlay i{color:#fff;font-size:1.5rem;opacity:0.8}
.galeri-card:hover .galeri-card-overlay{opacity:1}
.galeri-card-body{padding:1.5rem}
.galeri-card-title{font-weight:700;font-size:1.15rem;color:var(--dark-text);margin-bottom:0.5rem;line-height:1.3}
.galeri-card-badge{display:inline-block;font-size:0.72rem;font-weight:600;color:var(--primary-green);background:rgba(21, 101, 192, 0.08);padding:0.25rem 0.7rem;border-radius:6px;margin-bottom:0.75rem}
.galeri-card-desc{font-size:0.85rem;color:#888;line-height:1.6;margin-bottom:1rem}
.galeri-card-link{font-size:0.88rem;font-weight:600;color:var(--deep-teal);text-decoration:none;transition:all 0.3s ease;display:inline-flex;align-items:center}
.galeri-card-link:hover{color:var(--gold)}
.galeri-empty-icon{width:80px;height:80px;border-radius:50%;background:rgba(21, 101, 192, 0.08);display:inline-flex;align-items:center;justify-content:center;margin-bottom:1.25rem}
.galeri-empty-icon i{font-size:2rem;color:var(--primary-green);opacity:0.5}
.galeri-empty-title{font-weight:600;color:var(--dark-text);margin-bottom:0.5rem}
.galeri-empty-desc{color:#999;font-size:0.9rem}

.lightbox-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.92);z-index:9999;display:flex;align-items:center;justify-content:center;animation:lbFadeIn 0.3s ease}
.lightbox-content{position:relative;max-width:90vw;max-height:90vh;display:flex;align-items:center;justify-content:center}
.lightbox-content img{max-width:90vw;max-height:88vh;object-fit:contain;border-radius:8px;box-shadow:0 8px 40px rgba(0,0,0,0.5)}
.lightbox-close{position:fixed;top:20px;right:24px;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);color:#fff;font-size:1.8rem;width:48px;height:48px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.3s ease;z-index:10000;line-height:1;padding:0}
.lightbox-close:hover{background:rgba(255,255,255,0.25);transform:scale(1.1)}
.lightbox-nav{position:fixed;top:50%;transform:translateY(-50%);background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);color:#fff;width:52px;height:52px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1.2rem;transition:all 0.3s ease;z-index:10000}
.lightbox-nav:hover{background:rgba(255,255,255,0.25)}
.lightbox-prev{left:20px}
.lightbox-next{right:20px}
.lightbox-counter{position:fixed;bottom:24px;left:50%;transform:translateX(-50%);color:rgba(255,255,255,0.6);font-size:0.85rem;font-weight:500;z-index:10000}
@keyframes lbFadeIn{from{opacity:0}to{opacity:1}}

@media(max-width:767px){
    .galeri-hero-heading{font-size:1.8rem}
    .galeri-hero{padding:60px 0 40px}
    .galeri-grid-section{padding:40px 0 60px}
    .lightbox-nav{width:40px;height:40px;font-size:1rem}
    .lightbox-prev{left:10px}
    .lightbox-next{right:10px}
}
</style>
@endpush

@push('scripts')
<script>
(function(){
    var galleryImages = [];
    var currentIndex = 0;

    document.querySelectorAll('.galeri-card-img').forEach(function(el){
        var img = el.querySelector('img');
        if(img){
            galleryImages.push(img.src);
        }
    });

    window.openLightbox = function(src){
        currentIndex = galleryImages.indexOf(src);
        if(currentIndex === -1){ currentIndex = 0; }
        renderLightbox();
    };

    function renderLightbox(){
        var existing = document.querySelector('.lightbox-overlay');
        if(existing) existing.remove();

        var overlay = document.createElement('div');
        overlay.className = 'lightbox-overlay';

        var content = document.createElement('div');
        content.className = 'lightbox-content';

        var img = document.createElement('img');
        img.src = galleryImages[currentIndex];
        img.alt = 'Galeri HIMATIKA';

        var closeBtn = document.createElement('button');
        closeBtn.className = 'lightbox-close';
        closeBtn.innerHTML = '&times;';
        closeBtn.onclick = closeLightbox;

        content.appendChild(img);
        content.appendChild(closeBtn);

        if(galleryImages.length > 1){
            var prevBtn = document.createElement('button');
            prevBtn.className = 'lightbox-nav lightbox-prev';
            prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
            prevBtn.onclick = function(e){ e.stopPropagation(); navigateLightbox(-1); };

            var nextBtn = document.createElement('button');
            nextBtn.className = 'lightbox-nav lightbox-next';
            nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
            nextBtn.onclick = function(e){ e.stopPropagation(); navigateLightbox(1); };

            content.appendChild(prevBtn);
            content.appendChild(nextBtn);

            var counter = document.createElement('div');
            counter.className = 'lightbox-counter';
            counter.textContent = (currentIndex + 1) + ' / ' + galleryImages.length;
            overlay.appendChild(counter);
        }

        overlay.appendChild(content);
        overlay.onclick = function(e){ if(e.target === overlay) closeLightbox(); };
        document.body.appendChild(overlay);
        document.body.style.overflow = 'hidden';
    }

    function navigateLightbox(dir){
        currentIndex += dir;
        if(currentIndex < 0) currentIndex = galleryImages.length - 1;
        if(currentIndex >= galleryImages.length) currentIndex = 0;
        renderLightbox();
    }

    function closeLightbox(){
        var lb = document.querySelector('.lightbox-overlay');
        if(lb) lb.remove();
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e){
        var lb = document.querySelector('.lightbox-overlay');
        if(!lb) return;
        if(e.key === 'Escape') closeLightbox();
        if(e.key === 'ArrowLeft') navigateLightbox(-1);
        if(e.key === 'ArrowRight') navigateLightbox(1);
    });
})();
</script>
@endpush
