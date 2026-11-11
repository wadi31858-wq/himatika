@extends('layouts.app')
@section('title', 'Visi dan Misi - HIMATIKA UNUJA')

@section('content')

{{-- ==================== BANNER VISI & MISI ==================== --}}
<section class="vm-banner">
    <div class="container position-relative">
        <div class="vm-banner-content">
            <h1 class="vm-banner-title">Visi dan Misi</h1>
            <p class="vm-banner-subtitle">Arah pengembangan HIMATIKA FMIPA UNUJA.</p>
        </div>
    </div>
</section>

{{-- ==================== KONTEN DUA CARD ==================== --}}
<section class="vm-content-section py-5">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            
            {{-- CARD KIRI: VISI (BIDANG BIRU TUA TEKS PUTIH) --}}
            <div class="col-lg-5 col-md-6 col-12 d-flex">
                <div class="card-visi-navy w-100 p-4 p-md-5 rounded-4 d-flex flex-column justify-content-between text-white">
                    <div>
                        <div class="visi-quote-icon mb-3">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        
                        <h3 class="visi-title mb-3">Visi HIMATIKA</h3>
                        
                        <p class="visi-text">
                            “{{ $vm->vision ?? 'Menjadi organisasi mahasiswa Matematika yang aktif, inovatif, kolaboratif, dan unggul dalam pengembangan ilmu matematika serta sumber daya mahasiswa.' }}”
                        </p>
                    </div>

                    <div class="visi-footer-badge pt-3 mt-4 border-top border-white border-opacity-25">
                        <small class="text-white-50"><i class="fas fa-compass me-1"></i> Pedoman Strategis Organisasi</small>
                    </div>
                </div>
            </div>

            {{-- CARD KANAN: MISI (CARD PUTIH LEBIH LEBAR DENGAN ANGKA BIRU) --}}
            <div class="col-lg-7 col-md-6 col-12 d-flex">
                <div class="card-misi-white w-100 p-4 p-md-5 rounded-4 bg-white border shadow-sm d-flex flex-column justify-content-between">
                    <div>
                        <div class="misi-header mb-4">
                            <span class="misi-gold-subtitle">Misi HIMATIKA</span>
                        </div>

                        <div class="misi-list d-flex flex-column gap-3">
                            @foreach($mission as $index => $m)
                                <div class="misi-item d-flex align-items-start gap-3">
                                    <div class="misi-num-badge">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="misi-text-content flex-grow-1">
                                        {{ $m }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="misi-footer-note pt-3 mt-4 border-top border-light-subtle text-end">
                        <small class="text-muted"><i class="fas fa-check-circle text-primary me-1"></i> Komitmen Implementasi Kepengurusan</small>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* BANNER VISI & MISI */
    .vm-banner {
        background: linear-gradient(105deg, #0D47A1 0%, #1565C0 55%, #1976D2 100%);
        padding: 70px 0 50px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid #BFDBFE;
    }
    .vm-banner-title {
        color: #ffffff;
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }
    .vm-banner-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.05rem;
        margin-bottom: 0;
        font-weight: 400;
    }

    /* CARD VISI BIRU TUA */
    .card-visi-navy {
        background: linear-gradient(145deg, #0D47A1 0%, #1565C0 100%);
        border: 1px solid #1E40AF;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(13, 71, 161, 0.2);
    }
    .visi-quote-icon {
        font-size: 2.5rem;
        color: #93C5FD;
        opacity: 0.9;
        line-height: 1;
    }
    .visi-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #FFFFFF;
        letter-spacing: -0.3px;
    }
    .visi-text {
        font-size: 1.05rem;
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.95);
        font-style: italic;
    }

    /* CARD MISI PUTIH */
    .card-misi-white {
        border: 1px solid #BFDBFE !important;
        border-radius: 16px;
    }
    .misi-gold-subtitle {
        font-size: 1rem;
        font-weight: 700;
        color: #B45309;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .misi-item {
        padding: 6px 0;
    }
    .misi-num-badge {
        width: 30px;
        height: 30px;
        min-width: 30px;
        background: #1565C0;
        color: #FFFFFF;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
        margin-top: 2px;
        box-shadow: 0 2px 6px rgba(21, 101, 192, 0.25);
    }
    .misi-text-content {
        font-size: 0.96rem;
        line-height: 1.7;
        color: #334155;
    }

    @media (max-width: 767.98px) {
        .vm-banner {
            padding: 50px 0 35px;
        }
        .vm-banner-title {
            font-size: 1.8rem;
        }
        .card-visi-navy, .card-misi-white {
            padding: 24px 20px !important;
        }
        .visi-title {
            font-size: 1.35rem;
        }
    }
</style>
@endpush
