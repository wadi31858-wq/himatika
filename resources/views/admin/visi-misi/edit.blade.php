@extends('layouts.admin')
@section('title', 'Edit Visi & Misi')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit Visi & Misi</h4>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.visi-misi.update') }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Visi</label>
                <textarea name="vision" class="form-control @error('vision') is-invalid @enderror" rows="4" required>{{ old('vision', $vm->vision) }}</textarea>
                @error('vision')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Misi (satu poin per baris)</label>
                <textarea name="mission[]" class="form-control @error('mission') is-invalid @enderror" rows="6" required placeholder="Masukkan satu misi per baris...">@foreach($mission as $m){{ $m }}
@endforeach</textarea>
                @error('mission')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Masukkan satu misi di setiap baris.</small>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
        </form>
    </div>
</div>
@endsection
