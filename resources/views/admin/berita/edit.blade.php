@extends('layouts.admin')
@section('title', 'Edit Berita')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit Berita</h4>
    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.berita.update', $news) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Judul *</label><input type="text" name="title" class="form-control" value="{{ old('title', $news->title) }}" required></div>
                <div class="col-md-6"><label class="form-label">Kategori</label><input type="text" name="category" class="form-control" value="{{ old('category', $news->category) }}"></div>
                <div class="col-md-6"><label class="form-label">Penulis</label><input type="text" name="author" class="form-control" value="{{ old('author', $news->author) }}"></div>
                <div class="col-md-6"><label class="form-label">Tanggal Publikasi</label><input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', $news->published_at?->format('Y-m-d\TH:i')) }}"></div>
                <div class="col-md-6"><label class="form-label">Thumbnail</label><input type="file" name="thumbnail" class="form-control" accept="image/*">@if($news->thumbnail)<div class="mt-2"><img src="{{ asset('storage/'.$news->thumbnail) }}" width="100" class="rounded"></div>@endif</div>
                <div class="col-12"><label class="form-label">Isi Berita *</label><textarea name="content" class="form-control" rows="8" required>{{ old('content', $news->content) }}</textarea></div>
                <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
