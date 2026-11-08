@extends('layouts.app')
@section('title', 'Visi & Misi')

@push('styles')
<style>
    .vm-hero {
        background: var(--deep-teal);
        padding: 80px 0 50px;
        position: relative;
        overflow: hidden;
    }
    .vm-hero::before {
        content: '';
        position: absolute;
        top: -120px; right: -80px;
        width: 350px; height: 350px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.12) 0%, transparent 70%);
        border-radius: 50%;
    }
    .vm-hero::after {
        content: '';
        position: absolute;
        bottom: -100px; left: -60px;
        width: 280px; height: 280px;
        background: radial-gradient(circle, rgba(255,255,255,.04) 0%, transparent 70%);
        border-radius: 50%;
    }
    .vm-hero-label {
        display: inline-block;
        background: rgba(59, 130, 246, 0.15);
        color: var(--gold);
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 2.5px;
        padding: 6px 18px;
        border-radius: 50px;
        margin-bottom: 1.25rem;
    }
    .vm-hero h1 {
        font-size: 2.6rem;
        font-weight: 800;
        color: #fff;
        line-height: 1.2;
        margin-bottom: 0.75rem;
    }
    .vm-hero p {
        font-size: 1rem;
        color: rgba(255,255,255,.6);
        max-width: 500px;
        line-height: 1.7;
    }
    .vm-hero-icon {
        position: absolute;
        right: 10%;
        top: 50%;
        transform: translateY(-50%);
        width: 140px; height: 140px;
        background: rgba(59, 130, 246, 0.1);
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
    }
    .vm-hero-icon i {
        font-size: 3.5rem;
        color: var(--gold);
        opacity: .7;
    }
    .vm-visi-card {
        background: var(--white);
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,.05);
        border-left: 4px solid var(--primary-green);
    }
    .vm-visi-card h4 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 1rem;
    }
    .vm-misi-item {
        background: var(--off-white);
        border: 1px solid rgba(0,0,0,.04);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        transition: var(--transition);
    }
    .vm-misi-item:hover {
        background: var(--white);
        box-shadow: 0 4px 16px rgba(0,0,0,.06);
        transform: translateX(4px);
    }
    .vm-misi-num {
        min-width: 36px; height: 36px;
        background: var(--primary-green);
        color: #fff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.82rem;
        font-weight: 700;
    }
    .vm-misi-text {
        font-size: 0.95rem;
        color: var(--dark-text);
        line-height: 1.6;
    }
    @media (max-width: 991px) {
        .vm-hero h1 { font-size: 2rem; }
        .vm-hero-icon { display: none; }
    }
    @media (max-width: 767px) {
        .vm-hero { padding: 60px 0 35px; }
        .vm-hero h1 { font-size: 1.6rem; }
    }
</style>
@endpush

@section('content')

{{-- BREADCRUMB --}}
<section class="vm-hero">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="vm-hero-label">VISI & MISI</span>
                <h1>Arah dan Tujuan<br>HIMATIKA UNUJA</h1>
                <p>Pedoman strategis yang membimbing setiap langkah organisasi menuju keunggulan.</p>
            </div>
            <div class="vm-hero-icon d-none d-lg-flex">
                <i class="fas fa-compass"></i>
            </div>
        </div>
    </div>
</section>

{{-- CONTENT --}}
<section class="section-padding" style="background: var(--off-white);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- VISI --}}
                <div class="vm-visi-card mb-4">
                    <h4><i class="fas fa-eye me-2"></i>Visi</h4>
                    <p class="mb-0" style="font-size:1.05rem; color: var(--dark-text); line-height:1.8;">{{ $vm->vision ?? 'Belum tersedia' }}</p>
                </div>

                {{-- MISI --}}
                <div style="background:var(--white); border:1px solid rgba(0,0,0,.06); border-radius:16px; padding:2.5rem; box-shadow:0 4px 20px rgba(0,0,0,.05);">
                    <h4 style="font-size:1.1rem; font-weight:700; color:var(--primary-green); margin-bottom:1.25rem;"><i class="fas fa-bullseye me-2"></i>Misi</h4>
                    @foreach($mission as $i => $m)
                    <div class="vm-misi-item">
                        <div class="vm-misi-num">{{ $i + 1 }}</div>
                        <div class="vm-misi-text">{{ $m }}</div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
