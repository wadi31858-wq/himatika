@extends('layouts.admin')

@section('title', 'Berita Terkini di Beranda')
@section('page_title', 'Kelola Bagian Berita di Beranda')
@section('page_subtitle', 'Pilih berita utama sorotan, teks pengantar, dan tombol tautan artikel')

@section('content')
<form action="{{ route('admin.beranda.berita.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Left: Text Settings -->
        <div class="col-lg-6">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-newspaper"></i> Teks & Header Section
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Lencana Section</label>
                    <input type="text" name="home_berita_badge" class="form-control" value="{{ old('home_berita_badge', $siteSettings['home_berita_badge'] ?? 'INFORMASI TERBARU') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Judul Utama <span class="text-danger">*</span></label>
                    <input type="text" name="home_berita_title" class="form-control" value="{{ old('home_berita_title', $siteSettings['home_berita_title'] ?? 'Kabar & Informasi Terkini') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Deskripsi Ringkas</label>
                    <textarea name="home_berita_desc" class="form-control" rows="3">{{ old('home_berita_desc', $siteSettings['home_berita_desc'] ?? 'Ikuti perkembangan terbaru, pengumuman penting, liputan kegiatan, dan kabar prestasi seputar mahasiswa Matematika UNUJA.') }}</textarea>
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark small">Teks Tombol Semua Berita</label>
                        <input type="text" name="home_berita_btn_text" class="form-control" value="{{ old('home_berita_btn_text', $siteSettings['home_berita_btn_text'] ?? 'Lihat Semua Berita') }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark small">Tautan Tombol</label>
                        <input type="text" name="home_berita_btn_url" class="form-control" value="{{ old('home_berita_btn_url', $siteSettings['home_berita_btn_url'] ?? route('berita')) }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Featured News Selection -->
        <div class="col-lg-6">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-star text-warning"></i> Sorotan Berita Utama
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Pilih Berita Utama (Card Besar Kiri)</label>
                    <select name="home_featured_news_id" class="form-select">
                        <option value="">-- Otomatis: Berita Terbit Paling Baru --</option>
                        @foreach($allNews as $item)
                            <option value="{{ $item->id }}" {{ old('home_featured_news_id', $siteSettings['home_featured_news_id'] ?? '') == $item->id ? 'selected' : '' }}>
                                [{{ $item->category }}] {{ Str::limit($item->title, 55) }} ({{ $item->published_at ? $item->published_at->format('d M Y') : 'Draft' }})
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">Berita utama ditampilkan dalam format kartu besar, diikuti berita pendamping di sampingnya.</div>
                </div>

                <div class="alert alert-info py-2 px-3 small mb-4">
                    <i class="fas fa-info-circle me-1"></i> Berita lainnya diatur secara otomatis dari modul <strong>Informasi & Berita</strong> berdasarkan tanggal publikasi terbaru.
                </div>

                <button type="submit" class="btn btn-him-primary w-100 py-2">
                    <i class="fas fa-save me-1"></i> Simpan Pengaturan Berita Beranda
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

