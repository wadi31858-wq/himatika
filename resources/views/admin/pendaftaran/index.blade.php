@extends('layouts.admin')

@section('title', 'Pendaftaran Anggota')
@section('page_title', 'Kelola Pendaftaran Anggota')
@section('page_subtitle', 'Tinjau formulir pendaftaran calon pengurus dan anggota baru HIMATIKA')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-md-3">
        <div class="him-card p-3 text-center mb-0">
            <h3 class="mb-0 fw-bold text-dark">{{ App\Models\Registration::count() }}</h3>
            <small class="text-muted">Total Pendaftar</small>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="him-card p-3 text-center mb-0">
            <h3 class="mb-0 fw-bold text-warning">{{ App\Models\Registration::where('status', 'Menunggu')->count() }}</h3>
            <small class="text-muted">Menunggu Review</small>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="him-card p-3 text-center mb-0">
            <h3 class="mb-0 fw-bold text-success">{{ App\Models\Registration::where('status', 'Diterima')->count() }}</h3>
            <small class="text-muted">Diterima</small>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="him-card p-3 text-center mb-0">
            <h3 class="mb-0 fw-bold text-danger">{{ App\Models\Registration::where('status', 'Ditolak')->count() }}</h3>
            <small class="text-muted">Ditolak</small>
        </div>
    </div>
</div>

<div class="him-card">
    <div class="him-card-header">
        <h2 class="him-card-title">
            <i class="fas fa-user-plus"></i> Berkas Pendaftaran Masuk
        </h2>
    </div>

    <!-- Filter & Search Toolbar -->
    <form action="{{ route('admin.pendaftaran.index') }}" method="GET" class="row g-2 mb-4">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama atau NIM pendaftar..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-him-outline w-100">Filter</button>
        </div>
        @if(request()->hasAny(['search', 'status']))
            <div class="col-md-2">
                <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-light w-100">Reset</a>
            </div>
        @endif
    </form>

    <div class="table-responsive">
        <table class="table table-him align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama & NIM</th>
                    <th>Pilihan Divisi</th>
                    <th>Kontak (WA / Email)</th>
                    <th>Status</th>
                    <th>Tanggal Daftar</th>
                    <th class="text-end" style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $index => $reg)
                <tr>
                    <td>{{ $registrations->firstItem() + $index }}</td>
                    <td>
                        <div class="fw-bold text-dark">{{ $reg->name }}</div>
                        <small class="text-muted font-monospace">{{ $reg->nim }}</small>
                    </td>
                    <td>
                        <span class="badge bg-primary-subtle text-primary">{{ $reg->division_choice_1 ?: '-' }}</span>
                        @if($reg->division_choice_2)
                            <span class="badge bg-light text-dark border">{{ $reg->division_choice_2 }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="small text-dark">{{ $reg->whatsapp ?: '-' }}</div>
                        <small class="text-muted">{{ $reg->email ?: '-' }}</small>
                    </td>
                    <td>
                        @if($reg->status === 'Menunggu')
                            <span class="badge bg-warning-subtle text-warning-emphasis">Menunggu</span>
                        @elseif($reg->status === 'Diterima')
                            <span class="badge bg-success-subtle text-success">Diterima</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger">Ditolak</span>
                        @endif
                    </td>
                    <td class="small text-muted text-nowrap">
                        {{ $reg->created_at->format('d M Y') }}
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('admin.pendaftaran.show', $reg) }}" class="btn btn-sm btn-outline-primary" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteConfirmModal" 
                                    data-action="{{ route('admin.pendaftaran.destroy', $reg) }}" 
                                    data-title="Pendaftaran: {{ $reg->name }}"
                                    title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-inbox fs-1 d-block mb-2 text-muted"></i>
                        Tidak ada berkas pendaftaran ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $registrations->links() }}
    </div>
</div>
@endsection
