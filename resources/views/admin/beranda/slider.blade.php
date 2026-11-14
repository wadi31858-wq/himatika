@extends('layouts.admin')

@section('title', 'Slider Foto Hero')
@section('page_title', 'Kelola Slider Foto Hero Beranda')
@section('page_subtitle', 'Kelola galeri foto bergerak di area hero beranda, multi-unggah, jeda putar, urutan, dan teks alternatif')

@section('content')
<div class="row g-4 mb-4">
    <!-- 1. Pengaturan Interval & Autoplay -->
    <div class="col-lg-5">
        <div class="him-card h-100">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-sliders-h text-primary"></i> Pengaturan Slider
                </h2>
                <span class="badge bg-primary-subtle text-primary">Otomatisasi</span>
            </div>

            <form action="{{ route('admin.beranda.slider.settings') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Jeda Pergantian Foto (Detik)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-stopwatch text-muted"></i></span>
                        <input type="number" name="hero_slider_interval" class="form-control @error('hero_slider_interval') is-invalid @enderror" 
                               value="{{ old('hero_slider_interval', $interval ?? 5) }}" min="1" max="60" required>
                        <span class="input-group-text bg-light">detik</span>
                    </div>
                    @error('hero_slider_interval')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Nilai bawaan adalah 5 detik. Berlaku ketika pemutaran otomatis diaktifkan.</div>
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch d-flex align-items-center gap-3 ps-0">
                        <input class="form-check-input ms-0" type="checkbox" name="hero_slider_autoplay" id="autoplaySwitch" value="1" 
                               {{ old('hero_slider_autoplay', $autoplay ?? true) ? 'checked' : '' }} 
                               style="width: 2.6em; height: 1.3em; cursor: pointer;">
                        <label class="form-check-label fw-semibold text-dark mb-0" for="autoplaySwitch" style="cursor: pointer;">
                            Putar Otomatis (Autoplay)
                        </label>
                    </div>
                    <div class="form-text">Foto akan berganti otomatis secara horizontal dan terus mengulang dari awal (loop tak terbatas).</div>
                </div>

                <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                    <a href="{{ route('home') }}#hero" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                        <i class="fas fa-external-link-alt me-1"></i> Pratinjau Beranda
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-1"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. Form Unggah Foto Sekaligus (Multi-File Upload) -->
    <div class="col-lg-7">
        <div class="him-card h-100">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-cloud-upload-alt text-primary"></i> Unggah Foto Baru
                </h2>
                <span class="badge bg-success-subtle text-success">Mendukung Banyak File</span>
            </div>

            <form action="{{ route('admin.beranda.slider.store') }}" method="POST" enctype="multipart/form-data" id="multiUploadForm">
                @csrf

                <div class="upload-dropzone p-4 text-center border-dashed rounded-3 bg-light mb-3 position-relative" id="dropzoneBox" style="border: 2px dashed #d6b8c4; cursor: pointer;">
                    <input type="file" name="photos[]" id="photosInput" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" multiple accept="image/jpeg,image/png,image/jpg,image/webp,image/gif" style="cursor: pointer;">
                    <div class="py-2">
                        <div class="mb-2">
                            <i class="fas fa-images fa-3x text-primary" style="opacity: 0.85;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">Pilih Beberapa Foto Sekaligus</h6>
                        <p class="text-muted small mb-2">Klik atau seret file foto ke area ini. Anda dapat memilih 1 atau lebih foto sekaligus.</p>
                        <span class="badge bg-white text-secondary border">Format: JPG, JPEG, PNG, WEBP, GIF (Maks. 5MB / file)</span>
                    </div>
                </div>

                <!-- Pratinjau File Yang Dipilih -->
                <div id="filePreviewContainer" class="d-none mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="small fw-bold text-dark"><i class="fas fa-list-check me-1"></i> Pratinjau Foto Siap Diunggah (<span id="fileCountBadge">0</span>)</span>
                        <button type="button" class="btn btn-sm text-danger p-0 border-0" id="clearFilesBtn" style="font-size: 0.8rem;">
                            <i class="fas fa-times me-1"></i> Batalkan Semua
                        </button>
                    </div>
                    <div class="table-responsive border rounded bg-white" style="max-height: 220px; overflow-y: auto;">
                        <table class="table table-sm table-hover align-middle mb-0" id="previewTable">
                            <thead class="table-light">
                                <tr style="font-size: 0.8rem;">
                                    <th style="width: 60px;">Foto</th>
                                    <th>Nama File</th>
                                    <th>Ukuran</th>
                                    <th class="text-center" style="width: 90px;">Status</th>
                                    <th class="text-end" style="width: 50px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="previewTbody"></tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                    <span class="text-muted small" id="uploadSummaryText">Belum ada foto baru yang dipilih.</span>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" id="submitUploadBtn" disabled>
                        <i class="fas fa-upload me-1"></i> Mulai Unggah Foto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 3. Daftar Foto Slider Yang Sedang Digunakan -->
<div class="him-card">
    <div class="him-card-header flex-wrap gap-2">
        <div>
            <h2 class="him-card-title">
                <i class="fas fa-layer-group text-primary"></i> Daftar Foto Slider Sedang Digunakan
            </h2>
            <div class="text-muted small mt-1">
                Total <strong>{{ $sliders->count() }}</strong> foto terdaftar | 
                <strong class="text-success">{{ $sliders->where('is_active', true)->count() }}</strong> foto aktif tampil di Beranda
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            @if($sliders->where('is_active', true)->count() == 0)
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                    <i class="fas fa-exclamation-triangle me-1"></i> 0 Foto Aktif: Bingkai disembunyikan bersih di Beranda
                </span>
            @elseif($sliders->where('is_active', true)->count() == 1)
                <span class="badge bg-info-subtle text-info-emphasis px-3 py-2 rounded-pill">
                    <i class="fas fa-image me-1"></i> 1 Foto Aktif: Ditampilkan statis tanpa navigasi slider
                </span>
            @else
                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                    <i class="fas fa-play-circle me-1"></i> Multi-Foto: Slider aktif dengan kontrol & geser sentuh
                </span>
            @endif
        </div>
    </div>

    @if($sliders->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="fas fa-images fa-3x mb-3 text-secondary opacity-50"></i>
            <h5 class="fw-bold">Belum Ada Foto Slider</h5>
            <p class="small mb-3">Gunakan form di atas untuk mengunggah foto kepengurusan atau kegiatan HIMATIKA ke slider hero.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="sliderTable">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;" class="text-center">Urutan</th>
                        <th style="width: 140px;">Pratinjau Foto</th>
                        <th>Keterangan & Teks Alternatif</th>
                        <th style="width: 130px;" class="text-center">Status</th>
                        <th style="width: 180px;" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody id="sliderSortableTbody">
                    @foreach($sliders as $slider)
                        <tr data-id="{{ $slider->id }}" class="{{ !$slider->is_active ? 'opacity-75 bg-light' : '' }}">
                            <!-- Urutan & tombol geser -->
                            <td class="text-center">
                                <div class="d-flex flex-column align-items-center justify-content-center gap-1">
                                    <span class="badge bg-secondary rounded-pill px-2 py-1" style="font-size: 0.85rem;">
                                        #{{ $slider->order_num }}
                                    </span>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-1 btn-move-up" title="Geser ke Atas" {{ $loop->first ? 'disabled' : '' }}>
                                            <i class="fas fa-chevron-up" style="font-size: 0.7rem;"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-1 btn-move-down" title="Geser ke Bawah" {{ $loop->last ? 'disabled' : '' }}>
                                            <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <!-- Thumbnail -->
                            <td>
                                <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm border" style="width: 120px; background-color: #250D17;">
                                    <img src="{{ $slider->image_url }}" alt="{{ $slider->alt_text }}" class="object-fit-cover w-100 h-100" loading="lazy">
                                </div>
                            </td>

                            <!-- Informasi & Teks -->
                            <td>
                                <div class="fw-bold text-dark mb-1">
                                    {{ $slider->title ?: 'Tanpa Judul' }}
                                </div>
                                <div class="small text-muted mb-1">
                                    <span class="text-secondary fw-semibold">Teks Alt:</span> {{ $slider->alt_text ?: '(Belum diatur)' }}
                                </div>
                                @if($slider->caption)
                                    <div class="small text-muted fst-italic">
                                        <i class="fas fa-quote-left me-1 small"></i>{{ $slider->caption }}
                                    </div>
                                @endif
                                <div class="small text-muted font-monospace mt-1" style="font-size: 0.75rem;">
                                    <i class="fas fa-file-image me-1"></i>{{ basename($slider->image) }}
                                </div>
                            </td>

                            <!-- Status Aktif / Sembunyi -->
                            <td class="text-center">
                                <form action="{{ route('admin.beranda.slider.toggle', $slider->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm rounded-pill px-3 {{ $slider->is_active ? 'btn-success' : 'btn-outline-secondary' }}" title="Klik untuk mengubah status tampilan">
                                        @if($slider->is_active)
                                            <i class="fas fa-eye me-1"></i> Tampil
                                        @else
                                            <i class="fas fa-eye-slash me-1"></i> Disembunyikan
                                        @endif
                                    </button>
                                </form>
                            </td>

                            <!-- Aksi: Ganti Foto, Edit Teks, Hapus -->
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $slider->id }}" title="Edit Teks & Data">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#replaceModal{{ $slider->id }}" title="Ganti File Foto">
                                        <i class="fas fa-camera"></i> Ganti
                                    </button>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $slider->id }}" title="Hapus Foto">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit Data & Teks Alternatif -->
                        <div class="modal fade" id="editModal{{ $slider->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('admin.beranda.slider.update', $slider->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">
                                                <i class="fas fa-edit text-primary me-2"></i> Edit Data Foto #{{ $slider->order_num }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center mb-3">
                                                <img src="{{ $slider->image_url }}" alt="{{ $slider->alt_text }}" class="rounded shadow-sm img-thumbnail" style="max-height: 120px;">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-dark">Judul Foto</label>
                                                <input type="text" name="title" class="form-control" value="{{ old('title', $slider->title) }}" placeholder="Contoh: Pengurus HIMATIKA Periode 2026">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-dark">Teks Alternatif (Alt Text)</label>
                                                <input type="text" name="alt_text" class="form-control" value="{{ old('alt_text', $slider->alt_text) }}" placeholder="Deskripsi untuk pembaca layar & SEO">
                                                <div class="form-text">Membantu aksesibilitas dan pencarian ketika foto ditampilkan.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-dark">Keterangan Singkat (Opsional)</label>
                                                <input type="text" name="caption" class="form-control" value="{{ old('caption', $slider->caption) }}" placeholder="Keterangan singkat kegiatan/foto">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-dark">Nomor Urutan Tampil</label>
                                                <input type="number" name="order_num" class="form-control" value="{{ old('order_num', $slider->order_num) }}" min="1">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Ganti File Foto -->
                        <div class="modal fade" id="replaceModal{{ $slider->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('admin.beranda.slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">
                                                <i class="fas fa-camera text-primary me-2"></i> Ganti File Foto #{{ $slider->order_num }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center mb-3">
                                                <span class="small text-muted d-block mb-1">Foto Saat Ini:</span>
                                                <img src="{{ $slider->image_url }}" alt="{{ $slider->alt_text }}" class="rounded shadow-sm img-thumbnail" style="max-height: 140px;">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-dark">Pilih File Foto Baru</label>
                                                <input type="file" name="photo" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp,image/gif" required>
                                                <div class="form-text">Format: JPG, JPEG, PNG, WEBP, GIF (Maks. 5MB). Foto lama akan diganti dengan file baru ini.</div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                                <i class="fas fa-cloud-upload-alt me-1"></i> Simpan Foto Baru
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Konfirmasi Hapus -->
                        <div class="modal fade" id="deleteModal{{ $slider->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('admin.beranda.slider.destroy', $slider->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title text-danger fw-bold">
                                                <i class="fas fa-exclamation-circle me-2"></i> Konfirmasi Hapus Foto
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center py-4">
                                            <img src="{{ $slider->image_url }}" alt="{{ $slider->alt_text }}" class="rounded shadow-sm img-thumbnail mb-3" style="max-height: 120px;">
                                            <p class="mb-1 text-dark fw-semibold">Apakah Anda yakin ingin menghapus foto ini dari slider hero?</p>
                                            <p class="small text-muted mb-0">Foto: <strong>{{ $slider->title ?: basename($slider->image) }}</strong></p>
                                        </div>
                                        <div class="modal-footer border-0 pt-0 justify-content-center">
                                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger rounded-pill px-4">
                                                <i class="fas fa-trash-alt me-1"></i> Ya, Hapus Foto
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const photosInput = document.getElementById('photosInput');
    const previewContainer = document.getElementById('filePreviewContainer');
    const previewTbody = document.getElementById('previewTbody');
    const fileCountBadge = document.getElementById('fileCountBadge');
    const uploadSummaryText = document.getElementById('uploadSummaryText');
    const submitUploadBtn = document.getElementById('submitUploadBtn');
    const clearFilesBtn = document.getElementById('clearFilesBtn');
    let selectedFiles = [];

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 B';
        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    }

    function renderPreview() {
        if (!photosInput.files || photosInput.files.length === 0) {
            previewContainer.classList.add('d-none');
            submitUploadBtn.disabled = true;
            uploadSummaryText.textContent = 'Belum ada foto baru yang dipilih.';
            return;
        }

        const files = Array.from(photosInput.files);
        selectedFiles = files;
        previewTbody.innerHTML = '';
        fileCountBadge.textContent = files.length;
        uploadSummaryText.textContent = files.length + ' foto siap diunggah.';
        submitUploadBtn.disabled = false;
        previewContainer.classList.remove('d-none');

        let totalSize = 0;
        files.forEach((file, index) => {
            totalSize += file.size;
            const tr = document.createElement('tr');
            const isTooLarge = file.size > 5 * 1024 * 1024;

            tr.innerHTML = `
                <td>
                    <img id="prevImg_${index}" src="" class="rounded border" style="width: 44px; height: 32px; object-fit: cover;" alt="">
                </td>
                <td>
                    <span class="d-inline-block text-truncate fw-semibold text-dark" style="max-width: 220px;" title="${file.name}">
                        ${file.name}
                    </span>
                </td>
                <td class="small ${isTooLarge ? 'text-danger fw-bold' : 'text-muted'}">
                    ${formatFileSize(file.size)}
                </td>
                <td class="text-center">
                    ${isTooLarge 
                        ? '<span class="badge bg-danger">Terlalu Besar (>5MB)</span>' 
                        : '<span class="badge bg-success-subtle text-success">Siap Diunggah</span>'}
                </td>
                <td class="text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger py-0 px-1 btn-remove-item" data-index="${index}" title="Batalkan foto ini">
                        <i class="fas fa-trash-alt" style="font-size: 0.75rem;"></i>
                    </button>
                </td>
            `;
            previewTbody.appendChild(tr);

            // Thumbnail reader
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgEl = document.getElementById(`prevImg_${index}`);
                if (imgEl) imgEl.src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    }

    if (photosInput) {
        photosInput.addEventListener('change', renderPreview);
    }

    if (clearFilesBtn) {
        clearFilesBtn.addEventListener('click', function() {
            photosInput.value = '';
            renderPreview();
        });
    }

    // Handle removing single item from DataTransfer
    if (previewTbody) {
        previewTbody.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-remove-item');
            if (!btn) return;
            const removeIdx = parseInt(btn.getAttribute('data-index'), 10);
            const dt = new DataTransfer();
            const currentFiles = Array.from(photosInput.files);
            currentFiles.forEach((file, idx) => {
                if (idx !== removeIdx) dt.items.add(file);
            });
            photosInput.files = dt.files;
            renderPreview();
        });
    }

    // Urutan Up / Down buttons
    const tbody = document.getElementById('sliderSortableTbody');
    if (tbody) {
        tbody.addEventListener('click', function(e) {
            const upBtn = e.target.closest('.btn-move-up');
            const downBtn = e.target.closest('.btn-move-down');
            if (!upBtn && !downBtn) return;

            const tr = (upBtn || downBtn).closest('tr');
            if (upBtn) {
                const prev = tr.previousElementSibling;
                if (prev) {
                    tbody.insertBefore(tr, prev);
                    saveRowOrders();
                }
            } else if (downBtn) {
                const next = tr.nextElementSibling;
                if (next) {
                    tbody.insertBefore(next, tr);
                    saveRowOrders();
                }
            }
        });

        function saveRowOrders() {
            const rows = Array.from(tbody.querySelectorAll('tr[data-id]'));
            const orders = rows.map(r => r.getAttribute('data-id'));
            
            // Update UI badges locally
            rows.forEach((r, idx) => {
                const badge = r.querySelector('.badge.bg-secondary');
                if (badge) badge.textContent = '#' + (idx + 1);
                const up = r.querySelector('.btn-move-up');
                const down = r.querySelector('.btn-move-down');
                if (up) up.disabled = (idx === 0);
                if (down) down.disabled = (idx === rows.length - 1);
            });

            // Send AJAX to reorder
            fetch("{{ route('admin.beranda.slider.reorder') }}", {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ orders: orders })
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    // Success feedback
                }
            }).catch(err => {
                console.error('Reorder error:', err);
            });
        }
    }
});
</script>
@endpush
