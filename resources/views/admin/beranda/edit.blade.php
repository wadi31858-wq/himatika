@extends('layouts.admin')

@section('title', 'Kelola Beranda')
@section('page_title', 'Kelola Beranda & Hero Section')
@section('page_subtitle', 'Sesuaikan teks judul, tagline, tombol, foto sampul, dan statistik Beranda')

@section('content')
<form action="{{ route('admin.beranda.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Left Column: Form Settings -->
        <div class="col-lg-7">
            <!-- 1. Hero Content & Texts -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-heading"></i> Konten & Teks Hero
                    </h2>
                    <span class="badge bg-primary-subtle text-primary">Bagian Paling Atas</span>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Kapsul Label (Badge Atas)</label>
                    <input type="text" name="hero_badge" class="form-control" value="{{ old('hero_badge', $profile->hero_badge ?? 'HIMATIKA FMIPA UNUJA') }}" placeholder="Contoh: HIMATIKA FMIPA UNUJA">
                    <div class="form-text">Tampil di dalam kapsul navy di atas judul utama.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Teks Pendamping (Tagline)</label>
                    <input type="text" name="hero_tagline" class="form-control" value="{{ old('hero_tagline', $profile->hero_tagline ?? 'Synchronized Growth, Reaching New Heights') }}" placeholder="Contoh: Synchronized Growth, Reaching New Heights">
                    <div class="form-text">Teks slogan di samping kapsul dengan aksen garis pemisah.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Judul Utama Hero <span class="text-danger">*</span></label>
                    <textarea name="hero_title" class="form-control" rows="3" required placeholder="Tuliskan judul utama hero">{{ old('hero_title', $profile->hero_title ?? "Rumah yang\ninklusif, inovatif,\ndan tumbuh bersama.") }}</textarea>
                    <div class="form-text">Gunakan Enter/baris baru untuk mengatur pemenggalan kalimat pada tampilan Beranda.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Deskripsi Singkat</label>
                    <textarea name="hero_desc" class="form-control" rows="3" placeholder="Tuliskan ringkasan singkat">{{ old('hero_desc', $profile->hero_desc ?? 'Ruang resmi mahasiswa Matematika UNUJA untuk mengakses layanan, mengikuti kegiatan, menyampaikan aspirasi, dan mengenal karya HIMATIKA.') }}</textarea>
                </div>
            </div>

            <!-- 2. Action Buttons -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-mouse-pointer"></i> Tombol Tindakan (CTA)
                    </h2>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Teks Tombol Utama</label>
                        <input type="text" name="hero_btn_primary_text" class="form-control" value="{{ old('hero_btn_primary_text', $profile->hero_btn_primary_text ?? 'Hubungi Kami') }}" placeholder="Hubungi Kami">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Tautan Tombol Utama</label>
                        <input type="text" name="hero_btn_primary_url" class="form-control" value="{{ old('hero_btn_primary_url', $profile->hero_btn_primary_url ?? route('kontak')) }}" placeholder="{{ route('kontak') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Teks Tombol Sekunder</label>
                        <input type="text" name="hero_btn_secondary_text" class="form-control" value="{{ old('hero_btn_secondary_text', $profile->hero_btn_secondary_text ?? 'Pelajari Profil') }}" placeholder="Pelajari Profil">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Tautan Tombol Sekunder</label>
                        <input type="text" name="hero_btn_secondary_url" class="form-control" value="{{ old('hero_btn_secondary_url', $profile->hero_btn_secondary_url ?? route('profil')) }}" placeholder="{{ route('profil') }}">
                    </div>
                </div>
            </div>

            <!-- 3. Stats Settings -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-chart-bar"></i> Kartu Statistik Beranda
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Mode Penghitungan Angka Statistik</label>
                    <div class="d-flex gap-4 mt-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stats_mode" id="statsModeAuto" value="auto" {{ old('stats_mode', $profile->stats_mode ?? 'auto') === 'auto' ? 'checked' : '' }} onchange="toggleStatsMode()">
                            <label class="form-check-label fw-semibold text-dark" for="statsModeAuto">
                                Otomatis dari Database
                            </label>
                            <div class="text-muted small">Dihitung otomatis: {{ $autoStats['pengurus'] }} Pengurus, {{ $autoStats['bidang'] }} Bidang, {{ $autoStats['biro'] }} Biro.</div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stats_mode" id="statsModeManual" value="manual" {{ old('stats_mode', $profile->stats_mode ?? 'auto') === 'manual' ? 'checked' : '' }} onchange="toggleStatsMode()">
                            <label class="form-check-label fw-semibold text-dark" for="statsModeManual">
                                Kustom / Manual
                            </label>
                            <div class="text-muted small">Tentukan angka khusus secara bebas.</div>
                        </div>
                    </div>
                </div>

                <div id="manualStatsInputs" class="row g-3 pt-2" style="{{ old('stats_mode', $profile->stats_mode ?? 'auto') === 'manual' ? '' : 'display: none;' }}">
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold text-dark">Angka Pengurus</label>
                        <input type="text" name="hero_stats_pengurus" class="form-control" value="{{ old('hero_stats_pengurus', $profile->hero_stats_pengurus ?? '68') }}" placeholder="68">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold text-dark">Angka Bidang</label>
                        <input type="text" name="hero_stats_bidang" class="form-control" value="{{ old('hero_stats_bidang', $profile->hero_stats_bidang ?? '6') }}" placeholder="6">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold text-dark">Angka Biro</label>
                        <input type="text" name="hero_stats_biro" class="form-control" value="{{ old('hero_stats_biro', $profile->hero_stats_biro ?? '4') }}" placeholder="4">
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Visuals & Live Previews -->
        <div class="col-lg-5">
            <!-- 1. Background Photo Hero -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-image"></i> Foto Latar Hero
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted">Pratinjau Foto Latar Saat Ini:</label>
                    <div class="rounded-3 overflow-hidden border shadow-sm position-relative mb-2" style="height: 160px; background: #0D47A1;">
                        @if(!empty($profile->hero_image))
                            <img src="{{ asset('storage/' . $profile->hero_image) }}" alt="Hero Background" class="w-100 h-100" style="object-fit: cover;">
                        @else
                            <img src="{{ asset('images/hero-bg-unuja.jpg') }}" alt="Gedung UNUJA" class="w-100 h-100" style="object-fit: cover;">
                        @endif
                    </div>
                    <div class="small text-muted mb-3">Foto latar dipadukan dengan overlay elegan warna biru pada tampilan publik.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Ganti Foto Latar Hero</label>
                    <input type="file" name="hero_image" class="form-control" accept="image/png,image/jpeg,image/webp">
                    <div class="form-text">Format: JPG, PNG, WebP. Maksimal 3 MB. Disarankan resolusi lanskap (1920x1080).</div>
                </div>

                <div class="mb-0">
                    <label class="form-label small fw-semibold text-dark">Teks Alternatif (Alt)</label>
                    <input type="text" name="hero_image_alt" class="form-control" value="{{ old('hero_image_alt', $profile->hero_image_alt ?? 'Gedung Universitas Nurul Jadid') }}" placeholder="Deskripsi foto">
                </div>
            </div>

            <!-- 2. Right Frame / Organization Photo -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-portrait"></i> Foto Utama Organisasi (Bingkai Kanan)
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted">Pratinjau Foto Organisasi:</label>
                    <div class="rounded-3 overflow-hidden border shadow-sm mb-2 text-center bg-light" style="height: 180px;">
                        @if($profile->image)
                            <img src="{{ asset('storage/' . $profile->image) }}" alt="Foto Utama" class="w-100 h-100" style="object-fit: cover;">
                        @else
                            <img src="{{ asset('storage/profile/MmO6PGEjnheZras5q3R0WVRZ8WpodO9mDExn1wgH.jpg') }}" alt="Foto Utama" class="w-100 h-100" style="object-fit: cover;">
                        @endif
                    </div>
                </div>

                <div class="mb-0">
                    <label class="form-label fw-semibold text-dark">Ganti Foto Bingkai Kanan</label>
                    <input type="file" name="image" class="form-control" accept="image/png,image/jpeg,image/webp">
                    <div class="form-text">Format: JPG, PNG, WebP. Maksimal 3 MB. Menampilkan foto ketua/tim HIMATIKA.</div>
                </div>
            </div>

            <!-- Sticky Save Button -->
            <div class="him-card sticky-top p-3 bg-white shadow" style="top: 90px; z-index: 10;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fw-bold text-dark">Simpan Perubahan</div>
                        <small class="text-muted">Terapkan ke website publik</small>
                    </div>
                    <button type="submit" class="btn btn-him-primary px-4 py-2">
                        <i class="fas fa-save me-1"></i> Simpan Pengaturan
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    function toggleStatsMode() {
        const isManual = document.getElementById('statsModeManual').checked;
        const container = document.getElementById('manualStatsInputs');
        if (isManual) {
            container.style.display = 'flex';
        } else {
            container.style.display = 'none';
        }
    }
</script>
@endpush

