@extends('layouts.admin')

@section('title', 'Tambah Website / Berkas')
@section('page_title', 'Tambah Website Mahasiswa / Berkas Baru')
@section('page_subtitle', 'Tambahkan etalase karya website mahasiswa atau dokumen unduhan resmi')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="him-card">
            <div class="him-card-header d-flex align-items-center justify-content-between">
                <h2 class="him-card-title mb-0">
                    <i class="fas fa-plus-circle text-primary"></i> Formulir Karya / Dokumen Baru
                </h2>
                <a href="{{ route('admin.download.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.download.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Nama Proyek / Judul Dokumen <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Contoh: Portal Informasi Himpunan atau Panduan PKM 2026">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Pembuat / Mahasiswa</label>
                        <input type="text" name="author_name" class="form-control" value="{{ old('author_name') }}" placeholder="Contoh: Tim Pengembang Mahasiswa Angkatan 2024">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-dark">Tahun / Angkatan</label>
                        <input type="text" name="year" class="form-control" value="{{ old('year', date('Y')) }}" placeholder="2026">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-dark">Urutan Tampil</label>
                        <input type="number" name="order_num" class="form-control" value="{{ old('order_num', 0) }}" min="0">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Kategori</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category') }}" placeholder="Contoh: Karya Website, Panduan & SOP, Media Pembelajaran">
                </div>

                <!-- Type Section: Website vs File -->
                <div class="p-3 mb-3 bg-light rounded-3 border">
                    <div class="fw-bold text-dark mb-2">
                        <i class="fas fa-layer-group text-primary me-1"></i> Data Akses & Lampiran (Isi minimal salah satu)
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-globe text-primary me-1"></i> URL Demo / Website Mahasiswa
                            </label>
                            <input type="url" name="website_url" class="form-control" value="{{ old('website_url') }}" placeholder="https://karyasiswa.vercel.app">
                            <div class="form-text">Masukkan tautan jika karya berupa website online.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-file-upload text-success me-1"></i> Unggah Berkas Dokumen (Opsional)
                            </label>
                            <input type="file" name="file" class="form-control">
                            <div class="form-text">Maksimal 20 MB (PDF, DOCX, ZIP, XLSX).</div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">
                        <i class="fas fa-image text-info me-1"></i> Gambar Pratinjau / Thumbnail Karya (Opsional)
                    </label>
                    <input type="file" name="preview_image" class="form-control" accept="image/*">
                    <div class="form-text">Tangkapan layar tampilan website atau sampul dokumen. Maksimal 4 MB (JPG, PNG, WebP).</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Deskripsi Ringkas</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Tuliskan keterangan singkat mengenai proyek website atau dokumen ini...">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Status Penerbitan</label>
                    <select name="status" class="form-select" required>
                        <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Tampilkan di Galeri Website Publik</option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Sembunyikan / Simpan Sebagai Draft</option>
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
