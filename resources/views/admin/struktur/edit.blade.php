@extends('layouts.admin')

@section('title', 'Edit Struktur')
@section('page_title', 'Perbarui Posisi Struktur Organisasi')
@section('page_subtitle', 'Edit jabatan, atasan hirarki, urutan, atau foto pejabat')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-edit"></i> Edit: {{ $struktur->position }} ({{ $struktur->name }})
                </h2>
                <a href="{{ route('admin.struktur-organisasi.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.struktur-organisasi.update', $struktur) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nama Pejabat <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $struktur->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nama Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="position" class="form-control" value="{{ old('position', $struktur->position) }}" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Kelompok Kepengurusan <span class="text-danger">*</span></label>
                        <select name="kelompok" class="form-select" required>
                            <option value="putra" {{ old('kelompok', $struktur->kelompok) === 'putra' ? 'selected' : '' }}>Putra</option>
                            <option value="putri" {{ old('kelompok', $struktur->kelompok) === 'putri' ? 'selected' : '' }}>Putri</option>
                            <option value="semua" {{ old('kelompok', $struktur->kelompok) === 'semua' ? 'selected' : '' }}>Semua / Umum (Pembina/Biro Bersama)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Bidang / Divisi</label>
                        <input type="text" name="division" class="form-control" value="{{ old('division', $struktur->division) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Atasan Langsung (Induk Hirarki)</label>
                        <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                            <option value="">-- Pimpinan Puncak / Tanpa Atasan --</option>
                            @foreach($parents as $p)
                                <option value="{{ $p->id }}" {{ old('parent_id', $struktur->parent_id) == $p->id ? 'selected' : '' }}>{{ $p->position }} - {{ $p->name }} [{{ ucfirst($p->kelompok) }}]</option>
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
                        <input type="text" name="period" class="form-control" value="{{ old('period', $struktur->period) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Urutan Tampilan</label>
                        <input type="number" name="order_num" class="form-control" value="{{ old('order_num', $struktur->order_num ?? 0) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Status</label>
                        <select name="is_active" class="form-select" required>
                            <option value="1" {{ old('is_active', $struktur->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active', $struktur->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    @if($struktur->photo)
                        <div class="rounded-3 overflow-hidden border mb-2 text-center bg-light" style="max-height: 180px;">
                            <img src="{{ asset('storage/' . $struktur->photo) }}" alt="{{ $struktur->name }}" class="img-fluid" style="max-height: 180px; object-fit: contain;">
                            <div class="small text-muted p-1">Foto aktif saat ini</div>
                        </div>
                    @endif
                    <label class="form-label fw-semibold text-dark">Ganti Foto Pejabat / Pimpinan (Opsional)</label>
                    <input type="file" name="photo" id="photoInput" class="form-control @error('photo') is-invalid @enderror" accept="image/png,image/jpeg,image/webp">
                    <div class="form-text small">Foto profil individu pejabat/pimpinan (Maks 3 MB). Biarkan kosong jika tidak ingin mengganti.</div>
                    @error('photo')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    <div id="photoPreviewBox" class="mt-2 d-none">
                        <img id="photoPreviewImg" src="" alt="Pratinjau Baru" class="rounded border p-1" style="max-height: 140px; object-fit: contain;">
                        <div class="small text-success mt-1"><i class="fas fa-check-circle me-1"></i> Pratinjau foto baru (belum disimpan)</div>
                    </div>
                </div>

                {{-- Khusus Divisi / Bidang: Foto Bersama Anggota --}}
                <div class="p-3 mb-3 rounded-3 border" style="background: #faf8f9; border-color: #E9CDD5 !important;">
                    <div class="fw-bold text-dark mb-1 d-flex align-items-center justify-content-between">
                        <span><i class="fas fa-users-rectangle text-primary me-1"></i> Foto Bersama (Untuk Kartu Divisi)</span>
                        <span class="badge bg-secondary-subtle text-secondary small">Opsional</span>
                    </div>
                    <p class="text-muted small mb-3">Foto seluruh anggota divisi bersama-sama yang tampil di sebelah kiri kartu divisi.</p>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-dark">Foto Bersama (Putra / Utama)</label>
                            @if($struktur->group_photo)
                                <div class="rounded-3 overflow-hidden border mb-2 text-center bg-white" style="max-height: 130px;">
                                    <img src="{{ asset('storage/' . $struktur->group_photo) }}" alt="Foto Bersama" class="img-fluid" style="max-height: 130px; object-fit: cover; width: 100%;">
                                    <div class="small text-muted py-1 bg-light">Foto bersama saat ini</div>
                                </div>
                            @endif
                            <input type="file" name="group_photo" id="groupPhotoInput" class="form-control form-control-sm @error('group_photo') is-invalid @enderror" accept="image/png,image/jpeg,image/webp">
                            <div class="form-text small">Format JPG, PNG, WebP. Maks 5 MB. Biarkan kosong jika tidak ingin mengganti.</div>
                            <div id="groupPhotoError" class="text-danger small mt-1 d-none"></div>
                            @error('group_photo')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div id="groupPhotoPreviewBox" class="mt-2 d-none">
                                <img id="groupPhotoPreviewImg" src="" alt="Pratinjau Foto Bersama" class="rounded border p-1 w-100" style="max-height: 150px; object-fit: cover;">
                                <div class="small text-success mt-1"><i class="fas fa-check-circle me-1"></i> Pratinjau foto bersama baru (belum disimpan)</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-dark">Foto Bersama (Kelompok Putri - Opsional)</label>
                            @if($struktur->group_photo_putri)
                                <div class="rounded-3 overflow-hidden border mb-2 text-center bg-white" style="max-height: 130px;">
                                    <img src="{{ asset('storage/' . $struktur->group_photo_putri) }}" alt="Foto Bersama Putri" class="img-fluid" style="max-height: 130px; object-fit: cover; width: 100%;">
                                    <div class="small text-muted py-1 bg-light">Foto bersama putri saat ini</div>
                                </div>
                            @endif
                            <input type="file" name="group_photo_putri" id="groupPhotoPutriInput" class="form-control form-control-sm @error('group_photo_putri') is-invalid @enderror" accept="image/png,image/jpeg,image/webp">
                            <div class="form-text small">Tampil khusus tab Putri jika berbeda. Maks 5 MB.</div>
                            <div id="groupPhotoPutriError" class="text-danger small mt-1 d-none"></div>
                            @error('group_photo_putri')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div id="groupPhotoPutriPreviewBox" class="mt-2 d-none">
                                <img id="groupPhotoPutriPreviewImg" src="" alt="Pratinjau Foto Bersama Putri" class="rounded border p-1 w-100" style="max-height: 150px; object-fit: cover;">
                                <div class="small text-success mt-1"><i class="fas fa-check-circle me-1"></i> Pratinjau foto bersama putri baru</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Keterangan / Tugas Pokok</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $struktur->description) }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.struktur-organisasi.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-him-primary px-4">
                        <i class="fas fa-save me-1"></i> Perbarui Posisi
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
