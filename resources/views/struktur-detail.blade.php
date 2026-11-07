@extends('layouts.app')

@section('title', 'Detail Jabatan - HIMATIKA UNUJA 2026')

@section('content')
<div class="struktur-detail-wrapper" style="background-color: #f6f5ec; padding: 40px 0; min-height: 100vh;">
    <div class="container">
        {{-- BREADCRUMB --}}
        <div class="detail-breadcrumb d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('struktur-organisasi') }}" class="text-decoration-none" style="color: #114232; font-weight: 500; font-size: 15px;">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Struktur
            </a>
            <div class="breadcrumb-links" style="font-size: 14px; color: #666;">
                <a href="{{ route('home') }}" class="text-decoration-none text-muted">Beranda</a> / 
                <a href="{{ route('struktur-organisasi') }}" class="text-decoration-none text-muted">Struktur</a> / 
                <span style="color: #114232; font-weight: 500;">{{ $jabatan->position }}</span>
            </div>
        </div>

        {{-- HERO SECTION --}}
        <div class="detail-hero" style="background-color: #114232; border-radius: 24px; padding: 48px; color: white; display: flex; gap: 40px; position: relative; overflow: hidden; margin-bottom: 64px;">
            {{-- Background decorative element --}}
            <div style="position: absolute; top: -100px; left: -100px; opacity: 0.05; font-size: 400px; font-family: serif; user-select: none;">&sum;</div>
            
            <div class="hero-content" style="flex: 1; z-index: 1;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span style="color: #f4d03f; font-weight: 700; font-size: 14px; letter-spacing: 1px;">DETAIL JABATAN</span>
                    <span style="color: #f4d03f; font-size: 24px; line-height: 1;">&times;</span>
                </div>
                
                <h1 style="font-size: 56px; font-weight: 700; margin-bottom: 24px;">{{ $jabatan->position }}</h1>
                
                <p style="font-size: 18px; color: rgba(255,255,255,0.8); line-height: 1.6; max-width: 90%; margin-bottom: 40px;">
                    {{ $jabatan->description ?? 'Memimpin dan mengkoordinasikan seluruh kegiatan HIMATIKA serta bertanggung jawab atas arah organisasi.' }}
                </p>
                
                <div class="d-flex gap-4 mb-4">
                    <div style="border: 1px solid rgba(255,255,255,0.2); padding: 16px 24px; border-radius: 12px; min-width: 140px;">
                        <h2 style="color: #f4d03f; font-size: 32px; font-weight: 700; margin: 0; line-height: 1;">01</h2>
                        <span style="font-size: 12px; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 1px;">Anggota Aktif</span>
                    </div>
                    <div style="border: 1px solid rgba(255,255,255,0.2); padding: 16px 24px; border-radius: 12px; min-width: 140px;">
                        <h2 style="color: #f4d03f; font-size: 32px; font-weight: 700; margin: 0; line-height: 1;">04</h2>
                        <span style="font-size: 12px; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 1px;">Tugas Utama</span>
                    </div>
                </div>

                @if($terkait->count() > 0)
                <div class="terkait-chips" style="display: flex; flex-wrap: wrap; gap: 12px; margin-top: 32px;">
                    @foreach($terkait as $tk)
                        <a href="{{ route('struktur-organisasi.show', $tk->id) }}" style="text-decoration: none; border: 1px solid rgba(255,255,255,0.2); padding: 12px 20px; border-radius: 8px; font-size: 14px; color: white; display: inline-block; transition: all 0.3s ease; background: rgba(255,255,255,0.05);">
                            <span style="display: block; font-size: 10px; color: #f4d03f; margin-bottom: 4px; text-transform: uppercase;">Terkait</span>
                            {{ $tk->position }}
                        </a>
                    @endforeach
                </div>
                @endif
            </div>
            
            <div class="hero-image" style="width: 400px; flex-shrink: 0; position: relative; z-index: 1;">
                <div style="width: 100%; height: 100%; background-color: #d1d5db; border-radius: 20px; overflow: hidden; position: relative;">
                    @if($jabatan->photo)
                        <img src="{{ asset('storage/' . $jabatan->photo) }}" alt="{{ $jabatan->name }}" style="width: 100%; height: 100%; object-fit: cover; object-position: top;">
                    @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-secondary text-white">
                            <i class="fas fa-user" style="font-size: 80px; opacity: 0.5;"></i>
                        </div>
                    @endif
                    
                    {{-- Small watermark badge --}}
                    <div style="position: absolute; bottom: 24px; right: 24px; background: #f4d03f; color: #114232; font-size: 12px; font-weight: 700; padding: 6px 12px; border-radius: 20px;">
                        HIMATIKA 2026
                    </div>
                </div>
            </div>
        </div>

        {{-- RUANG KERJA SECTION --}}
        <div class="ruang-kerja-section" style="margin-bottom: 64px;">
            <h6 style="color: #666; font-size: 14px; letter-spacing: 1px; font-weight: 600; margin-bottom: 16px;">RUANG KERJA</h6>
            <h2 style="color: #114232; font-size: 40px; font-weight: 500; margin-bottom: 12px; letter-spacing: -1px;">Arah kerja dalam satu pandangan.</h2>
            <p style="color: #666; font-size: 16px; margin-bottom: 40px;">Tugas, program, dan rincian teknis disusun agar peran jabatan ini mudah dipahami.</p>
            
            <div class="row g-4">
                {{-- Tugas Utama --}}
                <div class="col-md-4">
                    <div style="background: white; border: 1px solid rgba(17,66,50,0.1); border-radius: 16px; padding: 32px; height: 100%; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: 20px; right: 20px; font-size: 60px; color: rgba(17,66,50,0.05); font-family: serif;">&sum;</div>
                        <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-3">
                            <div style="width: 40px; height: 40px; background: #114232; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div>
                                <span style="display: block; font-size: 10px; color: #666; text-transform: uppercase; letter-spacing: 1px;">KATEGORI 01</span>
                                <h4 style="margin: 0; font-size: 20px; color: #114232; font-weight: 600;">Tugas Utama</h4>
                            </div>
                        </div>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="margin-bottom: 16px; display: flex; gap: 12px; color: #444; font-size: 15px; line-height: 1.5;">
                                <i class="fas fa-check-circle" style="color: #8fa89b; margin-top: 4px;"></i> Memimpin dan mengoordinasikan seluruh jajaran HIMATIKA
                            </li>
                            <li style="margin-bottom: 16px; display: flex; gap: 12px; color: #444; font-size: 15px; line-height: 1.5;">
                                <i class="fas fa-check-circle" style="color: #8fa89b; margin-top: 4px;"></i> Memantau kepengurusan bersama formatur
                            </li>
                            <li style="margin-bottom: 16px; display: flex; gap: 12px; color: #444; font-size: 15px; line-height: 1.5;">
                                <i class="fas fa-check-circle" style="color: #8fa89b; margin-top: 4px;"></i> Mengambil kebijakan organisasi
                            </li>
                            <li style="display: flex; gap: 12px; color: #444; font-size: 15px; line-height: 1.5;">
                                <i class="fas fa-check-circle" style="color: #8fa89b; margin-top: 4px;"></i> Menyampaikan pertanggungjawaban pada musyawarah
                            </li>
                        </ul>
                    </div>
                </div>
                
                {{-- Program --}}
                <div class="col-md-4">
                    <div style="background: #fdfaf0; border: 1px solid rgba(244,208,63,0.3); border-radius: 16px; padding: 32px; height: 100%; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: 20px; right: 20px; font-size: 60px; color: rgba(17,66,50,0.05); font-family: serif;">&pi;</div>
                        <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-3" style="border-color: rgba(244,208,63,0.3) !important;">
                            <div style="width: 40px; height: 40px; background: #8e6c1e; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <div>
                                <span style="display: block; font-size: 10px; color: #8e6c1e; text-transform: uppercase; letter-spacing: 1px;">KATEGORI 02</span>
                                <h4 style="margin: 0; font-size: 20px; color: #8e6c1e; font-weight: 600;">Program</h4>
                            </div>
                        </div>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="margin-bottom: 16px; display: flex; gap: 12px; color: #554112; font-size: 15px; line-height: 1.5;">
                                <i class="fas fa-circle" style="color: #d6af3d; font-size: 8px; margin-top: 8px;"></i> Koordinasi Kepengurusan
                            </li>
                            <li style="display: flex; gap: 12px; color: #554112; font-size: 15px; line-height: 1.5;">
                                <i class="fas fa-circle" style="color: #d6af3d; font-size: 8px; margin-top: 8px;"></i> Monitoring Program Kerja
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Tugas Teknik --}}
                <div class="col-md-4">
                    <div style="background: white; border: 1px solid rgba(17,66,50,0.1); border-radius: 16px; padding: 32px; height: 100%; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: 20px; right: 20px; font-size: 60px; color: rgba(17,66,50,0.05); font-family: serif;">&int;</div>
                        <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-3">
                            <div style="width: 40px; height: 40px; background: #4a6c62; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div>
                                <span style="display: block; font-size: 10px; color: #666; text-transform: uppercase; letter-spacing: 1px;">KATEGORI 03</span>
                                <h4 style="margin: 0; font-size: 20px; color: #114232; font-weight: 600;">Tugas Teknik</h4>
                            </div>
                        </div>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="margin-bottom: 16px; display: flex; gap: 12px; color: #444; font-size: 15px; line-height: 1.5;">
                                <div style="width: 16px; height: 4px; background: #8fa89b; margin-top: 8px; flex-shrink: 0;"></div>
                                Pengambilan keputusan strategis
                            </li>
                            <li style="margin-bottom: 16px; display: flex; gap: 12px; color: #444; font-size: 15px; line-height: 1.5;">
                                <div style="width: 16px; height: 4px; background: #8fa89b; margin-top: 8px; flex-shrink: 0;"></div>
                                Representasi resmi HIMATIKA
                            </li>
                            <li style="display: flex; gap: 12px; color: #444; font-size: 15px; line-height: 1.5;">
                                <div style="width: 16px; height: 4px; background: #8fa89b; margin-top: 8px; flex-shrink: 0;"></div>
                                Evaluasi kinerja organisasi
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- ANGGOTA SECTION --}}
        <div class="anggota-section" style="background: white; border: 1px solid rgba(17,66,50,0.1); border-radius: 24px; padding: 48px;">
            <div class="d-flex justify-content-between align-items-start mb-5">
                <div>
                    <h6 style="color: #666; font-size: 14px; letter-spacing: 1px; font-weight: 600; margin-bottom: 8px;">ANGGOTA</h6>
                    <h3 style="color: #114232; font-size: 32px; font-weight: 500; margin-bottom: 8px; letter-spacing: -0.5px;">Anggota dalam jabatan ini</h3>
                    <p style="color: #666; margin: 0;">Orang-orang yang bergerak bersama di balik peran ini.</p>
                </div>
                <div style="color: #666; font-size: 14px;">1 anggota aktif</div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="anggota-card" style="border-radius: 16px; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); transition: transform 0.3s ease;">
                        <div style="height: 380px; background: #d1d5db; position: relative;">
                            @if($jabatan->photo)
                                <img src="{{ asset('storage/' . $jabatan->photo) }}" alt="{{ $jabatan->name }}" style="width: 100%; height: 100%; object-fit: cover; object-position: top;">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white" style="background-color: #6c757d;">
                                    <i class="fas fa-user" style="font-size: 80px; opacity: 0.5;"></i>
                                </div>
                            @endif
                            
                            {{-- Info badges overlay --}}
                            <div style="position: absolute; bottom: 16px; left: 16px; width: 32px; height: 32px; background: rgba(0,0,0,0.5); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas fa-id-badge" style="font-size: 14px;"></i>
                            </div>
                            <div style="position: absolute; bottom: 16px; right: 16px; width: 32px; height: 32px; background: #f4d03f; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #114232;">
                                <i class="fas fa-arrow-right" style="font-size: 14px;"></i>
                            </div>
                        </div>
                        <div style="padding: 24px; background: white;">
                            <h4 style="color: #114232; font-size: 20px; font-weight: 600; margin-bottom: 8px;">{{ $jabatan->name ?? 'Belum ada nama' }}</h4>
                            <span style="color: #8e6c1e; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; font-weight: 500;">{{ $jabatan->position }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .terkait-chips a:hover {
        background: rgba(255,255,255,0.15) !important;
        transform: translateY(-2px);
    }
    .anggota-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }
    @media (max-width: 991px) {
        .detail-hero {
            flex-direction: column;
            padding: 32px;
        }
        .hero-image {
            width: 100% !important;
            height: 400px;
        }
    }
</style>
@endsection
