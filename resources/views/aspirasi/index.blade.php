@extends('layouts.app')
@section('title', 'Kirim Aspirasi')

@push('styles')
<style>
    .asp-hero {
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--deep-teal) 100%);
        padding: 80px 0 50px;
        position: relative;
        overflow: hidden;
    }
    .asp-hero::before {
        content: '';
        position: absolute;
        top: -80px; left: -80px;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,.06) 0%, transparent 70%);
        border-radius: 50%;
    }
    .asp-hero-label {
        display: inline-block;
        background: rgba(255,255,255,.15);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 2.5px;
        padding: 6px 18px;
        border-radius: 50px;
        margin-bottom: 1.25rem;
    }
    .asp-hero h1 {
        font-size: 2.6rem;
        font-weight: 800;
        color: #fff;
        line-height: 1.2;
        margin-bottom: 0.75rem;
    }
    .asp-hero p {
        font-size: 1rem;
        color: rgba(255,255,255,.65);
        max-width: 480px;
        line-height: 1.7;
    }
    .asp-hero-badge {
        position: absolute;
        right: 10%; top: 50%;
        transform: translateY(-50%);
        width: 120px; height: 120px;
        background: rgba(255,255,255,.08);
        border: 2px solid rgba(255,255,255,.12);
        border-radius: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(8px);
    }
    .asp-hero-badge i {
        font-size: 3rem;
        color: rgba(255,255,255,.5);
    }
    .asp-form-card {
        background: var(--white);
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 4px 24px rgba(0,0,0,.05);
    }
    .asp-form-card .form-control,
    .asp-form-card .form-select {
        border-radius: 10px;
        border: 1px solid rgba(0,0,0,.1);
        font-size: 0.92rem;
    }
    .asp-form-card .form-control:focus,
    .asp-form-card .form-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.2rem rgba(21, 101, 192, 0.15);
    }
    .asp-link-card {
        background: var(--off-white);
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 12px;
        padding: 1.25rem;
        text-align: center;
        margin-top: 1.5rem;
        transition: var(--transition);
    }
    .asp-link-card:hover {
        background: var(--white);
        box-shadow: 0 4px 16px rgba(0,0,0,.06);
    }
    @media (max-width: 991px) {
        .asp-hero h1 { font-size: 2rem; }
        .asp-hero-badge { display: none; }
    }
    @media (max-width: 767px) {
        .asp-hero { padding: 60px 0 35px; }
        .asp-hero h1 { font-size: 1.6rem; }
        .asp-form-card { padding: 1.5rem; }
    }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="asp-hero">
    <div class="container position-relative">
        <span class="asp-hero-badge d-none d-lg-flex"><i class="fas fa-comments"></i></span>
        <span class="asp-hero-label">ASPIRASI</span>
        <h1>Kirim Aspirasi<br>HIMATIKA UNUJA</h1>
        <p>Sampaikan saran, masukan, atau aspirasi Anda untuk kemajuan HIMATIKA UNUJA.</p>
    </div>
</section>

{{-- FORM --}}
<section class="section-padding" style="background: var(--off-white);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" style="border-radius:12px;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="asp-form-card">
                    <form action="{{ route('aspirasi.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">NIM</label>
                                <input type="text" name="nim" class="form-control" value="{{ old('nim') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Kategori</label>
                                <select name="category" class="form-select">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Saran" {{ old('category') == 'Saran' ? 'selected' : '' }}>Saran</option>
                                    <option value="Masukan" {{ old('category') == 'Masukan' ? 'selected' : '' }}>Masukan</option>
                                    <option value="Keluhan" {{ old('category') == 'Keluhan' ? 'selected' : '' }}>Keluhan</option>
                                    <option value="Kritik" {{ old('category') == 'Kritik' ? 'selected' : '' }}>Kritik</option>
                                    <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Judul Aspirasi <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Contoh: Saran untuk kegiatan workshop" required>
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Pesan / Aspirasi <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5" required placeholder="Tuliskan aspirasi Anda secara detail...">{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary-custom btn-lg w-100"><i class="fas fa-paper-plane me-2"></i>Kirim Aspirasi</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="asp-link-card">
                    <a href="{{ route('aspirasi.cek') }}" style="color:var(--primary-green); font-weight:600; text-decoration:none;">
                        <i class="fas fa-search me-1"></i> Cek Status Aspirasi
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
