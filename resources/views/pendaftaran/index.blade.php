@extends('layouts.app')
@section('title', 'Pendaftaran Pengurus Baru')

@push('styles')
<style>
    .reg-hero {
        background: var(--dark-green);
        padding: 80px 0 50px;
        position: relative;
        overflow: hidden;
    }
    .reg-hero::before {
        content: '';
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    .reg-hero-label {
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
    .reg-hero h1 {
        font-size: 2.6rem;
        font-weight: 800;
        color: #fff;
        line-height: 1.2;
        margin-bottom: 0.75rem;
    }
    .reg-hero p {
        font-size: 1rem;
        color: rgba(255,255,255,.6);
        max-width: 480px;
        line-height: 1.7;
    }
    .reg-hero-steps {
        display: flex;
        gap: 1.5rem;
        margin-top: 2rem;
    }
    .reg-hero-step {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .reg-hero-step-num {
        min-width: 36px; height: 36px;
        background: rgba(59, 130, 246, 0.15);
        border: 1px solid rgba(59, 130, 246, 0.25);
        color: var(--gold);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.82rem;
        font-weight: 700;
    }
    .reg-hero-step-text {
        font-size: 0.85rem;
        color: rgba(255,255,255,.7);
    }
    .reg-form-card {
        background: var(--white);
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 4px 24px rgba(0,0,0,.05);
    }
    .reg-form-section {
        font-size: 1rem;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--cream);
    }
    .reg-form-card .form-control,
    .reg-form-card .form-select {
        border-radius: 10px;
        border: 1px solid rgba(0,0,0,.1);
        font-size: 0.92rem;
    }
    .reg-form-card .form-control:focus,
    .reg-form-card .form-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.2rem rgba(21, 101, 192, 0.15);
    }
    .reg-link-card {
        background: var(--off-white);
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 12px;
        padding: 1.25rem;
        text-align: center;
        margin-top: 1.5rem;
        transition: var(--transition);
    }
    .reg-link-card:hover {
        background: var(--white);
        box-shadow: 0 4px 16px rgba(0,0,0,.06);
    }
    @media (max-width: 991px) {
        .reg-hero h1 { font-size: 2rem; }
        .reg-hero-steps { flex-wrap: wrap; gap: 1rem; }
    }
    @media (max-width: 767px) {
        .reg-hero { padding: 60px 0 35px; }
        .reg-hero h1 { font-size: 1.6rem; }
        .reg-form-card { padding: 1.5rem; }
    }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="reg-hero">
    <div class="container position-relative">
        <span class="reg-hero-label">PENDAFTARAN</span>
        <h1>Bergabung dengan<br>HIMATIKA UNUJA</h1>
        <p>Kembangkan potensi Anda bersama HIMATIKA UNUJA. Daftarkan diri Anda sekarang!</p>
        <div class="reg-hero-steps">
            <div class="reg-hero-step">
                <div class="reg-hero-step-num">1</div>
                <div class="reg-hero-step-text">Isi Formulir</div>
            </div>
            <div class="reg-hero-step">
                <div class="reg-hero-step-num">2</div>
                <div class="reg-hero-step-text">Verifikasi</div>
            </div>
            <div class="reg-hero-step">
                <div class="reg-hero-step-num">3</div>
                <div class="reg-hero-step-text">Interview</div>
            </div>
            <div class="reg-hero-step">
                <div class="reg-hero-step-num">4</div>
                <div class="reg-hero-step-text">Diterima</div>
            </div>
        </div>
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

                <div class="reg-form-card">
                    <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="reg-form-section"><i class="fas fa-user me-2"></i>Data Diri</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">NIM <span class="text-danger">*</span></label>
                                <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}" required>
                                @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">No. WhatsApp</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Jenis Kelamin</label>
                                <select name="gender" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Tempat Lahir</label>
                                <input type="text" name="place_of_birth" class="form-control" value="{{ old('place_of_birth') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Tanggal Lahir</label>
                                <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Foto (KTP/KTM)</label>
                                <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                                @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Alamat</label>
                                <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                            </div>
                        </div>

                        <div class="reg-form-section"><i class="fas fa-graduation-cap me-2"></i>Data Akademik</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Program Studi</label>
                                <input type="text" name="study_program" class="form-control" value="{{ old('study_program', 'Matematika') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Semester</label>
                                <select name="semester" class="form-select">
                                    <option value="">Pilih</option>
                                    @for($i = 1; $i <= 14; $i++)
                                    <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="reg-form-section"><i class="fas fa-file-alt me-2"></i>Motivasi & Pengalaman</div>
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Alasan Bergabung <span class="text-danger">*</span></label>
                                <textarea name="reason" class="form-control @error('reason') is-invalid @enderror" rows="4" required placeholder="Tuliskan alasan Anda ingin bergabung dengan HIMATIKA UNUJA...">{{ old('reason') }}</textarea>
                                @error('reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Pengalaman Organisasi</label>
                                <textarea name="experience" class="form-control" rows="3" placeholder="Pengalaman kepengurusan sebelumnya...">{{ old('experience') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.85rem; font-weight:600;">Keahlian</label>
                                <textarea name="skills" class="form-control" rows="3" placeholder="Keahlian yang dimiliki (contoh: pemrograman, desain, dll.)">{{ old('skills') }}</textarea>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary-custom btn-lg"><i class="fas fa-paper-plane me-2"></i>Kirim Pendaftaran</button>
                        </div>
                    </form>
                </div>

                <div class="reg-link-card">
                    <a href="{{ route('pendaftaran.cek') }}" style="color:var(--primary-green); font-weight:600; text-decoration:none;">
                        <i class="fas fa-search me-1"></i> Cek Status Pendaftaran
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
