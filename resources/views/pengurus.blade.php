@extends('layouts.app')
@section('title', 'Pengurus')

@push('styles')
<style>
    .pengurus-hero {
        background: #FFF7FA;
        padding: 125px 0 45px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid #E2CBD3;
    }
    .pengurus-hero::before {
        content: '';
        position: absolute;
        top: -80px; right: -80px;
        width: 280px; height: 280px;
        background: radial-gradient(circle, rgba(100, 29, 56, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .pengurus-hero::after {
        content: '';
        position: absolute;
        bottom: -60px; left: -60px;
        width: 220px; height: 220px;
        background: radial-gradient(circle, rgba(138, 49, 81, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .pengurus-hero-label {
        display: inline-block;
        background: #641D38;
        color: #FFF7FA;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 2px;
        padding: 6px 18px;
        border-radius: 50px;
        margin-bottom: 12px;
        text-transform: uppercase;
    }
    .pengurus-hero h1 {
        font-size: 2.15rem;
        font-weight: 800;
        color: #32121F;
        line-height: 1.25;
        margin-bottom: 10px;
    }
    .pengurus-hero p {
        font-size: 0.98rem;
        font-weight: 500;
        color: #641D38;
        max-width: 600px;
        line-height: 1.65;
        margin-bottom: 0;
    }
    .pengurus-stat-row {
        display: flex;
        gap: 2rem;
        margin-top: 1.75rem;
    }
    .pengurus-stat-item {
        text-align: left;
    }
    .pengurus-stat-num {
        font-size: 2rem;
        font-weight: 800;
        color: #641D38;
        line-height: 1;
    }
    .pengurus-stat-text {
        font-size: 0.78rem;
        font-weight: 600;
        color: #32121F;
        margin-top: 0.35rem;
    }
    .pengurus-search-card {
        background: var(--white);
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,.06);
        margin-top: -28px;
        position: relative;
        z-index: 5;
    }
    .pengurus-search-card .form-control {
        border-radius: 10px;
        border: 1px solid rgba(0,0,0,.1);
    }
    .pengurus-search-card .form-control:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.2rem rgba(21, 101, 192, 0.15);
    }
    .pengurus-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.25rem;
    }
    .pengurus-card {
        background: var(--white);
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 14px;
        padding: 1.75rem;
        text-align: center;
        transition: var(--transition);
    }
    .pengurus-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 28px rgba(0,0,0,.1);
    }
    .pengurus-avatar {
        width: 80px; height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--cream);
        margin-bottom: 1rem;
    }
    .pengurus-name {
        font-size: 1rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 0.25rem;
    }
    .pengurus-nim {
        font-size: 0.78rem;
        color: #999;
    }
    .pengurus-badge {
        display: inline-block;
        background: var(--primary-green);
        color: #fff;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 50px;
        margin: 0.75rem 0 0.5rem;
    }
    .pengurus-division {
        font-size: 0.78rem;
        color: rgba(16,63,60,.5);
    }
    @media (max-width: 767px) {
        .pengurus-hero { padding: 105px 0 35px; }
        .pengurus-hero h1 { font-size: 1.75rem; margin-bottom: 8px; }
        .pengurus-hero p { font-size: 0.92rem; }
        .pengurus-stat-row { gap: 1.5rem; flex-wrap: wrap; }
        .pengurus-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 480px) {
        .pengurus-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="pengurus-hero">
    <div class="container position-relative">
        <span class="pengurus-hero-label">PENGURUS</span>
        <h1>Tim Pengurus<br>HIMATIKA UNUJA</h1>
        <p>Kenali para pengurus yang berdedikasi menggerakkan HIMATIKA UNUJA periode 2026.</p>
        <div class="pengurus-stat-row">
            <div class="pengurus-stat-item">
                <div class="pengurus-stat-num">{{ $members->total() }}</div>
                <div class="pengurus-stat-text">Total Pengurus</div>
            </div>
            <div class="pengurus-stat-item">
                <div class="pengurus-stat-num">{{ $members->unique('division')->count() }}</div>
                <div class="pengurus-stat-text">Divisi</div>
            </div>
        </div>
    </div>
</section>

{{-- SEARCH --}}
<section class="section-padding" style="background: var(--off-white); padding-top: 3.5rem;">
    <div class="container">
        <div class="pengurus-search-card mb-4">
            <form action="{{ route('pengurus') }}" method="GET">
                <div class="row g-2 align-items-center">
                    <div class="col-md-1"><i class="fas fa-search" style="color: var(--primary-green); font-size: 1.1rem;"></i></div>
                    <div class="col-md-8">
                        <input type="text" name="search" class="form-control border-0" placeholder="Cari nama, NIM, atau divisi..." value="{{ request('search') }}" style="font-size:0.92rem;">
                    </div>
                    <div class="col-md-3 text-end">
                        <button type="submit" class="btn btn-primary-custom w-100"><i class="fas fa-search me-1"></i> Cari</button>
                        @if(request('search'))<a href="{{ route('pengurus') }}" class="btn btn-outline-secondary mt-2 w-100"><i class="fas fa-times me-1"></i> Reset</a>@endif
                    </div>
                </div>
            </form>
        </div>

        {{-- GRID --}}
        <div class="pengurus-grid">
            @forelse($members as $m)
            @php 
                $struct = \App\Models\OrganizationalStructure::where('position', $m->division)->orWhere('position', $m->position)->first();
                $structId = $struct ? $struct->id : 1;
            @endphp
            <div class="pengurus-card" onclick="openDetailModal('{{ $m->name }}', '{{ $m->position }}', '{{ $m->photo ? asset('storage/'.$m->photo) : '' }}', '{{ $m->division }}', {{ $structId }})" style="cursor:pointer;">
                <img src="{{ $m->photo ? asset('storage/'.$m->photo) : 'https://ui-avatars.com/api/?name='.urlencode($m->name).'&background=155C57&color=fff&size=120' }}" alt="{{ $m->name }}" class="pengurus-avatar">
                <div class="pengurus-name">{{ $m->name }}</div>
                <div class="pengurus-nim">NIM: {{ $m->nim }}</div>
                <div class="pengurus-badge">{{ $m->position }}</div>
                @if($m->division)<div class="pengurus-division">{{ $m->division }}</div>@endif
                @if($m->bio)<p style="font-size:0.78rem; color:#aaa; margin-top:0.75rem; line-height:1.5;">{{ Str::limit($m->bio, 60) }}</p>@endif
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-users fa-3x" style="color:rgba(0,0,0,.1);"></i>
                <p style="color:#aaa;">Belum ada data pengurus.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">{{ $members->links() }}</div>
    </div>
</section>

@endsection
