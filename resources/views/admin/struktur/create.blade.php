@extends('layouts.admin')

@section('title', 'Tambah Struktur')
@section('page_title', 'Tambah Posisi Struktur Organisasi')
@section('page_subtitle', 'Tambahkan jabatan pimpinan atau divisi dalam bagan organisasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-sitemap"></i> Formulir Struktur Organisasi
                </h2>
                <a href="{{ route('admin.struktur-organisasi.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.struktur-organisasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nama Pejabat / Pemegang Amanah <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Contoh: Muhammad Ilham">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nama Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="position" class="form-control" value="{{ old('position') }}" required placeholder="Contoh: Ketua Umum, Kepala Divisi Kominfo">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Bidang / Divisi</label>
                        <input type="text" name="division" class="form-control" value="{{ old('division') }}" placeholder="Contoh: BPH, Kominfo, Keilmuan, PSDM">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Atasan Langsung (Induk Hirarki)</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- Pimpinan Puncak / Tanpa Atasan --</option>
                            @foreach($parents as $p)
                                <option value="{{ $p->id }}" {{ old('parent_id') == $p->id ? 'selected' : '' }}>{{ $p->position }} ({{ $p->name }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Periode Kepengurusan</label>
                        <input type="text" name="period" class="form-control" value="{{ old('period', '2026/2027') }}" placeholder="2026/2027">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Urutan Tampilan</label>
                        <input type="number" name="order_num" class="form-control" value="{{ old('order_num', 0) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Status</label>
                        <select name="is_active" class="form-select" required>
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Foto Profil Pejabat (Opsional)</label>
                    <input type="file" name="photo" class="form-control" accept="image/png,image/jpeg,image/webp">
                    <div class="form-text">Maksimal 3 MB (JPG, PNG, WebP).</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Keterangan / Tugas Pokok</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Tupoksi singkat jabatan ini...">{{ old('description') }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.struktur-organisasi.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-him-primary px-4">
                        <i class="fas fa-save me-1"></i> Simpan Posisi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
