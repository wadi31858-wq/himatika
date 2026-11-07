@extends('layouts.app')
@section('title', '404 - Halaman Tidak Ditemukan')
@section('content')
<section class="section-padding" style="min-height:70vh;display:flex;align-items:center;">
    <div class="container text-center">
        <h1 class="display-1 fw-bold text-primary">404</h1>
        <h3 class="mb-3">Halaman Tidak Ditemukan</h3>
        <p class="text-muted mb-4">Halaman yang Anda cari tidak tersedia atau telah dipindahkan.</p>
        <a href="{{ route('home') }}" class="btn btn-primary-custom"><i class="fas fa-home me-2"></i>Kembali ke Beranda</a>
    </div>
</section>
@endsection
