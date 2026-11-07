@extends('layouts.admin')
@section('title', 'Edit Program Kerja')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit Program Kerja</h4>
    <a href="{{ route('admin.program-kerja.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.program-kerja.update', $program) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Judul *</label><input type="text" name="title" class="form-control" value="{{ old('title', $program->title) }}" required></div>
                <div class="col-md-6"><label class="form-label">Divisi</label><input type="text" name="division" class="form-control" value="{{ old('division', $program->division) }}"></div>
                <div class="col-md-6"><label class="form-label">Tanggal</label><input type="date" name="date" class="form-control" value="{{ old('date', $program->date?->format('Y-m-d')) }}"></div>
                <div class="col-md-6"><label class="form-label">Status *</label><select name="status" class="form-select" required><option value="Akan Datang" {{ old('status', $program->status) === 'Akan Datang' ? 'selected' : '' }}>Akan Datang</option><option value="Sedang Berjalan" {{ old('status', $program->status) === 'Sedang Berjalan' ? 'selected' : '' }}>Sedang Berjalan</option><option value="Selesai" {{ old('status', $program->status) === 'Selesai' ? 'selected' : '' }}>Selesai</option></select></div>
                <div class="col-md-6"><label class="form-label">Gambar</label><input type="file" name="image" class="form-control" accept="image/*">@if($program->image)<div class="mt-2"><img src="{{ asset('storage/'.$program->image) }}" width="100" class="rounded"></div>@endif</div>
                <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="4">{{ old('description', $program->description) }}</textarea></div>
                <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
