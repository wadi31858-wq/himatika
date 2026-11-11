@extends('layouts.admin')

@section('title', 'Tentang HIMATIKA di Beranda')
@section('page_title', 'Kelola Bagian Tentang di Beranda')
@section('page_subtitle', 'Sesuaikan teks pengantar, kartu ringkasan Sambutan Kaprodi, dan kartu Struktur Organisasi')

@section('content')
<form action="{{ route('admin.beranda.tentang.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Section Header -->
        <div class="col-12">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-heading"></i> Judul & Pengantar Section
                    </h2>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Lencana Section</label>
                        <input type="text" name="home_tentang_badge" class="form-control" value="{{ old('home_tentang_badge', $siteSettings['home_tentang_badge'] ?? 'Tentang Organisasi') }}">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold text-dark">Judul Utama <span class="text-danger">*</span></label>
                        <input type="text" name="home_tentang_title" class="form-control" value="{{ old('home_tentang_title', $siteSettings['home_tentang_title'] ?? 'Tentang HIMATIKA') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold text-dark">Deskripsi Ringkas</label>
                        <textarea name="home_tentang_desc" class="form-control" rows="2">{{ old('home_tentang_desc', $siteSettings['home_tentang_desc'] ?? 'Mengenal wadah persatuan, pengembangan intelektual, dan ruang tumbuh bersama seluruh mahasiswa Program Studi Matematika FMIPA Universitas Nurul Jadid.') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Left Card: Sambutan Kaprodi Preview Card -->
        <div class="col-md-6">
            <div class="him-card h-100">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-quote-left text-primary"></i> Kartu 1: Sambutan Kaprodi
                    </h2>
                    <span class="badge bg-primary-subtle text-primary">Kartu Kiri</span>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Ringkasan Sambutan di Beranda</label>
                    <textarea name="home_sambutan_summary" class="form-control" rows="4">{{ old('home_sambutan_summary', $siteSettings['home_sambutan_summary'] ?? 'Sambutan resmi dari pimpinan dan Ketua Program Studi Matematika Universitas Nurul Jadid mengenai arah, visi, dan semangat pengembangan mahasiswa di era digital.') }}</textarea>
                    <div class="form-text">Ringkasan yang tampil di kartu Beranda sebelum membuka halaman lengkap.</div>
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark small">Teks Tombol</label>
                        <input type="text" name="home_sambutan_btn_text" class="form-control" value="{{ old('home_sambutan_btn_text', $siteSettings['home_sambutan_btn_text'] ?? 'Baca Sambutan Selengkapnya') }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark small">Tautan / URL</label>
                        <input type="text" name="home_sambutan_btn_url" class="form-control" value="{{ old('home_sambutan_btn_url', $siteSettings['home_sambutan_btn_url'] ?? route('sambutan')) }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Card: Struktur Organisasi Preview Card -->
        <div class="col-md-6">
            <div class="him-card h-100">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-sitemap text-primary"></i> Kartu 2: Struktur Organisasi
                    </h2>
                    <span class="badge bg-primary-subtle text-primary">Kartu Kanan</span>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Ringkasan Struktur di Beranda</label>
                    <textarea name="home_struktur_summary" class="form-control" rows="4">{{ old('home_struktur_summary', $siteSettings['home_struktur_summary'] ?? 'Struktur kepengurusan resmi HIMATIKA UNUJA 2026 yang terbagi dalam divisi Putra dan Putri dengan komitmen kolaborasi, transparansi, dan sinergi.') }}</textarea>
                    <div class="form-text">Ringkasan bagan dan divisi kepengurusan yang tampil di kartu Beranda.</div>
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark small">Teks Tombol</label>
                        <input type="text" name="home_struktur_btn_text" class="form-control" value="{{ old('home_struktur_btn_text', $siteSettings['home_struktur_btn_text'] ?? 'Lihat Struktur Lengkap') }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark small">Tautan / URL</label>
                        <input type="text" name="home_struktur_btn_url" class="form-control" value="{{ old('home_struktur_btn_url', $siteSettings['home_struktur_btn_url'] ?? route('struktur-organisasi')) }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-him-primary py-2 px-4">
                <i class="fas fa-save me-1"></i> Simpan Perubahan Bagian Tentang
            </button>
        </div>
    </div>
</form>
@endsection
