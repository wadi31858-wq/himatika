@extends('layouts.admin')

@section('title', 'Kotak Masuk Aspirasi')
@section('page_title', 'Kotak Masuk Aspirasi')
@section('page_subtitle', 'Tinjau kritik, saran, gagasan, dan pertanyaan dari mahasiswa Matematika')

@section('content')
<!-- Counts Overview -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-md-3">
        <div class="him-card p-3 text-center mb-0">
            <h3 class="mb-0 fw-bold text-dark">{{ $counts['total'] }}</h3>
            <small class="text-muted">Aspirasi Aktif</small>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="him-card p-3 text-center mb-0">
            <h3 class="mb-0 fw-bold text-danger">{{ $counts['baru'] }}</h3>
            <small class="text-muted">Status Baru</small>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="him-card p-3 text-center mb-0">
            <h3 class="mb-0 fw-bold text-primary">{{ $counts['diproses'] }}</h3>
            <small class="text-muted">Sedang Diproses</small>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="him-card p-3 text-center mb-0">
            <h3 class="mb-0 fw-bold text-success">{{ $counts['selesai'] }}</h3>
            <small class="text-muted">Selesai Ditindaklanjuti</small>
        </div>
    </div>
</div>

<div class="him-card">
    <div class="him-card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div class="d-flex align-items-center gap-2">
            <h2 class="him-card-title mb-0">
                <i class="fas fa-inbox text-primary"></i> Kotak Masuk Aspirasi
            </h2>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.aspirasi.arsip') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-archive me-1"></i> Arsip ({{ $counts['arsip'] }})
            </a>
            <a href="{{ route('admin.aspirasi.pengaturan') }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-cog me-1"></i> Pengaturan Formulir
            </a>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <form method="GET" action="{{ route('admin.aspirasi.index') }}" class="row g-2 mb-4">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari judul, nama, atau NIM..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Status Aktif</option>
                <option value="Baru" {{ request('status') === 'Baru' ? 'selected' : '' }}>Baru</option>
                <option value="Diproses" {{ request('status') === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-him-outline w-100">Filter</button>
        </div>
        @if(request()->hasAny(['search', 'status']))
            <div class="col-md-2">
                <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-light w-100">Reset</a>
            </div>
        @endif
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-him align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Pengirim</th>
                    <th>Judul Aspirasi</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Waktu Masuk</th>
                    <th class="text-end" style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aspirations as $index => $asp)
                <tr>
                    <td>{{ $aspirations->firstItem() + $index }}</td>
                    <td>
                        <div class="fw-bold text-dark">{{ $asp->name ?: 'Anonim' }}</div>
                        <small class="text-muted">{{ $asp->nim ?: 'NIM tidak dicantumkan' }}</small>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark text-truncate" style="max-width: 250px;">
                            {{ $asp->title }}
                        </div>
                        <small class="text-muted text-truncate d-block" style="max-width: 250px;">
                            {{ Str::limit($asp->message, 60) }}
                        </small>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">{{ $asp->category ?: 'Umum' }}</span>
                    </td>
                    <td>
                        @if($asp->status === 'Baru')
                            <span class="badge bg-danger-subtle text-danger">Baru</span>
                        @elseif($asp->status === 'Diproses')
                            <span class="badge bg-primary-subtle text-primary">Diproses</span>
                        @else
                            <span class="badge bg-success-subtle text-success">Selesai</span>
                        @endif
                    </td>
                    <td class="small text-muted text-nowrap">
                        {{ $asp->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('admin.aspirasi.show', $asp) }}" class="btn btn-sm btn-outline-primary" title="Tinjau & Tanggapi">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.aspirasi.archive', $asp) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Pindahkan ke Arsip" onclick="return confirm('Pindahkan aspirasi ini ke arsip?')">
                                    <i class="fas fa-archive"></i>
                                </button>
                            </form>
                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteConfirmModal" 
                                    data-action="{{ route('admin.aspirasi.destroy', $asp) }}" 
                                    data-title="Aspirasi dari {{ $asp->name }} ({{ $asp->title }})"
                                    title="Hapus Permanen">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-inbox fs-1 d-block mb-2 text-muted"></i>
                        Tidak ada data aspirasi aktif.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $aspirations->links() }}
    </div>
</div>
@endsection
