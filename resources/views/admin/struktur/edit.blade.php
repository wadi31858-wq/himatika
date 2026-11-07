@extends('layouts.admin')
@section('title', 'Edit Struktur')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit Struktur Organisasi</h4>
    <a href="{{ route('admin.struktur-organisasi.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.struktur-organisasi.update', $struktur) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Nama *</label><input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $struktur->name) }}" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label">Jabatan *</label><input type="text" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position', $struktur->position) }}" required>@error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label">Divisi</label><input type="text" name="division" class="form-control" value="{{ old('division', $struktur->division) }}"></div>
                <div class="col-md-6"><label class="form-label">Atasan</label><select name="parent_id" class="form-select"><option value="">-</option>@foreach($parents as $p)<option value="{{ $p->id }}" {{ old('parent_id', $struktur->parent_id) == $p->id ? 'selected' : '' }}>{{ $p->name }} - {{ $p->position }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Foto</label><input type="file" name="photo" class="form-control" accept="image/*">@if($struktur->photo)<div class="mt-2"><img src="{{ asset('storage/'.$struktur->photo) }}" width="100" class="rounded"></div>@endif</div>
                <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3">{{ old('description', $struktur->description) }}</textarea></div>
                <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
