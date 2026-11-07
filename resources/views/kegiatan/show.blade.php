@extends('layouts.app')
@section('title', $activity->title)
@section('content')
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kegiatan') }}">Kegiatan</a></li>
                <li class="breadcrumb-item active">{{ $activity->title }}</li>
            </ol>
        </nav>
    </div>
</div>
<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <img src="{{ $activity->image ? asset('storage/'.$activity->image) : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800' }}" alt="{{ $activity->title }}" class="img-fluid rounded shadow mb-4">
                <span class="badge-status badge-{{ $activity->status === 'Selesai' ? 'selesai' : ($activity->status === 'Sedang Berjalan' ? 'berjalan' : 'datang') }}">{{ $activity->status }}</span>
                <h2 class="mt-3">{{ $activity->title }}</h2>
                <p class="text-muted mb-4">
                    <i class="fas fa-calendar me-1"></i>{{ $activity->date?->format('d M Y') }}
                    &middot; <i class="fas fa-map-marker-alt me-1"></i>{{ $activity->location }}
                    &middot; <i class="fas fa-users me-1"></i>{{ $activity->organizer }}
                </p>
                <div class="content-area">{!! $activity->description !!}</div>
                @if($galleries->count())
                <h4 class="mt-5 mb-3">Dokumentasi</h4>
                <div class="row g-3">
                    @foreach($galleries as $g)
                    <div class="col-md-4">
                        <a href="{{ asset('storage/'.$g->image) }}" target="_blank">
                            <img src="{{ asset('storage/'.$g->image) }}" alt="{{ $g->title }}" class="img-fluid rounded shadow-sm">
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
