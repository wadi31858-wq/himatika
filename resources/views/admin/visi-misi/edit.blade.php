@extends('layouts.admin')

@section('title', 'Visi & Misi')
@section('page_title', 'Kelola Visi & Misi Organisasi')
@section('page_subtitle', 'Tentukan arah haluan, komitmen, dan butir-butir misi HIMATIKA')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-bullseye text-primary"></i> Visi & Misi HIMATIKA
                </h2>
                <a href="{{ route('visi-misi') }}" target="_blank" class="btn btn-sm btn-outline-info">
                    <i class="fas fa-external-link-alt me-1"></i> Lihat Publik
                </a>
            </div>

            <form action="{{ route('admin.visi-misi.update') }}" method="POST" id="visionMissionForm">
                @csrf
                @method('PUT')

                <!-- Visi -->
                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark fs-6">Visi Organisasi <span class="text-danger">*</span></label>
                    <textarea name="vision" class="form-control" rows="3" required placeholder="Tuliskan visi besar himpunan...">{{ old('vision', $vm->vision) }}</textarea>
                    <div class="form-text">Visi utama ditampilkan pada banner dan panel sorotan Visi di halaman publik.</div>
                </div>

                <!-- Misi List Repeater -->
                <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label fw-semibold text-dark fs-6 mb-0">Daftar Misi Organisasi <span class="text-danger">*</span></label>
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="addMissionItem()">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Butir Misi
                        </button>
                    </div>

                    <div id="missionListContainer" class="d-flex flex-column gap-2">
                        <!-- Items rendered by JS -->
                    </div>

                    <!-- Hidden actual input synced before submit -->
                    <textarea name="mission_text" id="hiddenMissionText" style="display: none;">{{ old('mission_text', $missionText) }}</textarea>
                    <div class="form-text mt-2">Setiap poin dapat diedit, diurutkan naik/turun, atau dihapus secara langsung.</div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <button type="submit" class="btn btn-him-primary px-4 py-2">
                        <i class="fas fa-save me-1"></i> Simpan Visi & Misi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const initialText = document.getElementById('hiddenMissionText').value;
    const container = document.getElementById('missionListContainer');
    const form = document.getElementById('visionMissionForm');

    // Parse initial lines
    let items = initialText.split(/\r?\n/).map(s => s.trim()).filter(s => s.length > 0);
    if (items.length === 0) {
        items = ['Penguatan Nilai Keislaman dan Pembentukan Akhlak Mulia', 'Peningkatan Prestasi Akademik, Inovasi, dan Literasi'];
    }

    function renderMissions() {
        container.innerHTML = '';
        items.forEach((text, idx) => {
            const itemRow = document.createElement('div');
            itemRow.className = 'd-flex align-items-center gap-2 p-2 bg-light border rounded-3';
            itemRow.innerHTML = `
                <span class="badge bg-primary rounded-circle" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    ${idx + 1}
                </span>
                <input type="text" class="form-control mission-input" value="${escapeHtml(text)}" onchange="updateItem(${idx}, this.value)">
                <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2" title="Pindah Ke Atas" onclick="moveItem(${idx}, -1)" ${idx === 0 ? 'disabled' : ''}>
                    <i class="fas fa-arrow-up"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2" title="Pindah Ke Bawah" onclick="moveItem(${idx}, 1)" ${idx === items.length - 1 ? 'disabled' : ''}>
                    <i class="fas fa-arrow-down"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2" title="Hapus Butir Misi" onclick="deleteItem(${idx})">
                    <i class="fas fa-trash-alt"></i>
                </button>
            `;
            container.appendChild(itemRow);
        });
        syncHidden();
    }

    function escapeHtml(text) {
        return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;");
    }

    function updateItem(idx, val) {
        items[idx] = val;
        syncHidden();
    }

    function addMissionItem() {
        items.push('');
        renderMissions();
        // Focus on the newly added input
        const inputs = container.querySelectorAll('.mission-input');
        if (inputs.length) {
            inputs[inputs.length - 1].focus();
        }
    }

    function deleteItem(idx) {
        if (items.length <= 1) {
            alert('Minimal harus ada satu butir misi.');
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

    form.addEventListener('submit', function() {
        syncHidden();
    });

    renderMissions();
</script>
@endpush
