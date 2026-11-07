@extends('layouts.app')
@section('title', $news->title)
@section('content')
<div class="page-breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}" class="breadcrumb-back">&larr; Kembali ke Beranda</a>
        <div class="breadcrumb-path">
            <a href="{{ route('home') }}">Beranda</a>
            <span>/</span>
            <a href="{{ route('berita') }}">Berita</a>
            <span>/</span>
            {{ Str::limit($news->title, 30) }}
        </div>
    </div>
</div>
<section class="section-padding" style="background: var(--off-white);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="berita-badges mb-3">
                    <span class="badge-category">{{ $news->category }}</span>
                    <span class="badge-date-berita">{{ $news->published_at?->format('d M Y') }}</span>
                </div>
                <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--dark-text); margin-bottom: 1rem; line-height: 1.3;">{{ $news->title }}</h1>
                <p style="font-size: 0.85rem; color: #999; margin-bottom: 2rem;">
                    <i class="fas fa-user me-1"></i>{{ $news->author }}
                </p>
                @if($news->thumbnail)
                <div style="border-radius: 14px; overflow: hidden; margin-bottom: 2rem;">
                    <img src="{{ asset('storage/'.$news->thumbnail) }}" alt="{{ $news->title }}" style="width:100%; height:auto; display:block;">
                </div>
                @endif
                <div class="content-area" style="font-size: 0.95rem; line-height: 1.8; color: var(--dark-text);">
                    {!! $news->content !!}
                </div>
                @if($relatedNews->count())
                <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid rgba(0,0,0,0.08);">
                    <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.25rem;">Berita Terkait</h4>
                    <div class="row g-3">
                        @foreach($relatedNews as $rn)
                        <div class="col-md-4">
                            <a href="{{ route('berita.show', $rn->slug) }}" style="text-decoration:none;">
                                <div style="background: var(--white); border: 1px solid rgba(0,0,0,0.06); border-radius: 12px; padding: 1.25rem; transition: var(--transition); height: 100%;">
                                    <span class="badge-category" style="margin-bottom: 0.5rem; display: inline-block;">{{ $rn->category }}</span>
                                    <h6 style="font-weight: 700; color: var(--dark-text); margin-bottom: 0.35rem;">{{ $rn->title }}</h6>
                                    <small style="color: #999;">{{ $rn->published_at?->format('d M Y') }}</small>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                <div style="margin-top: 2rem;">
                    <a href="{{ route('berita') }}" style="color: var(--primary-green); font-weight: 600; text-decoration: none; font-size: 0.9rem;">&larr; Kembali ke Berita</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
