@extends('layouts.admin')

@section('title', 'Edit Profil')
@section('page_title', 'Kelola Profil & Sejarah HIMATIKA')
@section('page_subtitle', 'Tentang organisasi, motto, filosofi lambang, mars, dan jejak langkah')

@section('content')
<form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-university"></i> Profil & Identitas Lengkap
                    </h2>
                    <a href="{{ route('profil') }}" target="_blank" class="btn btn-sm btn-outline-info">
                        <i class="fas fa-external-link-alt me-1"></i> Lihat Halaman Profil
                    </a>
                </div>

                <!-- Nav Tabs -->
                <ul class="nav nav-pills mb-4 gap-2" id="profilTab" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active px-3 py-2 fw-semibold" data-bs-toggle="pill" data-bs-target="#tab-profil" type="button">Tentang</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link px-3 py-2 fw-semibold" data-bs-toggle="pill" data-bs-target="#tab-motto" type="button">Motto</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link px-3 py-2 fw-semibold" data-bs-toggle="pill" data-bs-target="#tab-filosofi" type="button">Filosofi Lambang</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link px-3 py-2 fw-semibold" data-bs-toggle="pill" data-bs-target="#tab-mars" type="button">Mars HIMATIKA</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link px-3 py-2 fw-semibold" data-bs-toggle="pill" data-bs-target="#tab-jejak" type="button">Sejarah & Jejak</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Tab Profil -->
                    <div class="tab-pane fade show active" id="tab-profil">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Judul Bagian Profil <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $profile->title) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Isi Profil Lengkap <span class="text-danger">*</span></label>
                            <textarea name="content" class="form-control font-monospace" rows="10" required>{{ old('content', $profile->content) }}</textarea>
                            <div class="form-text">Dapat menggunakan tag HTML dasar untuk format teks (&lt;p&gt;, &lt;strong&gt;, &lt;ul&gt;).</div>
                        </div>
                    </div>

                    <!-- Tab Motto -->
                    <div class="tab-pane fade" id="tab-motto">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Motto Organisasi</label>
                            <input type="text" name="motto" class="form-control" value="{{ old('motto', $profile->motto) }}" placeholder="Contoh: Bersama Berkarya, Berinovasi, dan Mengembangkan Teknologi">
                        </div>
                    </div>

                    <!-- Tab Filosofi -->
                    <div class="tab-pane fade" id="tab-filosofi">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Filosofi Lambang / Logo</label>
                            <textarea name="philosophy" class="form-control font-monospace" rows="10">{{ old('philosophy', $profile->philosophy) }}</textarea>
                            <div class="form-text">Jelaskan makna di balik bentuk, warna, dan lambang HIMATIKA.</div>
                        </div>
                    </div>

                    <!-- Tab Mars -->
                    <div class="tab-pane fade" id="tab-mars">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Lirik Mars HIMATIKA</label>
                            <textarea name="mars" class="form-control font-monospace" rows="12">{{ old('mars', $profile->mars) }}</textarea>
                            <div class="form-text">Gunakan enter/baris baru untuk setiap bait lagu.</div>
                        </div>
                    </div>

                    <!-- Tab Jejak Langkah -->
                    <div class="tab-pane fade" id="tab-jejak">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Sejarah & Jejak Langkah Organisasi</label>
                            <textarea name="history" class="form-control font-monospace" rows="12">{{ old('history', $profile->history) }}</textarea>
                            <div class="form-text">Rangkaian linimasa perkembangan HIMATIKA sejak berdiri hingga saat ini.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Photos & Actions -->
        <div class="col-lg-4">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-image"></i> Foto Pengurus / Halaman
                    </h2>
                </div>

                @if($profile->image)
                    <div class="rounded-3 overflow-hidden border mb-3 text-center bg-light" style="max-height: 180px;">
                        <img src="{{ asset('storage/' . $profile->image) }}" alt="Foto Profil" class="img-fluid" style="max-height: 180px; object-fit: contain;">
                    </div>
                @endif

                <div class="mb-0">
                    <label class="form-label fw-semibold text-dark">Ganti Foto</label>
                    <input type="file" name="image" class="form-control" accept="image/png,image/jpeg,image/webp">
                    <div class="form-text">Format: JPG, PNG, WebP (maks 3 MB).</div>
                </div>
            </div>

            <!-- Sticky Save Card -->
            <div class="him-card sticky-top p-3 bg-white shadow" style="top: 90px; z-index: 10;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fw-bold text-dark">Simpan Perubahan</div>
                        <small class="text-muted">Perbarui halaman Profil</small>
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
