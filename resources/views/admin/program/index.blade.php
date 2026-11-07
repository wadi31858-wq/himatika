@extends('layouts.admin')
@section('title', 'Program Kerja')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Program Kerja</h4>
    <a href="{{ route('admin.program-kerja.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Tambah</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr><th>No</th><th>Judul</th><th>Divisi</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($programs as $p)
                    <tr>
                        <td>{{ $programs->firstItem() + $loop->index }}</td>
                        <td class="fw-bold">{{ $p->title }}</td>
                        <td>{{ $p->division }}</td>
                        <td>{{ $p->date?->format('d M Y') }}</td>
                        <td><span class="badge-status badge-{{ $p->status === 'Selesai' ? 'selesai' : ($p->status === 'Sedang Berjalan' ? 'berjalan' : 'datang') }}">{{ $p->status }}</span></td>
                        <td>
                            <a href="{{ route('admin.program-kerja.edit', $p) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.program-kerja.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $programs->links() }}
    </div>
</div>
@endsection
