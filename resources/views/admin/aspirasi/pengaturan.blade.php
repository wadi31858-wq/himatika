@extends('layouts.admin')

@section('title', 'Pengaturan Formulir Aspirasi')
@section('page_title', 'Pengaturan Formulir Aspirasi')
@section('page_subtitle', 'Sesuaikan teks pengantar, instruksi pengisian, label tombol, dan pesan konfirmasi publik')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header d-flex align-items-center justify-content-between">
                <h2 class="him-card-title mb-0">
                    <i class="fas fa-sliders-h text-primary"></i> Teks & Pengaturan Formulir Aspirasi
                </h2>
                <a href="{{ route('aspirasi.index') }}" target="_blank" class="btn btn-sm btn-outline-info">
                    <i class="fas fa-external-link-alt me-1"></i> Buka Halaman Publik
                </a>
            </div>

            <form action="{{ route('admin.aspirasi.pengaturan.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Judul Utama Halaman / Formulir <span class="text-danger">*</span></label>
                    <input type="text" name="aspiration_intro_title" class="form-control" value="{{ old('aspiration_intro_title', $introTitle) }}" required placeholder="Contoh: Ruang Terbuka Menyampaikan Aspirasi">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Deskripsi & Petunjuk Pengisian</label>
                    <textarea name="aspiration_intro_desc" class="form-control" rows="3" placeholder="Tuliskan petunjuk atau sambutan pembuka bagi mahasiswa...">{{ old('aspiration_intro_desc', $introDesc) }}</textarea>
                    <div class="form-text">Teks ini menjelaskan tujuan formulir dan etika penyampaian aspirasi kepada pengunjung website.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Label Tombol Kirim <span class="text-danger">*</span></label>
                    <input type="text" name="aspiration_btn_text" class="form-control" value="{{ old('aspiration_btn_text', $buttonText) }}" required placeholder="Contoh: Kirim Aspirasi Sekarang">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Pesan Konfirmasi Setelah Terkirim <span class="text-danger">*</span></label>
                    <textarea name="aspiration_success_msg" class="form-control" rows="3" required placeholder="Pesan ucapan terima kasih yang muncul setelah form disubmit...">{{ old('aspiration_success_msg', $successMsg) }}</textarea>
                    <div class="form-text">Pemberitahuan sukses yang ramah dan menenangkan bagi pengirim aspirasi.</div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Kotak Masuk
                    </a>
                    <button type="submit" class="btn btn-him-primary px-4">
                        <i class="fas fa-save me-1"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
