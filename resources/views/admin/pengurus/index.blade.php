@extends('layouts.admin')
@section('title', 'Pengurus')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Pengurus</h4>
    <a href="{{ route('admin.pengurus.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Tambah</a>
</div>
<div class="row mb-3">
    <div class="col-md-6">
        <form action="{{ route('admin.pengurus.index') }}" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari nama/NIM..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </div>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr><th>No</th><th>Nama</th><th>NIM</th><th>Jabatan</th><th>Divisi</th><th>Periode</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($members as $m)
                    <tr>
                        <td>{{ $members->firstItem() + $loop->index }}</td>
                        <td class="fw-bold">{{ $m->name }}</td>
                        <td>{{ $m->nim }}</td>
                        <td>{{ $m->position }}</td>
                        <td>{{ $m->division }}</td>
                        <td>{{ $m->period }}</td>
                        <td>
                            <a href="{{ route('admin.pengurus.edit', $m) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.pengurus.destroy', $m) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $members->links() }}
    </div>
</div>
@endsection
