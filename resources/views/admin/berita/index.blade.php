@extends('layouts.admin')
@section('title', 'Berita')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Berita</h4>
    <a href="{{ route('admin.berita.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Tambah</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr><th>No</th><th>Judul</th><th>Kategori</th><th>Penulis</th><th>Tanggal</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($news as $n)
                    <tr>
                        <td>{{ $news->firstItem() + $loop->index }}</td>
                        <td class="fw-bold">{{ $n->title }}</td>
                        <td><span class="badge bg-primary">{{ $n->category }}</span></td>
                        <td>{{ $n->author }}</td>
                        <td>{{ $n->published_at?->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.berita.edit', $n) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.berita.destroy', $n) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $news->links() }}
    </div>
</div>
@endsection
