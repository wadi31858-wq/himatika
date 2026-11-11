@extends('layouts.app')
@section('title', 'Sambutan Kaprodi - HIMATIKA UNUJA')

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
                                Semoga wadah ini dapat menjadi pendorong kemajuan intelektual, moral, dan prestasi keilmuan matematika bagi seluruh keluarga besar HIMATIKA.
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
    </div>
</section>

@endsection
