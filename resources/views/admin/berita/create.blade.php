@extends('layouts.admin')
@section('title', 'Tambah Berita')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Tambah Berita</h4>
    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Judul *</label><input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>@error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label">Kategori</label><input type="text" name="category" class="form-control" value="{{ old('category') }}" placeholder="Contoh: Kegiatan, Pengumuman, Prestasi"></div>
                <div class="col-md-6"><label class="form-label">Penulis</label><input type="text" name="author" class="form-control" value="{{ old('author', 'Admin HIMATIKA UNUJA') }}"></div>
                <div class="col-md-6"><label class="form-label">Tanggal Publikasi</label><input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at') }}"></div>
                <div class="col-md-6"><label class="form-label">Thumbnail</label><input type="file" name="thumbnail" class="form-control" accept="image/*"></div>
                <div class="col-12"><label class="form-label">Isi Berita *</label><textarea name="content" class="form-control" rows="8" required>{{ old('content') }}</textarea></div>
                <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
