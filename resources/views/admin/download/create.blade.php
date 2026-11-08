@extends('layouts.admin')

@section('title', 'Tambah Website / Berkas')
@section('page_title', 'Tambah Website Mahasiswa / Berkas Baru')
@section('page_subtitle', 'Tambahkan tautan website karya mahasiswa atau berkas unduhan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-plus-circle"></i> Formulir Karya / Dokumen
                </h2>
                <a href="{{ route('admin.download.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.download.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Nama Website / Judul Dokumen <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Contoh: Portal Informasi Himpunan atau Panduan PKM 2026">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nama Pembuat / Pengarang</label>
                        <input type="text" name="author_name" class="form-control" value="{{ old('author_name') }}" placeholder="Contoh: Tim Mahasiswa Matematika Angkatan 2024">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Kategori Proyek / Berkas</label>
                        <input type="text" name="category" class="form-control" value="{{ old('category') }}" placeholder="Contoh: Web Development, Data Science, Akademik">
                    </div>
                </div>

                <!-- Content Type Selector / Inputs -->
                <div class="p-3 mb-3 bg-light rounded-3 border">
                    <div class="fw-bold text-primary mb-2">
                        <i class="fas fa-info-circle me-1"></i> Tautan Website atau Berkas Fisik
                    </div>
                    <p class="small text-muted mb-3">
                        Pilih untuk memasukkan tautan website karya mahasiswa <em>ATAU</em> mengunggah berkas dokumen (PDF, DOCX, ZIP).
                    </p>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">
                            <i class="fas fa-globe me-1 text-primary"></i> Tautan Website (URL)
                        </label>
                        <input type="url" name="website_url" class="form-control" value="{{ old('website_url') }}" placeholder="https://karya-mahasiswa.vercel.app">
                        <div class="form-text">Isi jika karya berupa website online.</div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold text-dark">
                            <i class="fas fa-file-upload me-1 text-success"></i> Unggah Berkas Dokumen (Opsional)
                        </label>
                        <input type="file" name="file" class="form-control">
                        <div class="form-text">Maksimal 20 MB (PDF, DOCX, ZIP, PPTX, XLSX).</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Ringkasan / Deskripsi Singkat</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Tuliskan keterangan singkat mengenai website atau dokumen ini...">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Status Penerbitan</label>
                    <select name="status" class="form-select" required>
                        <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Terbitkan Langsung di Galeri Website</option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Simpan Sebagai Draft</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.download.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-him-primary px-4">
                        <i class="fas fa-save me-1"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
