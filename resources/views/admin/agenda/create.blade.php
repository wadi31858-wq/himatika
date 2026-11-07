@extends('layouts.admin')
@section('title', 'Tambah Agenda')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Tambah Agenda</h4>
    <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.agenda.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Judul *</label><input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>@error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label">Status *</label><select name="status" class="form-select" required><option value="Akan Datang">Akan Datang</option><option value="Sedang Berjalan">Sedang Berjalan</option><option value="Selesai">Selesai</option></select></div>
                <div class="col-md-4"><label class="form-label">Tanggal *</label><input type="date" name="date" class="form-control" value="{{ old('date') }}" required></div>
                <div class="col-md-4"><label class="form-label">Waktu</label><input type="text" name="time" class="form-control" value="{{ old('time') }}" placeholder="09:00 - 12:00"></div>
                <div class="col-md-4"><label class="form-label">Lokasi</label><input type="text" name="location" class="form-control" value="{{ old('location') }}"></div>
                <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea></div>
                <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
