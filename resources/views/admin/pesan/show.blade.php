@extends('layouts.admin')

@section('title', 'Detail Pesan')
@section('page_title', 'Detail Pesan Kontak')
@section('page_subtitle', 'Pesan dari pengunjung melalui formulir kontak')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-envelope-open"></i> Subjek: {{ $message->subject }}
                </h2>
                <a href="{{ route('admin.pesan.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="p-3 mb-4 rounded-3 bg-light border">
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted d-block">Nama Pengirim:</small>
                        <strong class="text-dark">{{ $message->name }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Alamat Email:</small>
                        <strong class="text-dark">{{ $message->email }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Waktu Pengiriman:</small>
                        <span class="text-dark small"><i class="far fa-clock me-1 text-primary"></i>{{ $message->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Subjek:</small>
                        <span class="badge bg-primary-subtle text-primary">{{ $message->subject }}</span>
                    </div>
                </div>
            </div>

            <label class="form-label fw-semibold text-dark">Isi Pesan:</label>
            <div class="p-4 rounded-3 border bg-white mb-4" style="line-height: 1.7; font-size: 0.95rem; white-space: pre-wrap;">{{ $message->message }}</div>

            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <a href="mailto:{{ $message->email }}?subject=Balasan: {{ urlencode($message->subject) }}" class="btn btn-him-primary">
                    <i class="fas fa-reply me-1"></i> Balas via Email
                </a>
                <button type="button" class="btn btn-outline-danger" 
                        data-bs-toggle="modal" 
                        data-bs-target="#deleteConfirmModal" 
                        data-action="{{ route('admin.pesan.destroy', $message) }}" 
                        data-title="Pesan dari {{ $message->name }}">
                    <i class="fas fa-trash-alt me-1"></i> Hapus Pesan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
