@extends('layouts.app')
@section('title', 'Visi dan Misi - HIMATIKA FMIPA UNUJA')

@section('content')

{{-- ==================== BANNER VISI & MISI ==================== --}}
<section class="vm-banner" id="visi-misi-section">
    <div class="container position-relative">
        <div class="vm-banner-content">
            <h1 class="vm-banner-title">Visi dan Misi</h1>
            <p class="vm-banner-subtitle">Arah dan tujuan pengembangan HIMATIKA FMIPA UNUJA.</p>
        </div>
    </div>
</section>

{{-- ==================== KONTEN DUA CARD ==================== --}}
<section class="vm-content-section py-5">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            
            {{-- CARD KIRI: VISI --}}
            <div class="col-lg-5 col-md-6 col-12 d-flex">
                <div class="card-visi-navy w-100 p-4 p-md-5 rounded-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="visi-quote-icon mb-3">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        
                        <h3 class="visi-title mb-3">Visi HIMATIKA FMIPA UNUJA</h3>
                        
                        <p class="visi-text">
                            “{{ $vm->vision ?? 'Menjadi organisasi mahasiswa Matematika yang aktif, inovatif, kolaboratif, dan unggul dalam pengembangan ilmu matematika serta sumber daya mahasiswa.' }}”
                        </p>
                    </div>

                    <div class="visi-footer-badge pt-3 mt-4 border-top border-white border-opacity-25">
                        <small class="text-white-50"><i class="fas fa-compass me-1"></i> Pedoman Strategis Organisasi</small>
                    </div>
                </div>
            </div>

            {{-- CARD KANAN: MISI --}}
            <div class="col-lg-7 col-md-6 col-12 d-flex">
                <div class="card-misi-white w-100 p-4 p-md-5 rounded-4 bg-white border shadow-sm d-flex flex-column justify-content-between">
                    <div>
                        <div class="misi-header mb-4">
                            <span class="misi-gold-subtitle">Misi HIMATIKA FMIPA UNUJA</span>
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
        background: linear-gradient(135deg, #250D17 0%, #641D38 100%);
        padding: 135px 0 55px;
        margin-top: 0;
        border-top: none;
        border-bottom: 1px solid rgba(138, 49, 81, 0.35);
        position: relative;
        overflow: visible;
        height: auto;
        min-height: auto;
        scroll-margin-top: 85px;
    }
    .vm-banner-content {
        position: relative;
        z-index: 2;
    }
    .vm-banner-title {
        color: #FFF7FA;
        font-size: 2.6rem;
        font-weight: 800;
        margin-bottom: 10px;
        line-height: 1.25;
        letter-spacing: -0.5px;
    }
    .vm-banner-subtitle {
        color: #FFF7FA;
        font-size: 1.05rem;
        margin-bottom: 0;
        font-weight: 400;
        line-height: 1.6;
        opacity: 0.95;
    }

    /* SECTION KONTEN */
    .vm-content-section {
        background-color: #F6E9EE;
        min-height: auto;
    }

    /* CARD VISI */
    .card-visi-navy {
        background: linear-gradient(145deg, #250D17 0%, #641D38 100%);
        border: 1px solid #8A3151;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(37, 13, 23, 0.25);
        color: #FFF7FA;
    }
    .visi-quote-icon {
        font-size: 2.5rem;
        color: #8A3151;
        opacity: 0.9;
        line-height: 1;
    }
    .visi-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #FFF7FA;
        letter-spacing: -0.3px;
    }
    .visi-text {
        font-size: 1.05rem;
        line-height: 1.8;
        color: #FFF7FA;
        font-style: italic;
    }

    /* CARD MISI */
    .card-misi-white {
        background: #FFFFFF !important;
        border: 1px solid #E2CBD3 !important;
        border-radius: 16px;
    }
    .misi-gold-subtitle {
        font-size: 1rem;
        font-weight: 700;
        color: #641D38;
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
        background: #8A3151;
        color: #FFF7FA;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
        margin-top: 2px;
        box-shadow: 0 2px 6px rgba(138, 49, 81, 0.25);
    }
    .misi-text-content {
        font-size: 0.96rem;
        line-height: 1.7;
        color: #32121F;
    }

    @media (max-width: 767.98px) {
        .vm-banner {
            padding: 110px 0 45px;
        }
        .vm-banner-title {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .vm-banner-subtitle {
            font-size: 0.95rem;
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
