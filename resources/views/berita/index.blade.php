@extends('layouts.app')
@section('title', 'Berita')

@section('content')

{{-- ==================== BREADCRUMB ==================== --}}
<section class="berita-breadcrumb">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('home') }}" class="berita-breadcrumb-back">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
            </a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Berita</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- ==================== HERO ==================== --}}
<section class="berita-hero">
    <div class="container text-center">
        <span class="berita-hero-label">BERITA</span>
        <h1 class="berita-hero-title">Artikel dan Kabar HIMATIKA</h1>
        <p class="berita-hero-desc">Liputan terbaru seputar kegiatan organisasi dan pencapaian mahasiswa matematika.</p>
    </div>
</section>

{{-- ==================== FILTER BAR ==================== --}}
<section class="berita-filter-section">
    <div class="container">
        <form id="beritaFilterForm" class="berita-filter-card" method="GET" action="{{ route('berita') }}">
            <div class="row g-3 align-items-end">
                <div class="col-lg-4 col-md-6">
                    <label class="berita-filter-label">Cari berita</label>
                    <div class="position-relative">
                        <i class="fas fa-search berita-filter-icon"></i>
                        <input type="text" name="search" class="form-control berita-filter-input" placeholder="Cari judul atau topik" value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="berita-filter-label">Kategori</label>
                    <select name="category" class="form-select berita-filter-select">
                        <option value="">Semua kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4 col-md-12">
                    <button type="submit" class="berita-filter-btn">
                        <i class="fas fa-filter me-2"></i>Tampilkan Berita
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

{{-- ==================== GRID BERITA ==================== --}}
<section class="berita-grid-section">
    <div class="container">
        <div id="beritaGrid" class="row g-4">
            @forelse($news as $n)
                <div class="col-lg-4 col-md-6">
                    <article class="berita-card">
                        <a href="{{ route('berita.show', $n->slug) }}" class="berita-card-link">
                            <div class="berita-card-img">
                                @if($n->thumbnail)
                                    <img src="{{ asset('storage/' . $n->thumbnail) }}" alt="{{ $n->title }}">
                                @else
                                    <div class="berita-card-placeholder">
                                        <i class="far fa-image mb-2"></i>
                                        <span>Dokumentasi</span>
                                    </div>
                                @endif
                            </div>
                            <div class="berita-card-body">
                                <div class="d-flex gap-2 mb-2">
                                    <span class="berita-badge-category">{{ $n->category }}</span>
                                    @if($n->published_at)
                                        <span class="berita-badge-date">
                                            <i class="far fa-calendar-alt me-1"></i>{{ $n->published_at->format('d M Y') }}
                                        </span>
                                    @endif
                                </div>
                                <h3 class="berita-card-title">{{ $n->title }}</h3>
                                <p class="berita-card-excerpt">{{ Str::limit(strip_tags($n->content), 100) }}</p>
                                <span class="berita-card-readmore">Baca selengkapnya <i class="fas fa-arrow-right ms-1"></i></span>
                            </div>
                        </a>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="berita-empty">
                        <i class="far fa-newspaper"></i>
                        <h4>Berita tidak ditemukan.</h4>
                        <p>Belum ada artikel yang sesuai dengan pencarian Anda.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="berita-pagination-wrapper">
            {{ $news->links() }}
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* ===== BREADCRUMB ===== */
    .berita-breadcrumb {
        background: var(--primary-green);
        padding: 1rem 0;
    }
    .berita-breadcrumb .container {
        color: rgba(255,255,255,0.85);
        font-size: 0.85rem;
    }
    .berita-breadcrumb-back {
        color: rgba(255,255,255,0.9);
        text-decoration: none;
        font-size: 0.85rem;
        transition: color 0.2s;
    }
    .berita-breadcrumb-back:hover {
        color: #fff;
    }
    .berita-breadcrumb .breadcrumb {
        background: transparent;
        margin: 0;
        padding: 0;
        font-size: 0.85rem;
    }
    .berita-breadcrumb .breadcrumb-item a {
        color: rgba(255,255,255,0.7);
        text-decoration: none;
        transition: color 0.2s;
    }
    .berita-breadcrumb .breadcrumb-item a:hover {
        color: #fff;
    }
    .berita-breadcrumb .breadcrumb-item.active {
        color: rgba(255,255,255,0.95);
    }
    .berita-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.5);
    }

    /* ===== HERO ===== */
    .berita-hero {
        background: var(--cream);
        padding: 4rem 0 3rem;
    }
    .berita-hero-label {
        display: inline-block;
        background: var(--gold);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        padding: 0.35rem 1.2rem;
        border-radius: 50px;
        margin-bottom: 1rem;
    }
    .berita-hero-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 2rem;
        color: var(--primary-green);
        margin-bottom: 0.75rem;
    }
    .berita-hero-desc {
        font-size: 1rem;
        color: #555;
        max-width: 520px;
        margin: 0 auto;
    }

    /* ===== FILTER BAR ===== */
    .berita-filter-section {
        padding: 2.5rem 0 1rem;
    }
    .berita-filter-card {
        background: #fff;
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    }
    .berita-filter-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.4rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .berita-filter-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.85rem;
        color: #999;
        pointer-events: none;
    }
    .berita-filter-input,
    .berita-filter-select {
        border: 1px solid rgba(0,0,0,0.12);
        border-radius: 10px;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        color: #333;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .berita-filter-input {
        padding-left: 2.5rem;
    }
    .berita-filter-input:focus,
    .berita-filter-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(21,92,87,0.1);
        outline: none;
    }
    .berita-filter-btn {
        width: 100%;
        background: var(--primary-green);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.6rem 1.5rem;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
    }
    .berita-filter-btn:hover {
        background: #114d48;
        transform: translateY(-1px);
    }
    .berita-filter-btn:active {
        transform: translateY(0);
    }

    /* ===== GRID ===== */
    .berita-grid-section {
        padding: 1rem 0 4rem;
    }

    /* ===== CARD ===== */
    .berita-card {
        background: #fff;
        border: 1px solid rgba(0,0,0,0.06);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        height: 100%;
    }
    .berita-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
    .berita-card-link {
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .berita-card-link:hover {
        color: inherit;
    }
    .berita-card-img {
        width: 100%;
        aspect-ratio: 16/9;
        overflow: hidden;
        background: #f0f0f0;
    }
    .berita-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .berita-card:hover .berita-card-img img {
        transform: scale(1.05);
    }
    .berita-card-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--primary-green) 0%, #1a7a73 50%, var(--gold) 100%);
        color: rgba(255,255,255,0.85);
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 1px;
    }
    .berita-card-placeholder i {
        font-size: 2rem;
        opacity: 0.7;
    }
    .berita-card-body {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .berita-badge-category {
        display: inline-block;
        background: var(--cream);
        color: #8a7a3a;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.25rem 0.7rem;
        border-radius: 50px;
    }
    .berita-badge-date {
        display: inline-flex;
        align-items: center;
        background: transparent;
        color: var(--primary-green);
        font-size: 0.65rem;
        font-weight: 600;
        padding: 0.25rem 0.65rem;
        border-radius: 50px;
        border: 1px solid var(--primary-green);
    }
    .berita-card-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 1.05rem;
        color: var(--primary-green);
        margin: 0.5rem 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .berita-card-excerpt {
        font-size: 0.85rem;
        color: #777;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 0.75rem;
        flex: 1;
    }
    .berita-card-readmore {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--primary-green);
        transition: color 0.2s;
    }
    .berita-card-link:hover .berita-card-readmore {
        color: #114d48;
    }

    /* ===== EMPTY STATE ===== */
    .berita-empty {
        text-align: center;
        padding: 4rem 1rem;
        color: #aaa;
    }
    .berita-empty i {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        opacity: 0.4;
    }
    .berita-empty h4 {
        font-weight: 700;
        color: #666;
        margin-bottom: 0.5rem;
    }
    .berita-empty p {
        font-size: 0.9rem;
        color: #999;
    }

    /* ===== PAGINATION ===== */
    .berita-pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 3rem;
    }
    .berita-pagination-wrapper .pagination {
        gap: 0.3rem;
    }
    .berita-pagination-wrapper .page-link {
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: 8px;
        padding: 0.45rem 0.9rem;
        font-size: 0.85rem;
        color: var(--primary-green);
        transition: all 0.2s;
    }
    .berita-pagination-wrapper .page-link:hover {
        background: var(--cream);
        border-color: var(--primary-green);
        color: var(--primary-green);
    }
    .berita-pagination-wrapper .page-item.active .page-link {
        background: var(--primary-green);
        border-color: var(--primary-green);
        color: #fff;
    }
    .berita-pagination-wrapper .page-item.disabled .page-link {
        color: #ccc;
        background: transparent;
        border-color: rgba(0,0,0,0.05);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 991.98px) {
        .berita-hero-title {
            font-size: 1.7rem;
        }
    }
    @media (max-width: 767.98px) {
        .berita-breadcrumb .container {
            flex-direction: column;
            gap: 0.5rem;
        }
        .berita-hero {
            padding: 3rem 0 2rem;
        }
        .berita-hero-title {
            font-size: 1.5rem;
        }
        .berita-hero-desc {
            font-size: 0.9rem;
        }
        .berita-filter-card {
            padding: 1.25rem;
        }
        .berita-card-title {
            font-size: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#beritaFilterForm').on('submit', function(e) {
            e.preventDefault();
            var $form = $(this);
            var $grid = $('#beritaGrid');

            $.ajax({
                url: $form.attr('action'),
                type: 'GET',
                data: $form.serialize(),
                beforeSend: function() {
                    $grid.css('opacity', '0.5');
                },
                success: function(response) {
                    var $newGrid = $(response).find('#beritaGrid');
                    if ($newGrid.length) {
                        $grid.html($newGrid.html());
                    }
                },
                error: function() {
                    $grid.css('opacity', '1');
                },
                complete: function() {
                    $grid.css('opacity', '1');
                }
            });
        });

        $(document).on('click', '#beritaGrid .pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var $grid = $('#beritaGrid');

            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function() {
                    $grid.css('opacity', '0.5');
                },
                success: function(response) {
                    var $newGrid = $(response).find('#beritaGrid');
                    var $newPagination = $(response).find('.berita-pagination-wrapper');
                    if ($newGrid.length) {
                        $grid.html($newGrid.html());
                    }
                    if ($newPagination.length) {
                        $('.berita-pagination-wrapper').html($newPagination.html());
                    }
                    $('html, body').animate({ scrollTop: $('.berita-grid-section').offset().top - 100 }, 300);
                },
                complete: function() {
                    $grid.css('opacity', '1');
                }
            });
        });
    });
</script>
@endpush
