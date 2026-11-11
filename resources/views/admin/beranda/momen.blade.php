@extends('layouts.admin')

@section('title', 'Dokumentasi Momen di Beranda')
@section('page_title', 'Kelola Bagian Dokumentasi Momen di Beranda')
@section('page_subtitle', 'Pilih sorotan album galeri, sesuaikan teks pengantar, dan tombol lihat galeri')

@section('content')
<form action="{{ route('admin.beranda.momen.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Left: Text Settings -->
        <div class="col-lg-6">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-camera-retro"></i> Teks & Header Section
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Lencana Section</label>
                    <input type="text" name="home_galeri_badge" class="form-control" value="{{ old('home_galeri_badge', $siteSettings['home_galeri_badge'] ?? 'DOKUMENTASI MOMEN') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Judul Utama <span class="text-danger">*</span></label>
                    <input type="text" name="home_galeri_title" class="form-control" value="{{ old('home_galeri_title', $siteSettings['home_galeri_title'] ?? 'Jejak Langkah & Kebersamaan') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Deskripsi Ringkas</label>
                    <textarea name="home_galeri_desc" class="form-control" rows="3">{{ old('home_galeri_desc', $siteSettings['home_galeri_desc'] ?? 'Setiap momen kebersamaan dan perjuangan terabadikan dalam galeri resmi kegiatan HIMATIKA.') }}</textarea>
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark small">Teks Tombol</label>
                        <input type="text" name="home_galeri_btn_text" class="form-control" value="{{ old('home_galeri_btn_text', $siteSettings['home_galeri_btn_text'] ?? 'Buka Galeri Foto') }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark small">Tautan Tombol</label>
                        <input type="text" name="home_galeri_btn_url" class="form-control" value="{{ old('home_galeri_btn_url', $siteSettings['home_galeri_btn_url'] ?? route('galeri')) }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Featured Gallery Selection -->
        <div class="col-lg-6">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-images text-primary"></i> Sorotan Album Khusus (Opsional)
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Pilih Album Unggulan</label>
                    <select name="home_featured_gallery_id" class="form-select">
                        <option value="">-- Otomatis: Tampilkan Album-album Terbaru --</option>
                        @foreach($galleries as $g)
                            <option value="{{ $g->id }}" {{ old('home_featured_gallery_id', $siteSettings['home_featured_gallery_id'] ?? '') == $g->id ? 'selected' : '' }}>
                                {{ $g->title }} ({{ $g->photos->count() ?: 1 }} foto)
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">Secara bawaan, Beranda menampilkan album-album yang terbit secara dinamis.</div>
                </div>

                <div class="alert alert-info py-2 px-3 small mb-4">
                    <i class="fas fa-info-circle me-1"></i> Seluruh album dan foto-fotonya dikelola melalui modul <strong>Galeri Foto</strong>.
                </div>

                <button type="submit" class="btn btn-him-primary w-100 py-2">
                    <i class="fas fa-save me-1"></i> Simpan Pengaturan Dokumentasi Momen
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
