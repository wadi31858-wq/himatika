@extends('layouts.admin')
@section('title', 'Detail Pendaftaran')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Detail Pendaftaran</h4>
    <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold"><i class="fas fa-user me-2"></i>Data Diri</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Nama Lengkap</strong>
                        <p>{{ $registration->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>NIM</strong>
                        <p>{{ $registration->nim }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Email</strong>
                        <p>{{ $registration->email }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>No. WhatsApp</strong>
                        <p>{{ $registration->phone ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Jenis Kelamin</strong>
                        <p>{{ $registration->gender ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tempat, Tanggal Lahir</strong>
                        <p>{{ $registration->place_of_birth ?? '-' }}, {{ $registration->date_of_birth?->format('d M Y') ?? '-' }}</p>
                    </div>
                    <div class="col-12">
                        <strong>Alamat</strong>
                        <p>{{ $registration->address ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white fw-bold"><i class="fas fa-graduation-cap me-2"></i>Data Akademik</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Program Studi</strong>
                        <p>{{ $registration->study_program ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Semester</strong>
                        <p>{{ $registration->semester ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white fw-bold"><i class="fas fa-file-alt me-2"></i>Motivasi & Pengalaman</div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Alasan Bergabung</strong>
                    <p class="mt-1">{{ $registration->reason }}</p>
                </div>
                <div class="mb-3">
                    <strong>Pengalaman Organisasi</strong>
                    <p class="mt-1">{{ $registration->experience ?? '-' }}</p>
                </div>
                <div>
                    <strong>Keahlian</strong>
                    <p class="mt-1">{{ $registration->skills ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold"><i class="fas fa-camera me-2"></i>Foto</div>
            <div class="card-body text-center">
                @if($registration->photo)
                <img src="{{ asset('storage/'.$registration->photo) }}" alt="Foto" class="img-fluid rounded" style="max-height:300px;">
                @else
                <div class="py-5 text-muted"><i class="fas fa-user-circle fa-5x"></i><p>Tidak ada foto</p></div>
                @endif
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white fw-bold"><i class="fas fa-cog me-2"></i>Keputusan</div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Status Saat Ini:</strong>
                    @if($registration->status === 'Diterima')
                    <span class="badge bg-success fs-6">Diterima</span>
                    @elseif($registration->status === 'Ditolak')
                    <span class="badge bg-danger fs-6">Ditolak</span>
                    @else
                    <span class="badge bg-warning text-dark fs-6">Menunggu</span>
                    @endif
                </div>

                <form action="{{ route('admin.pendaftaran.update', $registration) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Ubah Status</label>
                        <select name="status" class="form-select" required>
                            <option value="Menunggu" {{ $registration->status === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Diterima" {{ $registration->status === 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="Ditolak" {{ $registration->status === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan Admin</label>
                        <textarea name="admin_notes" class="form-control" rows="3">{{ $registration->admin_notes }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save me-1"></i>Simpan Keputusan</button>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
                <div class="d-grid">
                    <a href="mailto:{{ $registration->email }}" class="btn btn-outline-primary mb-2"><i class="fas fa-envelope me-1"></i>Email Pendaftar</a>
                    @if($registration->phone)
                    <a href="https://wa.me/{{ $registration->phone }}" target="_blank" class="btn btn-outline-success"><i class="fab fa-whatsapp me-1"></i>WhatsApp</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
