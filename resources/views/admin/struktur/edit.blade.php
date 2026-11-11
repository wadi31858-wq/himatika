@extends('layouts.admin')

@section('title', 'Edit Struktur')
@section('page_title', 'Perbarui Posisi Struktur Organisasi')
@section('page_subtitle', 'Edit jabatan, atasan hirarki, urutan, atau foto pejabat')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-edit"></i> Edit: {{ $struktur->position }} ({{ $struktur->name }})
                </h2>
                <a href="{{ route('admin.struktur-organisasi.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.struktur-organisasi.update', $struktur) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nama Pejabat <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $struktur->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nama Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="position" class="form-control" value="{{ old('position', $struktur->position) }}" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Kelompok Kepengurusan <span class="text-danger">*</span></label>
                        <select name="kelompok" class="form-select" required>
                            <option value="putra" {{ old('kelompok', $struktur->kelompok) === 'putra' ? 'selected' : '' }}>Putra</option>
                            <option value="putri" {{ old('kelompok', $struktur->kelompok) === 'putri' ? 'selected' : '' }}>Putri</option>
                            <option value="semua" {{ old('kelompok', $struktur->kelompok) === 'semua' ? 'selected' : '' }}>Semua / Umum (Pembina/Biro Bersama)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Bidang / Divisi</label>
                        <input type="text" name="division" class="form-control" value="{{ old('division', $struktur->division) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Atasan Langsung (Induk Hirarki)</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- Pimpinan Puncak / Tanpa Atasan --</option>
                            @foreach($parents as $p)
                                <option value="{{ $p->id }}" {{ old('parent_id', $struktur->parent_id) == $p->id ? 'selected' : '' }}>{{ $p->position }} ({{ $p->name }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Periode Kepengurusan</label>
                        <input type="text" name="period" class="form-control" value="{{ old('period', $struktur->period) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Urutan Tampilan</label>
                        <input type="number" name="order_num" class="form-control" value="{{ old('order_num', $struktur->order_num ?? 0) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Status</label>
                        <select name="is_active" class="form-select" required>
                            <option value="1" {{ old('is_active', $struktur->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active', $struktur->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    @if($struktur->photo)
                        <div class="rounded-3 overflow-hidden border mb-2 text-center bg-light" style="max-height: 180px;">
                            <img src="{{ asset('storage/' . $struktur->photo) }}" alt="{{ $struktur->name }}" class="img-fluid" style="max-height: 180px; object-fit: contain;">
                        </div>
                    @endif
                    <label class="form-label fw-semibold text-dark">Ganti Foto Pejabat (Opsional)</label>
                    <input type="file" name="photo" class="form-control" accept="image/png,image/jpeg,image/webp">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Keterangan / Tugas Pokok</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $struktur->description) }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.struktur-organisasi.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-him-primary px-4">
                        <i class="fas fa-save me-1"></i> Perbarui Posisi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
