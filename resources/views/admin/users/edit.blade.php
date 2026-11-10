@extends('layouts.admin')

@section('title', 'Edit Admin')
@section('page_title', 'Perbarui Akun Administrator')
@section('page_subtitle', 'Edit data akun, atur password baru, atau ubah status keaktifan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-user-edit"></i> Edit Akun: {{ $user->name }}
                </h2>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="+62 812-3456-7890">
                    </div>
                </div>

                <div class="p-3 mb-3 rounded-3 bg-light border">
                    <div class="fw-semibold text-dark mb-1">
                        <i class="fas fa-key text-primary me-1"></i> Ubah Password (Opsional)
                    </div>
                    <div class="small text-muted mb-3">Biarkan kolom password kosong jika tidak ingin mengubah password lama.</div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark">Password Baru</label>
                            <input type="password" name="password" class="form-control" minlength="6" placeholder="Ketik password baru">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" minlength="6" placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Status Akun</label>
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_active" id="statusActive" value="1" {{ old('is_active', $user->is_active ? '1' : '0') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label text-dark fw-semibold" for="statusActive">
                                <i class="fas fa-check-circle text-success me-1"></i> Aktif (Dapat Login)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_active" id="statusInactive" value="0" {{ old('is_active', $user->is_active ? '1' : '0') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label text-dark fw-semibold" for="statusInactive">
                                <i class="fas fa-ban text-secondary me-1"></i> Nonaktif (Akses Diblokir)
                            </label>
                        </div>
                    </div>
                    <div class="form-text text-muted">Akun admin terakhir yang aktif tidak dapat dinonaktifkan demi keamanan akses sistem.</div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-him-primary px-4">
                        <i class="fas fa-save me-1"></i> Perbarui Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

