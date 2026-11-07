@extends('layouts.admin')
@section('title', 'Edit Pengurus')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit Pengurus</h4>
    <a href="{{ route('admin.pengurus.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.pengurus.update', $member) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Nama *</label><input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $member->name) }}" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label">NIM *</label><input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim', $member->nim) }}" required>@error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label">Jabatan *</label><input type="text" name="position" class="form-control" value="{{ old('position', $member->position) }}" required></div>
                <div class="col-md-6"><label class="form-label">Divisi</label><input type="text" name="division" class="form-control" value="{{ old('division', $member->division) }}"></div>
                <div class="col-md-6"><label class="form-label">Periode</label><input type="text" name="period" class="form-control" value="{{ old('period', $member->period) }}"></div>
                <div class="col-md-6"><label class="form-label">Foto</label><input type="file" name="photo" class="form-control" accept="image/*">@if($member->photo)<div class="mt-2"><img src="{{ asset('storage/'.$member->photo) }}" width="100" class="rounded"></div>@endif</div>
                <div class="col-12"><label class="form-label">Bio</label><textarea name="bio" class="form-control" rows="3">{{ old('bio', $member->bio) }}</textarea></div>
                <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
