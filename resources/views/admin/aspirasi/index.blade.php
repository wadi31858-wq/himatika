@extends('layouts.admin')
@section('title', 'Kelola Aspirasi')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Aspirasi Masuk</h4>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <h3 class="mb-0 text-warning">{{ App\Models\Aspiration::where('status', 'Baru')->count() }}</h3>
            <small class="text-muted">Baru</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <h3 class="mb-0 text-info">{{ App\Models\Aspiration::where('status', 'Dibaca')->count() }}</h3>
            <small class="text-muted">Dibaca</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <h3 class="mb-0 text-primary">{{ App\Models\Aspiration::where('status', 'Diproses')->count() }}</h3>
            <small class="text-muted">Diproses</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <h3 class="mb-0 text-success">{{ App\Models\Aspiration::where('status', 'Selesai')->count() }}</h3>
            <small class="text-muted">Selesai</small>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-8">
        <form action="{{ route('admin.aspirasi.index') }}" method="GET" class="row g-2">
            <div class="col-md-7">
                <input type="text" name="search" class="form-control" placeholder="Cari nama/judul..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Baru" {{ request('status') == 'Baru' ? 'selected' : '' }}>Baru</option>
                    <option value="Dibaca" {{ request('status') == 'Dibaca' ? 'selected' : '' }}>Dibaca</option>
                    <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
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
                    <tr><th>No</th><th>Nama</th><th>NIM</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($aspirations as $a)
                    <tr>
                        <td>{{ $aspirations->firstItem() + $loop->index }}</td>
                        <td class="fw-bold">{{ $a->name }}</td>
                        <td>{{ $a->nim }}</td>
                        <td>{{ Str::limit($a->title, 40) }}</td>
                        <td><span class="badge bg-secondary">{{ $a->category }}</span></td>
                        <td>
                            <span class="badge bg-{{ $a->status === 'Selesai' ? 'success' : ($a->status === 'Diproses' ? 'primary' : ($a->status === 'Dibaca' ? 'info' : 'warning')) }}">
                                {{ $a->status }}
                            </span>
                        </td>
                        <td>{{ $a->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.aspirasi.show', $a) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                            <form action="{{ route('admin.aspirasi.destroy', $a) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-4">Belum ada aspirasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $aspirations->links() }}
    </div>
</div>
@endsection
