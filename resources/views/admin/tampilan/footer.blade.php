@extends('layouts.admin')

@section('title', 'Footer & Kontak Website')
@section('page_title', 'Kelola Footer & Kontak Website')
@section('page_subtitle', 'Teks penutup, hak cipta, tautan sosial media, sekretariat, dan peta lokasi')

@section('content')
<form action="{{ route('admin.tampilan.footer.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Left: Footer Text & Copyright -->
        <div class="col-lg-6">
            <div class="him-card h-100">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-paragraph text-primary"></i> Teks Footer & Hak Cipta
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Deskripsi Ringkas Footer</label>
                    <textarea name="footer_text" class="form-control" rows="4" placeholder="Tuliskan profil singkat organisasi yang tampil di kolom kiri footer...">{{ old('footer_text', $profile->footer_text) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Teks Hak Cipta (Copyright)</label>
                    <input type="text" name="copyright_text" class="form-control" value="{{ old('copyright_text', $siteSettings['footer_copyright'] ?? '© 2026 HIMATIKA UNUJA 2026.') }}">
                    <div class="form-text">Ditampilkan di baris paling bawah sebelah kiri.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Keterangan Pengelola (Managed By)</label>
                    <input type="text" name="managed_by" class="form-control" value="{{ old('managed_by', $siteSettings['footer_managed_by'] ?? 'Dikelola oleh Tim Website HIMATIKA') }}">
                    <div class="form-text">Ditampilkan di baris paling bawah sebelah kanan.</div>
                </div>

                <div class="mb-0">
                    <label class="form-label fw-semibold text-dark">Alamat Sekretariat</label>
                    <textarea name="address" class="form-control" rows="3" placeholder="Alamat lengkap sekretariat / kampus...">{{ old('address', $profile->address) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Right: Kontak & Sosial Media -->
        <div class="col-lg-6">
            <div class="him-card h-100">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-address-book text-primary"></i> Kontak & Sosial Media
                    </h2>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark"><i class="fas fa-envelope text-danger me-1"></i> Email Resmi</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $profile->email) }}" placeholder="himatika@unuja.ac.id">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark"><i class="fas fa-phone text-secondary me-1"></i> Telepon Kantor / Sekretariat</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $profile->phone) }}" placeholder="+62 812-3456-7890">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">
                        <i class="fab fa-whatsapp text-success me-1"></i> Nomor WhatsApp Resmi Organisasi
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-success fw-bold"><i class="fab fa-whatsapp fs-5"></i></span>
                        <input type="text" name="whatsapp_number" class="form-control" value="{{ old('whatsapp_number', $siteSettings['whatsapp_number'] ?? '[NOMOR_WHATSAPP_HIMATIKA]') }}" placeholder="[NOMOR_WHATSAPP_HIMATIKA]">
                    </div>
                    <div class="form-text">
                        Nomor ini menjadi satu sumber untuk tautan <strong>Hubungi via WhatsApp</strong> di footer dan <strong>tombol WhatsApp bulat mengambang</strong>. Awalan <code>08</code> akan otomatis dikonversi ke format internasional <code>628</code> dengan pesan: <em>"Halo HIMATIKA UNUJA, saya ingin bertanya."</em>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark"><i class="fab fa-instagram text-danger me-1"></i> Tautan Instagram</label>
                    <input type="url" name="instagram" class="form-control" value="{{ old('instagram', $profile->instagram) }}" placeholder="https://instagram.com/himatika_unuja">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark"><i class="fab fa-youtube text-danger me-1"></i> Tautan YouTube</label>
                    <input type="url" name="youtube" class="form-control" value="{{ old('youtube', $profile->youtube) }}" placeholder="https://youtube.com/@himatika_unuja">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark"><i class="fab fa-tiktok text-dark me-1"></i> Tautan TikTok</label>
                        <input type="url" name="tiktok" class="form-control" value="{{ old('tiktok', $profile->tiktok) }}" placeholder="https://tiktok.com/@himatika_unuja">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark"><i class="fab fa-facebook text-primary me-1"></i> Tautan Facebook</label>
                        <input type="url" name="facebook" class="form-control" value="{{ old('facebook', $profile->facebook) }}" placeholder="https://facebook.com/himatika.unuja">
                    </div>
                </div>

                <div class="mb-0">
                    <label class="form-label fw-semibold text-dark"><i class="fas fa-map-marked-alt text-info me-1"></i> Google Maps Embed (URL Iframe)</label>
                    <input type="text" name="maps_embed" class="form-control" value="{{ old('maps_embed', $siteSettings['footer_maps_embed'] ?? '') }}" placeholder="https://www.google.com/maps/embed?pb=...">
                    <div class="form-text">Salin tautan `src` dari sematan peta Google Maps untuk menampilkan peta mini pada footer.</div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="him-card py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('home') }}#kontak" target="_blank" class="btn btn-outline-info">
                        <i class="fas fa-external-link-alt me-1"></i> Lihat Footer Publik
                    </a>
                    <button type="submit" class="btn btn-him-primary px-4">
                        <i class="fas fa-save me-1"></i> Simpan Pengaturan Footer
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

