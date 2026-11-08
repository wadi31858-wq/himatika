@extends('layouts.admin')

@section('title', 'Visi, Misi & Tujuan')
@section('page_title', 'Kelola Visi & Misi Organisasi')
@section('page_subtitle', 'Tentukan arah haluan, komitmen, dan tujuan HIMATIKA FMIPA UNUJA')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-bullseye"></i> Visi & Misi HIMATIKA
                </h2>
                <a href="{{ route('visi-misi') }}" target="_blank" class="btn btn-sm btn-outline-info">
                    <i class="fas fa-external-link-alt me-1"></i> Lihat di Website
                </a>
            </div>

            <form action="{{ route('admin.visi-misi.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Visi Organisasi <span class="text-danger">*</span></label>
                    <textarea name="vision" class="form-control" rows="4" required placeholder="Tuliskan visi besar himpunan...">{{ old('vision', $vm->vision) }}</textarea>
                    <div class="form-text">Visi utama ditampilkan pada halaman Tentang dan Visi-Misi publik.</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Misi Organisasi (Satu poin per baris) <span class="text-danger">*</span></label>
                    <textarea name="mission_text" class="form-control font-monospace" rows="8" required placeholder="Masukkan satu misi di setiap baris...">{{ old('mission_text', $missionText) }}</textarea>
                    <div class="form-text">Setiap baris baru akan otomatis ditampilkan sebagai satu butir misi dengan aksen garis vertikal di halaman publik.</div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <button type="submit" class="btn btn-him-primary px-4 py-2">
                        <i class="fas fa-save me-1"></i> Simpan Visi & Misi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
