@extends('layouts.admin')
@section('title', 'Edit Kegiatan')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit Kegiatan</h4>
    <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.kegiatan.update', $activity) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Judul *</label><input type="text" name="title" class="form-control" value="{{ old('title', $activity->title) }}" required></div>
                <div class="col-md-6"><label class="form-label">Status *</label><select name="status" class="form-select" required><option value="Akan Datang" {{ old('status', $activity->status) === 'Akan Datang' ? 'selected' : '' }}>Akan Datang</option><option value="Sedang Berjalan" {{ old('status', $activity->status) === 'Sedang Berjalan' ? 'selected' : '' }}>Sedang Berjalan</option><option value="Selesai" {{ old('status', $activity->status) === 'Selesai' ? 'selected' : '' }}>Selesai</option></select></div>
                <div class="col-md-6"><label class="form-label">Tanggal</label><input type="date" name="date" class="form-control" value="{{ old('date', $activity->date?->format('Y-m-d')) }}"></div>
                <div class="col-md-6"><label class="form-label">Lokasi</label><input type="text" name="location" class="form-control" value="{{ old('location', $activity->location) }}"></div>
                <div class="col-md-6"><label class="form-label">Penyelenggara</label><input type="text" name="organizer" class="form-control" value="{{ old('organizer', $activity->organizer) }}"></div>
                <div class="col-md-6"><label class="form-label">Gambar</label><input type="file" name="image" class="form-control" accept="image/*">@if($activity->image)<div class="mt-2"><img src="{{ asset('storage/'.$activity->image) }}" width="100" class="rounded"></div>@endif</div>
                <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="5">{{ old('description', $activity->description) }}</textarea></div>
                <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
