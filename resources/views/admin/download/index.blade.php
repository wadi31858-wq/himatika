@extends('layouts.admin')
@section('title', 'Download')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Download</h4>
    <a href="{{ route('admin.download.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Tambah</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr><th>No</th><th>Judul</th><th>Deskripsi</th><th>File</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($downloads as $d)
                    <tr>
                        <td>{{ $downloads->firstItem() + $loop->index }}</td>
                        <td class="fw-bold">{{ $d->title }}</td>
                        <td>{{ Str::limit($d->description, 50) }}</td>
                        <td><a href="{{ asset('storage/'.$d->file) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-download"></i></a></td>
                        <td>
                            <a href="{{ route('admin.download.edit', $d) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.download.destroy', $d) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $downloads->links() }}
    </div>
</div>
@endsection
