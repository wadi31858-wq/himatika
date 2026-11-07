@extends('layouts.app')
@section('title', $galeri->title)
@section('content')
<div class="page-breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}" class="breadcrumb-back">&larr; Kembali ke Beranda</a>
        <div class="breadcrumb-path">
            <a href="{{ route('home') }}">Beranda</a>
            <span>/</span>
            <a href="{{ route('galeri') }}">Galeri</a>
            <span>/</span>
            {{ Str::limit($galeri->title, 30) }}
        </div>
    </div>
</div>
<section class="section-padding" style="background: var(--off-white);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <span style="font-size: 0.72rem; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--primary-green); display: inline-block; margin-bottom: 0.75rem;">GALERI</span>
                <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--dark-text); margin-bottom: 0.5rem; line-height: 1.3;">{{ $galeri->title }}</h1>
                @if($galeri->activity)
                <p style="font-size: 0.85rem; color: #999; margin-bottom: 2rem;">{{ $galeri->activity->title }}</p>
                @endif
                @if($galeri->description)
                <p style="font-size: 0.95rem; color: #666; line-height: 1.7; margin-bottom: 2rem;">{{ $galeri->description }}</p>
                @endif
                @if($galeri->image)
                <div style="border-radius: 14px; overflow: hidden; margin-bottom: 2rem;">
                    <img src="{{ asset('storage/'.$galeri->image) }}" alt="{{ $galeri->title }}" style="width:100%; height:auto; display:block;">
                </div>
                @endif
                <div style="margin-top: 2rem;">
                    <a href="{{ route('galeri') }}" style="color: var(--primary-green); font-weight: 600; text-decoration: none; font-size: 0.9rem;">&larr; Kembali ke Galeri</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
