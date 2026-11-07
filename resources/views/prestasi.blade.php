@extends('layouts.app')
@section('title', 'Prestasi')

@push('styles')
<style>
    .prestasi-hero {
        background: linear-gradient(135deg, #083F3B 0%, #0B514B 50%, #155C57 100%);
        padding: 80px 0 50px;
        position: relative;
        overflow: hidden;
    }
    .prestasi-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23DDAA45' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .prestasi-hero-label {
        display: inline-block;
        background: var(--gold);
        color: var(--dark-green);
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 2.5px;
        padding: 6px 18px;
        border-radius: 50px;
        margin-bottom: 1.25rem;
    }
    .prestasi-hero h1 {
        font-size: 2.6rem;
        font-weight: 800;
        color: #fff;
        line-height: 1.2;
        margin-bottom: 0.75rem;
    }
    .prestasi-hero p {
        font-size: 1rem;
        color: rgba(255,255,255,.6);
        max-width: 480px;
        line-height: 1.7;
    }
    .prestasi-trophy {
        position: absolute;
        right: 8%; top: 50%;
        transform: translateY(-50%);
        font-size: 6rem;
        color: rgba(221,170,69,.12);
        z-index: 0;
    }
    .prestasi-search-card {
        background: var(--white);
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,.06);
        margin-top: -28px;
        position: relative;
        z-index: 5;
    }
    .prestasi-card {
        background: var(--white);
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 14px;
        padding: 1.5rem;
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .prestasi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 28px rgba(0,0,0,.1);
    }
    .prestasi-rank {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, var(--gold), #f0c860);
        color: var(--dark-green);
        font-size: 0.72rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 50px;
    }
    .prestasi-year {
        display: inline-block;
        background: var(--cream);
        color: var(--dark-text);
        font-size: 0.72rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 50px;
    }
    .prestasi-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0.75rem 0 0.35rem;
    }
    .prestasi-participant {
        font-size: 0.85rem;
        color: var(--primary-green);
        font-weight: 600;
    }
    .prestasi-meta {
        font-size: 0.78rem;
        color: #999;
        margin-bottom: 0.5rem;
    }
    .prestasi-desc {
        font-size: 0.85rem;
        color: #888;
        line-height: 1.6;
        margin-top: auto;
    }
    @media (max-width: 991px) {
        .prestasi-hero h1 { font-size: 2rem; }
        .prestasi-trophy { display: none; }
    }
    @media (max-width: 767px) {
        .prestasi-hero { padding: 60px 0 35px; }
        .prestasi-hero h1 { font-size: 1.6rem; }
    }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="prestasi-hero">
    <div class="container position-relative">
        <span class="prestasi-trophy"><i class="fas fa-trophy"></i></span>
        <span class="prestasi-hero-label">PRESTASI</span>
        <h1>Pencapaian Terbaik<br>Mahasiswa Matematika</h1>
        <p>Jejak prestasi membanggakan yang diraih oleh mahasiswa HIMATIKA UNUJA di berbagai kompetisi.</p>
    </div>
</section>

{{-- SEARCH --}}
<section class="section-padding" style="background: var(--off-white); padding-top: 3.5rem;">
    <div class="container">
        <div class="prestasi-search-card mb-4">
            <form action="{{ route('prestasi') }}" method="GET">
                <div class="row g-2 align-items-center">
                    <div class="col-md-1"><i class="fas fa-trophy" style="color:var(--gold);"></i></div>
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control border-0" placeholder="Cari prestasi..." value="{{ request('search') }}" style="font-size:0.92rem;">
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select border-0" style="font-size:0.92rem;">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $c)
                            <option value="{{ $c }}" {{ request('category') == $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 text-end">
                        <button type="submit" class="btn btn-primary-custom w-100"><i class="fas fa-search me-1"></i> Cari</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- GRID --}}
        <div class="row g-4">
            @forelse($achievements as $a)
            <div class="col-md-6 col-lg-4">
                <div class="prestasi-card">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="prestasi-rank"><i class="fas fa-medal"></i> {{ $a->rank }}</span>
                        <span class="prestasi-year">{{ $a->year }}</span>
                    </div>
                    <div class="prestasi-name">{{ $a->title }}</div>
                    <div class="prestasi-participant"><i class="fas fa-user me-1"></i> {{ $a->participant }}</div>
                    <div class="prestasi-meta">{{ $a->category }} &middot; Tingkat {{ $a->level }}</div>
                    @if($a->description)<p class="prestasi-desc">{{ Str::limit($a->description, 100) }}</p>@endif
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-trophy fa-3x" style="color:rgba(0,0,0,.08);"></i>
                <p style="color:#aaa;">Belum ada prestasi.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">{{ $achievements->links() }}</div>
    </div>
</section>

@endsection
