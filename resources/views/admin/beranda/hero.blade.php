@extends('layouts.admin')

@section('title', 'Hero Beranda')
@section('page_title', 'Kelola Hero Beranda')
@section('page_subtitle', 'Sesuaikan teks judul, tagline, foto latar, tombol aksi, dan foto utama kepengurusan')

@section('content')
<form action="{{ route('admin.beranda.hero.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Status & Visibilitas Section Hero -->
    <div class="him-card mb-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" name="hero_is_visible" id="heroIsVisible" value="1" {{ old('hero_is_visible', $siteSettings['hero_is_visible'] ?? '1') === '1' ? 'checked' : '' }} style="width: 2.8em; height: 1.4em; cursor: pointer;">
                </div>
                <div>
                    <label class="form-label fw-bold text-dark mb-0 fs-6" for="heroIsVisible">
                        Tampilkan Bagian Hero di Halaman Beranda
                    </label>
                    <div class="form-text mt-0">
                        Jika dinonaktifkan, bagian hero akan disembunyikan dan konten beranda dimulai dari bagian berikutnya.
                    </div>
                </div>
            </div>
            <div>
                <a href="{{ route('home') }}#hero" target="_blank" class="btn btn-sm btn-outline-primary px-3 rounded-pill">
                    <i class="fas fa-external-link-alt me-1"></i> Buka Tampilan Beranda
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left: Text Contents & Buttons -->
        <div class="col-lg-7">
            <!-- 1. Text & Headings -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-heading text-primary"></i> Konten & Teks Hero
                    </h2>
                    <span class="badge bg-primary-subtle text-primary">Teks Utama</span>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Kapsul Label (Badge Atas)</label>
                    <input type="text" name="hero_badge" class="form-control" value="{{ old('hero_badge', $profile->hero_badge ?? 'HIMATIKA FMIPA UNUJA') }}" placeholder="HIMATIKA FMIPA UNUJA">
                    <div class="form-text">Tampil di dalam kapsul di atas judul hero.</div>
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <label class="form-label fw-semibold text-dark mb-0">Teks Pendamping (Tagline)</label>
                        <button type="button" class="btn btn-sm btn-link text-muted p-0 text-decoration-none" onclick="document.getElementById('heroTagline').value = ''">
                            <i class="fas fa-eraser me-1"></i> Kosongkan
                        </button>
                    </div>
                    <input type="text" name="hero_tagline" id="heroTagline" class="form-control" value="{{ old('hero_tagline', $profile->hero_tagline ?? 'Grow with HIMATIKA') }}" placeholder="Grow with HIMATIKA">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Judul Utama Hero <span class="text-danger">*</span></label>
                    <textarea name="hero_title" class="form-control" rows="3" required placeholder="Tuliskan judul utama hero">{{ old('hero_title', $profile->hero_title ?? "Ruang Berkarya\nMahasiswa Informatika") }}</textarea>
                    <div class="form-text">Gunakan Enter / baris baru untuk mengatur pemenggalan kalimat pada tampilan Beranda.</div>
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <label class="form-label fw-semibold text-dark mb-0">Deskripsi Singkat (Opsional)</label>
                        <button type="button" class="btn btn-sm btn-link text-muted p-0 text-decoration-none" onclick="document.getElementById('heroDesc').value = ''">
                            <i class="fas fa-eraser me-1"></i> Kosongkan
                        </button>
                    </div>
                    <textarea name="hero_desc" id="heroDesc" class="form-control" rows="3" placeholder="Tuliskan deskripsi atau kosongkan jika tidak ingin ditampilkan">{{ old('hero_desc', $profile->hero_desc) }}</textarea>
                    <div class="form-text">Jika dikosongkan, area deskripsi tidak akan memakan ruang.</div>
                </div>
            </div>

            <!-- 2. Buttons CTA -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-mouse-pointer text-primary"></i> Tombol Aksi (CTA)
                    </h2>
                    <span class="badge bg-info-subtle text-info">Interaktif</span>
                </div>

                <!-- Primary Button -->
                <div class="p-3 bg-light rounded-3 mb-3 border">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="fw-bold text-dark"><i class="fas fa-arrow-circle-right text-primary me-1"></i> Tombol Utama</span>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="hero_btn_primary_active" id="btnPrimaryActive" value="1" {{ old('hero_btn_primary_active', $profile->hero_btn_primary_active ?? 1) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label small fw-semibold" for="btnPrimaryActive">Tampilkan Tombol</label>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Label Tombol</label>
                            <input type="text" name="hero_btn_primary_text" class="form-control form-control-sm" value="{{ old('hero_btn_primary_text', $profile->hero_btn_primary_text ?? 'Hubungi Kami') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Tautan / URL Tujuan</label>
                            <input type="text" name="hero_btn_primary_url" class="form-control form-control-sm" value="{{ old('hero_btn_primary_url', $profile->hero_btn_primary_url ?? route('kontak')) }}">
                        </div>
                    </div>
                </div>

                <!-- Secondary Button -->
                <div class="p-3 bg-light rounded-3 border">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="fw-bold text-dark"><i class="fas fa-arrow-circle-right text-secondary me-1"></i> Tombol Sekunder</span>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="hero_btn_secondary_active" id="btnSecondaryActive" value="1" {{ old('hero_btn_secondary_active', $profile->hero_btn_secondary_active ?? 1) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label small fw-semibold" for="btnSecondaryActive">Tampilkan Tombol</label>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Label Tombol</label>
                            <input type="text" name="hero_btn_secondary_text" class="form-control form-control-sm" value="{{ old('hero_btn_secondary_text', $profile->hero_btn_secondary_text ?? 'Pelajari Profil') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Tautan / URL Tujuan</label>
                            <input type="text" name="hero_btn_secondary_url" class="form-control form-control-sm" value="{{ old('hero_btn_secondary_url', $profile->hero_btn_secondary_url ?? '#tentang') }}">
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
                        <i class="fas fa-image text-primary"></i> Foto Latar Belakang Kampus
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Ganti Foto Latar Hero</label>
                    <input type="file" name="hero_image" class="form-control" accept="image/*">
                    <div class="form-text">Format: JPG, PNG, WEBP (Maks 4MB).</div>
                </div>

                @if($profile->hero_image && file_exists(public_path('storage/' . $profile->hero_image)))
                    <div class="rounded-3 overflow-hidden border p-1 bg-light mb-3">
                        <img src="{{ asset('storage/' . $profile->hero_image) }}" class="w-100 rounded" style="height: 140px; object-fit: cover;">
                        <div class="d-flex justify-content-between align-items-center p-1">
                            <span class="small text-success"><i class="fas fa-check-circle me-1"></i> Foto kustom aktif</span>
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="remove_hero_image" id="removeHeroImage" value="1">
                                <label class="form-check-label small text-danger" for="removeHeroImage">Hapus & Gunakan Default</label>
                            </div>
                        </div>
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

            <!-- Visual Foto Pengurus Card -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-users text-primary"></i> Foto Pengurus di Bingkai Hero Kanan
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Upload / Ganti Foto Pengurus</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <div class="form-text">Tampil memenuhi bingkai visual di sebelah kanan hero beranda.</div>
                </div>

                @php
                    $currentPengurusPhoto = null;
                    if (!empty($siteSettings['hero_pengurus_photo']) && file_exists(public_path('storage/' . $siteSettings['hero_pengurus_photo']))) {
                        $currentPengurusPhoto = asset('storage/' . $siteSettings['hero_pengurus_photo']);
                    } elseif (!empty($profile->image) && file_exists(public_path('storage/' . $profile->image))) {
                        $currentPengurusPhoto = asset('storage/' . $profile->image);
                    } elseif (file_exists(public_path('storage/news/news_1794407889_gb5rjeODz5yqGHUwbWhGZ34Odvvpuo9LrKyJBBhM.png'))) {
                        $currentPengurusPhoto = asset('storage/news/news_1794407889_gb5rjeODz5yqGHUwbWhGZ34Odvvpuo9LrKyJBBhM.png');
                    } else {
                        $currentPengurusPhoto = asset('images/news/news-1.jpg');
                    }
                @endphp
                <div class="rounded-3 overflow-hidden border p-1 bg-light mb-3">
                    <img src="{{ $currentPengurusPhoto }}" class="w-100 rounded" style="height: 160px; object-fit: cover;">
                    <div class="d-flex justify-content-between align-items-center p-1 mt-1">
                        <span class="small text-muted"><i class="fas fa-camera me-1"></i> Foto tampil di website publik</span>
                        @if(!empty($profile->image))
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="remove_image" id="removePengurusImage" value="1">
                                <label class="form-check-label small text-danger" for="removePengurusImage">Kembalikan ke Default</label>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-him-primary w-100 py-3 fs-6">
                <i class="fas fa-save me-1"></i> Simpan Perubahan Hero Beranda
            </button>
        </div>
    </div>
</form>
@endsection
