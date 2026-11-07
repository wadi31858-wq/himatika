@extends('layouts.admin')
@section('title', 'Edit Download')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit Download</h4>
    <a href="{{ route('admin.download.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.download.update', $download) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Judul *</label><input type="text" name="title" class="form-control" value="{{ old('title', $download->title) }}" required></div>
                <div class="col-md-6"><label class="form-label">File</label><input type="file" name="file" class="form-control">@if($download->file)<div class="mt-1"><small class="text-muted">File saat ini: {{ basename($download->file) }}</small></div>@endif</div>
                <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3">{{ old('description', $download->description) }}</textarea></div>
                <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
