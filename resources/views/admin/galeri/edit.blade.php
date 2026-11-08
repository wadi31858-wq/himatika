@extends('layouts.admin')

@section('title', 'Edit Foto Galeri')
@section('page_title', 'Perbarui Foto Galeri')
@section('page_subtitle', 'Edit informasi foto, urutan, atau ganti gambar')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-edit"></i> Edit: {{ $gallery->title }}
                </h2>
                <a href="{{ route('admin.galeri.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.galeri.update', $gallery) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Judul / Keterangan Singkat Foto <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $gallery->title) }}" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Kategori / Topik Kegiatan</label>
                        <input type="text" name="category" class="form-control" value="{{ old('category', $gallery->category) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nomor Urut Tampilan</label>
                        <input type="number" name="order_num" class="form-control" value="{{ old('order_num', $gallery->order_num ?? 0) }}" min="0">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Foto Saat Ini:</label>
                    <div class="rounded-3 overflow-hidden border mb-2 text-center bg-light" style="max-height: 220px;">
                        <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="img-fluid" style="max-height: 220px; object-fit: contain;">
                    </div>
                    <label class="form-label fw-semibold text-dark">Ganti Foto (Opsional)</label>
                    <input type="file" name="image" class="form-control" accept="image/png,image/jpeg,image/webp">
                    <div class="form-text">Biarkan kosong jika tidak ingin mengubah foto.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Teks Alternatif (Alt Text)</label>
                    <input type="text" name="alt_text" class="form-control" value="{{ old('alt_text', $gallery->alt_text) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Deskripsi Tambahan</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $gallery->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Status Penerbitan</label>
                    <select name="status" class="form-select" required>
                        <option value="published" {{ old('status', $gallery->status) === 'published' ? 'selected' : '' }}>Terbitkan di Galeri Publik</option>
                        <option value="draft" {{ old('status', $gallery->status) === 'draft' ? 'selected' : '' }}>Simpan Sebagai Draft</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.galeri.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-him-primary px-4">
                        <i class="fas fa-save me-1"></i> Perbarui Foto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
