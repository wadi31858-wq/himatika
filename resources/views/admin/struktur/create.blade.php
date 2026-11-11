@extends('layouts.admin')

@section('title', 'Tambah Struktur')
@section('page_title', 'Tambah Posisi Struktur Organisasi')
@section('page_subtitle', 'Tambahkan jabatan pimpinan atau divisi dalam bagan organisasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-sitemap"></i> Formulir Struktur Organisasi
                </h2>
                <a href="{{ route('admin.struktur-organisasi.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.struktur-organisasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nama Pejabat / Pemegang Amanah <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Contoh: Muhammad Ilham">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nama Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="position" class="form-control" value="{{ old('position') }}" required placeholder="Contoh: Ketua Umum Putra, Sekretaris Putri, Kepala Divisi Kominfo">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Kelompok Kepengurusan <span class="text-danger">*</span></label>
                        <select name="kelompok" class="form-select" required>
                            <option value="putra" {{ old('kelompok') === 'putra' ? 'selected' : '' }}>Putra</option>
                            <option value="putri" {{ old('kelompok') === 'putri' ? 'selected' : '' }}>Putri</option>
                            <option value="semua" {{ old('kelompok', 'semua') === 'semua' ? 'selected' : '' }}>Semua / Umum (Pembina/Biro Bersama)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Bidang / Divisi</label>
                        <input type="text" name="division" class="form-control" value="{{ old('division') }}" placeholder="Contoh: BPH, Kominfo, Keilmuan, PSDM">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Atasan Langsung (Induk Hirarki)</label>
                        <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                            <option value="">-- Pimpinan Puncak / Tanpa Atasan --</option>
                            @foreach($parents as $p)
                                <option value="{{ $p->id }}" {{ old('parent_id') == $p->id ? 'selected' : '' }}>{{ $p->position }} - {{ $p->name }} [{{ ucfirst($p->kelompok) }}]</option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Periode Kepengurusan</label>
                        <input type="text" name="period" class="form-control" value="{{ old('period', '2026/2027') }}" placeholder="2026/2027">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Urutan Tampilan</label>
                        <input type="number" name="order_num" class="form-control" value="{{ old('order_num', 0) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Status</label>
                        <select name="is_active" class="form-select" required>
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Foto Profil Pejabat (Opsional)</label>
                    <input type="file" name="photo" id="photoInput" class="form-control @error('photo') is-invalid @enderror" accept="image/png,image/jpeg,image/webp">
                    <div class="form-text">Maksimal 3 MB (JPG, PNG, WebP).</div>
                    @error('photo')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    <div id="photoPreviewBox" class="mt-2 d-none">
                        <img id="photoPreviewImg" src="" alt="Preview" class="rounded border p-1" style="max-height: 140px; object-fit: contain;">
                        <div class="small text-muted mt-1">Pratinjau Foto Profil</div>
                    </div>
                </div>

                {{-- Khusus Divisi / Bidang: Foto Bersama Anggota --}}
                <div class="p-3 mb-3 rounded-3 border" style="background: #faf8f9; border-color: #E9CDD5 !important;">
                    <div class="fw-bold text-dark mb-1 d-flex align-items-center justify-content-between">
                        <span><i class="fas fa-users-rectangle text-primary me-1"></i> Foto Bersama (Untuk Kartu Divisi)</span>
                        <span class="badge bg-secondary-subtle text-secondary small">Opsional</span>
                    </div>
                    <p class="text-muted small mb-3">Foto satu kelompok seluruh anggota divisi bersama-sama yang tampil di sebelah kiri kartu divisi.</p>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-dark">Foto Bersama (Putra / Utama)</label>
                            <input type="file" name="group_photo" id="groupPhotoInput" class="form-control form-control-sm @error('group_photo') is-invalid @enderror" accept="image/png,image/jpeg,image/webp">
                            <div class="form-text small">Format JPG, PNG, WebP. Maks 5 MB.</div>
                            <div id="groupPhotoError" class="text-danger small mt-1 d-none"></div>
                            @error('group_photo')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div id="groupPhotoPreviewBox" class="mt-2 d-none">
                                <img id="groupPhotoPreviewImg" src="" alt="Preview Foto Bersama" class="rounded border p-1 w-100" style="max-height: 160px; object-fit: cover;">
                                <div class="small text-muted mt-1">Pratinjau Foto Bersama</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-dark">Foto Bersama (Kelompok Putri - Opsional)</label>
                            <input type="file" name="group_photo_putri" id="groupPhotoPutriInput" class="form-control form-control-sm @error('group_photo_putri') is-invalid @enderror" accept="image/png,image/jpeg,image/webp">
                            <div class="form-text small">Khusus tab Putri jika ada foto terpisah. Maks 5 MB.</div>
                            <div id="groupPhotoPutriError" class="text-danger small mt-1 d-none"></div>
                            @error('group_photo_putri')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div id="groupPhotoPutriPreviewBox" class="mt-2 d-none">
                                <img id="groupPhotoPutriPreviewImg" src="" alt="Preview Foto Bersama Putri" class="rounded border p-1 w-100" style="max-height: 160px; object-fit: cover;">
                                <div class="small text-muted mt-1">Pratinjau Foto Bersama Putri</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Keterangan / Tugas Pokok</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Tupoksi singkat jabatan ini...">{{ old('description') }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.struktur-organisasi.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-him-primary px-4">
                        <i class="fas fa-save me-1"></i> Simpan Posisi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function setupImagePreview(inputId, boxId, imgId, errorId, maxMb) {
        const input = document.getElementById(inputId);
        const box = document.getElementById(boxId);
        const img = document.getElementById(imgId);
        const err = errorId ? document.getElementById(errorId) : null;
        if (!input || !box || !img) return;

        input.addEventListener('change', function() {
            if (err) {
                err.textContent = '';
                err.classList.add('d-none');
            }
            const file = this.files && this.files[0];
            if (!file) {
                box.classList.add('d-none');
                img.src = '';
                return;
            }

            // Validasi ukuran
            if (maxMb && file.size > maxMb * 1024 * 1024) {
                if (err) {
                    err.textContent = `Ukuran file melebihi batas maksimal ${maxMb} MB (${(file.size / (1024*1024)).toFixed(1)} MB).`;
                    err.classList.remove('d-none');
                }
                this.value = '';
                box.classList.add('d-none');
                img.src = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                box.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        });
    }

    setupImagePreview('photoInput', 'photoPreviewBox', 'photoPreviewImg', null, 3);
    setupImagePreview('groupPhotoInput', 'groupPhotoPreviewBox', 'groupPhotoPreviewImg', 'groupPhotoError', 5);
    setupImagePreview('groupPhotoPutriInput', 'groupPhotoPutriPreviewBox', 'groupPhotoPutriPreviewImg', 'groupPhotoPutriError', 5);
});
</script>
@endpush
@endsection
