@extends('layouts.app')
@section('title', 'Galeri Website Mahasiswa')

@push('styles')
<style>
    body {
        background-color: #ebf0ea !important; /* matching structure page */
    }
    
    .breadcrumb-section {
        background: transparent;
        padding: 96px 0 10px;
    }
    .breadcrumb-section .breadcrumb { margin-bottom: 0; padding: 0; }
    .breadcrumb-section .breadcrumb-item a { color: var(--dark-green); text-decoration: none; font-weight: 600; font-size: 0.85rem; transition: var(--transition); }
    .breadcrumb-section .breadcrumb-item a:hover { color: var(--gold); }
    .breadcrumb-section .breadcrumb-item.active { color: rgba(11,81,75,.7); font-size: 0.85rem; }
    .breadcrumb-section .breadcrumb-item + .breadcrumb-item::before { color: rgba(11,81,75,.45); }
    .back-link { display: inline-flex; align-items: center; gap: 6px; color: var(--dark-green); text-decoration: none; font-weight: 600; font-size: 0.85rem; transition: var(--transition); }
    .back-link:hover { color: var(--gold); }

    .doc-hero-card {
        background: linear-gradient(135deg, #f3f6f1, #e9ece4);
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 16px;
        padding: 40px;
        position: relative;
        overflow: hidden;
        margin-bottom: 40px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }
    /* decorative bg text */
    .doc-hero-card::after {
        content: 'WEB';
        position: absolute;
        right: 5%;
        top: 50%;
        transform: translateY(-50%);
        font-size: 150px;
        font-weight: 800;
        color: rgba(15,81,87,0.03);
        pointer-events: none;
        letter-spacing: -5px;
    }
    .doc-hero-card::before {
        content: '</>';
        position: absolute;
        left: 45%;
        top: 50%;
        transform: translateY(-50%);
        font-size: 140px;
        font-weight: 700;
        font-family: monospace;
        color: rgba(15,81,87,0.03);
        pointer-events: none;
    }

    .doc-hero-title {
        font-size: 2.2rem;
        font-weight: 500;
        color: var(--dark-green);
        margin-bottom: 12px;
        position: relative;
        z-index: 2;
    }
    .doc-hero-desc {
        color: rgba(11,81,75,0.7);
        font-size: 0.95rem;
        max-width: 520px;
        line-height: 1.6;
        position: relative;
        z-index: 2;
        margin-bottom: 0;
    }
    
    .doc-stats {
        display: flex;
        gap: 15px;
        position: relative;
        z-index: 2;
    }
    .stat-box {
        background: rgba(255,255,255,0.8);
        border-radius: 12px;
        padding: 15px 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        backdrop-filter: blur(5px);
    }
    .stat-num {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--dark-green);
        line-height: 1;
        margin-bottom: 4px;
    }
    .stat-label {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 1px;
        color: rgba(11,81,75,0.6);
        text-transform: uppercase;
    }

    /* Content header */
    .doc-section-title {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        color: rgba(11,81,75,0.8);
        text-transform: uppercase;
        margin-bottom: 10px;
    }
    .doc-section-heading {
        font-size: 1.6rem;
        font-weight: 500;
        color: var(--dark-green);
        margin-bottom: 30px;
    }
    .doc-pagination-info {
        font-size: 0.8rem;
        color: rgba(11,81,75,0.6);
        text-align: right;
    }

    /* Cards Grid */
    .doc-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 60px;
    }
    .doc-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(0,0,0,0.04);
        text-decoration: none;
    }
    .doc-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    }
    
    .doc-cover {
        background: #f8fafc;
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: 12px;
        height: 180px;
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
    }
    .doc-cover-browser-bar {
        height: 26px;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        padding: 0 10px;
        gap: 5px;
        border-bottom: 1px solid rgba(0,0,0,0.06);
        z-index: 1;
    }
    .browser-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        display: inline-block;
    }
    .browser-dot.red { background: #ef4444; }
    .browser-dot.yellow { background: #f59e0b; }
    .browser-dot.green { background: #10b981; }
    .browser-url-bar {
        margin-left: 6px;
        height: 14px;
        flex: 1;
        max-width: 130px;
        background: #fff;
        border-radius: 4px;
        display: flex;
        align-items: center;
        padding: 0 6px;
        font-size: 8px;
        color: #94a3b8;
    }
    .doc-cover-body {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f8fafc 0%, #edf2f7 100%);
        position: relative;
    }
    .doc-cover-badge {
        background: var(--dark-green);
        color: #fff;
        font-weight: 700;
        font-size: 0.72rem;
        padding: 4px 12px;
        border-radius: 6px;
        position: absolute;
        bottom: 14px;
        left: 14px;
        z-index: 2;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.12);
    }
    .doc-cover-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .doc-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    .doc-year {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--dark-green);
    }
    .doc-type {
        background: #fef08a;
        color: #854d0e;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        text-transform: uppercase;
    }

    .doc-category {
        font-size: 0.65rem;
        font-weight: 700;
        color: #d97706;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }
    .doc-title {
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--dark-green);
        line-height: 1.4;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .doc-desc {
        font-size: 0.8rem;
        color: rgba(11,81,75,0.6);
        line-height: 1.5;
        margin-bottom: 20px;
        flex: 1;
    }

    .doc-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid rgba(0,0,0,0.05);
        padding-top: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--dark-green);
        transition: var(--transition);
    }
    .doc-card:hover .doc-footer {
        color: var(--gold);
    }
    
    @media (max-width: 767px) {
        .doc-hero-title { font-size: 1.8rem; }
        .doc-hero-card::after { font-size: 100px; }
        .doc-hero-card::before { font-size: 120px; left: 10%; }
        .doc-stats { margin-top: 20px; }
    }
</style>
@endpush

@section('content')

{{-- BREADCRUMB --}}
<section class="breadcrumb-section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <a href="{{ route('home') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">Galeri Website</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- CONTENT --}}
<section class="pb-5">
    <div class="container">
        
        {{-- Hero Banner --}}
        <div class="doc-hero-card">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <h1 class="doc-hero-title">Galeri Website Mahasiswa</h1>
                    <p class="doc-hero-desc">Kumpulan website karya mahasiswa selama menempuh pendidikan di UNUJA. Jelajahi karya dan perjalanan belajar teman-teman dalam satu galeri.</p>
                </div>
                <div class="col-md-5 d-flex justify-content-md-end mt-4 mt-md-0">
                    <div class="doc-stats">
                        <div class="stat-box">
                            <div class="stat-num">{{ str_pad($downloads->total(), 2, '0', STR_PAD_LEFT) }}</div>
                            <div class="stat-label">WEBSITE TERSIMPAN</div>
                        </div>
                        <div class="stat-box">
                            @php
                                $latestYear = $downloads->isNotEmpty() 
                                    ? ($downloads->max(fn($item) => $item->created_at ? $item->created_at->format('Y') : null) ?: date('Y'))
                                    : '-';
                            @endphp
                            <div class="stat-num">{{ $latestYear }}</div>
                            <div class="stat-label">TAHUN TERBARU</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section Header --}}
        <div class="row align-items-end mb-4">
            <div class="col-md-8">
                <div class="doc-section-title">KOLEKSI WEBSITE</div>
                <h2 class="doc-section-heading mb-0">Jelajahi website karya teman-teman.</h2>
            </div>
            <div class="col-md-4 doc-pagination-info mt-3 mt-md-0">
                Halaman {{ $downloads->currentPage() }} dari {{ $downloads->lastPage() ?: 1 }}
            </div>
        </div>

        {{-- Grid --}}
        <div class="doc-grid">
            @forelse($downloads as $d)
            @php
                $websiteUrl = '#';
                if (!empty($d->url)) {
                    $websiteUrl = $d->url;
                } elseif (!empty($d->link)) {
                    $websiteUrl = $d->link;
                } elseif (!empty($d->file)) {
                    $websiteUrl = Str::startsWith($d->file, ['http://', 'https://']) ? $d->file : asset('storage/' . $d->file);
                }

                $isImage = false;
                if (!empty($d->image)) {
                    $isImage = true;
                } elseif (!empty($d->file)) {
                    $ext = strtolower(pathinfo($d->file, PATHINFO_EXTENSION));
                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']);
                }

                $author = $d->author ?? $d->creator ?? $d->student_name ?? $d->pembuat ?? null;
            @endphp
            <a href="{{ $websiteUrl }}" class="doc-card" target="_blank" rel="noopener noreferrer">
                <div class="doc-cover">
                    @if($isImage)
                        <img src="{{ asset('storage/' . ($d->image ?? $d->file)) }}" alt="{{ $d->title }}" class="doc-cover-img">
                    @else
                        <div class="doc-cover-browser-bar">
                            <span class="browser-dot red"></span>
                            <span class="browser-dot yellow"></span>
                            <span class="browser-dot green"></span>
                            <span class="browser-url-bar"><i class="fas fa-lock me-1" style="font-size: 7px;"></i> https://...</span>
                        </div>
                        <div class="doc-cover-body">
                            <div class="text-center" style="color: rgba(17,66,50,0.3);">
                                <i class="fas fa-laptop-code" style="font-size: 2.5rem; margin-bottom: 6px;"></i>
                                <div style="font-size: 0.7rem; font-weight: 600; letter-spacing: 0.5px;">WEBSITE PREVIEW</div>
                            </div>
                        </div>
                    @endif
                    <div class="doc-cover-badge">
                        <i class="fas fa-globe me-1"></i> Website
                    </div>
                </div>
                
                <div class="doc-meta">
                    <span class="doc-year">{{ $d->created_at ? $d->created_at->format('Y') : date('Y') }}</span>
                    <span class="doc-type">Website</span>
                </div>

                <div class="doc-category">{{ strtoupper($d->category ?? 'PROYEK MAHASISWA') }}</div>
                <h3 class="doc-title">{{ $d->title }}</h3>
                <p class="doc-desc">
                    @if($author)
                        <strong style="color: var(--dark-green); display: block; margin-bottom: 3px;">
                            <i class="fas fa-user-circle me-1" style="font-size: 0.75rem; opacity: 0.7;"></i> {{ $author }}
                        </strong>
                    @endif
                    {{ Str::limit($d->description, 80) }}
                </p>
                
                <div class="doc-footer">
                    <span>Kunjungi Website</span>
                    <i class="fas fa-arrow-up-right-from-square"></i>
                </div>
            </a>
            @empty
            <div class="col-12 text-center py-5" style="grid-column: 1 / -1;">
                <i class="fas fa-globe mb-3" style="font-size: 3rem; color: rgba(11,81,75,0.2);"></i>
                <h5 style="color: var(--dark-green); font-weight: 600; margin-bottom: 6px;">Belum Ada Website Tersimpan</h5>
                <p style="color: rgba(11,81,75,0.5); font-weight: 500;">Belum ada website karya mahasiswa yang tersedia saat ini.</p>
            </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center">
            {{ $downloads->links() }}
        </div>
    </div>
</section>

@endsection
