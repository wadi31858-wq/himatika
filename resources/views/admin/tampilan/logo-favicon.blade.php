@extends('layouts.admin')

@section('title', 'Kelola Logo & Favicon')
@section('page_title', 'Kelola Logo & Favicon')
@section('page_subtitle', 'Sesuaikan logo utama, favicon, serta pengaturan khusus untuk navbar, footer, dan panel admin')

@section('content')
<form action="{{ route('admin.tampilan.logo-favicon.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- BAGIAN 1: LOGO & FAVICON UTAMA (MASTER) -->
    <div class="row g-4 mb-4">
        <!-- Master Logo -->
        <div class="col-lg-6">
            <div class="him-card h-100">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-certificate text-warning"></i> Logo Utama Website (Master)
                    </h2>
                </div>
                <p class="small text-muted mb-3">
                    Logo standar yang otomatis digunakan di seluruh bagian website jika tidak ada logo khusus yang diaktifkan.
                </p>

                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 border mb-3">
                    <div class="bg-white p-2 rounded border d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        @if($profile->logo)
                            <img src="{{ asset('storage/' . $profile->logo) }}" alt="Logo Utama" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        @else
                            <i class="fas fa-infinity fs-1 text-primary"></i>
                        @endif
                    </div>
                    <div>
                        <div class="fw-bold text-dark">Logo Utama Terpasang</div>
                        <small class="text-muted d-block">
                            {{ $profile->logo ? basename($profile->logo) : 'Menggunakan ikon bawaan' }}
                        </small>
                        <span class="badge bg-success-subtle text-success mt-1">Aktif sebagai Default</span>
                    </div>
                </div>

                <div class="mb-0">
                    <label class="form-label fw-semibold text-dark">Ganti Logo Utama</label>
                    <input type="file" name="main_logo" class="form-control" accept="image/*">
                    <div class="form-text">Format: PNG transparan, SVG, atau WebP. Maksimal 2 MB. Disarankan proporsi persegi atau rasio horizontal 1:1 hingga 3:1.</div>
                </div>
            </div>
        </div>

        <!-- Master Favicon -->
        <div class="col-lg-6">
            <div class="him-card h-100">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-star text-warning"></i> Favicon Utama (Browser Tab)
                    </h2>
                </div>
                <p class="small text-muted mb-3">
                    Ikon tab browser, bookmark, dan pintasan layar beranda pengunjung.
                </p>

                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 border mb-3">
                    <div class="bg-white p-2 rounded border d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        @if($profile->favicon)
                            <img src="{{ asset('storage/' . $profile->favicon) }}" alt="Favicon" style="max-width: 48px; max-height: 48px; object-fit: contain;">
                        @else
                            <i class="fas fa-globe fs-2 text-secondary"></i>
                        @endif
                    </div>
                    <div>
                        <div class="fw-bold text-dark">Favicon Terpasang</div>
                        <small class="text-muted d-block">
                            {{ $profile->favicon ? basename($profile->favicon) : 'Menggunakan favicon default' }}
                        </small>
                        <span class="badge bg-info-subtle text-info mt-1">Format Ikon 32x32 / 48x48</span>
                    </div>
                </div>

                <div class="mb-0">
                    <label class="form-label fw-semibold text-dark">Ganti Favicon Utama</label>
                    <input type="file" name="main_favicon" class="form-control" accept=".ico,.png,.svg,.jpg">
                    <div class="form-text">Format yang disarankan: .ico atau .png 32x32 px. Maksimal 1 MB.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- BAGIAN 2: PENGATURAN SPESIFIK PER LOKASI -->
    <div class="him-card mb-4">
        <div class="him-card-header">
            <h2 class="him-card-title">
                <i class="fas fa-map-marker-alt text-primary"></i> Pengaturan Logo Spesifik Per Lokasi
            </h2>
        </div>
        <p class="text-muted mb-4">
            Anda dapat menyesuaikan tampilan logo untuk setiap posisi penempatan. Jika memilih <strong>"Gunakan Logo Utama"</strong>, sistem otomatis menerapkan Logo Utama. Jika memilih <strong>"Gunakan Logo Khusus"</strong>, Anda dapat mengunggah varian warna atau tata letak berbeda (misal: logo putih untuk footer gelap, atau logo persegi untuk sidebar).
        </p>

        <div class="row g-4">
            @foreach($locations as $key => $loc)
            @php
                $isCustom = ($siteSettings[$loc['use_custom_key']] ?? '0') === '1';
                $customFile = $siteSettings[$loc['file_key']] ?? '';
                $altVal = $siteSettings[$loc['alt_key']] ?? $loc['default_alt'];
            @endphp
            <div class="col-lg-6">
                <div class="p-3 rounded-3 border bg-light h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h5 class="fw-bold text-dark mb-0 fs-6">
                                <i class="fas fa-check-circle text-primary me-1"></i> {{ $loc['name'] }}
                            </h5>
                            @if($isCustom && $customFile)
                                <span class="badge bg-warning-subtle text-warning">Logo Khusus</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Logo Utama</span>
                            @endif
                        </div>
                        <p class="small text-muted mb-3">{{ $loc['desc'] }}</p>

                        <!-- Radio Choice -->
                        <div class="mb-3 d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="use_custom_{{ $key }}" id="use_main_{{ $key }}" value="0" {{ !$isCustom ? 'checked' : '' }} onchange="toggleCustomLogo('{{ $key }}', false)">
                                <label class="form-check-label small fw-semibold" for="use_main_{{ $key }}">
                                    Gunakan Logo Utama
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="use_custom_{{ $key }}" id="use_custom_{{ $key }}" value="1" {{ $isCustom ? 'checked' : '' }} onchange="toggleCustomLogo('{{ $key }}', true)">
                                <label class="form-check-label small fw-semibold text-primary" for="use_custom_{{ $key }}">
                                    Gunakan Logo Khusus
                                </label>
                            </div>
                        </div>

                        <!-- Current Preview -->
                        <div class="d-flex align-items-center gap-3 p-2 bg-white rounded border mb-3">
                            <div class="bg-light p-1 rounded border d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                                @if($isCustom && $customFile && file_exists(storage_path('app/public/' . $customFile)))
                                    <img src="{{ asset('storage/' . $customFile) }}" alt="{{ $altVal }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                @elseif($profile->logo)
                                    <img src="{{ asset('storage/' . $profile->logo) }}" alt="Logo Utama" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                @else
                                    <i class="fas fa-image text-muted"></i>
                                @endif
                            </div>
                            <div class="small flex-grow-1">
                                <div class="fw-semibold text-dark">
                                    {{ $isCustom && $customFile ? 'Berkas Khusus: ' . basename($customFile) : 'Mengikuti Logo Utama' }}
                                </div>
                                <div class="text-muted" style="font-size: 0.75rem;">Alt: {{ $altVal }}</div>
                            </div>
                        </div>

                        <!-- Custom Upload & Alt Input (shown/enabled) -->
                        <div id="custom_box_{{ $key }}" class="{{ !$isCustom ? 'd-none' : '' }}">
                            <div class="mb-2">
                                <label class="form-label small fw-semibold text-dark mb-1">Unggah Logo Khusus Lokasi Ini</label>
                                <input type="file" name="file_{{ $key }}" class="form-control form-control-sm" accept="image/*">
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label small fw-semibold text-dark mb-1">Teks Alt (Aksesibilitas)</label>
                            <input type="text" name="alt_{{ $key }}" class="form-control form-control-sm" value="{{ old('alt_' . $key, $altVal) }}">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- SUBMIT BAR -->
    <div class="him-card py-3">
        <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted small">Pastikan perubahan disimpan agar segera tercermin di tampilan website publik dan panel admin.</span>
            <button type="submit" class="btn btn-him-primary px-4 py-2">
                <i class="fas fa-save me-1"></i> Simpan Seluruh Pengaturan Logo
            </button>
        </div>
    </div>
</form>

<script>
function toggleCustomLogo(locKey, isCustom) {
    const box = document.getElementById('custom_box_' + locKey);
    if (box) {
        if (isCustom) {
            box.classList.remove('d-none');
        } else {
            box.classList.add('d-none');
        }
    }
}
</script>
@endsection

