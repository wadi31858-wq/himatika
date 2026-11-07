@extends('layouts.admin')
@section('title', 'Detail Aspirasi')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Detail Aspirasi</h4>
    <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold"><i class="fas fa-comment-dots me-2"></i>Aspirasi</div>
            <div class="card-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-6"><strong>Nama:</strong> {{ $aspirasi->name }}</div>
                    <div class="col-md-6"><strong>NIM:</strong> {{ $aspirasi->nim ?? '-' }}</div>
                    <div class="col-md-6"><strong>Email:</strong> {{ $aspirasi->email ?? '-' }}</div>
                    <div class="col-md-6"><strong>Kategori:</strong> <span class="badge bg-secondary">{{ $aspirasi->category }}</span></div>
                    <div class="col-12"><strong>Judul:</strong> {{ $aspirasi->title }}</div>
                </div>
                <hr>
                <div class="p-3 bg-light rounded">{!! nl2br(e($aspirasi->message)) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold"><i class="fas fa-cog me-2"></i>Penanganan</div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Status:</strong>
                    <span class="badge bg-{{ $aspirasi->status === 'Selesai' ? 'success' : ($aspirasi->status === 'Diproses' ? 'primary' : ($aspirasi->status === 'Dibaca' ? 'info' : 'warning')) }} fs-6">{{ $aspirasi->status }}</span>
                </div>
                <form action="{{ route('admin.aspirasi.update', $aspirasi) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Ubah Status</label>
                        <select name="status" class="form-select" required>
                            <option value="Baru" {{ $aspirasi->status === 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option value="Dibaca" {{ $aspirasi->status === 'Dibaca' ? 'selected' : '' }}>Dibaca</option>
                            <option value="Diproses" {{ $aspirasi->status === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ $aspirasi->status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Balasan / Catatan</label>
                        <textarea name="admin_reply" class="form-control" rows="4" placeholder="Tulis balasan untuk aspirasi ini...">{{ $aspirasi->admin_reply }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save me-1"></i>Simpan</button>
                </form>
            </div>
        </div>
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-body d-grid gap-2">
                @if($aspirasi->email)
                <a href="mailto:{{ $aspirasi->email }}" class="btn btn-outline-primary"><i class="fas fa-envelope me-1"></i>Email Pendaftar</a>
                @endif
                <form action="{{ route('admin.aspirasi.destroy', $aspirasi) }}" method="POST" onsubmit="return confirm('Hapus aspirasi ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger w-100"><i class="fas fa-trash me-1"></i>Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
