@extends('layouts.admin')
@section('title', 'Tambah Galeri')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Tambah Galeri</h4>
    <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Judul *</label><input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>@error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label">Foto *</label><input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>@error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label">Kegiatan</label><select name="activity_id" class="form-select"><option value="">-</option>@foreach($activities as $a)<option value="{{ $a->id }}">{{ $a->title }}</option>@endforeach</select></div>
                <div class="col-12"><label class="form-label">Keterangan</label><textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea></div>
                <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
