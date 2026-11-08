@extends('layouts.admin')

@section('title', 'Edit Agenda')
@section('page_title', 'Perbarui Agenda Kegiatan')
@section('page_subtitle', 'Edit informasi agenda, jadwal, link pendaftaran, atau status acara')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-edit"></i> Edit Agenda: {{ $agenda->title }}
                </h2>
                <a href="{{ route('admin.agenda.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.agenda.update', $agenda) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Nama / Judul Kegiatan <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $agenda->title) }}" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Tanggal Kegiatan <span class="text-danger">*</span></label>
                        <input type="date" name="date" class="form-control" value="{{ old('date', $agenda->date->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Waktu Mulai</label>
                        <input type="time" name="start_time" class="form-control" value="{{ old('start_time', $agenda->start_time ? substr($agenda->start_time, 0, 5) : '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Waktu Selesai</label>
                        <input type="time" name="end_time" class="form-control" value="{{ old('end_time', $agenda->end_time ? substr($agenda->end_time, 0, 5) : '') }}">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Lokasi Kegiatan</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location', $agenda->location) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Tautan Pendaftaran (Opsional)</label>
                        <input type="url" name="registration_link" class="form-control" value="{{ old('registration_link', $agenda->registration_link) }}" placeholder="https://forms.gle/...">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Tahapan Status Acara</label>
                        <select name="status" class="form-select" required>
                            <option value="Akan Datang" {{ old('status', $agenda->status) === 'Akan Datang' ? 'selected' : '' }}>Akan Datang</option>
                            <option value="Berlangsung" {{ old('status', $agenda->status) === 'Berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                            <option value="Selesai" {{ old('status', $agenda->status) === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Status Penerbitan</label>
                        <select name="pub_status" class="form-select" required>
                            <option value="published" {{ old('pub_status', $agenda->pub_status) === 'published' ? 'selected' : '' }}>Terbitkan Langsung (Published)</option>
                            <option value="draft" {{ old('pub_status', $agenda->pub_status) === 'draft' ? 'selected' : '' }}>Draft (Hanya Pengurus)</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    @if($agenda->image)
                        <div class="rounded-3 overflow-hidden border mb-2 text-center bg-light" style="max-height: 180px;">
                            <img src="{{ asset('storage/' . $agenda->image) }}" alt="{{ $agenda->title }}" class="img-fluid" style="max-height: 180px; object-fit: contain;">
                        </div>
                    @endif
                    <label class="form-label fw-semibold text-dark">Ganti Poster / Banner (Opsional)</label>
                    <input type="file" name="image" class="form-control" accept="image/png,image/jpeg,image/webp">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Deskripsi & Rincian Agenda</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description', $agenda->description) }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.agenda.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-him-primary px-4">
                        <i class="fas fa-save me-1"></i> Perbarui Agenda
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
