@extends('layouts.admin')
@section('title', 'Struktur Organisasi')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Struktur Organisasi</h4>
    <a href="{{ route('admin.struktur-organisasi.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Tambah</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr><th>No</th><th>Nama</th><th>Jabatan</th><th>Divisi</th><th>Atasan</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($structures as $s)
                    <tr>
                        <td>{{ $structures->firstItem() + $loop->index }}</td>
                        <td class="fw-bold">{{ $s->name }}</td>
                        <td>{{ $s->position }}</td>
                        <td>{{ $s->division }}</td>
                        <td>{{ $s->parent->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.struktur-organisasi.edit', $s) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.struktur-organisasi.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $structures->links() }}
    </div>
</div>
@endsection
