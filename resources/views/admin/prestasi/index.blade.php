@extends('layouts.admin')
@section('title', 'Prestasi')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Prestasi</h4>
    <a href="{{ route('admin.prestasi.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Tambah</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr><th>No</th><th>Judul</th><th>Peraih</th><th>Kategori</th><th>Tingkat</th><th>Tahun</th><th>Juara</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($achievements as $a)
                    <tr>
                        <td>{{ $achievements->firstItem() + $loop->index }}</td>
                        <td class="fw-bold">{{ $a->title }}</td>
                        <td>{{ $a->participant }}</td>
                        <td>{{ $a->category }}</td>
                        <td>{{ $a->level }}</td>
                        <td>{{ $a->year }}</td>
                        <td><span class="badge bg-warning text-dark">{{ $a->rank }}</span></td>
                        <td>
                            <a href="{{ route('admin.prestasi.edit', $a) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.prestasi.destroy', $a) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $achievements->links() }}
    </div>
</div>
@endsection
