@extends('layouts.app')
@section('title', 'Cek Status Aspirasi')
@section('content')
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('aspirasi.index') }}">Aspirasi</a></li>
                <li class="breadcrumb-item active">Cek Status</li>
            </ol>
        </nav>
    </div>
</div>

<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-4">
                    <h2 class="section-title">Cek Status Aspirasi</h2>
                    <p class="section-subtitle">Masukkan NIM Anda untuk melihat status aspirasi</p>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('aspirasi.cek') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="nim" class="form-control" placeholder="Masukkan NIM Anda" value="{{ request('nim') }}" required>
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search me-1"></i>Cek</button>
                            </div>
                        </form>
                    </div>
                </div>

                @if(request('nim'))
                <div class="mt-4">
                    @forelse($aspirations as $a)
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $a->title }}</h6>
                                    <small class="text-muted">{{ $a->created_at->format('d M Y H:i') }} &middot; {{ $a->category }}</small>
                                </div>
                                <span class="badge bg-{{ $a->status === 'Selesai' ? 'success' : ($a->status === 'Diproses' ? 'primary' : ($a->status === 'Dibaca' ? 'info' : 'warning')) }}">
                                    {{ $a->status }}
                                </span>
                            </div>
                            <p class="mt-2 mb-0">{{ Str::limit($a->message, 150) }}</p>
                            @if($a->admin_reply)
                            <div class="mt-2 p-3 bg-light rounded">
                                <strong class="text-primary"><i class="fas fa-reply me-1"></i>Balasan HIMATIKA UNUJA:</strong>
                                <p class="mb-0 mt-1">{{ $a->admin_reply }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Tidak ada aspirasi ditemukan untuk NIM ini.</p>
                    </div>
                    @endforelse
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
