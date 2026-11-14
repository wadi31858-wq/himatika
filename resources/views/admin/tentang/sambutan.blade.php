@extends('layouts.admin')

@section('title', 'Kelola Sambutan Kaprodi')
@section('page_title', 'Kelola Sambutan Kaprodi')
@section('page_subtitle', 'Sesuaikan nama, jabatan, foto, naskah sambutan, dan kutipan resmi Kaprodi')

@section('content')
<form action="{{ route('admin.tentang.sambutan.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Status & Visibilitas Sambutan Kaprodi -->
    <div class="him-card mb-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" name="sambutan_is_visible" id="sambutanIsVisible" value="1" {{ old('sambutan_is_visible', $siteSettings['sambutan_is_visible'] ?? '1') === '1' ? 'checked' : '' }} style="width: 2.8em; height: 1.4em; cursor: pointer;">
                </div>
                <div>
                    <label class="form-label fw-bold text-dark mb-0 fs-6" for="sambutanIsVisible">
                        Tampilkan Halaman Sambutan di Website Publik
                    </label>
                    <div class="form-text mt-0">
                        Jika dinonaktifkan, tautan ke Sambutan Kaprodi pada navbar akan disembunyikan.
                    </div>
                </div>
            </div>
            <div>
                <a href="{{ route('sambutan') }}" target="_blank" class="btn btn-sm btn-outline-primary px-3 rounded-pill">
                    <i class="fas fa-external-link-alt me-1"></i> Buka Tampilan Publik
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left: Form inputs -->
        <div class="col-lg-8">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-user-tie text-primary"></i> Data & Naskah Sambutan
                    </h2>
                    <a href="{{ route('sambutan') }}" target="_blank" class="btn btn-sm btn-outline-info">
                        <i class="fas fa-external-link-alt me-1"></i> Lihat Publik
                    </a>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Lencana Atas (Badge)</label>
                        <input type="text" name="sambutan_badge" class="form-control" value="{{ old('sambutan_badge', $siteSettings['sambutan_badge'] ?? 'PESAN PIMPINAN') }}">
                        <div class="form-text">Contoh: PESAN PIMPINAN</div>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold text-dark">Judul Sambutan</label>
                        <input type="text" name="sambutan_banner_title" class="form-control" value="{{ old('sambutan_banner_title', $siteSettings['sambutan_banner_title'] ?? 'Sambutan Kaprodi') }}">
                        <div class="form-text">Contoh: Sambutan Kaprodi (Kata kedua otomatis beraksen miring emas).</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                        <input type="text" name="sambutan_name" class="form-control" value="{{ old('sambutan_name', $siteSettings['sambutan_name'] ?? ($kaprodi->name ?? 'MUDAKKIR, S.Pd., MM.')) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Jabatan Resmi <span class="text-danger">*</span></label>
                        <input type="text" name="sambutan_title" class="form-control" value="{{ old('sambutan_title', $siteSettings['sambutan_title'] ?? ($kaprodi->position ?? 'Ketua Program Studi')) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Kutipan / Motto Singkat</label>
                    <input type="text" name="sambutan_quote" class="form-control" value="{{ old('sambutan_quote', $siteSettings['sambutan_quote'] ?? 'Mewujudkan generasi unggul yang beriman, berilmu, dan berakhlak mulia.') }}">
                    <div class="form-text">Tampil di dalam kotak kutipan di bawah foto profil Kaprodi.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Isi Lengkap Sambutan <span class="text-danger">*</span></label>
                    <textarea name="sambutan_content" class="form-control visual-editor" rows="12" required>{{ old('sambutan_content', $siteSettings['sambutan_content'] ?? ($kaprodi->bio ?? "Assalamu’alaikum warahmatullahi wabarakatuh.\n\nPuji syukur ke hadirat Allah SWT atas limpahan rahmat dan karunia-Nya, website resmi HIMATIKA UNUJA hadir sebagai media informasi, komunikasi, dan transparansi kegiatan kemahasiswaan.\n\nKami berharap wadah ini dapat mempererat tali silaturahmi serta mendorong prestasi akademik dan kepemimpinan seluruh mahasiswa.")) }}</textarea>
                    <div class="form-text">Tuliskan teks sambutan secara jelas. Gunakan Enter untuk paragraf baru.</div>
                </div>
            </div>
        </div>

        <!-- Right: Photo upload -->
        <div class="col-lg-4">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-portrait"></i> Foto Resmi Kaprodi
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Ganti Foto Profil</label>
                    <input type="file" name="sambutan_photo" class="form-control" accept="image/*">
                    <div class="form-text">Gunakan foto formal pimpinan (rasio vertikal atau persegi).</div>
                </div>

                @php $curPhoto = $siteSettings['sambutan_photo'] ?? ($kaprodi->photo ?? null); @endphp
                @if($curPhoto)
                    <div class="rounded-3 overflow-hidden border p-1 bg-light mb-3 text-center">
                        <img src="{{ asset('storage/' . $curPhoto) }}" class="rounded" style="height: 200px; width: auto; object-fit: cover;">
                        <div class="small text-muted p-1">Foto aktif saat ini</div>
                    </div>
                @endif

                <button type="submit" class="btn btn-him-primary w-100 py-2">
                    <i class="fas fa-save me-1"></i> Simpan Sambutan Kaprodi
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

