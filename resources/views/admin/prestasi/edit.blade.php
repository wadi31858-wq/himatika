@extends('layouts.admin')
@section('title', 'Edit Prestasi')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit Prestasi</h4>
    <a href="{{ route('admin.prestasi.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.prestasi.update', $achievement) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Judul *</label><input type="text" name="title" class="form-control" value="{{ old('title', $achievement->title) }}" required></div>
                <div class="col-md-6"><label class="form-label">Peraih</label><input type="text" name="participant" class="form-control" value="{{ old('participant', $achievement->participant) }}"></div>
                <div class="col-md-4"><label class="form-label">Kategori</label><select name="category" class="form-select">@foreach(['Akademik','Non-akademik','Teknologi','Olahraga','Seni'] as $c)<option value="{{ $c }}" {{ old('category', $achievement->category) === $c ? 'selected' : '' }}>{{ $c }}</option>@endforeach</select></div>
                <div class="col-md-4"><label class="form-label">Tingkat</label><input type="text" name="level" class="form-control" value="{{ old('level', $achievement->level) }}"></div>
                <div class="col-md-4"><label class="form-label">Tahun</label><input type="number" name="year" class="form-control" value="{{ old('year', $achievement->year) }}" min="2000" max="2100"></div>
                <div class="col-md-6"><label class="form-label">Juara</label><input type="text" name="rank" class="form-control" value="{{ old('rank', $achievement->rank) }}"></div>
                <div class="col-md-6"><label class="form-label">Foto</label><input type="file" name="image" class="form-control" accept="image/*">@if($achievement->image)<div class="mt-2"><img src="{{ asset('storage/'.$achievement->image) }}" width="100" class="rounded"></div>@endif</div>
                <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3">{{ old('description', $achievement->description) }}</textarea></div>
                <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
