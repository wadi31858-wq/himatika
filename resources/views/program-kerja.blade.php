@extends('layouts.app')
@section('title', 'Program Kerja')

@push('styles')
<style>
    .prog-hero {
        background: var(--off-white);
        padding: 80px 0 50px;
        position: relative;
        overflow: hidden;
    }
    .prog-hero::before {
        content: '';
        position: absolute;
        top: -80px; left: -80px;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(21, 101, 192, 0.06) 0%, transparent 70%);
        border-radius: 50%;
    }
    .prog-hero::after {
        content: '';
        position: absolute;
        bottom: -60px; right: -60px;
        width: 250px; height: 250px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }
    .prog-hero-label {
        display: inline-block;
        background: var(--primary-green);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 2.5px;
        padding: 6px 18px;
        border-radius: 50px;
        margin-bottom: 1.25rem;
    }
    .prog-hero h1 {
        font-size: 2.6rem;
        font-weight: 800;
        color: var(--dark-text);
        line-height: 1.2;
        margin-bottom: 0.75rem;
    }
    .prog-hero p {
        font-size: 1rem;
        color: rgba(16,63,60,.55);
        max-width: 480px;
        line-height: 1.7;
    }
    .prog-stats-row {
        display: flex;
        gap: 2rem;
        margin-top: 2rem;
    }
    .prog-stat-item {
        background: var(--white);
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 12px;
        padding: 1rem 1.5rem;
        text-align: center;
    }
    .prog-stat-num {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary-green);
        line-height: 1;
    }
    .prog-stat-text {
        font-size: 0.72rem;
        color: rgba(16,63,60,.5);
        margin-top: 0.25rem;
    }
    .prog-table-card {
        background: var(--white);
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,.04);
    }
    .prog-table-card thead {
        background: var(--dark-green);
    }
    .prog-table-card th {
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        border: none;
        padding: 0.9rem 1rem;
    }
    .prog-table-card td {
        font-size: 0.88rem;
        vertical-align: middle;
        padding: 0.85rem 1rem;
    }
    .prog-search-card {
        background: var(--white);
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,.06);
        margin-bottom: 1.5rem;
    }
    @media (max-width: 767px) {
        .prog-hero h1 { font-size: 1.8rem; }
        .prog-stats-row { flex-wrap: wrap; gap: 1rem; }
        .prog-stat-item { flex: 1; min-width: 100px; }
    }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="prog-hero">
    <div class="container position-relative">
        <span class="prog-hero-label">PROGRAM KERJA</span>
        <h1>Program Kerja<br>HIMATIKA UNUJA</h1>
        <p>Daftar seluruh program kerja yang telah dan akan dilaksanakan oleh HIMATIKA UNUJA.</p>
        <div class="prog-stats-row">
            <div class="prog-stat-item">
                <div class="prog-stat-num">{{ $programs->total() }}</div>
                <div class="prog-stat-text">Total Program</div>
            </div>
            <div class="prog-stat-item">
                <div class="prog-stat-num">{{ $programs->where('status', 'Selesai')->count() }}</div>
                <div class="prog-stat-text">Selesai</div>
            </div>
            <div class="prog-stat-item">
                <div class="prog-stat-num">{{ $programs->where('status', 'Akan Datang')->count() }}</div>
                <div class="prog-stat-text">Akan Datang</div>
            </div>
        </div>
    </div>
</section>

{{-- CONTENT --}}
<section class="section-padding" style="background: var(--off-white);">
    <div class="container">

        {{-- SEARCH --}}
        <div class="prog-search-card">
            <form action="{{ route('program-kerja') }}" method="GET">
                <div class="row g-2 align-items-center">
                    <div class="col-md-1"><i class="fas fa-search" style="color:var(--primary-green);"></i></div>
                    <div class="col-md-8">
                        <input type="text" name="search" class="form-control border-0" placeholder="Cari program kerja..." value="{{ request('search') }}" style="font-size:0.92rem;">
                    </div>
                    <div class="col-md-3 text-end">
                        <button type="submit" class="btn btn-primary-custom w-100"><i class="fas fa-search me-1"></i> Cari</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="prog-table-card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="color:#fff;">No</th>
                            <th style="color:#fff;">Nama Program</th>
                            <th style="color:#fff;">Divisi</th>
                            <th style="color:#fff;">Tanggal</th>
                            <th style="color:#fff;">Status</th>
                            <th style="color:#fff;">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programs as $p)
                        <tr>
                            <td>{{ $programs->firstItem() + $loop->index }}</td>
                            <td class="fw-bold" style="color:var(--dark-text);">{{ $p->title }}</td>
                            <td><span style="font-size:0.78rem; background:var(--cream); color:var(--dark-text); padding:3px 10px; border-radius:50px;">{{ $p->division }}</span></td>
                            <td style="font-size:0.85rem; color:#888;">{{ $p->date?->format('d M Y') }}</td>
                            <td>
                                <span class="badge-status badge-{{ $p->status === 'Selesai' ? 'selesai' : ($p->status === 'Sedang Berjalan' ? 'berjalan' : 'datang') }}">{{ $p->status }}</span>
                            </td>
                            <td style="font-size:0.85rem; color:#888;">{{ Str::limit($p->description, 60) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-5" style="color:#aaa;">
                            <i class="fas fa-clipboard-list fa-3x mb-3" style="color:rgba(0,0,0,.08);"></i><br>
                            Belum ada program kerja.
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">{{ $programs->links() }}</div>
    </div>
</section>

@endsection
