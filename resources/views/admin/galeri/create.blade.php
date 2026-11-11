@extends('layouts.admin')

@section('title', 'Tambah Album Galeri')
@section('page_title', 'Buat Album Galeri Baru')
@section('page_subtitle', 'Unggah beberapa foto sekaligus ke dalam satu album kegiatan')

@section('content')
<form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" id="galleryAlbumForm">
    @csrf

    <div class="row g-4">
        <!-- Left: Album Metadata -->
        <div class="col-lg-5">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-folder-plus"></i> Informasi Album
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Judul Album <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Contoh: Makrab Mahasiswa Baru 2026">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Kategori / Kegiatan</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category') }}" placeholder="Contoh: Kaderisasi / Dies Natalis">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Deskripsi Album</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Ceritakan singkat momen kegiatan dalam album ini">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Foto Sampul Utama (Opsional)</label>
                    <input type="file" name="cover_image" class="form-control" accept="image/*">
                    <div class="form-text">Jika dikosongkan, foto pertama dari antrean unggahan akan otomatis dijadikan sampul.</div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark">Status</label>
                        <select name="status" class="form-select">
                            <option value="published" selected>Terbitkan (Publik)</option>
                            <option value="draft">Draft (Admin)</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark">Nomor Urut</label>
                        <input type="number" name="order_num" class="form-control" value="0" min="0">
                    </div>
                </div>

                <button type="submit" class="btn btn-him-primary w-100 py-2">
                    <i class="fas fa-cloud-upload-alt me-1"></i> Simpan Album & Foto
                </button>
            </div>
        </div>

        <!-- Right: Multi-Photo Queue Manager -->
        <div class="col-lg-7">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-images"></i> Unggah Banyak Foto Sekaligus
                    </h2>
                    <span class="badge bg-primary-subtle text-primary" id="selectedCountBadge">0 Foto Terpilih</span>
                </div>

                <!-- Custom Drag & Drop or Browse Box -->
                <div class="border border-2 border-dashed rounded-4 p-4 text-center bg-light mb-3" id="dropArea" style="cursor: pointer;">
                    <i class="fas fa-camera-retro fs-1 text-primary opacity-75 mb-2"></i>
                    <h5 class="fw-bold text-dark mb-1">Pilih atau Seret Foto ke Sini</h5>
                    <p class="text-muted small mb-2">Bisa memilih banyak foto sekaligus (Maksimal 30 foto, hingga 5MB per foto).</p>
                    <button type="button" class="btn btn-sm btn-outline-primary px-3 rounded-pill" onclick="document.getElementById('multiFileInput').click()">
                        <i class="fas fa-folder-open me-1"></i> Telusuri Foto
                    </button>
                    <!-- Actual hidden multiple file input -->
                    <input type="file" id="multiFileInput" multiple accept="image/jpeg,image/png,image/webp" style="display: none;">
                </div>

                <!-- Preview Grid with Individual Remove Buttons -->
                <div id="photosQueueContainer">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="fw-semibold text-dark small">Daftar Antrean Foto yang Akan Disimpan:</span>
                        <button type="button" class="btn btn-sm text-danger p-0 border-0" id="clearQueueBtn" style="display: none;" onclick="clearAllQueued()">
                            <i class="fas fa-times me-1"></i> Kosongkan Semua
                        </button>
                    </div>

                    <div class="row g-3" id="photoThumbsRow">
                        <div class="col-12 text-center py-4 text-muted small" id="emptyQueueMsg">
                            <i class="fas fa-info-circle me-1"></i> Belum ada foto yang dipilih. Silakan klik tombol di atas untuk memilih foto.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    // In-memory FileList accumulator using DataTransfer
    const dt = new DataTransfer();
    const fileInput = document.getElementById('multiFileInput');
    const thumbsRow = document.getElementById('photoThumbsRow');
    const countBadge = document.getElementById('selectedCountBadge');
    const emptyMsg = document.getElementById('emptyQueueMsg');
    const clearBtn = document.getElementById('clearQueueBtn');
    const form = document.getElementById('galleryAlbumForm');

    fileInput.addEventListener('change', function(e) {
        if (!this.files.length) return;

        for (let i = 0; i < this.files.length; i++) {
            const file = this.files[i];
            // Check size max 5MB
            if (file.size > 5 * 1024 * 1024) {
                alert(`Berkas "${file.name}" melebihi batas 5MB dan dilewati.`);
                continue;
            }
            dt.items.add(file);
        }
        renderQueue();
    });

    function renderQueue() {
        thumbsRow.innerHTML = '';
        const count = dt.files.length;
        countBadge.textContent = `${count} Foto Terpilih`;

        if (count === 0) {
            emptyMsg.style.display = 'block';
            clearBtn.style.display = 'none';
            thumbsRow.appendChild(emptyMsg);
            return;
        }

        emptyMsg.style.display = 'none';
        clearBtn.style.display = 'inline-block';

        Array.from(dt.files).forEach((file, index) => {
            const col = document.createElement('div');
            col.className = 'col-sm-4 col-6';

            const reader = new FileReader();
            reader.onload = function(e) {
                const sizeKb = (file.size / 1024).toFixed(0);
                col.innerHTML = `
                    <div class="position-relative rounded-3 overflow-hidden border shadow-sm bg-white p-1">
                        <img src="${e.target.result}" class="w-100 rounded" style="height: 110px; object-fit: cover;">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle py-0 px-2 shadow" title="Batalkan foto ini" onclick="removeQueuedPhoto(${index})">
                            &times;
                        </button>
                        <div class="px-1 pt-1 text-truncate small fw-semibold" title="${file.name}">${file.name}</div>
                        <div class="px-1 text-muted" style="font-size: 0.72rem;">${sizeKb} KB ${index === 0 ? '· <span class="badge bg-success" style="font-size:0.65rem">Auto Sampul</span>' : ''}</div>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
            thumbsRow.appendChild(col);
        });
    }

    function removeQueuedPhoto(index) {
        const newDt = new DataTransfer();
        Array.from(dt.files).forEach((file, i) => {
            if (i !== index) {
                newDt.items.add(file);
            }
        });
        dt.items.clear();
        Array.from(newDt.files).forEach(file => dt.items.add(file));
        renderQueue();
    }

    function clearAllQueued() {
        dt.items.clear();
        renderQueue();
    }

    // Attach accumulated DataTransfer files to form before submission
    form.addEventListener('submit', function(e) {
        // Remove existing input file if any to attach DataTransfer
        fileInput.files = dt.files;
        fileInput.name = 'photos[]';
    });
</script>
@endpush
