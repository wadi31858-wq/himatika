@extends('layouts.admin')

@section('title', 'Edit Album Galeri')
@section('page_title', 'Edit Album: ' . $gallery->title)
@section('page_subtitle', 'Kelola informasi album, foto yang sudah tersimpan, serta tambahkan foto baru')

@section('content')
<form action="{{ route('admin.galeri.update', $gallery) }}" method="POST" enctype="multipart/form-data" id="galleryAlbumEditForm">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Left: Album Metadata -->
        <div class="col-lg-5">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-edit"></i> Informasi Album
                    </h2>
                    <a href="{{ route('galeri.show', $gallery->id) }}" target="_blank" class="btn btn-sm btn-outline-info">
                        <i class="fas fa-external-link-alt me-1"></i> Lihat Publik
                    </a>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Judul Album <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $gallery->title) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Kategori / Kegiatan</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category', $gallery->category) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Deskripsi Album</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $gallery->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Ganti Foto Sampul Khusus</label>
                    <input type="file" name="cover_image" class="form-control" accept="image/*">
                    @if($gallery->image)
                        <div class="mt-2 d-flex align-items-center gap-2">
                            <img src="{{ asset('storage/' . $gallery->image) }}" class="rounded" style="width: 60px; height: 45px; object-fit: cover;">
                            <span class="small text-muted">Sampul aktif saat ini</span>
                        </div>
                    @endif
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark">Status</label>
                        <select name="status" class="form-select">
                            <option value="published" {{ old('status', $gallery->status) === 'published' ? 'selected' : '' }}>Terbitkan (Publik)</option>
                            <option value="draft" {{ old('status', $gallery->status) === 'draft' ? 'selected' : '' }}>Draft (Admin)</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark">Nomor Urut</label>
                        <input type="number" name="order_num" class="form-control" value="{{ old('order_num', $gallery->order_num) }}" min="0">
                    </div>
                </div>

                <button type="submit" class="btn btn-him-primary w-100 py-2">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan Album
                </button>
            </div>
        </div>

        <!-- Right: Existing Photos + Multi-Photo Upload Queue -->
        <div class="col-lg-7">
            <!-- 1. Existing Saved Photos in Album -->
            <div class="him-card mb-4">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-photo-video"></i> Foto Tersimpan di Album Ini
                    </h2>
                    <span class="badge bg-success-subtle text-success">{{ $gallery->photos->count() }} Foto</span>
                </div>

                <div class="row g-3">
                    @forelse($gallery->photos as $photo)
                        @php $isCover = ($gallery->image === $photo->image); @endphp
                        <div class="col-sm-4 col-6">
                            <div class="card h-100 border shadow-sm position-relative overflow-hidden">
                                <img src="{{ asset('storage/' . $photo->image) }}" class="card-img-top" style="height: 120px; object-fit: cover;">
                                @if($isCover)
                                    <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2 shadow-sm">
                                        <i class="fas fa-star me-1"></i> Sampul
                                    </span>
                                @endif
                                <div class="card-body p-2 d-flex flex-column justify-content-between gap-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        @if(!$isCover)
                                            <form action="{{ route('admin.galeri.setCover', $photo) }}" method="POST" class="d-inline no-double-submit">
                                                @csrf
                                                <button type="submit" class="btn btn-xs btn-outline-warning text-dark py-0 px-2" style="font-size: 0.72rem;" title="Jadikan Sampul">
                                                    <i class="far fa-star"></i> Sampul
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted" style="font-size: 0.72rem;">Sampul Utama</span>
                                        @endif

                                        <form action="{{ route('admin.galeri.destroyPhoto', $photo) }}" method="POST" class="d-inline no-double-submit" onsubmit="return confirm('Hapus foto ini dari album?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-outline-danger py-0 px-2" style="font-size: 0.72rem;" title="Hapus foto ini">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-3 text-muted small">
                            Belum ada foto tersimpan dalam album ini. Tambahkan foto di bawah ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- 2. Append More Photos Queue -->
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-plus-circle"></i> Tambah Foto Baru ke Album
                    </h2>
                    <span class="badge bg-primary-subtle text-primary" id="selectedCountBadge">0 Foto Baru</span>
                </div>

                <div class="border border-2 border-dashed rounded-4 p-4 text-center bg-light mb-3" style="cursor: pointer;" onclick="document.getElementById('multiFileInput').click()">
                    <i class="fas fa-camera-retro fs-1 text-primary opacity-75 mb-2"></i>
                    <h5 class="fw-bold text-dark mb-1">Pilih Foto Tambahan</h5>
                    <p class="text-muted small mb-2">Pilih satu atau banyak foto sekaligus untuk ditambahkan ke album ini.</p>
                    <button type="button" class="btn btn-sm btn-outline-primary px-3 rounded-pill">
                        <i class="fas fa-folder-open me-1"></i> Telusuri Foto
                    </button>
                    <input type="file" id="multiFileInput" multiple accept="image/jpeg,image/png,image/webp" style="display: none;">
                </div>

                <div id="photosQueueContainer">
                    <div class="row g-3" id="photoThumbsRow">
                        <div class="col-12 text-center py-2 text-muted small" id="emptyQueueMsg">
                            Tidak ada foto baru dalam antrean.
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
    const dt = new DataTransfer();
    const fileInput = document.getElementById('multiFileInput');
    const thumbsRow = document.getElementById('photoThumbsRow');
    const countBadge = document.getElementById('selectedCountBadge');
    const emptyMsg = document.getElementById('emptyQueueMsg');
    const form = document.getElementById('galleryAlbumEditForm');

    fileInput.addEventListener('change', function(e) {
        if (!this.files.length) return;

        for (let i = 0; i < this.files.length; i++) {
            const file = this.files[i];
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
        countBadge.textContent = `${count} Foto Baru`;

        if (count === 0) {
            emptyMsg.style.display = 'block';
            thumbsRow.appendChild(emptyMsg);
            return;
        }

        emptyMsg.style.display = 'none';

        Array.from(dt.files).forEach((file, index) => {
            const col = document.createElement('div');
            col.className = 'col-sm-4 col-6';

            const reader = new FileReader();
            reader.onload = function(e) {
                const sizeKb = (file.size / 1024).toFixed(0);
                col.innerHTML = `
                    <div class="position-relative rounded-3 overflow-hidden border shadow-sm bg-white p-1">
                        <img src="${e.target.result}" class="w-100 rounded" style="height: 100px; object-fit: cover;">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 rounded-circle py-0 px-2 shadow" title="Batalkan foto ini" onclick="removeQueuedPhoto(${index})">
                            &times;
                        </button>
                        <div class="px-1 pt-1 text-truncate small fw-semibold" title="${file.name}">${file.name}</div>
                        <div class="px-1 text-muted" style="font-size: 0.7rem;">${sizeKb} KB (Belum disimpan)</div>
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

    form.addEventListener('submit', function(e) {
        fileInput.files = dt.files;
        fileInput.name = 'photos[]';
    });
</script>
@endpush
