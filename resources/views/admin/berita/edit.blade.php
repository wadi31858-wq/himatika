@extends('layouts.admin')

@section('title', 'Edit Berita')
@section('page_title', 'Perbarui Berita / Artikel')
@section('page_subtitle', 'Edit judul, isi konten, gambar sampul, atau ubah status penerbitan')

@section('content')
<form action="{{ route('admin.berita.update', $news) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-edit"></i> Edit Konten Berita
                    </h2>
                    <div class="d-flex gap-2">
                        @if($news->status === 'published')
                            <a href="{{ route('berita.show', $news->slug) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-external-link-alt me-1"></i> Pratinjau Publik
                            </a>
                        @endif
                        <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Judul Berita <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $news->title) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Ringkasan / Excerpt</label>
                    <textarea name="excerpt" class="form-control" rows="3">{{ old('excerpt', $news->excerpt) }}</textarea>
                </div>

                <div class="mb-0">
                    <label class="form-label fw-semibold text-dark">Isi Lengkap Berita <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control font-monospace" rows="14" required>{{ old('content', $news->content) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Sidebar Options -->
        <div class="col-lg-4">
            <!-- Publishing Box -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-paper-plane"></i> Pengaturan Publikasi
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Status Publikasi</label>
                    <select name="status" class="form-select">
                        <option value="published" {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>Terbitkan (Published)</option>
                        <option value="draft" {{ old('status', $news->status) === 'draft' ? 'selected' : '' }}>Draft (Hanya Admin)</option>
                        <option value="archived" {{ old('status', $news->status) === 'archived' ? 'selected' : '' }}>Arsip</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Tanggal Terbit</label>
                    <input type="date" name="published_at" class="form-control" value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d') : date('Y-m-d')) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Kategori</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category', $news->category) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Nama Penulis</label>
                    <input type="text" name="author" class="form-control" value="{{ old('author', $news->author) }}">
                </div>

                <div class="p-2 mb-3 bg-light rounded text-muted small">
                    <i class="fas fa-chart-line me-1"></i> Total Dilihat: <strong>{{ number_format($news->views ?? 0) }} kali</strong>
                </div>

                <button type="submit" class="btn btn-him-primary w-100 py-2">
                    <i class="fas fa-save me-1"></i> Perbarui Berita
                </button>
            </div>

            <!-- Thumbnail Upload -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-image"></i> Gambar Sampul
                    </h2>
                </div>

                @if($news->thumbnail)
                    <div class="rounded-3 overflow-hidden border mb-3 text-center bg-light" style="max-height: 180px;">
                        <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}" class="img-fluid w-100" style="object-fit: cover; max-height: 180px;">
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Ganti Gambar Sampul</label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/png,image/jpeg,image/webp">
                    <div class="form-text">Biarkan kosong jika tidak ingin mengubah.</div>
                </div>

                <div class="mb-0">
                    <label class="form-label small fw-semibold text-dark">Keterangan Gambar (Alt Text)</label>
                    <input type="text" name="image_alt" class="form-control" value="{{ old('image_alt', $news->image_alt) }}">
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
