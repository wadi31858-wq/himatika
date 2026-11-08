@extends('layouts.admin')

@section('title', 'Edit Website / Berkas')
@section('page_title', 'Perbarui Website Mahasiswa / Berkas')
@section('page_subtitle', 'Edit data karya website, perbarui link, atau ganti berkas dokumen')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-edit"></i> Edit: {{ $download->title }}
                </h2>
                <a href="{{ route('admin.download.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.download.update', $download) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Nama Website / Judul Dokumen <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $download->title) }}" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nama Pembuat / Pengarang</label>
                        <input type="text" name="author_name" class="form-control" value="{{ old('author_name', $download->author_name) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Kategori Proyek / Berkas</label>
                        <input type="text" name="category" class="form-control" value="{{ old('category', $download->category) }}">
                    </div>
                </div>

                <!-- Content Type Selector / Inputs -->
                <div class="p-3 mb-3 bg-light rounded-3 border">
                    <div class="fw-bold text-primary mb-2">
                        <i class="fas fa-link me-1"></i> Tautan Website atau Berkas Fisik
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">
                            <i class="fas fa-globe me-1 text-primary"></i> Tautan Website (URL)
                        </label>
                        <input type="url" name="website_url" class="form-control" value="{{ old('website_url', $download->website_url) }}" placeholder="https://...">
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold text-dark">
                            <i class="fas fa-file-upload me-1 text-success"></i> Berkas Dokumen Saat Ini
                        </label>
                        @if($download->file)
                            <div class="d-flex align-items-center gap-2 mb-2 p-2 bg-white rounded border">
                                <i class="fas fa-file-alt text-primary fs-5"></i>
                                <div class="small">
                                    <div class="fw-bold text-dark">{{ basename($download->file) }}</div>
                                    <div class="text-muted">{{ $download->file_size ?: 'Ukuran file' }} &bull; {{ strtoupper($download->file_type ?: 'File') }}</div>
                                </div>
                                <a href="{{ asset('storage/' . $download->file) }}" target="_blank" class="btn btn-sm btn-outline-primary ms-auto">
                                    Unduh
                                </a>
                            </div>
                        @endif
                        <label class="form-label small text-muted">Unggah berkas baru untuk mengganti file lama:</label>
                        <input type="file" name="file" class="form-control">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengubah berkas.</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Ringkasan / Deskripsi Singkat</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $download->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Status Penerbitan</label>
                    <select name="status" class="form-select" required>
                        <option value="published" {{ old('status', $download->status) === 'published' ? 'selected' : '' }}>Terbitkan di Galeri Website</option>
                        <option value="draft" {{ old('status', $download->status) === 'draft' ? 'selected' : '' }}>Simpan Sebagai Draft</option>
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
