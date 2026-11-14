@extends('layouts.admin')

@section('title', 'Brand & Logo Navbar')
@section('page_title', 'Kelola Brand & Logo Navbar')
@section('page_subtitle', 'Edit logo, nama brand himpunan, garis aksen, dan pratinjau tampilan bilah navigasi website')

@push('styles')
<style>
    .brand-preview-card {
        background: #250D17;
        border: 2px solid #641D38;
        border-radius: 16px;
        padding: 24px 28px;
        box-shadow: 0 10px 25px rgba(37, 13, 23, 0.35);
        position: relative;
        overflow: hidden;
    }
    .brand-preview-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(138, 49, 81, 0.25) 0%, transparent 70%);
        pointer-events: none;
    }
    .preview-badge-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #F6E9EE;
        background: rgba(100, 29, 56, 0.6);
        border: 1px solid rgba(255, 247, 250, 0.2);
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
    }
    .preview-navbar-stage {
        background: rgba(255, 255, 255, 0.04);
        border: 1px dashed rgba(255, 247, 250, 0.2);
        border-radius: 12px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 80px;
    }
    .live-brand-container {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }
    .live-brand-logo-frame {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        flex-shrink: 0;
        transition: all 0.25s ease;
    }
    .live-brand-logo-frame img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .live-brand-text-col {
        display: flex;
        flex-direction: column;
        line-height: 1.15;
    }
    .live-brand-title {
        font-weight: 800;
        font-size: 1.15rem;
        letter-spacing: 0.2px;
        color: #FFF7FA;
        transition: color 0.2s ease;
    }
    .live-brand-subtitle {
        font-size: 0.7rem;
        font-weight: 600;
        color: #F6E9EE;
        opacity: 0.85;
        margin-top: 2px;
        letter-spacing: 0.3px;
    }
    .live-brand-accent {
        width: 42px;
        height: 3px;
        background: #8A3151;
        border-radius: 2px;
        margin-top: 4px;
        transition: all 0.2s ease;
    }
    .setting-section-card {
        background: #ffffff;
        border: 1px solid var(--him-border, #E2CBD3);
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
        padding: 22px;
        margin-bottom: 24px;
    }
    .setting-section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(100, 29, 56, 0.1);
    }
    .setting-section-header h3 {
        font-size: 1.05rem;
        font-weight: 700;
        color: #250D17;
        margin: 0;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10">

        <!-- ALERT NOTIFIKASI -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="fas fa-check-circle fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle me-1"></i> Terjadi kesalahan validasi:</div>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- 1. LIVE PREVIEW CARD (PERSIS TAMPILAN DI GAMBAR REFERENSI) -->
        <div class="brand-preview-card mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="preview-badge-label">
                    <i class="fas fa-eye text-warning"></i> Pratinjau Langsung (Live Navbar Header)
                </div>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-light px-3" style="border-radius: 9999px; font-size: 0.8rem;">
                    <i class="fas fa-external-link-alt me-1"></i> Buka Website Publik
                </a>
            </div>

            <p class="text-white-50 small mb-3">
                Berikut adalah simulasi tampilan nyata brand navbar Anda pada bilah navigasi website utama:
            </p>

            <div class="preview-navbar-stage">
                <!-- Simulating Brand in Navbar -->
                <div class="live-brand-container" id="previewBrandLink">
                    @php
                        $currentNavLogo = null;
                        $navAlt = $siteSettings['logo_nav_desktop_alt'] ?? 'Logo HIMATIKA';
                        $isCustomNavLogo = ($siteSettings['logo_nav_desktop_custom'] ?? '0') === '1' && !empty($siteSettings['logo_nav_desktop_file']);
                        if ($isCustomNavLogo) {
                            $currentNavLogo = asset('storage/' . $siteSettings['logo_nav_desktop_file']);
                        } elseif (!empty($siteSettings['main_logo'])) {
                            $currentNavLogo = asset('storage/' . $siteSettings['main_logo']);
                        } elseif ($globalProfile && $globalProfile->logo) {
                            $currentNavLogo = asset('storage/' . $globalProfile->logo);
                        }
                        $logoShape = $siteSettings['navbar_brand_logo_shape'] ?? 'circle';
                        $logoSize = $siteSettings['navbar_brand_logo_size'] ?? '44px';
                        $brandTitle = $siteSettings['navbar_brand_title'] ?? (($siteSettings['site_short_title'] ?? 'HIMATIKA') . ' UNUJA');
                        $brandSubtitle = $siteSettings['navbar_brand_subtitle'] ?? '';
                        $showSubtitle = ($siteSettings['navbar_brand_show_subtitle'] ?? '0') === '1';
                        $showAccent = ($siteSettings['navbar_brand_show_accent'] ?? '1') !== '0';
                        $accentWidth = $siteSettings['navbar_brand_accent_width'] ?? '42px';
                        $accentColor = $siteSettings['navbar_brand_accent_color'] ?? '#8A3151';
                        $textColor = $siteSettings['navbar_brand_text_color'] ?? '#FFF7FA';
                    @endphp

                    <div class="live-brand-logo-frame" id="previewLogoFrame" style="width: {{ $logoSize }}; height: {{ $logoSize }}; {{ $logoShape === 'none' ? 'background: transparent; border: none; box-shadow: none;' : ($logoShape === 'rounded' ? 'border-radius: 10px;' : 'border-radius: 50%;') }}">
                        @if($currentNavLogo)
                            <img src="{{ $currentNavLogo }}" id="previewLogoImg" alt="{{ $navAlt }}">
                        @else
                            <i class="fas fa-infinity" id="previewLogoFallback" style="color: #8A3151; font-size: 1.25rem;"></i>
                        @endif
                    </div>

                    <div class="live-brand-text-col">
                        <span class="live-brand-title" id="previewTitle" style="color: {{ $textColor }};">{{ $brandTitle }}</span>
                        <span class="live-brand-subtitle" id="previewSubtitle" style="{{ $showSubtitle ? '' : 'display: none;' }}">{{ $brandSubtitle }}</span>
                        <span class="live-brand-accent" id="previewAccent" style="width: {{ $accentWidth }}; background: {{ $accentColor }}; {{ $showAccent ? '' : 'display: none;' }}"></span>
                    </div>
                </div>

                <!-- Fake Navbar Links for realistic context -->
                <div class="d-none d-md-flex align-items-center gap-2 opacity-50 pe-2">
                    <span class="badge bg-secondary text-white fw-normal px-2 py-1" style="font-size: 0.75rem;">Beranda</span>
                    <span class="badge bg-secondary text-white fw-normal px-2 py-1" style="font-size: 0.75rem;">Tentang</span>
                    <span class="badge bg-secondary text-white fw-normal px-2 py-1" style="font-size: 0.75rem;">Informasi</span>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2 mt-2">
                <small class="text-white-50 fst-italic">
                    <i class="fas fa-info-circle me-1"></i> Preview ini bereaksi secara instan saat Anda mengetik atau mengubah opsi di bawah.
                </small>
            </div>
        </div>

        <!-- 2. MAIN EDIT FORM -->
        <form action="{{ route('admin.tampilan.brand.update') }}" method="POST" enctype="multipart/form-data" id="brandEditForm">
            @csrf
            @method('PUT')

            <!-- KARTU 1: TEKS NAMA BRAND & WARNA -->
            <div class="setting-section-card">
                <div class="setting-section-header">
                    <div class="p-2 bg-light rounded text-primary">
                        <i class="fas fa-font fa-lg"></i>
                    </div>
                    <div>
                        <h3>1. Teks Nama Brand Navbar</h3>
                        <small class="text-muted">Kelola tulisan nama himpunan dan fakultas/kampus yang tampil di header website</small>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold text-dark">
                            Nama Utama Brand Navbar <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="navbar_brand_title" 
                               id="inputTitle"
                               class="form-control form-control-lg fw-bold" 
                               value="{{ old('navbar_brand_title', $brandTitle) }}" 
                               required 
                               placeholder="Contoh: HIMATIKA UNUJA">
                        <div class="form-text">
                            Tulisan utama yang paling menonjol pada bilah navigasi website (Standar: <strong>HIMATIKA UNUJA</strong>).
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark">Warna Teks Brand</label>
                        <div class="input-group">
                            <input type="color" 
                                   name="navbar_brand_text_color" 
                                   id="inputTextColor" 
                                   class="form-control form-control-color" 
                                   value="{{ old('navbar_brand_text_color', $textColor) }}" 
                                   title="Pilih Warna Teks">
                            <input type="text" 
                                   id="inputTextColorHex" 
                                   class="form-control text-uppercase" 
                                   value="{{ old('navbar_brand_text_color', $textColor) }}" 
                                   placeholder="#FFF7FA">
                        </div>
                        <div class="form-text">Standar tema burgundy: <code>#FFF7FA</code>.</div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold text-dark">Sub-Teks / Tagline (Opsional)</label>
                        <input type="text" 
                               name="navbar_brand_subtitle" 
                               id="inputSubtitle"
                               class="form-control" 
                               value="{{ old('navbar_brand_subtitle', $brandSubtitle) }}" 
                               placeholder="Contoh: Universitas Nurul Jadid">
                        <div class="form-text">Teks kecil di bawah judul jika Anda ingin menyertakan nama kampus atau prodi.</div>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="navbar_brand_show_subtitle" 
                                   id="checkShowSubtitle" 
                                   value="1" 
                                   {{ $showSubtitle ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="checkShowSubtitle">
                                Tampilkan Sub-Teks
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label fw-semibold text-dark">Tautan Tujuan Klik Brand (URL)</label>
                    <input type="text" 
                           name="navbar_brand_url" 
                           class="form-control" 
                           value="{{ old('navbar_brand_url', $siteSettings['navbar_brand_url'] ?? '/') }}" 
                           placeholder="/">
                    <div class="form-text">Halaman yang dituju saat pengunjung mengklik logo/nama brand (default: <code>/</code> untuk Beranda).</div>
                </div>
            </div>

            <!-- KARTU 2: LOGO NAVBAR -->
            <div class="setting-section-card">
                <div class="setting-section-header">
                    <div class="p-2 bg-light rounded text-warning">
                        <i class="fas fa-image fa-lg"></i>
                    </div>
                    <div>
                        <h3>2. Logo Brand Navbar</h3>
                        <small class="text-muted">Unggah logo khusus untuk navbar atau sesuaikan bentuk bingkainya</small>
                    </div>
                </div>

                <div class="row g-4 align-items-center mb-4">
                    <div class="col-md-3 text-center">
                        <div class="p-3 bg-light rounded-3 border d-inline-block">
                            <div style="width: 70px; height: 70px; margin: 0 auto; display: flex; align-items: center; justify-content: center; background: #250D17; border-radius: 12px; padding: 6px;">
                                <div id="formLogoThumbnail" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #ffffff; border-radius: 50%; overflow: hidden;">
                                    @if($currentNavLogo)
                                        <img src="{{ $currentNavLogo }}" style="width: 100%; height: 100%; object-fit: contain;">
                                    @else
                                        <i class="fas fa-infinity text-muted"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="small fw-bold text-dark mt-2">Logo Saat Ini</div>
                            <div class="small text-muted" style="font-size: 0.75rem;">
                                {{ $isCustomNavLogo ? 'Logo Khusus Navbar' : 'Logo Utama Master' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <label class="form-label fw-bold text-dark">Ganti / Unggah Logo Navbar Baru</label>
                        <input type="file" 
                               name="navbar_brand_logo" 
                               id="inputLogoFile"
                               class="form-control" 
                               accept="image/png,image/jpeg,image/webp,image/svg+xml">
                        <div class="form-text mb-3">
                            Format yang didukung: PNG (sangat direkomendasikan dengan background transparan), JPG, WEBP, atau SVG. Maksimum 2 MB.
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold text-dark">Bentuk Bingkai Logo</label>
                                <select name="navbar_brand_logo_shape" id="selectLogoShape" class="form-select">
                                    <option value="circle" {{ $logoShape === 'circle' ? 'selected' : '' }}>
                                        Lingkaran Putih (Bulat Penuh) - Acuan Resmi
                                    </option>
                                    <option value="rounded" {{ $logoShape === 'rounded' ? 'selected' : '' }}>
                                        Kotak Sudut Membulat (Rounded Square)
                                    </option>
                                    <option value="none" {{ $logoShape === 'none' ? 'selected' : '' }}>
                                        Tanpa Bingkai (Polos / Transparan)
                                    </option>
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold text-dark">Ukuran Logo Navbar</label>
                                <select name="navbar_brand_logo_size" id="selectLogoSize" class="form-select">
                                    <option value="38px" {{ $logoSize === '38px' ? 'selected' : '' }}>Kecil (38px)</option>
                                    <option value="44px" {{ $logoSize === '44px' ? 'selected' : '' }}>Standar / Ideal (44px)</option>
                                    <option value="48px" {{ $logoSize === '48px' ? 'selected' : '' }}>Sedang (48px)</option>
                                    <option value="54px" {{ $logoSize === '54px' ? 'selected' : '' }}>Besar (54px)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Teks Alternatif (Alt Text Gambar)</label>
                    <input type="text" 
                           name="logo_nav_desktop_alt" 
                           class="form-control" 
                           value="{{ old('logo_nav_desktop_alt', $navAlt) }}" 
                           placeholder="Contoh: Logo HIMATIKA UNUJA">
                    <div class="form-text">Deskripsi gambar untuk aksesibilitas dan SEO Google.</div>
                </div>

                @if($isCustomNavLogo)
                    <div class="p-3 bg-light rounded-3 border d-flex align-items-center justify-content-between">
                        <div>
                            <span class="badge bg-info text-dark mb-1">Status Kustom</span>
                            <div class="small text-muted">Navbar sedang menggunakan logo khusus yang berbeda dari logo utama website.</div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="document.getElementById('resetLogoForm').submit();">
                            <i class="fas fa-undo me-1"></i> Reset ke Logo Master
                        </button>
                    </div>
                @endif
            </div>

            <!-- KARTU 3: GARIS AKSEN DI BAWAH TEKS -->
            <div class="setting-section-card">
                <div class="setting-section-header">
                    <div class="p-2 bg-light rounded text-danger">
                        <i class="fas fa-minus fa-lg"></i>
                    </div>
                    <div>
                        <h3>3. Garis Aksen Bawah (Underline Accent)</h3>
                        <small class="text-muted">Aksen garis khas di bawah teks HIMATIKA seperti pada desain resmi</small>
                    </div>
                </div>

                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="navbar_brand_show_accent" 
                                   id="checkShowAccent" 
                                   value="1" 
                                   {{ $showAccent ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-dark" for="checkShowAccent">
                                Tampilkan Garis Aksen
                            </label>
                        </div>
                        <div class="form-text">Garis kecil bernuansa burgundy di bawah nama brand.</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Panjang / Lebar Garis</label>
                        <select name="navbar_brand_accent_width" id="selectAccentWidth" class="form-select">
                            <option value="28px" {{ $accentWidth === '28px' ? 'selected' : '' }}>Pendek (28px)</option>
                            <option value="42px" {{ $accentWidth === '42px' ? 'selected' : '' }}>Standar / Ideal (42px)</option>
                            <option value="56px" {{ $accentWidth === '56px' ? 'selected' : '' }}>Panjang (56px)</option>
                            <option value="80px" {{ $accentWidth === '80px' ? 'selected' : '' }}>Sangat Panjang (80px)</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Warna Garis Aksen</label>
                        <div class="input-group">
                            <input type="color" 
                                   name="navbar_brand_accent_color" 
                                   id="inputAccentColor" 
                                   class="form-control form-control-color" 
                                   value="{{ old('navbar_brand_accent_color', $accentColor) }}" 
                                   title="Pilih Warna Aksen">
                            <input type="text" 
                                   id="inputAccentColorHex" 
                                   class="form-control text-uppercase" 
                                   value="{{ old('navbar_brand_accent_color', $accentColor) }}" 
                                   placeholder="#8A3151">
                        </div>
                        <div class="form-text">Warna aksen tema resmi: <code>#8A3151</code>.</div>
                    </div>
                </div>
            </div>

            <!-- TOMBOL SIMPAN UTAMA -->
            <div class="d-flex align-items-center justify-content-between pt-3 pb-5">
                <a href="{{ route('admin.tampilan.navbar') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Menu Navbar
                </a>
                <button type="submit" class="btn btn-him-primary btn-lg px-5 shadow-sm">
                    <i class="fas fa-save me-2"></i> Simpan Perubahan Brand Navbar
                </button>
            </div>
        </form>

        <!-- HIDDEN RESET LOGO FORM -->
        <form action="{{ route('admin.tampilan.brand.reset-logo') }}" method="POST" id="resetLogoForm" style="display: none;">
            @csrf
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputTitle = document.getElementById('inputTitle');
    const previewTitle = document.getElementById('previewTitle');

    const inputSubtitle = document.getElementById('inputSubtitle');
    const previewSubtitle = document.getElementById('previewSubtitle');
    const checkShowSubtitle = document.getElementById('checkShowSubtitle');

    const inputTextColor = document.getElementById('inputTextColor');
    const inputTextColorHex = document.getElementById('inputTextColorHex');

    const checkShowAccent = document.getElementById('checkShowAccent');
    const selectAccentWidth = document.getElementById('selectAccentWidth');
    const inputAccentColor = document.getElementById('inputAccentColor');
    const inputAccentColorHex = document.getElementById('inputAccentColorHex');
    const previewAccent = document.getElementById('previewAccent');

    const selectLogoShape = document.getElementById('selectLogoShape');
    const selectLogoSize = document.getElementById('selectLogoSize');
    const previewLogoFrame = document.getElementById('previewLogoFrame');
    const inputLogoFile = document.getElementById('inputLogoFile');
    const previewLogoImg = document.getElementById('previewLogoImg');

    // 1. Title real-time typing
    if (inputTitle && previewTitle) {
        inputTitle.addEventListener('input', function () {
            previewTitle.textContent = this.value.trim() ? this.value : 'HIMATIKA UNUJA';
        });
    }

    // 2. Subtitle real-time typing & toggle
    if (inputSubtitle && previewSubtitle) {
        inputSubtitle.addEventListener('input', function () {
            previewSubtitle.textContent = this.value;
        });
    }
    if (checkShowSubtitle && previewSubtitle) {
        checkShowSubtitle.addEventListener('change', function () {
            previewSubtitle.style.display = this.checked ? 'block' : 'none';
        });
    }

    // 3. Text Color sync
    if (inputTextColor && inputTextColorHex && previewTitle) {
        inputTextColor.addEventListener('input', function () {
            inputTextColorHex.value = this.value.toUpperCase();
            previewTitle.style.color = this.value;
        });
        inputTextColorHex.addEventListener('input', function () {
            if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
                inputTextColor.value = this.value;
                previewTitle.style.color = this.value;
            }
        });
    }

    // 4. Accent line sync
    if (checkShowAccent && previewAccent) {
        checkShowAccent.addEventListener('change', function () {
            previewAccent.style.display = this.checked ? 'block' : 'none';
        });
    }
    if (selectAccentWidth && previewAccent) {
        selectAccentWidth.addEventListener('change', function () {
            previewAccent.style.width = this.value;
        });
    }
    if (inputAccentColor && inputAccentColorHex && previewAccent) {
        inputAccentColor.addEventListener('input', function () {
            inputAccentColorHex.value = this.value.toUpperCase();
            previewAccent.style.backgroundColor = this.value;
        });
        inputAccentColorHex.addEventListener('input', function () {
            if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
                inputAccentColor.value = this.value;
                previewAccent.style.backgroundColor = this.value;
            }
        });
    }

    // 5. Logo Shape & Size sync
    function updateLogoFrame() {
        if (!previewLogoFrame) return;
        const shape = selectLogoShape ? selectLogoShape.value : 'circle';
        const size = selectLogoSize ? selectLogoSize.value : '44px';

        previewLogoFrame.style.width = size;
        previewLogoFrame.style.height = size;

        if (shape === 'none') {
            previewLogoFrame.style.background = 'transparent';
            previewLogoFrame.style.border = 'none';
            previewLogoFrame.style.boxShadow = 'none';
            previewLogoFrame.style.borderRadius = '0';
        } else if (shape === 'rounded') {
            previewLogoFrame.style.background = '#ffffff';
            previewLogoFrame.style.border = '1px solid rgba(255, 255, 255, 0.3)';
            previewLogoFrame.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.2)';
            previewLogoFrame.style.borderRadius = '10px';
        } else {
            previewLogoFrame.style.background = '#ffffff';
            previewLogoFrame.style.border = '1px solid rgba(255, 255, 255, 0.3)';
            previewLogoFrame.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.2)';
            previewLogoFrame.style.borderRadius = '50%';
        }
    }

    if (selectLogoShape) selectLogoShape.addEventListener('change', updateLogoFrame);
    if (selectLogoSize) selectLogoSize.addEventListener('change', updateLogoFrame);

    // 6. Live File Image Preview
    if (inputLogoFile && previewLogoImg) {
        inputLogoFile.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewLogoImg.src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});
</script>
@endpush

