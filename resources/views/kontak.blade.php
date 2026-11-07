@extends('layouts.app')
@section('title', 'Kontak')

@push('styles')
<style>
    .kontak-hero {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--deep-teal) 100%);
        padding: 80px 0 50px;
        position: relative;
        overflow: hidden;
    }
    .kontak-hero::before {
        content: '';
        position: absolute;
        bottom: -120px; right: -80px;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(221,170,69,.08) 0%, transparent 70%);
        border-radius: 50%;
    }
    .kontak-hero-label {
        display: inline-block;
        background: rgba(255,255,255,.1);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 2.5px;
        padding: 6px 18px;
        border-radius: 50px;
        margin-bottom: 1.25rem;
        backdrop-filter: blur(4px);
    }
    .kontak-hero h1 {
        font-size: 2.6rem;
        font-weight: 800;
        color: #fff;
        line-height: 1.2;
        margin-bottom: 0.75rem;
    }
    .kontak-hero p {
        font-size: 1rem;
        color: rgba(255,255,255,.6);
        max-width: 480px;
        line-height: 1.7;
    }
    .kontak-hero-icons {
        position: absolute;
        right: 10%; top: 50%;
        transform: translateY(-50%);
        display: flex;
        gap: 1rem;
    }
    .kontak-hero-icons span {
        width: 60px; height: 60px;
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(8px);
    }
    .kontak-hero-icons i {
        font-size: 1.3rem;
        color: rgba(255,255,255,.4);
    }
    .kontak-info-card {
        background: var(--white);
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 14px;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }
    .kontak-info-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.85rem 0;
        border-bottom: 1px solid rgba(0,0,0,.04);
    }
    .kontak-info-item:last-child { border-bottom: none; }
    .kontak-info-icon {
        min-width: 44px; height: 44px;
        background: rgba(21,92,87,.08);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .kontak-info-icon i {
        font-size: 1rem;
        color: var(--primary-green);
    }
    .kontak-form-card {
        background: var(--white);
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 14px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,.04);
    }
    .kontak-form-card .form-control {
        border-radius: 10px;
        border: 1px solid rgba(0,0,0,.1);
        font-size: 0.92rem;
    }
    .kontak-form-card .form-control:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.2rem rgba(21,92,87,.15);
    }
    @media (max-width: 991px) {
        .kontak-hero h1 { font-size: 2rem; }
        .kontak-hero-icons { display: none; }
    }
    @media (max-width: 767px) {
        .kontak-hero { padding: 60px 0 35px; }
        .kontak-hero h1 { font-size: 1.6rem; }
    }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="kontak-hero">
    <div class="container position-relative">
        <div class="kontak-hero-icons d-none d-lg-flex">
            <span><i class="fas fa-envelope"></i></span>
            <span><i class="fab fa-whatsapp"></i></span>
            <span><i class="fab fa-instagram"></i></span>
        </div>
        <span class="kontak-hero-label">KONTAK</span>
        <h1>Hubungi Kami<br>HIMATIKA UNUJA</h1>
        <p>Ada pertanyaan atau saran? Jangan ragu untuk menghubungi kami.</p>
    </div>
</section>

{{-- CONTENT --}}
<section class="section-padding" style="background: var(--off-white);">
    <div class="container">
        <div class="row g-4">

            {{-- LEFT: INFO --}}
            <div class="col-lg-5">
                <div class="kontak-info-card">
                    <h5 style="font-size:1.05rem; font-weight:700; color:var(--dark-text); margin-bottom:1rem;">Informasi Kontak</h5>
                    <div class="kontak-info-item">
                        <div class="kontak-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <div style="font-size:0.82rem; font-weight:600; color:var(--dark-text);">Alamat</div>
                            <div style="font-size:0.85rem; color:#888;">Jl. KH Wahid Hasyim No. 170, Jember</div>
                        </div>
                    </div>
                    <div class="kontak-info-item">
                        <div class="kontak-info-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <div style="font-size:0.82rem; font-weight:600; color:var(--dark-text);">Email</div>
                            <div style="font-size:0.85rem; color:#888;">himatika@unuja.ac.id</div>
                        </div>
                    </div>
                    <div class="kontak-info-item">
                        <div class="kontak-info-icon"><i class="fab fa-whatsapp"></i></div>
                        <div>
                            <div style="font-size:0.82rem; font-weight:600; color:var(--dark-text);">WhatsApp</div>
                            <div style="font-size:0.85rem; color:#888;">081234567890</div>
                        </div>
                    </div>
                    <div class="kontak-info-item">
                        <div class="kontak-info-icon"><i class="fab fa-instagram"></i></div>
                        <div>
                            <div style="font-size:0.82rem; font-weight:600; color:var(--dark-text);">Instagram</div>
                            <div style="font-size:0.85rem; color:#888;">@himatika_unuja</div>
                        </div>
                    </div>
                </div>
                <div class="ratio ratio-16x9 mt-3" style="border-radius:14px; overflow:hidden;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18" style="border:0;" allowfullscreen loading="lazy"></iframe>
                </div>
            </div>

            {{-- RIGHT: FORM --}}
            <div class="col-lg-7">
                <div class="kontak-form-card">
                    <h5 style="font-size:1.05rem; font-weight:700; color:var(--dark-text); margin-bottom:1.25rem;"><i class="fas fa-paper-plane me-2" style="color:var(--primary-green);"></i>Kirim Pesan</h5>
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                    @endif
                    <form action="{{ route('kontak.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Subjek</label>
                                <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Pesan <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5" required>{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary-custom"><i class="fas fa-paper-plane me-2"></i>Kirim Pesan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
