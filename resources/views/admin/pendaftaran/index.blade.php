@extends('layouts.admin')
@section('title', 'Kelola Pendaftaran')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Pendaftaran Pengurus Baru</h4>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <h3 class="mb-0 text-primary">{{ App\Models\Registration::where('status', 'Menunggu')->count() }}</h3>
            <small class="text-muted">Menunggu</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <h3 class="mb-0 text-success">{{ App\Models\Registration::where('status', 'Diterima')->count() }}</h3>
            <small class="text-muted">Diterima</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <h3 class="mb-0 text-danger">{{ App\Models\Registration::where('status', 'Ditolak')->count() }}</h3>
            <small class="text-muted">Ditolak</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <h3 class="mb-0 text-secondary">{{ App\Models\Registration::count() }}</h3>
            <small class="text-muted">Total</small>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <form action="{{ route('admin.pendaftaran.index') }}" method="GET" class="row g-2">
            <div class="col-md-7">
                <input type="text" name="search" class="form-control" placeholder="Cari nama/NIM..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Email</th>
                        <th>Prodi</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $r)
                    <tr>
                        <td>{{ $registrations->firstItem() + $loop->index }}</td>
                        <td class="fw-bold">{{ $r->name }}</td>
                        <td>{{ $r->nim }}</td>
                        <td>{{ $r->email }}</td>
                        <td>{{ $r->study_program }}</td>
                        <td>{{ $r->semester }}</td>
                        <td>
                            @if($r->status === 'Diterima')
                            <span class="badge bg-success">Diterima</span>
                            @elseif($r->status === 'Ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                            @else
                            <span class="badge bg-warning text-dark">Menunggu</span>
                            @endif
                        </td>
                        <td>{{ $r->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.pendaftaran.show', $r) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                            <form action="{{ route('admin.pendaftaran.destroy', $r) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center py-4">Belum ada pendaftaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $registrations->links() }}
    </div>
</div>
@endsection
