@extends('layouts.admin')

@section('title', 'Visi dan Misi')
@section('page_title', 'Kelola Visi dan Misi')
@section('page_subtitle', 'Sesuaikan judul banner, deskripsi pembuka, kartu visi, dan butir-butir misi yang tampil di website publik')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <form action="{{ route('admin.visi-misi.update') }}" method="POST" id="visionMissionForm">
            @csrf
            @method('PUT')

            <!-- 1. KONTROL STATUS & VISIBILITAS -->
            <div class="him-card">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="vm_is_visible" id="vmIsVisible" value="1" {{ old('vm_is_visible', $isVisible ?? '1') === '1' ? 'checked' : '' }} style="width: 2.8em; height: 1.4em; cursor: pointer;">
                        </div>
                        <div>
                            <label class="form-label fw-bold text-dark mb-0 fs-6" for="vmIsVisible">
                                Tampilkan Halaman Visi dan Misi di Website Publik
                            </label>
                            <div class="form-text mt-0">
                                Jika dinonaktifkan, halaman Visi & Misi akan disembunyikan dan tautan pada menu navigasi Tentang akan dihilangkan otomatis.
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('visi-misi') }}" target="_blank" class="btn btn-sm btn-outline-primary px-3 rounded-pill">
                            <i class="fas fa-external-link-alt me-1"></i> Buka Tampilan Publik
                        </a>
                    </div>
                </div>
            </div>

            <!-- 2. BANNER & HEADER SECTION -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-heading text-primary"></i> Banner & Header Halaman
                    </h2>
                    <span class="badge bg-secondary-subtle text-secondary">Bagian Atas</span>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Judul Bagian / Banner <span class="text-danger">*</span></label>
                    <input type="text" name="vm_banner_title" id="vmBannerTitle" class="form-control" required value="{{ old('vm_banner_title', $bannerTitle ?? 'Visi dan Misi') }}" placeholder="Visi dan Misi">
                    <div class="form-text">Teks judul utama yang tampil besar di dalam banner gradien burgundy.</div>
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <label class="form-label fw-semibold text-dark mb-0">Deskripsi Pembuka</label>
                        <button type="button" class="btn btn-sm btn-link text-muted p-0 text-decoration-none" onclick="document.getElementById('vmBannerSubtitle').value = ''">
                            <i class="fas fa-eraser me-1"></i> Kosongkan
                        </button>
                    </div>
                    <textarea name="vm_banner_subtitle" id="vmBannerSubtitle" class="form-control" rows="2" placeholder="Arah dan tujuan pengembangan HIMATIKA UNUJA.">{{ old('vm_banner_subtitle', $bannerSubtitle ?? 'Arah dan tujuan pengembangan HIMATIKA UNUJA.') }}</textarea>
                    <div class="form-text">Subjudul penjelas tepat di bawah judul banner Visi dan Misi.</div>
                </div>
            </div>

            <!-- 3. KARTU VISI -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-quote-left text-primary"></i> Kartu Visi Organisasi
                    </h2>
                    <span class="badge bg-primary-subtle text-primary">Kartu Kiri (Latar Gelap)</span>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Judul Kartu Visi</label>
                    <input type="text" name="vm_vision_title" class="form-control" value="{{ old('vm_vision_title', $visionTitle ?? 'Visi HIMATIKA UNUJA') }}" placeholder="Visi HIMATIKA UNUJA">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Isi Visi Organisasi <span class="text-danger">*</span></label>
                    <textarea name="vision" id="visionInput" class="form-control" rows="4" required placeholder="Tuliskan pernyataan visi organisasi...">{{ old('vision', $vm->vision) }}</textarea>
                    <div class="form-text">Isi visi ini otomatis disinkronkan ke panel Visi pada Beranda sehingga Anda cukup memperbaruinya di sini.</div>
                </div>
            </div>

            <!-- 4. KARTU MISI & REPEATER BUTIR MISI -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-list-check text-primary"></i> Kartu Misi & Butir-Butir Misi
                    </h2>
                    <span class="badge bg-success-subtle text-success">Kartu Kanan (Daftar Berulang)</span>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Judul Kartu Misi</label>
                    <input type="text" name="vm_mission_title" class="form-control" value="{{ old('vm_mission_title', $missionTitle ?? 'Misi HIMATIKA UNUJA') }}" placeholder="Misi HIMATIKA UNUJA">
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                        <div>
                            <span class="fw-semibold text-dark fs-6">Daftar Butir Misi</span>
                            <div class="text-muted small">Kelola setiap poin butir misi secara mandiri: tambah, edit teks, atur urutan naik/turun, atau hapus.</div>
                        </div>
                        <button type="button" class="btn btn-sm btn-him-primary rounded-pill px-3" onclick="addMissionItem()">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Butir Misi
                        </button>
                    </div>

                    <div id="missionListContainer" class="d-flex flex-column gap-2 mb-3">
                        <!-- Rendered by JS -->
                    </div>

                    <!-- Hidden actual input for fallback sync -->
                    <textarea name="mission_text" id="hiddenMissionText" style="display: none;">{{ old('mission_text', $missionText) }}</textarea>
                </div>
            </div>

            <!-- 5. TOMBOL AKSI SIMPAN -->
            <div class="him-card bg-light">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="text-muted small">
                        <i class="fas fa-info-circle me-1 text-primary"></i> Perubahan yang disimpan langsung terlihat pada halaman publik.
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary px-4 py-2" onclick="resetToOriginal()">
                            <i class="fas fa-undo me-1"></i> Reset Form
                        </button>
                        <button type="submit" class="btn btn-him-primary px-5 py-2">
                            <i class="fas fa-save me-1"></i> Simpan Pengaturan Visi & Misi
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initial data from server
    let initialMissions = @json($missionList ?? []);
    if (!initialMissions || initialMissions.length === 0) {
        initialMissions = [
            'Meningkatkan kemampuan akademik dan non-akademik mahasiswa Informatika.',
            'Mendorong kreativitas dan inovasi dalam bidang matematika terapan.',
            'Membangun solidaritas antar mahasiswa Informatika.',
            'Menyelenggarakan kegiatan edukatif dan kompetitif.',
            'Membangun kerja sama dengan pihak internal dan eksternal kampus.',
            'Mengembangkan potensi mahasiswa Informatika UNUJA.'
        ];
    }

    let items = JSON.parse(JSON.stringify(initialMissions));
    const container = document.getElementById('missionListContainer');
    const form = document.getElementById('visionMissionForm');

    function renderMissions() {
        container.innerHTML = '';
        if (items.length === 0) {
            container.innerHTML = `
                <div class="p-4 text-center border rounded-3 bg-white text-muted">
                    <i class="fas fa-exclamation-circle fa-2x mb-2 text-warning"></i>
                    <p class="mb-2">Belum ada butir misi.</p>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addMissionItem()">
                        <i class="fas fa-plus me-1"></i> Tambah Butir Pertama
                    </button>
                </div>
            `;
            syncHidden();
            return;
        }

        items.forEach((text, idx) => {
            const itemRow = document.createElement('div');
            itemRow.className = 'd-flex align-items-center gap-2 p-2 bg-white border rounded-3 shadow-xs';
            itemRow.innerHTML = `
                <span class="badge bg-secondary rounded-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.9rem; font-weight: 700;">
                    ${idx + 1}
                </span>
                <input type="text" name="mission_items[]" class="form-control mission-input" value="${escapeHtml(text)}" placeholder="Ketikkan butir misi..." oninput="updateItem(${idx}, this.value)" required>
                <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2" title="Pindah Ke Atas" onclick="moveItem(${idx}, -1)" ${idx === 0 ? 'disabled' : ''}>
                    <i class="fas fa-arrow-up"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2" title="Pindah Ke Bawah" onclick="moveItem(${idx}, 1)" ${idx === items.length - 1 ? 'disabled' : ''}>
                    <i class="fas fa-arrow-down"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2" title="Hapus Butir Misi" onclick="deleteMissionItem(${idx})">
                    <i class="fas fa-trash-alt"></i>
                </button>
            `;
            container.appendChild(itemRow);
        });
        syncHidden();
    }

    function escapeHtml(text) {
        if (!text) return '';
        return String(text).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;");
    }

    function updateItem(idx, val) {
        items[idx] = val;
        syncHidden();
    }

    function addMissionItem() {
        items.push('');
        renderMissions();
        const inputs = container.querySelectorAll('.mission-input');
        if (inputs.length) {
            inputs[inputs.length - 1].focus();
        }
    }

    function deleteMissionItem(idx) {
        if (!confirm('Apakah Anda yakin ingin menghapus butir misi ini?')) {
            return;
        }
        items.splice(idx, 1);
        renderMissions();
    }

    function moveItem(idx, direction) {
        const target = idx + direction;
        if (target < 0 || target >= items.length) return;
        const temp = items[idx];
        items[idx] = items[target];
        items[target] = temp;
        renderMissions();
    }

    function syncHidden() {
        const inputs = container.querySelectorAll('.mission-input');
        const vals = [];
        inputs.forEach(inp => {
            const v = inp.value.trim();
            if (v) vals.push(v);
        });
        document.getElementById('hiddenMissionText').value = vals.join("\n");
    }

    function resetToOriginal() {
        if (!confirm('Kembalikan butir misi ke data yang tersimpan sebelumnya?')) return;
        items = JSON.parse(JSON.stringify(initialMissions));
        renderMissions();
    }

    form.addEventListener('submit', function() {
        syncHidden();
    });

    // Render initial
    renderMissions();
</script>
@endpush
