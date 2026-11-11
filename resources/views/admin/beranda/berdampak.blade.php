@extends('layouts.admin')

@section('title', 'HIMATIKA Berdampak di Beranda')
@section('page_title', 'Kelola Bagian HIMATIKA Berdampak')
@section('page_subtitle', 'Sesuaikan judul, deskripsi, tombol, dan angka-angka capaian/statistik sosial')

@section('content')
<form action="{{ route('admin.beranda.berdampak.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Left: Text Settings -->
        <div class="col-lg-6">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-hand-holding-heart text-danger"></i> Teks & Header Section
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Lencana Section</label>
                    <input type="text" name="home_peduli_badge" class="form-control" value="{{ old('home_peduli_badge', $siteSettings['home_peduli_badge'] ?? 'HIMATIKA BERDAMPAK') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Judul Utama <span class="text-danger">*</span></label>
                    <input type="text" name="home_peduli_title" class="form-control" value="{{ old('home_peduli_title', $siteSettings['home_peduli_title'] ?? 'Mengabdi dengan Hati, Berkontribusi Nyata') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Deskripsi Ringkas</label>
                    <textarea name="home_peduli_desc" class="form-control" rows="3">{{ old('home_peduli_desc', $siteSettings['home_peduli_desc'] ?? 'Melalui berbagai inisiatif sosial, pelatihan, dan pengabdian masyarakat, mahasiswa Matematika terus aktif menebarkan manfaat di dalam dan luar kampus.') }}</textarea>
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark small">Teks Tombol</label>
                        <input type="text" name="home_peduli_btn_text" class="form-control" value="{{ old('home_peduli_btn_text', $siteSettings['home_peduli_btn_text'] ?? 'Lihat Semua Prestasi') }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark small">Tautan Tombol</label>
                        <input type="text" name="home_peduli_btn_url" class="form-control" value="{{ old('home_peduli_btn_url', $siteSettings['home_peduli_btn_url'] ?? route('prestasi')) }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Stats & Numbers -->
        <div class="col-lg-6">
            <!-- 1. Stats Calculation Mode -->
            <div class="him-card mb-4">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-chart-pie text-primary"></i> Statistik Organisasi
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Mode Penghitungan Angka</label>
                    <div class="d-flex gap-4 mt-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stats_mode" id="statsModeAuto" value="auto" {{ old('stats_mode', $profile->stats_mode ?? 'auto') === 'auto' ? 'checked' : '' }} onchange="toggleStatsMode()">
                            <label class="form-check-label fw-semibold text-dark" for="statsModeAuto">
                                Otomatis dari Data
                            </label>
                            <div class="text-muted small">Dihitung otomatis: {{ $autoStats['pengurus'] }} Pengurus, {{ $autoStats['bidang'] }} Bidang, {{ $autoStats['biro'] }} Biro.</div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stats_mode" id="statsModeManual" value="manual" {{ old('stats_mode', $profile->stats_mode ?? 'auto') === 'manual' ? 'checked' : '' }} onchange="toggleStatsMode()">
                            <label class="form-check-label fw-semibold text-dark" for="statsModeManual">
                                Kustom / Manual
                            </label>
                            <div class="text-muted small">Tentukan angka secara manual.</div>
                        </div>
                    </div>
                </div>

                <div id="manualStatsFields" style="{{ old('stats_mode', $profile->stats_mode ?? 'auto') === 'manual' ? '' : 'display:none;' }}">
                    <div class="row g-2 border-top pt-3">
                        <div class="col-4">
                            <label class="form-label small fw-semibold">Total Pengurus</label>
                            <input type="text" name="hero_stats_pengurus" class="form-control form-control-sm" value="{{ old('hero_stats_pengurus', $profile->hero_stats_pengurus ?? 68) }}">
                        </div>
                        <div class="col-4">
                            <label class="form-label small fw-semibold">Total Bidang</label>
                            <input type="text" name="hero_stats_bidang" class="form-control form-control-sm" value="{{ old('hero_stats_bidang', $profile->hero_stats_bidang ?? 6) }}">
                        </div>
                        <div class="col-4">
                            <label class="form-label small fw-semibold">Total Biro</label>
                            <input type="text" name="hero_stats_biro" class="form-control form-control-sm" value="{{ old('hero_stats_biro', $profile->hero_stats_biro ?? 4) }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Capaian / Sosial Stats -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-trophy text-warning"></i> Capaian Sosial & Pengabdian
                    </h2>
                </div>

                <div class="row g-2 mb-2">
                    <div class="col-4">
                        <label class="form-label small fw-semibold">Angka 1</label>
                        <input type="text" name="home_peduli_stat1_num" class="form-control form-control-sm" value="{{ old('home_peduli_stat1_num', $siteSettings['home_peduli_stat1_num'] ?? '10+') }}">
                    </div>
                    <div class="col-8">
                        <label class="form-label small fw-semibold">Label Capaian 1</label>
                        <input type="text" name="home_peduli_stat1_label" class="form-control form-control-sm" value="{{ old('home_peduli_stat1_label', $siteSettings['home_peduli_stat1_label'] ?? 'Program Sosial & Edukasi') }}">
                    </div>
                </div>

                <div class="row g-2 mb-2">
                    <div class="col-4">
                        <label class="form-label small fw-semibold">Angka 2</label>
                        <input type="text" name="home_peduli_stat2_num" class="form-control form-control-sm" value="{{ old('home_peduli_stat2_num', $siteSettings['home_peduli_stat2_num'] ?? '500+') }}">
                    </div>
                    <div class="col-8">
                        <label class="form-label small fw-semibold">Label Capaian 2</label>
                        <input type="text" name="home_peduli_stat2_label" class="form-control form-control-sm" value="{{ old('home_peduli_stat2_label', $siteSettings['home_peduli_stat2_label'] ?? 'Penerima Manfaat') }}">
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-4">
                        <label class="form-label small fw-semibold">Angka 3</label>
                        <input type="text" name="home_peduli_stat3_num" class="form-control form-control-sm" value="{{ old('home_peduli_stat3_num', $siteSettings['home_peduli_stat3_num'] ?? '100%') }}">
                    </div>
                    <div class="col-8">
                        <label class="form-label small fw-semibold">Label Capaian 3</label>
                        <input type="text" name="home_peduli_stat3_label" class="form-control form-control-sm" value="{{ old('home_peduli_stat3_label', $siteSettings['home_peduli_stat3_label'] ?? 'Dedikasi Mahasiswa') }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-him-primary w-100 py-2">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan Capaian
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    function toggleStatsMode() {
        const isManual = document.getElementById('statsModeManual').checked;
        document.getElementById('manualStatsFields').style.display = isManual ? 'block' : 'none';
    }
</script>
@endpush

