@extends('layouts.admin')

@section('title', 'Kelola Sejarah')
@section('page_title', 'Kelola Halaman Sejarah')
@section('page_subtitle', 'Sesuaikan naskah sejarah, foto pembuka, dan tautan dokumentasi sejarah')

@section('content')
<form action="{{ route('admin.tentang.sejarah.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Left: Form inputs -->
        <div class="col-lg-8">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-landmark text-primary"></i> Konten Halaman Sejarah
                    </h2>
                    <a href="{{ route('sejarah') }}" target="_blank" class="btn btn-sm btn-outline-info">
                        <i class="fas fa-external-link-alt me-1"></i> Lihat Publik
                    </a>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Judul Utama <span class="text-danger">*</span></label>
                    <input type="text" name="history_title" class="form-control" value="{{ old('history_title', $siteSettings['history_title'] ?? ($profile->title ? 'Sejarah ' . $profile->title : 'Sejarah HIMATIKA UNUJA')) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Subjudul / Pengantar Banner</label>
                    <input type="text" name="history_subtitle" class="form-control" value="{{ old('history_subtitle', $siteSettings['history_subtitle'] ?? 'Perjalanan panjang himpunan mahasiswa dalam mengabdi dan berkarya') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Isi Lengkap Sejarah <span class="text-danger">*</span></label>
                    <textarea name="history_content" class="form-control visual-editor" rows="12" required>{{ old('history_content', $profile->history ?? "HIMATIKA merupakan lembaga kemahasiswaan yang tumbuh dan berkembang dari semangat mahasiswa dalam membangun persatuan yang berorientasikan nilai-nilai keislaman.\n\nDalam perkembangannya, HIMATIKA terus berikhtiar meningkatkan mutu keilmuan, kepemimpinan, dan jejaring pengabdian.") }}</textarea>
                    <div class="form-text">Gunakan Enter untuk membuat paragraf baru. Format teks didukung secara otomatis tanpa perlu mengetik kode HTML.</div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark small">Teks Tombol Dokumentasi</label>
                        <input type="text" name="history_doc_text" class="form-control" value="{{ old('history_doc_text', $siteSettings['history_doc_text'] ?? 'Dokumentasi Sejarah') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark small">Tautan Dokumentasi Sejarah</label>
                        <input type="text" name="history_doc_url" class="form-control" value="{{ old('history_doc_url', $siteSettings['history_doc_url'] ?? route('galeri')) }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Photo upload -->
        <div class="col-lg-4">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-image"></i> Foto Pembuka Sejarah
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Ganti Foto Pembuka</label>
                    <input type="file" name="history_image" class="form-control" accept="image/*">
                    <div class="form-text">Foto gedung, prasasti, atau momentum awal pendirian.</div>
                </div>

                @php $curHistImg = $siteSettings['history_image'] ?? $profile->image; @endphp
                @if($curHistImg)
                    <div class="rounded-3 overflow-hidden border p-1 bg-light mb-3">
                        <img src="{{ asset('storage/' . $curHistImg) }}" class="w-100 rounded" style="height: 180px; object-fit: cover;">
                        <div class="small text-muted p-1">Foto aktif saat ini</div>
                    </div>
                @endif

                <button type="submit" class="btn btn-him-primary w-100 py-2">
                    <i class="fas fa-save me-1"></i> Simpan Halaman Sejarah
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
