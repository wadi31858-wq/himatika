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
                    <textarea name="home_sambutan_summary" class="form-control" rows="4">{{ old('home_sambutan_summary', $siteSettings['home_sambutan_summary'] ?? ($siteSettings['sambutan_quote'] ?? 'Sambutan resmi dari pimpinan dan Ketua Program Studi Matematika Universitas Nurul Jadid mengenai arah, visi, dan semangat pengembangan mahasiswa di era digital.')) }}</textarea>
                    <div class="form-text text-muted small"><i class="fas fa-sync-alt text-success me-1"></i> Tersinkronisasi otomatis dengan menu <a href="{{ route('admin.tentang.sambutan') }}" target="_blank"><strong>Tentang &rarr; Sambutan Kaprodi</strong></a>.</div>
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

        <!-- Right Card: Visi dan Misi Preview Card -->
        <div class="col-md-6">
            <div class="him-card h-100">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-bullseye text-primary"></i> Kartu 2: Visi dan Misi
                    </h2>
                    <span class="badge bg-primary-subtle text-primary">Kartu Kanan</span>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark small">Lencana Kartu</label>
                        <input type="text" name="home_visi_badge" class="form-control" value="{{ old('home_visi_badge', $siteSettings['home_visi_badge'] ?? 'PEDOMAN ORGANISASI') }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark small">Teks Tombol</label>
                        <input type="text" name="home_visi_btn_text" class="form-control" value="{{ old('home_visi_btn_text', $siteSettings['home_visi_btn_text'] ?? 'Lihat Visi & Misi Selengkapnya') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Ringkasan Visi di Beranda</label>
                    <textarea name="home_visi_summary" class="form-control" rows="3">{{ old('home_visi_summary', $siteSettings['home_visi_summary'] ?? (\App\Models\VisionMission::value('vision') ?? 'Menjadi organisasi mahasiswa Matematika yang aktif, inovatif, kolaboratif, dan unggul dalam pengembangan ilmu matematika serta sumber daya mahasiswa.')) }}</textarea>
                    <div class="form-text text-muted small"><i class="fas fa-sync-alt text-success me-1"></i> Tersinkronisasi otomatis dengan menu <a href="{{ route('admin.visi-misi.edit') }}" target="_blank"><strong>Tentang &rarr; Visi dan Misi</strong></a>.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark small">Tautan / URL Tombol</label>
                    <input type="text" name="home_visi_btn_url" class="form-control" value="{{ old('home_visi_btn_url', $siteSettings['home_visi_btn_url'] ?? route('visi-misi')) }}">
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

