@extends('layouts.app')
@section('title', 'Sambutan Kaprodi - HIMATIKA FMIPA UNUJA')

@section('content')

@php
    $kaprodiName = !empty($siteSettings['sambutan_name']) ? $siteSettings['sambutan_name'] : ($kaprodi->name ?? 'MUDAKKIR, S.Pd., MM.');
    $kaprodiRole = !empty($siteSettings['sambutan_title']) ? $siteSettings['sambutan_title'] : ($kaprodi->position ?? 'Ketua Program Studi Matematika');
    $badgeText   = !empty($siteSettings['sambutan_badge']) ? $siteSettings['sambutan_badge'] : 'PESAN PIMPINAN';
    $rawTitle    = !empty($siteSettings['sambutan_banner_title']) ? $siteSettings['sambutan_banner_title'] : 'Sambutan Kaprodi';

    if (stripos($rawTitle, 'Sambutan') === 0) {
        $titlePrefix = 'Sambutan';
        $titleAccent = trim(substr($rawTitle, 8));
        if (empty($titleAccent)) {
            $titleAccent = 'Kaprodi';
        }
    } else {
        $titlePrefix = $rawTitle;
        $titleAccent = '';
    }

    $kaprodiPhoto = null;
    if (!empty($siteSettings['sambutan_photo']) && file_exists(public_path('storage/' . $siteSettings['sambutan_photo']))) {
        $kaprodiPhoto = asset('storage/' . $siteSettings['sambutan_photo']);
    } elseif ($kaprodi && $kaprodi->photo && file_exists(public_path('storage/' . $kaprodi->photo))) {
        $kaprodiPhoto = asset('storage/' . $kaprodi->photo);
    } else {
        $kaprodiPhoto = asset('storage/profile/sambutan_1794400568_4jRmDkAS3by8fJdumt7yXqA03XvRNJdCIiK1z8KM.png');
    }
@endphp

<section class="sambutan-ref-section">
    <div class="container">
        @if(($siteSettings['sambutan_is_visible'] ?? '1') === '0')
            <div class="text-center py-5">
                <div class="p-5 bg-white rounded-4 border shadow-sm mx-auto" style="max-width: 620px;">
                    <div class="mb-3 text-muted">
                        <i class="fas fa-eye-slash fa-3x" style="color: var(--burgundy-accent);"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: var(--burgundy-darkest);">Halaman Sambutan Sedang Dinonaktifkan</h3>
                    <p class="text-muted mb-4">Informasi Sambutan Kaprodi saat ini sedang diperbarui oleh administrator organisasi.</p>
                    <a href="{{ route('home') }}" class="btn px-4 py-2 text-white rounded-pill" style="background: var(--burgundy-main);">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        @else
        <div class="sambutan-ref-card mx-auto" style="max-width: 1060px;">
            {{-- Header: — PESAN PIMPINAN & Sambutan Kaprodi --}}
            <div class="sambutan-ref-header">
                <div class="sambutan-ref-badge-wrap">
                    <span class="sambutan-ref-bar"></span>
                    <span class="sambutan-ref-badge-text">{{ $badgeText }}</span>
                </div>
                <h1 class="sambutan-ref-title">
                    {{ $titlePrefix }}@if($titleAccent)<span class="sambutan-title-accent">{{ $titleAccent }}</span>@endif
                </h1>
            </div>

            {{-- 2 Columns: Photo Left, Italic Message Right --}}
            <div class="row g-4 g-lg-5 align-items-center">
                {{-- Left: Portrait Frame with rounded corners & green border --}}
                <div class="col-lg-4 col-md-5 col-12 text-center">
                    <div class="sambutan-ref-photo-frame mx-auto">
                        <img src="{{ $kaprodiPhoto }}" alt="{{ $kaprodiName }}" class="sambutan-ref-photo-img">
                    </div>
                </div>

                {{-- Right: Italic Message + Divider + Signature --}}
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="sambutan-ref-body">
                        @if(!empty($siteSettings['sambutan_content']))
                            @foreach(explode("\n", str_replace("\r", "", $siteSettings['sambutan_content'])) as $paragraph)
                                @if(trim($paragraph) !== '')
                                    <p class="sambutan-ref-p">
                                        {{ trim($paragraph) }}
                                    </p>
                                @endif
                            @endforeach
                        @else
                            <p class="sambutan-ref-p">
                                Assalamualaikum warahmatullahi wabarakatuh. Puji syukur ke hadirat Allah SWT atas segala limpahan rahmat dan karunia-Nya sehingga website resmi HIMATIKA FMIPA Universitas Nurul Jadid dapat hadir sebagai media informasi dan komunikasi bagi seluruh mahasiswa, civitas akademika, alumni, serta masyarakat luas.
                            </p>
                            <p class="sambutan-ref-p">
                                Website ini kami hadirkan sebagai upaya strategis untuk memperkuat transparansi, meningkatkan kualitas pelayanan informasi kemahasiswaan, serta mempererat tali silaturahmi antara program studi, dosen, mahasiswa, dan masyarakat luas.
                            </p>
                            <p class="sambutan-ref-p mb-0">
                                Semoga wadah ini dapat menjadi pendorong kemajuan intelektual, moral, dan prestasi keilmuan matematika bagi seluruh keluarga besar HIMATIKA FMIPA UNUJA.
                            </p>
                        @endif

                        {{-- Horizontal Divider --}}
                        <div class="sambutan-ref-divider"></div>

                        {{-- Signature Block --}}
                        <div class="sambutan-ref-sig-name">
                            {{ $kaprodiName }}
                        </div>
                        <div class="sambutan-ref-sig-role">
                            {{ $kaprodiRole }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

@endsection
