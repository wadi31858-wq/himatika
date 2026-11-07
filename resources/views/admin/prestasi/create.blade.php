@extends('layouts.admin')
@section('title', 'Tambah Prestasi')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Tambah Prestasi</h4>
    <a href="{{ route('admin.prestasi.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.prestasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Judul *</label><input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>@error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label">Peraih</label><input type="text" name="participant" class="form-control" value="{{ old('participant') }}"></div>
                <div class="col-md-4"><label class="form-label">Kategori</label><select name="category" class="form-select"><option value="Akademik">Akademik</option><option value="Non-akademik">Non-akademik</option><option value="Teknologi">Teknologi</option><option value="Olahraga">Olahraga</option><option value="Seni">Seni</option></select></div>
                <div class="col-md-4"><label class="form-label">Tingkat</label><input type="text" name="level" class="form-control" value="{{ old('level') }}" placeholder="Universitas/Nasional/Internasional"></div>
                <div class="col-md-4"><label class="form-label">Tahun</label><input type="number" name="year" class="form-control" value="{{ old('year', date('Y')) }}" min="2000" max="2100"></div>
                <div class="col-md-6"><label class="form-label">Juara</label><input type="text" name="rank" class="form-control" value="{{ old('rank') }}" placeholder="Juara 1/Best Paper/"></div>
                <div class="col-md-6"><label class="form-label">Foto</label><input type="file" name="image" class="form-control" accept="image/*"></div>
                <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea></div>
                <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
