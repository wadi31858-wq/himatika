@extends('layouts.app')
@section('title', 'Agenda')

@push('styles')
<style>
    .agenda-hero {
        background: var(--cream);
        padding: 80px 0 40px;
    }
    .agenda-hero .agenda-hero-label {
        color: var(--primary-green);
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 2px;
        text-transform: uppercase;
        border: 1px solid rgba(21, 101, 192, 0.3);
        border-radius: 6px;
        display: inline-block;
        padding: 0.35rem 1rem;
        margin-bottom: 1rem;
    }
    .agenda-hero h1 {
        font-size: 2.4rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 0.75rem;
    }
    .agenda-hero p {
        font-size: 1rem;
        color: #666;
        max-width: 540px;
    }
    .agenda-search-card {
        background: var(--white);
        border: 1px solid rgba(0, 0, 0, 0.06);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 1.25rem 1.5rem;
        margin-top: -30px;
        position: relative;
        z-index: 5;
    }
    .agenda-search-card .search-label {
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 0.5rem;
        display: block;
    }
    .agenda-search-card .form-control {
        border-radius: 10px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        font-size: 0.88rem;
        padding: 0.65rem 1rem;
    }
    .agenda-search-card .form-control:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.2rem rgba(21, 101, 192, 0.15);
    }
    .btn-agenda-search {
        background: var(--primary-green);
        color: var(--white);
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.88rem;
        padding: 0.65rem 1.8rem;
        transition: var(--transition);
        white-space: nowrap;
    }
    .btn-agenda-search:hover {
        background: var(--deep-teal);
        color: var(--white);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(21, 101, 192, 0.25);
    }
    .agenda-card {
        background: var(--white);
        border: 1px solid rgba(0, 0, 0, 0.06);
        border-radius: 12px;
        overflow: hidden;
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .agenda-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }
    .agenda-card-img {
        width: 100%;
        aspect-ratio: 16 / 9;
        overflow: hidden;
        position: relative;
    }
    .agenda-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .agenda-card:hover .agenda-card-img img {
        transform: scale(1.05);
    }
    .agenda-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--cream) 0%, #e8e5d8 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: rgba(0, 0, 0, 0.25);
        font-size: 0.85rem;
        font-weight: 600;
        gap: 0.5rem;
    }
    .agenda-placeholder i {
        font-size: 2rem;
    }
    .agenda-card-body {
        padding: 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .agenda-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }
    .badge-date {
        background: rgba(59, 130, 246, 0.12);
        color: var(--dark-green);
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.3rem 0.75rem;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .badge-location {
        background: transparent;
        color: var(--primary-green);
        border: 1px solid rgba(21, 101, 192, 0.3);
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.3rem 0.75rem;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .badge-status {
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.3rem 0.7rem;
        border-radius: 50px;
    }
    .badge-selesai {
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
    }
    .badge-berjalan {
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
    }
    .badge-datang {
        background: rgba(234, 179, 8, 0.1);
        color: #ca8a04;
    }
    .agenda-card-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 0.5rem;
        line-height: 1.35;
    }
    .agenda-card-desc {
        font-size: 0.85rem;
        color: #888;
        line-height: 1.6;
        margin-bottom: 1rem;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .agenda-card-link {
        color: var(--primary-green);
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        transition: var(--transition);
    }
    .agenda-card-link:hover {
        color: var(--deep-teal);
        gap: 0.6rem;
    }
    .agenda-empty {
        text-align: center;
        padding: 4rem 1rem;
        grid-column: 1 / -1;
    }
    .agenda-empty i {
        font-size: 3rem;
        color: rgba(0, 0, 0, 0.12);
        margin-bottom: 1rem;
        display: block;
    }
    .agenda-empty p {
        color: #aaa;
        font-size: 0.95rem;
    }
    .agenda-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
    .agenda-section {
        background: var(--off-white);
        padding: 3rem 0 4rem;
    }
    .breadcrumb-section {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    .pagination .page-item.active .page-link {
        background: var(--primary-green);
        border-color: var(--primary-green);
        color: var(--white);
    }
    .pagination .page-link {
        color: var(--primary-green);
        border-radius: 8px;
        margin: 0 2px;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    @media (max-width: 991px) {
        .agenda-hero h1 {
            font-size: 2rem;
        }
    }
    @media (max-width: 767px) {
        .agenda-hero {
            padding: 60px 0 30px;
        }
        .agenda-hero h1 {
            font-size: 1.6rem;
        }
        .agenda-grid {
            grid-template-columns: 1fr;
        }
        .agenda-search-card {
            padding: 1rem;
        }
    }
</style>
@endpush

@section('content')

{{-- ==================== BREADCRUMB ==================== --}}
<div class="breadcrumb-section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <a href="{{ route('home') }}" class="text-decoration-none" style="color: rgba(255,255,255,0.65); font-size: 0.85rem; font-weight: 500;">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
            </a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: none; padding: 0; margin: 0;">
                    <li class="breadcrumb-item" style="font-size: 0.82rem;"><a href="{{ route('home') }}" style="color: rgba(59, 130, 246, 0.8); text-decoration: none; font-weight: 500;">Beranda</a></li>
                    <li class="breadcrumb-item active" style="color: var(--white); font-size: 0.82rem; font-weight: 600;" aria-current="page">Agenda</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

{{-- ==================== HERO ==================== --}}
<section class="agenda-hero">
    <div class="container">
        <span class="agenda-hero-label">AGENDA</span>
        <h1>Agenda dan Program HIMATIKA</h1>
        <p>Agenda dirancang untuk menguatkan kompetensi akademik, solidaritas, dan kontribusi sosial.</p>
    </div>
</section>

{{-- ==================== SEARCH + GRID ==================== --}}
<section class="agenda-section">
    <div class="container">

        {{-- Search Bar --}}
        <div class="agenda-search-card mb-5">
            <form id="agendaSearchForm" action="{{ route('agenda') }}" method="GET">
                <div class="row g-2 align-items-end">
                    <div class="col-lg-2 col-md-3 col-sm-12">
                        <label class="search-label mb-md-0">Cari agenda</label>
                    </div>
                    <div class="col-lg-7 col-md-6 col-sm-9">
                        <input type="text" name="search" class="form-control" placeholder="Cari judul atau kegiatan" value="{{ request('search') }}" id="agendaSearchInput">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <button type="submit" class="btn btn-agenda-search w-100">
                            <i class="fas fa-search me-1"></i> Tampilkan Agenda
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Agenda Grid --}}
        <div id="agendaGrid" class="agenda-grid">
            @forelse($agendas as $a)
                <div class="agenda-card">
                    <div class="agenda-card-img">
                        @if($a->image)
                            <img src="{{ asset('storage/' . $a->image) }}" alt="{{ $a->title }}">
                        @else
                            <div class="agenda-placeholder">
                                <i class="far fa-image"></i>
                                <span>Dokumentasi</span>
                            </div>
                        @endif
                    </div>
                    <div class="agenda-card-body">
                        <div class="agenda-badges">
                            <span class="badge-date">
                                <i class="far fa-calendar-alt"></i>
                                {{ $a->date->format('d M Y') }}
                            </span>
                            @if($a->location)
                                <span class="badge-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $a->location }}
                                </span>
                            @endif
                            <span class="badge-status badge-{{ $a->status === 'Selesai' ? 'selesai' : ($a->status === 'Sedang Berjalan' ? 'berjalan' : 'datang') }}">
                                {{ $a->status }}
                            </span>
                        </div>
                        <h5 class="agenda-card-title">{{ $a->title }}</h5>
                        <p class="agenda-card-desc">{{ $a->description }}</p>
                        <a href="#" class="agenda-card-link">Lihat detail agenda <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i></a>
                    </div>
                </div>
            @empty
                <div class="agenda-empty">
                    <i class="far fa-calendar-alt"></i>
                    <p>Belum ada agenda.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-5 d-flex justify-content-center">
            {{ $agendas->links() }}
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var searchForm = document.getElementById('agendaSearchForm');
    var searchInput = document.getElementById('agendaSearchInput');
    var agendaGrid = document.getElementById('agendaGrid');

    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        var url = searchForm.action + '?' + new URLSearchParams(new FormData(searchForm)).toString();

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(function(response) { return response.text(); })
        .then(function(html) {
            var parser = new DOMParser();
            var doc = parser.parseFromString(html, 'text/html');
            var newGrid = doc.getElementById('agendaGrid');
            var newPagination = doc.querySelector('.mt-5.d-flex.justify-content-center');

            if (newGrid) {
                agendaGrid.innerHTML = newGrid.innerHTML;
            }
            var paginationContainer = document.querySelector('.mt-5.d-flex.justify-content-center');
            if (paginationContainer && newPagination) {
                paginationContainer.innerHTML = newPagination.innerHTML;
            }

            window.history.pushState({}, '', url);
        })
        .catch(function() {
            searchForm.submit();
        });
    });

    var debounceTimer;
    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function() {
            searchForm.dispatchEvent(new Event('submit'));
        }, 500);
    });

    window.addEventListener('popstate', function() {
        searchForm.dispatchEvent(new Event('submit'));
    });
});
</script>
@endpush