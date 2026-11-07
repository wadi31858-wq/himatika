@extends('layouts.admin')
@section('title', 'Tambah Pengurus')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Tambah Pengurus</h4>
    <a href="{{ route('admin.pengurus.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.pengurus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Nama *</label><input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label">NIM *</label><input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}" required>@error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label">Jabatan *</label><input type="text" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position') }}" required>@error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label">Divisi</label><input type="text" name="division" class="form-control" value="{{ old('division') }}"></div>
                <div class="col-md-6"><label class="form-label">Periode</label><input type="text" name="period" class="form-control" value="{{ old('period', '2025-2026') }}"></div>
                <div class="col-md-6"><label class="form-label">Foto</label><input type="file" name="photo" class="form-control" accept="image/*"></div>
                <div class="col-12"><label class="form-label">Bio</label><textarea name="bio" class="form-control" rows="3">{{ old('bio') }}</textarea></div>
                <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
