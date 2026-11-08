@extends('layouts.admin')

@section('title', 'Tambah Agenda')
@section('page_title', 'Tambah Agenda Baru')
@section('page_subtitle', 'Jadwalkan kegiatan, seminar, atau acara mendatang')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-calendar-plus"></i> Formulir Agenda
                </h2>
                <a href="{{ route('admin.agenda.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.agenda.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Nama / Judul Kegiatan <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Contoh: Mathematics Olympiad 2026">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Tanggal Kegiatan <span class="text-danger">*</span></label>
                        <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Waktu Mulai</label>
                        <input type="time" name="start_time" class="form-control" value="{{ old('start_time') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Waktu Selesai</label>
                        <input type="time" name="end_time" class="form-control" value="{{ old('end_time') }}">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Lokasi Kegiatan</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="Contoh: Auditorium Utama UNUJA / Zoom Meeting">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Tautan Pendaftaran (Opsional)</label>
                        <input type="url" name="registration_link" class="form-control" value="{{ old('registration_link') }}" placeholder="https://forms.gle/...">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Tahapan Status Acara</label>
                        <select name="status" class="form-select" required>
                            <option value="Akan Datang" {{ old('status') === 'Akan Datang' ? 'selected' : '' }}>Akan Datang</option>
                            <option value="Berlangsung" {{ old('status') === 'Berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                            <option value="Selesai" {{ old('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Status Penerbitan</label>
                        <select name="pub_status" class="form-select" required>
                            <option value="published" {{ old('pub_status', 'published') === 'published' ? 'selected' : '' }}>Terbitkan Langsung (Published)</option>
                            <option value="draft" {{ old('pub_status') === 'draft' ? 'selected' : '' }}>Draft (Hanya Pengurus)</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Poster / Banner Acara (Opsional)</label>
                    <input type="file" name="image" class="form-control" accept="image/png,image/jpeg,image/webp">
                    <div class="form-text">Format JPG, PNG, WebP (maks 3 MB).</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Deskripsi & Rincian Agenda</label>
                    <textarea name="description" class="form-control" rows="5" placeholder="Tuliskan keterangan detail mengenai acara ini...">{{ old('description') }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.agenda.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-him-primary px-4">
                        <i class="fas fa-save me-1"></i> Simpan Agenda
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
