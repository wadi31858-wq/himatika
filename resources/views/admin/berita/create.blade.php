@extends('layouts.admin')

@section('title', 'Tambah Berita')
@section('page_title', 'Tulis Berita / Artikel Baru')
@section('page_subtitle', 'Terbitkan informasi atau simpan sebagai draft')

@section('content')
<form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-edit"></i> Konten Berita
                    </h2>
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Judul Berita <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Masukkan judul berita yang menarik">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Ringkasan / Excerpt</label>
                    <textarea name="excerpt" class="form-control" rows="3" placeholder="Ringkasan 1-2 kalimat untuk tampilan cuplikan kartu berita">{{ old('excerpt') }}</textarea>
                </div>

                <div class="mb-0">
                    <label class="form-label fw-semibold text-dark">Isi Lengkap Berita <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control font-monospace" rows="12" required placeholder="Tuliskan isi berita secara lengkap di sini...">{{ old('content') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Sidebar Options -->
        <div class="col-lg-4">
            <!-- Publishing Box -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-paper-plane"></i> Publikasi
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Status Publikasi</label>
                    <select name="status" class="form-select">
                        <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Terbitkan Langsung (Published)</option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Simpan Sebagai Draft</option>
                        <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Arsip</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Tanggal Terbit</label>
                    <input type="date" name="published_at" class="form-control" value="{{ old('published_at', date('Y-m-d')) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Kategori</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category', 'Kegiatan') }}" placeholder="Contoh: Kegiatan, Akademik, Prestasi">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Nama Penulis</label>
                    <input type="text" name="author" class="form-control" value="{{ old('author', auth()->user()->name) }}">
                </div>

                <button type="submit" class="btn btn-him-primary w-100 py-2">
                    <i class="fas fa-save me-1"></i> Simpan Berita
                </button>
            </div>

            <!-- Thumbnail Upload -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-image"></i> Gambar Sampul
                    </h2>
                </div>

                <div class="mb-3">
                    <input type="file" name="thumbnail" class="form-control" accept="image/png,image/jpeg,image/webp">
                    <div class="form-text">Maksimal 3 MB (JPG, PNG, WebP).</div>
                </div>

                <div class="mb-0">
                    <label class="form-label small fw-semibold text-dark">Keterangan Gambar (Alt Text)</label>
                    <input type="text" name="image_alt" class="form-control" value="{{ old('image_alt') }}" placeholder="Deskripsi gambar untuk aksesibilitas">
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
