@extends('layouts.admin')

@section('title', 'Hero Beranda')
@section('page_title', 'Kelola Hero Beranda')
@section('page_subtitle', 'Sesuaikan teks judul, tagline, foto latar, tombol aksi, dan visual kolase utama')

@section('content')
<form action="{{ route('admin.beranda.hero.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Left: Text Contents & Buttons -->
        <div class="col-lg-7">
            <!-- 1. Text & Headings -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-heading"></i> Konten & Teks Hero
                    </h2>
                    <span class="badge bg-primary-subtle text-primary">Bagian Paling Atas</span>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Kapsul Label (Badge Atas)</label>
                    <input type="text" name="hero_badge" class="form-control" value="{{ old('hero_badge', $profile->hero_badge ?? 'HIMATIKA FMIPA UNUJA') }}" placeholder="HIMATIKA FMIPA UNUJA">
                    <div class="form-text">Tampil di dalam kapsul navy di atas judul hero.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Teks Pendamping (Tagline)</label>
                    <input type="text" name="hero_tagline" class="form-control" value="{{ old('hero_tagline', $profile->hero_tagline ?? 'Synchronized Growth, Reaching New Heights') }}" placeholder="Synchronized Growth, Reaching New Heights">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Judul Utama Hero <span class="text-danger">*</span></label>
                    <textarea name="hero_title" class="form-control" rows="3" required placeholder="Tuliskan judul utama hero">{{ old('hero_title', $profile->hero_title ?? "Rumah yang\ninklusif, inovatif,\ndan tumbuh bersama.") }}</textarea>
                    <div class="form-text">Gunakan Enter / baris baru untuk mengatur pemenggalan kalimat pada tampilan Beranda.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Deskripsi Singkat</label>
                    <textarea name="hero_desc" class="form-control" rows="3">{{ old('hero_desc', $profile->hero_desc ?? 'Ruang resmi mahasiswa Matematika UNUJA untuk mengakses layanan, mengikuti kegiatan, menyampaikan aspirasi, dan mengenal karya HIMATIKA.') }}</textarea>
                </div>
            </div>

            <!-- 2. Buttons CTA -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-mouse-pointer"></i> Tombol Tindakan (CTA)
                    </h2>
                    <span class="badge bg-info-subtle text-info">Disusun Vertikal</span>
                </div>

                <!-- Primary Button -->
                <div class="p-3 bg-light rounded-3 mb-3 border">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="fw-bold text-dark"><i class="fas fa-arrow-circle-right text-primary me-1"></i> Tombol Utama (Atas)</span>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="hero_btn_primary_active" id="btnPrimaryActive" value="1" {{ old('hero_btn_primary_active', $siteSettings['hero_btn_primary_active'] ?? '1') === '1' ? 'checked' : '' }}>
                            <label class="form-check-label small fw-semibold" for="btnPrimaryActive">Tampilkan Tombol</label>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Label Tombol</label>
                            <input type="text" name="hero_btn_primary_text" class="form-control form-control-sm" value="{{ old('hero_btn_primary_text', $profile->hero_btn_primary_text ?? 'Hubungi Kami') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Tautan / URL</label>
                            <input type="text" name="hero_btn_primary_url" class="form-control form-control-sm" value="{{ old('hero_btn_primary_url', $profile->hero_btn_primary_url ?? route('kontak')) }}">
                        </div>
                    </div>
                </div>

                <!-- Secondary Button -->
                <div class="p-3 bg-light rounded-3 border">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="fw-bold text-dark"><i class="fas fa-arrow-circle-right text-secondary me-1"></i> Tombol Sekunder (Bawah)</span>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="hero_btn_secondary_active" id="btnSecondaryActive" value="1" {{ old('hero_btn_secondary_active', $siteSettings['hero_btn_secondary_active'] ?? '1') === '1' ? 'checked' : '' }}>
                            <label class="form-check-label small fw-semibold" for="btnSecondaryActive">Tampilkan Tombol</label>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Label Tombol</label>
                            <input type="text" name="hero_btn_secondary_text" class="form-control form-control-sm" value="{{ old('hero_btn_secondary_text', $profile->hero_btn_secondary_text ?? 'Pelajari Profil') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Tautan / URL</label>
                            <input type="text" name="hero_btn_secondary_url" class="form-control form-control-sm" value="{{ old('hero_btn_secondary_url', $profile->hero_btn_secondary_url ?? route('profil')) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Background Photo & Visual Collage -->
        <div class="col-lg-5">
            <!-- Background Photo -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-image"></i> Foto Latar Belakang Kampus
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Ganti Foto Latar Hero</label>
                    <input type="file" name="hero_image" class="form-control" accept="image/*">
                    <div class="form-text">Direkomendasikan foto lanskap gedung/kampus resolusi tinggi. Diberi lapisan putih transparan otomatis di frontend.</div>
                </div>

                @if($profile->hero_image)
                    <div class="rounded-3 overflow-hidden border p-1 bg-light mb-3">
                        <img src="{{ asset('storage/' . $profile->hero_image) }}" class="w-100 rounded" style="height: 140px; object-fit: cover;">
                        <div class="small text-muted p-1"><i class="fas fa-check-circle text-success me-1"></i> Foto kustom aktif</div>
                    </div>
                @else
                    <div class="rounded-3 overflow-hidden border p-1 bg-light mb-3">
                        <img src="{{ asset('images/hero-bg-unuja.jpg') }}" class="w-100 rounded" style="height: 140px; object-fit: cover;">
                        <div class="small text-muted p-1"><i class="fas fa-info-circle text-info me-1"></i> Menggunakan foto latar bawaan UNUJA</div>
                    </div>
                @endif

                <div class="mb-2">
                    <label class="form-label fw-semibold text-dark">Teks Alternatif (Alt Text)</label>
                    <input type="text" name="hero_image_alt" class="form-control" value="{{ old('hero_image_alt', $profile->hero_image_alt ?? 'Kampus UNUJA') }}">
                </div>
            </div>

            <!-- Visual Kolase Card -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-users"></i> Foto Visual Kolase / Tim
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Ganti Foto Tim / Kepengurusan</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <div class="form-text">Tampil pada kartu mengambang kanan bawah di dalam bingkai kolase hero.</div>
                </div>

                @if($profile->image)
                    <div class="rounded-3 overflow-hidden border p-1 bg-light mb-3">
                        <img src="{{ asset('storage/' . $profile->image) }}" class="w-100 rounded" style="height: 140px; object-fit: cover;">
                        <div class="small text-muted p-1">Foto aktif saat ini</div>
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-him-primary w-100 py-3 fs-6">
                <i class="fas fa-save me-1"></i> Simpan Perubahan Hero Beranda
            </button>
        </div>
    </div>
</form>
@endsection
