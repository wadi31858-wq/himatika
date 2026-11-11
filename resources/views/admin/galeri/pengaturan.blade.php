@extends('layouts.admin')

@section('title', 'Pengaturan Halaman Galeri')
@section('page_title', 'Pengaturan Halaman Galeri Publik')
@section('page_subtitle', 'Kelola judul banner, teks pengantar, dan lencana halaman Galeri Foto')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-sliders-h"></i> Header & Teks Halaman Galeri
                </h2>
                <a href="{{ route('galeri') }}" target="_blank" class="btn btn-sm btn-outline-info">
                    <i class="fas fa-external-link-alt me-1"></i> Buka Halaman Publik
                </a>
            </div>

            <form action="{{ route('admin.galeri.pengaturan.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Kapsul Label (Badge Header)</label>
                    <input type="text" name="gallery_page_badge" class="form-control" value="{{ old('gallery_page_badge', $pageBadge) }}" placeholder="Contoh: GALERI">
                    <div class="form-text">Tampil di bagian atas banner halaman galeri.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Judul Utama Halaman <span class="text-danger">*</span></label>
                    <input type="text" name="gallery_page_title" class="form-control" value="{{ old('gallery_page_title', $pageTitle) }}" required placeholder="Contoh: Momen HIMATIKA UNUJA">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Deskripsi Singkat / Pengantar</label>
                    <textarea name="gallery_page_desc" class="form-control" rows="3" placeholder="Tuliskan pengantar singkat galeri dokumentasi">{{ old('gallery_page_desc', $pageDesc) }}</textarea>
                </div>

                <button type="submit" class="btn btn-him-primary py-2 px-4">
                    <i class="fas fa-save me-1"></i> Simpan Pengaturan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
