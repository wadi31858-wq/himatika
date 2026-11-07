@extends('layouts.admin')
@section('title', 'Edit Agenda')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit Agenda</h4>
    <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.agenda.update', $agenda) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Judul *</label><input type="text" name="title" class="form-control" value="{{ old('title', $agenda->title) }}" required></div>
                <div class="col-md-6"><label class="form-label">Status *</label><select name="status" class="form-select" required><option value="Akan Datang" {{ old('status', $agenda->status) === 'Akan Datang' ? 'selected' : '' }}>Akan Datang</option><option value="Sedang Berjalan" {{ old('status', $agenda->status) === 'Sedang Berjalan' ? 'selected' : '' }}>Sedang Berjalan</option><option value="Selesai" {{ old('status', $agenda->status) === 'Selesai' ? 'selected' : '' }}>Selesai</option></select></div>
                <div class="col-md-4"><label class="form-label">Tanggal *</label><input type="date" name="date" class="form-control" value="{{ old('date', $agenda->date->format('Y-m-d')) }}" required></div>
                <div class="col-md-4"><label class="form-label">Waktu</label><input type="text" name="time" class="form-control" value="{{ old('time', $agenda->time) }}"></div>
                <div class="col-md-4"><label class="form-label">Lokasi</label><input type="text" name="location" class="form-control" value="{{ old('location', $agenda->location) }}"></div>
                <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3">{{ old('description', $agenda->description) }}</textarea></div>
                <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
