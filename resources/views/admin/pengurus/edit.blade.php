@extends('layouts.admin')

@section('title', 'Edit Pengurus')
@section('page_title', 'Perbarui Data Pengurus')
@section('page_subtitle', 'Edit informasi anggota, jabatan, divisi, atau ganti foto')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-edit"></i> Edit: {{ $member->name }}
                </h2>
                <a href="{{ route('admin.pengurus.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.pengurus.update', $member) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-3">
                    <div class="col-md-7">
                        <label class="form-label fw-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $member->name) }}" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-semibold text-dark">NIM <span class="text-danger">*</span></label>
                        <input type="text" name="nim" class="form-control font-monospace" value="{{ old('nim', $member->nim) }}" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="position" class="form-control" value="{{ old('position', $member->position) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Bidang / Divisi</label>
                        <input type="text" name="division" class="form-control" value="{{ old('division', $member->division) }}">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Periode</label>
                        <input type="text" name="period" class="form-control" value="{{ old('period', $member->period) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Urutan Tampilan</label>
                        <input type="number" name="order_num" class="form-control" value="{{ old('order_num', $member->order_num ?? 0) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Status Keaktifan</label>
                        <select name="is_active" class="form-select" required>
                            <option value="1" {{ old('is_active', $member->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active', $member->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    @if($member->photo)
                        <div class="rounded-3 overflow-hidden border mb-2 text-center bg-light" style="max-height: 180px;">
                            <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="img-fluid" style="max-height: 180px; object-fit: contain;">
                        </div>
                    @endif
                    <label class="form-label fw-semibold text-dark">Ganti Foto Profil (Opsional)</label>
                    <input type="file" name="photo" class="form-control" accept="image/png,image/jpeg,image/webp">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Bio Singkat</label>
                    <textarea name="bio" class="form-control" rows="3">{{ old('bio', $member->bio) }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.pengurus.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-him-primary px-4">
                        <i class="fas fa-save me-1"></i> Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
