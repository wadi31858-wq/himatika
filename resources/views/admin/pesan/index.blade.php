@extends('layouts.admin')
@section('title', 'Pesan')
@section('content')
<h4 class="fw-bold mb-4">Pesan Masuk</h4>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr><th>No</th><th>Nama</th><th>Email</th><th>Subjek</th><th>Tanggal</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($messages as $m)
                    <tr class="{{ !$m->is_read ? 'table-warning' : '' }}">
                        <td>{{ $messages->firstItem() + $loop->index }}</td>
                        <td class="fw-bold">{{ $m->name }}</td>
                        <td>{{ $m->email }}</td>
                        <td>{{ $m->subject }}</td>
                        <td>{{ $m->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.pesan.show', $m) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                            <form action="{{ route('admin.pesan.destroy', $m) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Tidak ada pesan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $messages->links() }}
    </div>
</div>
@endsection
