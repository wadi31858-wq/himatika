@extends('layouts.admin')

@section('title', 'Identitas Website')
@section('page_title', 'Identitas & Meta Informasi Website')
@section('page_subtitle', 'Nama himpunan, singkatan resmi, fakultas/kampus, motto, serta deskripsi SEO')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="him-card">
            <div class="him-card-header d-flex align-items-center justify-content-between">
                <h2 class="him-card-title mb-0">
                    <i class="fas fa-id-card text-primary"></i> Identitas Pokok Website
                </h2>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-info">
                    <i class="fas fa-external-link-alt me-1"></i> Buka Website
                </a>
            </div>

            <form action="{{ route('admin.tampilan.identitas.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold text-dark">Nama Resmi Organisasi <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $profile->title) }}" required placeholder="Contoh: HIMATIKA FMIPA UNUJA">
                        <div class="form-text">Nama lengkap himpunan mahasiswa.</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Singkatan / Akronim</label>
                        <input type="text" name="short_title" class="form-control" value="{{ old('short_title', $siteSettings['site_short_title'] ?? 'HIMATIKA') }}" placeholder="Contoh: HIMATIKA">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Fakultas / Jurusan</label>
                        <input type="text" name="faculty_name" class="form-control" value="{{ old('faculty_name', $siteSettings['site_faculty_name'] ?? 'Fakultas MIPA') }}" placeholder="Fakultas MIPA">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nama Universitas / Kampus</label>
                        <input type="text" name="campus_name" class="form-control" value="{{ old('campus_name', $profile->campus_name) }}" placeholder="Universitas Nurul Jadid">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Slogan / Motto Himpunan</label>
                    <input type="text" name="motto" class="form-control" value="{{ old('motto', $profile->motto) }}" placeholder="Contoh: Synchronized Growth, Reaching New Heights">
                    <div class="form-text">Motto ditampilkan pada banner, header, dan footer website.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Deskripsi Meta (SEO & Pratinjau Tautan)</label>
                    <textarea name="meta_description" class="form-control" rows="3" placeholder="Tuliskan deskripsi ringkas 1-2 kalimat untuk mesin pencari Google dan kartu pratinjau media sosial...">{{ old('meta_description', $profile->meta_description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Kata Kunci SEO (Pisahkan dengan koma)</label>
                    <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $siteSettings['site_meta_keywords'] ?? 'HIMATIKA, UNUJA, Matematika, FMIPA, Nurul Jadid') }}" placeholder="HIMATIKA, UNUJA, Matematika, FMIPA">
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <button type="submit" class="btn btn-him-primary px-4">
                        <i class="fas fa-save me-1"></i> Simpan Identitas Website
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
