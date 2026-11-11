@extends('layouts.admin')

@section('title', 'Edit Website / Berkas')
@section('page_title', 'Perbarui Website Mahasiswa / Berkas')
@section('page_subtitle', 'Edit data karya website, perbarui link, atau ganti berkas dokumen')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="him-card">
            <div class="him-card-header d-flex align-items-center justify-content-between">
                <h2 class="him-card-title mb-0">
                    <i class="fas fa-edit text-primary"></i> Edit: {{ $download->title }}
                </h2>
                <a href="{{ route('admin.download.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.download.update', $download) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Nama Proyek / Judul Dokumen <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $download->title) }}" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Pembuat / Mahasiswa</label>
                        <input type="text" name="author_name" class="form-control" value="{{ old('author_name', $download->author_name) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-dark">Tahun / Angkatan</label>
                        <input type="text" name="year" class="form-control" value="{{ old('year', $download->year ?? date('Y')) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-dark">Urutan Tampil</label>
                        <input type="number" name="order_num" class="form-control" value="{{ old('order_num', $download->order_num ?? 0) }}" min="0">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Kategori</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category', $download->category) }}">
                </div>

                <!-- Access Section -->
                <div class="p-3 mb-3 bg-light rounded-3 border">
                    <div class="fw-bold text-dark mb-2">
                        <i class="fas fa-layer-group text-primary me-1"></i> Data Akses & Lampiran
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-globe text-primary me-1"></i> URL Demo / Website Mahasiswa
                            </label>
                            <input type="url" name="website_url" class="form-control" value="{{ old('website_url', $download->website_url) }}" placeholder="https://...">
                            <div class="form-text">Masukkan tautan jika karya berupa website online.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-file-upload text-success me-1"></i> Berkas Dokumen Fisik
                            </label>
                            @if($download->file)
                                <div class="d-flex align-items-center gap-2 mb-2 p-2 bg-white rounded border">
                                    <i class="fas fa-file-alt text-primary fs-5"></i>
                                    <div class="small">
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 180px;">{{ basename($download->file) }}</div>
                                        <div class="text-muted">{{ $download->file_size ?: 'Ukuran file' }} &bull; {{ strtoupper($download->file_type ?: 'File') }}</div>
                                    </div>
                                    <a href="{{ asset('storage/' . $download->file) }}" target="_blank" class="btn btn-sm btn-outline-primary ms-auto">
                                        Unduh
                                    </a>
                                </div>
                            @endif
                            <input type="file" name="file" class="form-control">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengganti file lama.</div>
                        </div>
                    </div>
                </div>

                <!-- Preview Image -->
                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">
                        <i class="fas fa-image text-info me-1"></i> Gambar Pratinjau / Thumbnail
                    </label>
                    @if($download->preview_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $download->preview_image) }}" alt="Pratinjau" style="height: 120px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                        </div>
                    @endif
                    <input type="file" name="preview_image" class="form-control" accept="image/*">
                    <div class="form-text">Biarkan kosong jika tetap menggunakan gambar pratinjau yang ada. Maksimal 4 MB.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Ringkasan / Deskripsi Singkat</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $download->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Status Penerbitan</label>
                    <select name="status" class="form-select" required>
                        <option value="published" {{ old('status', $download->status) === 'published' ? 'selected' : '' }}>Tampilkan di Galeri Website Publik</option>
                        <option value="draft" {{ old('status', $download->status) === 'draft' ? 'selected' : '' }}>Sembunyikan / Simpan Sebagai Draft</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.download.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-him-primary px-4">
                        <i class="fas fa-save me-1"></i> Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
