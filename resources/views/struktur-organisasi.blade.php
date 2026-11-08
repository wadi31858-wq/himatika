@extends('layouts.app')
@section('title', 'Struktur Organisasi')
@section('content')

<style>
    .breadcrumb-section {
        background: #EFF6FF;
        padding: 96px 0 10px;
    }
    .breadcrumb-section .breadcrumb {
        margin-bottom: 0;
        background: transparent;
        padding: 0;
    }
    .breadcrumb-section .breadcrumb-item a {
        color: var(--dark-green);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        transition: var(--transition);
    }
    .breadcrumb-section .breadcrumb-item a:hover {
        color: var(--gold);
    }
    .breadcrumb-section .breadcrumb-item.active {
        color: rgba(21, 101, 192, 0.7);
        font-size: 0.85rem;
    }
    .breadcrumb-section .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(21, 101, 192, 0.45);
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--dark-green);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        transition: var(--transition);
    }
    .back-link:hover {
        color: var(--gold);
    }

    .breadcrumb-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .hero-section {
        background: #EFF6FF;
        padding: 20px 0 30px;
        position: relative;
        overflow: hidden;
        min-height: auto;
    }
    .hero-section::before {
        content: '';
        position: absolute;
        top: -80px; right: -80px;
        width: 280px; height: 280px;
        background: radial-gradient(circle, rgba(21, 101, 192, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }
    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -60px; left: -60px;
        width: 220px; height: 220px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }
    .hero-label {
        display: inline-block;
        background: var(--primary-green);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 2px;
        padding: 6px 18px;
        border-radius: 50px;
        margin-bottom: 8px;
    }
    .hero-heading {
        font-size: 2rem;
        font-weight: 800;
        color: var(--dark-text);
        line-height: 1.2;
        margin-bottom: 8px;
    }
    .hero-desc {
        font-size: 0.95rem;
        color: rgba(15, 23, 42, 0.6);
        max-width: 560px;
        line-height: 1.5;
        margin-bottom: 0;
    }

    .org-section {
        background: #EFF6FF;
        padding: 0 0 60px;
        position: relative;
    }

    .org-chart {
        position: relative;
        max-width: 1100px;
        margin: 0 auto;
    }

    /* Elegant Tree Connectors */
    .tree-connector {
        width: 2px;
        margin: 0 auto;
        background-color: var(--deep-teal);
        position: relative;
    }
    .tree-connector.dashed {
        background-color: transparent;
        border-left: 2px dashed #3B82F6;
    }
    .tree-connector.h-20 { height: 20px; }
    .tree-connector.h-24 { height: 24px; }
    .tree-connector.h-32 { height: 32px; }
    
    .tree-branch-container {
        position: relative;
        margin-top: 16px;
    }
    .tree-horizontal-line {
        position: absolute;
        top: 0;
        left: 25%;
        width: 50%;
        height: 2px;
        background-color: var(--deep-teal);
    }
    
    @media (max-width: 767.98px) {
        .tree-horizontal-line { display: none; }
        .tree-branch-container { margin-top: 0; }
        .mobile-hide-line { display: none !important; }
    }

    /* Level labels */
    .level-label {
        text-align: center;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: rgba(15, 23, 42, 0.45);
        margin-bottom: 8px;
    }
    .level-label.gold { color: var(--gold); }

    .branch-label {
        text-align: center;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--deep-teal);
        background: rgba(21, 101, 192, 0.07);
        display: inline-block;
        padding: 5px 16px;
        border-radius: 50px;
        margin-bottom: 16px;
    }

    /* Cards */
    .org-card {
        background: #FFFFFF;
        border: 1px solid rgba(0,0,0,.04);
        border-radius: 12px;
        padding: 20px 22px;
        box-shadow: 0 4px 14px rgba(0,0,0,.03);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }
    .org-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,.06);
        transform: translateY(-2px);
    }
    .org-card.gold-border {
        border: 1.5px solid rgba(59, 130, 246, 0.3);
    }
    .org-card.gold-border::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: var(--gold);
    }
    .org-card.teal-border {
        border: 1.5px solid rgba(21, 101, 192, 0.2);
    }
    .org-card.teal-border::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #1565C0, #0D47A1);
    }

    .card-body-inner {
        display: flex;
        gap: 18px;
        align-items: flex-start;
    }

    .photo-placeholder {
        width: 60px; height: 60px;
        min-width: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: #fff;
        flex-shrink: 0;
    }
    .photo-placeholder.gold {
        background: linear-gradient(135deg, #3B82F6, #60A5FA);
    }
    .photo-placeholder.teal {
        background: linear-gradient(135deg, #1565C0, #0D47A1);
    }

    .card-title-text {
        font-size: 1rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 4px;
    }
    .card-desc {
        font-size: 0.82rem;
        color: rgba(15, 23, 42, 0.55);
        line-height: 1.6;
        margin-bottom: 0;
    }

    .card-footer-inner {
        border-top: 1px solid rgba(0,0,0,.05);
        margin-top: 16px;
        padding-top: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-footer-left {
        font-size: 0.8rem;
        color: rgba(15, 23, 42, 0.5);
        font-weight: 500;
    }
    .card-footer-link {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--deep-teal);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: var(--transition);
    }
    .card-footer-link:hover {
        color: var(--primary-green);
    }
    .card-footer-link.gold-link {
        color: var(--gold);
    }
    .card-footer-link.gold-link:hover {
        color: #1565C0;
    }

    .org-card-center {
        max-width: 480px;
        margin: 0 auto;
    }

    .biro-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .biro-card {
        background: #fff;
        border: 1px solid rgba(0,0,0,.05);
        border-radius: 12px;
        padding: 18px 20px;
        box-shadow: 0 1px 8px rgba(0,0,0,.04);
        transition: var(--transition);
    }
    .biro-card:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,.08);
        transform: translateY(-1px);
    }
    .biro-card-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 4px;
    }
    .biro-card-desc {
        font-size: 0.78rem;
        color: rgba(15, 23, 42, 0.5);
        line-height: 1.55;
        margin-bottom: 10px;
    }
    .biro-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid rgba(0,0,0,.04);
        padding-top: 8px;
    }
    .biro-card-footer .card-footer-left {
        font-size: 0.75rem;
    }

    @media (max-width: 767.98px) {
        .hero-heading { font-size: 1.7rem; }
        .hero-section { padding: 40px 0 32px; }
        .org-section { padding: 32px 0 48px; }
        .biro-grid { grid-template-columns: 1fr; }
        .org-card-center { max-width: 100%; }
        .branch-split::before, .branch-split::after { display: none; }
        .breadcrumb-row { flex-direction: column; align-items: flex-start; }
    }
    @media (max-width: 575.98px) {
        .org-card { padding: 16px 18px; }
        .card-body-inner { gap: 14px; }
        .photo-placeholder { width: 50px; height: 50px; min-width: 50px; font-size: 1.1rem; }
    }
</style>

<script>
// Serialize members from PHP
const allMembers = @json($members ?? []);
let currentModalMembers = [];
let currentSlideIndex = 0;
let currentStructId = 1;

function updateModalView() {
    if(currentModalMembers.length === 0) return;
    
    const member = currentModalMembers[currentSlideIndex];
    document.getElementById('modalName').textContent = member.name;
    document.getElementById('modalDivision').textContent = member.position; // Kepala Biro, etc.
    document.getElementById('modalPhoto').src = member.photo ? "{{ asset('storage') }}/" + member.photo : 'https://ui-avatars.com/api/?name='+encodeURIComponent(member.name)+'&background=1565C0&color=fff&size=120';
    
    document.getElementById('slideCounter').textContent = (currentSlideIndex + 1) + ' / ' + currentModalMembers.length;
    
    // Render dots
    const dotsContainer = document.getElementById('slideDots');
    dotsContainer.innerHTML = '';
    for(let i=0; i<currentModalMembers.length; i++) {
        let dot = document.createElement('span');
        if(i === currentSlideIndex) {
            dot.style.cssText = "width: 24px; height: 4px; background: #3B82F6; border-radius: 2px;";
        } else {
            dot.style.cssText = "width: 6px; height: 6px; background: #cbd5e1; border-radius: 50%; align-self: center; cursor: pointer;";
            dot.onclick = () => { currentSlideIndex = i; updateModalView(); };
        }
        dotsContainer.appendChild(dot);
    }
}

function slidePrev() {
    if(currentModalMembers.length <= 1) return;
    currentSlideIndex--;
    if(currentSlideIndex < 0) currentSlideIndex = currentModalMembers.length - 1;
    updateModalView();
}

function slideNext() {
    if(currentModalMembers.length <= 1) return;
    currentSlideIndex++;
    if(currentSlideIndex >= currentModalMembers.length) currentSlideIndex = 0;
    updateModalView();
}

function openDetailModal(title, desc, photo, structId) {
    document.getElementById('modalPosition').textContent = title;
    document.getElementById('modalDesc').textContent = desc;
    
    currentStructId = structId || 1;
    
    // Find members for this division/title
    currentModalMembers = allMembers.filter(m => m.division === title || m.position === title);
    
    // Fallback if no members found
    if(currentModalMembers.length === 0) {
        currentModalMembers = [{
            name: 'Belum ada data',
            position: '-',
            photo: null
        }];
    }
    
    currentSlideIndex = 0;
    updateModalView();
    
    let baseUrl = "{{ route('struktur-organisasi.show', ':id') }}";
    document.getElementById('modalDetailLink').href = baseUrl.replace(':id', currentStructId);

    document.getElementById('detailModal').classList.add('show');
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.remove('show');
}
</script>

{{-- ==================== BREADCRUMB ==================== --}}
<section class="breadcrumb-section">
    <div class="container">
        <div class="breadcrumb-row">
            <a href="{{ route('home') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">Struktur HIMATIKA UNUJA 2026</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- ==================== HERO ==================== --}}
<section class="hero-section">
    <div class="container" style="position:relative;z-index:1;" data-aos="zoom-in">
        <span class="hero-label">STRUKTUR ORGANISASI</span>
        <h1 class="hero-heading">Struktur HIMATIKA<br>UNUJA 2026</h1>
        <p class="hero-desc">Kenali pengurus dan peran setiap unit yang menggerakkan HIMATIKA UNUJA periode 2026.</p>
    </div>
</section>

{{-- ==================== ORG CHART ==================== --}}
<section class="org-section">
    <div class="container">
        <div class="org-chart">

            {{-- LEVEL 1: KAPRODI --}}
            <div class="level-label gold">KAPRODI</div>
            <div class="org-card-center mx-auto mb-0">
                <div class="org-card gold-border">
                    <div class="card-body-inner">
                        @php
                            $kaprodi = collect($members)->first(function($m) {
                                $pos = strtolower($m->position ?? '');
                                $div = strtolower($m->division ?? '');
                                return str_contains($pos, 'kaprodi') || str_contains($pos, 'ketua program studi') || str_contains($div, 'kaprodi') || str_contains($pos, 'pembina');
                            });
                        @endphp
                        @if($kaprodi && $kaprodi->photo)
                            <img src="{{ asset('storage/' . $kaprodi->photo) }}" class="photo-placeholder gold" style="object-fit: cover; padding: 0;">
                        @else
                            <div class="photo-placeholder gold">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        @endif
                        <div>
                            <div class="card-title-text">{{ $kaprodi->name ?? 'Ketua Program Studi' }}</div>
                            @if($kaprodi && $kaprodi->name)
                                <div style="color: var(--gold); font-size: 0.78rem; font-weight: 600; margin-top: -2px; margin-bottom: 4px;">{{ $kaprodi->position ?: 'Ketua Program Studi' }}</div>
                            @endif
                            <p class="card-desc">{{ $kaprodi->description ?? 'Memberikan bimbingan, arahan, dan pembinaan dalam pelaksanaan kegiatan akademik serta pengembangan organisasi kemahasiswaan Program Studi Matematika.' }}</p>
                        </div>
                    </div>
                    <div class="card-footer-inner">
                        @if($kaprodi)
                            <a href="{{ route('struktur-organisasi.show', $kaprodi->id) }}" class="card-footer-link gold-link">Lihat profil &rarr;</a>
                        @else
                            <span class="card-footer-left">Pembina Organisasi</span>
                            <span class="card-footer-link gold-link">→</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Connector: Gold Dashed --}}
            <div class="tree-connector dashed h-24"></div>

            {{-- LEVEL 2: KETUA UMUM --}}
            <div class="level-label mb-2">KETUA UMUM</div>
            <div class="tree-connector h-20 mb-2"></div>
            <div class="org-card-center mx-auto mb-0">
                <div class="org-card teal-border">
                    <div class="card-body-inner">
                        @php
                            $ketua = collect($members)->firstWhere('id', 1);
                        @endphp
                        @if($ketua && $ketua->photo)
                            <img src="{{ asset('storage/' . $ketua->photo) }}?v={{ time() }}" class="photo-placeholder teal" style="object-fit: cover; padding: 0;">
                        @else
                            <div class="photo-placeholder teal">
                                <i class="fas fa-user-tie"></i>
                            </div>
                        @endif
                        <div>
                            <div class="card-title-text">{{ $ketua->name ?? 'Ketua Umum' }}</div>
                            <p class="card-desc">{{ $ketua->description ?? 'Memimpin dan mengoordinasikan seluruh kegiatan HIMATIKA serta bertanggung jawab atas arah organisasi.' }}</p>
                        </div>
                    </div>
                    <div class="card-footer-inner">
                        <a href="{{ route('struktur-organisasi.show', 1) }}" class="card-footer-link">Lihat profil &rarr;</a>
                    </div>
                </div>
            </div>

            {{-- Connector: Teal --}}
            <div class="tree-connector h-24"></div>

            {{-- LEVEL 3: WAKIL KETUA UMUM --}}
            <div class="level-label mb-2">WAKIL KETUA UMUM</div>
            <div class="tree-connector h-20 mb-2"></div>
            <div class="org-card-center mx-auto mb-0">
                <div class="org-card teal-border">
                    <div class="card-body-inner">
                        @php
                            $wakil = collect($members)->firstWhere('id', 2);
                        @endphp
                        @if($wakil && $wakil->photo)
                            <img src="{{ asset('storage/' . $wakil->photo) }}?v={{ time() }}" class="photo-placeholder teal" style="object-fit: cover; padding: 0;">
                        @else
                            <div class="photo-placeholder teal">
                                <i class="fas fa-user-shield"></i>
                            </div>
                        @endif
                        <div>
                            <div class="card-title-text">{{ $wakil->name ?? 'Wakil Ketua Umum' }}</div>
                            <p class="card-desc">{{ $wakil->description ?? 'Menjadi second leader yang memperkuat koordinasi dan mengawal kerja internal kepengurusan HIMATIKA.' }}</p>
                        </div>
                    </div>
                    <div class="card-footer-inner">
                        <a href="{{ route('struktur-organisasi.show', 2) }}" class="card-footer-link">Lihat profil &rarr;</a>
                    </div>
                </div>
            </div>

            {{-- Connector: Teal to branch --}}
            <div class="tree-connector h-24 mobile-hide-line"></div>

            {{-- LEVEL 4: BRANCHES --}}
            <div class="tree-branch-container row g-4 mt-0">
                <div class="tree-horizontal-line"></div>

                {{-- LEFT: ADMINISTRASI & INTERNAL --}}
                <div class="col-lg-6 col-md-6 position-relative">
                    <div class="tree-connector h-20 mb-2 mobile-hide-line"></div>
                    <div class="text-center mb-3">
                        <span class="branch-label">ADMINISTRASI & INTERNAL</span>
                    </div>
                    <div class="tree-connector h-24"></div>

                    {{-- Sekretaris Umum --}}
                    <div class="org-card teal-border mb-3">
                        <div class="card-body-inner">
                            @php
                                $sekretaris = collect($members)->firstWhere('id', 3);
                            @endphp
                            @if($sekretaris && $sekretaris->photo)
                            <img src="{{ asset('storage/' . $sekretaris->photo) }}?v={{ time() }}" class="photo-placeholder teal" style="object-fit: cover; padding: 0;">
                        @else
                                <div class="photo-placeholder teal">
                                    <i class="fas fa-file-lines"></i>
                                </div>
                            @endif
                            <div>
                                <div class="card-title-text">{{ $sekretaris->name ?? 'Sekretaris Umum' }}</div>
                                <p class="card-desc">{{ $sekretaris->description ?? 'Mengoordinasikan kesekretariatan, administrasi, dan arsip agar kerja organisasi terdokumentasi dengan tertib.' }}</p>
                            </div>
                        </div>
                        <div class="card-footer-inner">
                        <a href="{{ route('struktur-organisasi.show', 3) }}" class="card-footer-link">Lihat profil &rarr;</a>
                        </div>
                    </div>

                    <div class="tree-connector h-20"></div>

                    <div class="biro-grid">
                        <div class="biro-card">
                            @php $biroAdm = collect($members)->firstWhere('id', 5); @endphp
                            <div class="biro-card-title">{{ $biroAdm->division ?? 'Biro Administrasi Kesekretariatan' }}</div>
                            <p class="biro-card-desc">{{ $biroAdm->description ?? 'Mengelola administrasi, arsip, dan kebutuhan kesekretariatan organisasi.' }}</p>
                            <div class="biro-card-footer">
                                <span class="card-footer-left">5 anggota</span>
                                <a href="#" class="card-footer-link" style="font-size:0.78rem;" onclick="openDetailModal('{{ $biroAdm->division ?? 'Biro Administrasi Kesekretariatan' }}', 'Mengelola administrasi, arsip, dan kebutuhan kesekretariatan organisasi.', '{{ $biroAdm->photo ? asset('storage/'.$biroAdm->photo) : 'https://ui-avatars.com/api/?name=Biro+Administrasi+Kesekretariatan&background=1565C0&color=fff&size=200' }}', 5)">Lihat &rarr;</a>
                            </div>
                        </div>
                        <div class="biro-card">
                            @php $biroKons = collect($members)->firstWhere('id', 6); @endphp
                            <div class="biro-card-title">{{ $biroKons->division ?? 'Biro Konsolidasi Lembaga' }}</div>
                            <p class="biro-card-desc">{{ $biroKons->description ?? 'Memantau keaktifan dan konsolidasi kepengurusan.' }}</p>
                            <div class="biro-card-footer">
                                <span class="card-footer-left">6 anggota</span>
                                <a href="#" class="card-footer-link" style="font-size:0.78rem;" onclick="openDetailModal('{{ $biroKons->division ?? 'Biro Konsolidasi Lembaga' }}', 'Memantau keaktifan pengurus, menumbuhkan rasa memiliki, dan menjaga kekompakan internal HIMATIKA.', '{{ $biroKons->photo ? asset('storage/'.$biroKons->photo) : 'https://ui-avatars.com/api/?name=Biro+Konsolidasi+Lembaga&background=1565C0&color=fff&size=200' }}', 6)">Lihat &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: KEUANGAN & KEMANDIRIAN --}}
                <div class="col-lg-6 col-md-6 position-relative">
                    <div class="tree-connector h-20 mb-2 mobile-hide-line"></div>
                    <div class="text-center mb-3">
                        <span class="branch-label">KEUANGAN & KEMANDIRIAN</span>
                    </div>
                    <div class="tree-connector h-24"></div>

                    {{-- Bendahara Umum --}}
                    <div class="org-card teal-border mb-3">
                        <div class="card-body-inner">
                            @php
                                $bendahara = collect($members)->firstWhere('id', 4);
                            @endphp
                            @if($bendahara && $bendahara->photo)
                            <img src="{{ asset('storage/' . $bendahara->photo) }}?v={{ time() }}" class="photo-placeholder teal" style="object-fit: cover; padding: 0;">
                        @else
                                <div class="photo-placeholder teal">
                                    <i class="fas fa-coins"></i>
                                </div>
                            @endif
                            <div>
                                <div class="card-title-text">{{ $bendahara->name ?? 'Bendahara Umum' }}</div>
                                <p class="card-desc">{{ $bendahara->description ?? 'Mengoordinasikan kebendaharaan dan mengelola keuangan HIMATIKA secara efektif, efisien, dan bertanggung jawab.' }}</p>
                            </div>
                        </div>
                        <div class="card-footer-inner">
                        <a href="{{ route('struktur-organisasi.show', 4) }}" class="card-footer-link">Lihat profil &rarr;</a>
                        </div>
                    </div>

                    <div class="tree-connector h-20"></div>

                    <div class="biro-grid">
                        <div class="biro-card">
                            @php $biroKeu = collect($members)->firstWhere('id', 7); @endphp
                            <div class="biro-card-title">{{ $biroKeu->division ?? 'Biro Administrasi Keuangan' }}</div>
                            <p class="biro-card-desc">{{ $biroKeu->description ?? 'Mengelola administrasi, pencatatan, dan kebutuhan keuangan organisasi.' }}</p>
                            <div class="biro-card-footer">
                                <span class="card-footer-left">4 anggota</span>
                                <a href="#" class="card-footer-link" style="font-size:0.78rem;" onclick="openDetailModal('{{ $biroKeu->division ?? 'Biro Administrasi Keuangan' }}', 'Mengelola administrasi, pencatatan, dan kebutuhan keuangan organisasi.', '{{ $biroKeu->photo ? asset('storage/'.$biroKeu->photo) : 'https://ui-avatars.com/api/?name=Biro+Administrasi+Keuangan&background=1565C0&color=fff&size=200' }}', 7)">Lihat &rarr;</a>
                            </div>
                        </div>
                        <div class="biro-card">
                            @php $biroEko = collect($members)->firstWhere('id', 8); @endphp
                            <div class="biro-card-title">{{ $biroEko->division ?? 'Biro Ekonomi Kreatif' }}</div>
                            <p class="biro-card-desc">{{ $biroEko->description ?? 'Mengembangkan usaha, kemandirian, dan potensi ekonomi organisasi.' }}</p>
                            <div class="biro-card-footer">
                                <span class="card-footer-left">6 anggota</span>

                                <a href="#" class="card-footer-link" style="font-size:0.78rem;" onclick="openDetailModal('{{ $biroEko->division ?? 'Biro Ekonomi Kreatif' }}', 'Mengembangkan usaha, kemandirian, dan potensi ekonomi organisasi.', '{{ $biroEko->photo ? asset('storage/'.$biroEko->photo) : 'https://ui-avatars.com/api/?name=Biro+Ekonomi+Kreatif&background=1565C0&color=fff&size=200' }}', 8)">Lihat &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- MODAL DETAIL -->
<div id="detailModal" class="modal-overlay">
    <div class="modal-content">
        <button class="modal-close" onclick="closeDetailModal()"><i class="fas fa-times"></i></button>
        <span class="modal-label">DETAIL JABATAN</span>
        <h2 id="modalPosition" class="modal-title"></h2>
        <p id="modalDesc" class="modal-desc"></p>
        
        <div class="modal-body-content">
            <!-- Ini slider anggota yang hardcoded sesuai gambar -->
            <div style="width: 100%; display: flex; flex-direction: column; align-items: center; gap: 20px;">
                <div style="width: 100%; height: 300px; background: #e2e8f0; border-radius: 12px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    <img id="modalPhoto" src="" alt="Photo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;">
                </div>
                
                <div style="text-align: center;">
                    <h3 id="modalName" style="color: #0D47A1; font-size: 20px; font-weight: 600; margin-bottom: 4px;"></h3>
                    <div id="modalDivision" style="color: #1565C0; font-size: 12px; font-weight: 700; text-transform: uppercase;"></div>
                </div>

                                <!-- Slider Controls (Tampilan Statis) -->
                <div style="display: flex; flex-direction: column; align-items: center; gap: 12px; margin-top: 10px;">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <button onclick="slidePrev()" style="width: 32px; height: 32px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.1); background: white; color: #ccc; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <i class="fas fa-arrow-left" style="font-size: 12px;"></i>
                        </button>
                        <span id="slideCounter" style="color: #666; font-size: 13px; font-weight: 600;">1 / 6</span>
                        <button onclick="slideNext()" style="width: 32px; height: 32px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.1); background: white; color: #64748B; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <i class="fas fa-arrow-right" style="font-size: 12px;"></i>
                        </button>
                    </div>
                    <div id="slideDots" style="display: flex; gap: 6px;">
                        <span style="width: 24px; height: 4px; background: #3B82F6; border-radius: 2px;"></span>
                        <span style="width: 6px; height: 6px; background: #cbd5e1; border-radius: 50%; align-self: center;"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer" style="justify-content: flex-start; border-top: none; padding-top: 0;">
            <a href="#" id="modalDetailLink" class="btn btn-primary-custom" style="padding: 10px 20px; font-size: 13px;">Lihat Detail Jabatan</a>
        </div>
    </div>
</div>

<style>
/* CSS Modal (Disembunyikan agar tidak panjang, asumsikan sudah ada style nya di atas) */
.modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 1000; display: none; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease; }
.modal-overlay.show { display: flex; opacity: 1; }
.modal-content { background: #FFFFFF; width: 90%; max-width: 500px; border-radius: 16px; padding: 32px; position: relative; transform: translateY(20px); transition: transform 0.3s ease; max-height: 90vh; overflow-y: auto; }
.modal-overlay.show .modal-content { transform: translateY(0); }
.modal-close { position: absolute; top: 20px; right: 20px; background: none; border: 1px solid rgba(0,0,0,0.1); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #666; transition: all 0.2s; }
.modal-close:hover { background: rgba(0,0,0,0.05); }
.modal-label { display: block; font-size: 10px; font-weight: 700; letter-spacing: 2px; color: #1565C0; margin-bottom: 12px; }
.modal-title { font-size: 28px; font-weight: 600; color: #0D47A1; margin-bottom: 12px; line-height: 1.2; }
.modal-desc { font-size: 14px; color: #666; line-height: 1.6; margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid rgba(0,0,0,0.05); }
.modal-body-content { margin-bottom: 32px; }
.btn-primary-custom { background-color: #0D47A1; color: #fff; border: none; font-weight: 600; transition: all 0.3s; border-radius: 8px; text-decoration: none; }
.btn-primary-custom:hover { background-color: #1565C0; color: #fff; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(13, 71, 161, 0.2); }
</style>


@endsection
