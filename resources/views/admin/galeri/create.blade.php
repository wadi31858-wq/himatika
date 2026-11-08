@extends('layouts.admin')

@section('title', 'Unggah Foto Galeri')
@section('page_title', 'Unggah Foto Galeri Baru')
@section('page_subtitle', 'Tambahkan dokumentasi foto kegiatan organisasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-image"></i> Formulir Foto Galeri
                </h2>
                <a href="{{ route('admin.galeri.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Judul / Keterangan Singkat Foto <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Contoh: Rapat Kerja Anggota HIMATIKA 2026">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Kategori / Topik Kegiatan</label>
                        <input type="text" name="category" class="form-control" value="{{ old('category') }}" placeholder="Contoh: Rapat Kerja, Seminar, Lomba">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nomor Urut Tampilan</label>
                        <input type="number" name="order_num" class="form-control" value="{{ old('order_num', 0) }}" min="0">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Pilih Berkas Foto <span class="text-danger">*</span></label>
                    <input type="file" name="image" class="form-control" accept="image/png,image/jpeg,image/webp" required>
                    <div class="form-text">Format: JPG, PNG, WebP. Maksimal 5 MB.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Teks Alternatif (Alt Text)</label>
                    <input type="text" name="alt_text" class="form-control" value="{{ old('alt_text') }}" placeholder="Keterangan singkat isi foto">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Deskripsi Tambahan</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Ceritakan momen di balik foto ini...">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Status Penerbitan</label>
                    <select name="status" class="form-select" required>
                        <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Terbitkan di Galeri Publik</option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Simpan Sebagai Draft</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.galeri.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-him-primary px-4">
                        <i class="fas fa-upload me-1"></i> Unggah Foto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
