@extends('layouts.admin')

@section('title', 'Tinjau Aspirasi')
@section('page_title', 'Tinjau & Tanggapi Aspirasi')
@section('page_subtitle', 'Detail pesan mahasiswa, tanggapan resmi, dan catatan internal admin')

@section('content')
<div class="row g-4">
    <!-- Left: Content of Aspiration -->
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-comment-dots"></i> Isi Aspirasi Mahasiswa
                </h2>
                <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <!-- Student Info Card -->
            <div class="p-3 mb-4 rounded-3 bg-light border">
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted d-block">Nama Mahasiswa:</small>
                        <strong class="text-dark">{{ $aspirasi->name ?: 'Anonim' }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">NIM Mahasiswa:</small>
                        <strong class="text-dark">{{ $aspirasi->nim ?: '-' }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Alamat Email:</small>
                        <span class="text-dark">{{ $aspirasi->email ?: '-' }}</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Kategori Aspirasi:</small>
                        <span class="badge bg-primary-subtle text-primary">{{ $aspirasi->category ?: 'Umum' }}</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Waktu Pengiriman:</small>
                        <span class="text-dark small"><i class="far fa-clock me-1 text-primary"></i>{{ $aspirasi->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Alamat IP Pengirim (Privat):</small>
                        <span class="text-muted font-monospace small">{{ $aspirasi->ip_address ?: '-' }}</span>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold text-dark mb-2">{{ $aspirasi->title }}</h5>
            <div class="p-4 rounded-3 border bg-white mb-4" style="line-height: 1.7; font-size: 0.95rem; white-space: pre-wrap;">{{ $aspirasi->message }}</div>

            @if($aspirasi->email)
                <div class="pt-2">
                    <a href="mailto:{{ $aspirasi->email }}?subject=Tanggapan Aspirasi HIMATIKA UNUJA: {{ urlencode($aspirasi->title) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-envelope me-1"></i> Kirim Email Langsung ke Mahasiswa
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Right: Status & Reply Form -->
    <div class="col-lg-4">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-tasks"></i> Penanganan Aspirasi
                </h2>
            </div>

            <form action="{{ route('admin.aspirasi.update', $aspirasi) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Status Tindak Lanjut <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="Baru" {{ $aspirasi->status === 'Baru' ? 'selected' : '' }}>Baru (Belum Ditindaklanjuti)</option>
                        <option value="Diproses" {{ $aspirasi->status === 'Diproses' ? 'selected' : '' }}>Diproses (Sedang Ditangani)</option>
                        <option value="Selesai" {{ $aspirasi->status === 'Selesai' ? 'selected' : '' }}>Selesai (Tuntas)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Tanggapan Resmi (Dapat Dilihat Mahasiswa)</label>
                    <textarea name="admin_reply" class="form-control" rows="4" placeholder="Tuliskan jawaban atau konfirmasi untuk mahasiswa saat mengecek status via NIM...">{{ old('admin_reply', $aspirasi->admin_reply) }}</textarea>
                    <div class="form-text">Tanggapan ini akan tampil secara transparan kepada mahasiswa saat memasukkan NIM.</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">
                        <i class="fas fa-lock text-warning me-1"></i> Catatan Internal (Hanya Pengurus)
                    </label>
                    <textarea name="admin_notes" class="form-control bg-light" rows="3" placeholder="Catatan rapat divisi atau pengurus terkait aspirasi ini (privat, tidak tampil ke publik)...">{{ old('admin_notes', $aspirasi->admin_notes) }}</textarea>
                </div>

                <button type="submit" class="btn btn-him-primary w-100 py-2">
                    <i class="fas fa-save me-1"></i> Simpan Penanganan
                </button>
            </form>

            <div class="border-top pt-3 mt-3">
                <button type="button" class="btn btn-outline-danger w-100" 
                        data-bs-toggle="modal" 
                        data-bs-target="#deleteConfirmModal" 
                        data-action="{{ route('admin.aspirasi.destroy', $aspirasi) }}" 
                        data-title="Aspirasi: {{ $aspirasi->title }}">
                    <i class="fas fa-trash-alt me-1"></i> Hapus Aspirasi Ini
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
