@extends('layouts.admin')

@section('title', 'Tambah Admin')
@section('page_title', 'Tambah Akun Admin Baru')
@section('page_subtitle', 'Berikan hak akses pengelolaan sistem kepada pengurus HIMATIKA')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-user-plus"></i> Formulir Akun Admin
                </h2>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Contoh: Ahmad Fauzi">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="admin@himatika.test">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+62 812-3456-7890">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required minlength="6" placeholder="Minimal 6 karakter">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required minlength="6" placeholder="Ulangi password">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Status Akun</label>
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_active" id="statusActive" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label text-dark fw-semibold" for="statusActive">
                                <i class="fas fa-check-circle text-success me-1"></i> Aktif (Dapat Login)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_active" id="statusInactive" value="0" {{ old('is_active') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label text-dark fw-semibold" for="statusInactive">
                                <i class="fas fa-ban text-secondary me-1"></i> Nonaktif (Akses Diblokir)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-him-primary px-4">
                        <i class="fas fa-save me-1"></i> Simpan Akun Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

