@extends('layouts.admin')

@section('title', 'Tambah Pengurus')
@section('page_title', 'Tambah Pengurus Baru')
@section('page_subtitle', 'Masukkan data anggota atau pengurus baru HIMATIKA')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-user-plus"></i> Formulir Data Pengurus
                </h2>
                <a href="{{ route('admin.pengurus.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.pengurus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-md-7">
                        <label class="form-label fw-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Contoh: Muhammad Ilham">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-semibold text-dark">NIM <span class="text-danger">*</span></label>
                        <input type="text" name="nim" class="form-control font-monospace" value="{{ old('nim') }}" required placeholder="230101001">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="position" class="form-control" value="{{ old('position') }}" required placeholder="Contoh: Anggota Divisi Keilmuan, Sekretaris 1">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Bidang / Divisi</label>
                        <input type="text" name="division" class="form-control" value="{{ old('division') }}" placeholder="Contoh: BPH, Kominfo, Keilmuan, PSDM">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Periode</label>
                        <input type="text" name="period" class="form-control" value="{{ old('period', '2026') }}" placeholder="2026">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Urutan Tampilan</label>
                        <input type="number" name="order_num" class="form-control" value="{{ old('order_num', 0) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Status Keaktifan</label>
                        <select name="is_active" class="form-select" required>
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Foto Profil Pengurus</label>
                    <input type="file" name="photo" class="form-control" accept="image/png,image/jpeg,image/webp">
                    <div class="form-text">Maksimal 3 MB (JPG, PNG, WebP).</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Bio Singkat</label>
                    <textarea name="bio" class="form-control" rows="3" placeholder="Kata mutiara, kutipan, atau perkenalan singkat...">{{ old('bio') }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.pengurus.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-him-primary px-4">
                        <i class="fas fa-save me-1"></i> Simpan Pengurus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
