@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('page_title', 'Pengaturan Umum Website')
@section('page_subtitle', 'Identitas, logo, favicon, kontak, dan tautan media sosial resmi HIMATIKA')

@section('content')
<form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Left: Identity, Contacts, Socials -->
        <div class="col-lg-7">
            <!-- Website Identity -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-globe"></i> Identitas Website
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Nama Himpunan / Website <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $profile->title ?? 'HIMATIKA FMIPA UNUJA') }}" required placeholder="HIMATIKA FMIPA UNUJA">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Nama Kampus / Universitas</label>
                    <input type="text" name="campus_name" class="form-control" value="{{ old('campus_name', $profile->campus_name ?? 'Universitas Nurul Jadid') }}" placeholder="Universitas Nurul Jadid">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Deskripsi Meta (SEO & Pratinjau Tautan)</label>
                    <textarea name="meta_description" class="form-control" rows="2" placeholder="Website resmi Himpunan Mahasiswa Matematika...">{{ old('meta_description', $profile->meta_description ?? '') }}</textarea>
                </div>

                <div class="mb-0">
                    <label class="form-label fw-semibold text-dark">Teks Ringkasan Footer</label>
                    <textarea name="footer_text" class="form-control" rows="2" placeholder="Teks keterangan singkat di bagian footer...">{{ old('footer_text', $profile->footer_text ?? '') }}</textarea>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-address-book"></i> Kontak & Alamat Resmi
                    </h2>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Email Resmi</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $profile->email ?? '') }}" placeholder="himatika@unuja.ac.id">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $profile->phone ?? '') }}" placeholder="+62 812-3456-7890">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold text-dark">Alamat Sekretariat</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="Gedung FMIPA, Universitas Nurul Jadid, Paiton, Probolinggo">{{ old('address', $profile->address ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-share-alt"></i> Tautan Media Sosial
                    </h2>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark"><i class="fab fa-instagram text-danger me-1"></i> Instagram</label>
                        <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $profile->instagram ?? '') }}" placeholder="https://instagram.com/himatika_unuja">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark"><i class="fab fa-youtube text-danger me-1"></i> YouTube</label>
                        <input type="text" name="youtube" class="form-control" value="{{ old('youtube', $profile->youtube ?? '') }}" placeholder="https://youtube.com/@himatika">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark"><i class="fab fa-tiktok text-dark me-1"></i> TikTok</label>
                        <input type="text" name="tiktok" class="form-control" value="{{ old('tiktok', $profile->tiktok ?? '') }}" placeholder="https://tiktok.com/@himatika_unuja">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark"><i class="fab fa-facebook text-primary me-1"></i> Facebook</label>
                        <input type="text" name="facebook" class="form-control" value="{{ old('facebook', $profile->facebook ?? '') }}" placeholder="https://facebook.com/himatika.unuja">
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Logo & Favicon -->
        <div class="col-lg-5">
            <!-- Logo Upload -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-shield-alt"></i> Logo Organisasi
                    </h2>
                </div>

                <div class="text-center p-3 mb-3 bg-light rounded-3 border">
                    @if($profile->logo)
                        <img src="{{ asset('storage/' . $profile->logo) }}" alt="Logo" class="img-fluid" style="max-height: 100px; object-fit: contain;">
                    @else
                        <div class="text-muted small py-4">
                            <i class="fas fa-image fs-1 d-block mb-2 text-muted"></i>
                            Belum ada logo diunggah.
                        </div>
                    @endif
                </div>

                <div class="mb-0">
                    <label class="form-label fw-semibold text-dark">Unggah Logo Baru</label>
                    <input type="file" name="logo" class="form-control" accept="image/png,image/jpeg,image/svg+xml,image/webp">
                    <div class="form-text">Format: PNG, SVG, JPG, WebP. Maksimal 2 MB. Disarankan latar transparan.</div>
                </div>
            </div>

            <!-- Favicon Upload -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-icons"></i> Favicon (Ikon Tab Browser)
                    </h2>
                </div>

                <div class="text-center p-3 mb-3 bg-light rounded-3 border">
                    @if($profile->favicon)
                        <img src="{{ asset('storage/' . $profile->favicon) }}" alt="Favicon" style="width: 48px; height: 48px; object-fit: contain;">
                    @else
                        <div class="text-muted small py-3">
                            <i class="fas fa-browser fs-2 d-block mb-2 text-muted"></i>
                            Favicon default browser.
                        </div>
                    @endif
                </div>

                <div class="mb-0">
                    <label class="form-label fw-semibold text-dark">Unggah Favicon</label>
                    <input type="file" name="favicon" class="form-control" accept="image/x-icon,image/png,image/svg+xml">
                    <div class="form-text">Format: ICO, PNG, SVG (32x32 atau 64x64). Maksimal 1 MB.</div>
                </div>
            </div>

            <!-- Sticky Save -->
            <div class="him-card sticky-top p-3 bg-white shadow" style="top: 90px; z-index: 10;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fw-bold text-dark">Simpan Pengaturan</div>
                        <small class="text-muted">Perbarui seluruh situs</small>
                    </div>
                    <button type="submit" class="btn btn-him-primary px-4 py-2">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

