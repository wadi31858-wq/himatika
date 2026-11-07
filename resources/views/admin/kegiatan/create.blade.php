@extends('layouts.admin')
@section('title', 'Tambah Kegiatan')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Tambah Kegiatan</h4>
    <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.kegiatan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Judul *</label><input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>@error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label">Status *</label><select name="status" class="form-select" required><option value="Akan Datang">Akan Datang</option><option value="Sedang Berjalan">Sedang Berjalan</option><option value="Selesai">Selesai</option></select></div>
                <div class="col-md-6"><label class="form-label">Tanggal</label><input type="date" name="date" class="form-control" value="{{ old('date') }}"></div>
                <div class="col-md-6"><label class="form-label">Lokasi</label><input type="text" name="location" class="form-control" value="{{ old('location') }}"></div>
                <div class="col-md-6"><label class="form-label">Penyelenggara</label><input type="text" name="organizer" class="form-control" value="{{ old('organizer') }}"></div>
                <div class="col-md-6"><label class="form-label">Gambar</label><input type="file" name="image" class="form-control" accept="image/*"></div>
                <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea></div>
                <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
