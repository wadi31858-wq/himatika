@extends('layouts.admin')
@section('title', 'Agenda')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Agenda</h4>
    <a href="{{ route('admin.agenda.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Tambah</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr><th>No</th><th>Judul</th><th>Tanggal</th><th>Waktu</th><th>Lokasi</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($agendas as $a)
                    <tr>
                        <td>{{ $agendas->firstItem() + $loop->index }}</td>
                        <td class="fw-bold">{{ $a->title }}</td>
                        <td>{{ $a->date->format('d M Y') }}</td>
                        <td>{{ $a->time }}</td>
                        <td>{{ $a->location }}</td>
                        <td><span class="badge-status badge-{{ $a->status === 'Selesai' ? 'selesai' : ($a->status === 'Sedang Berjalan' ? 'berjalan' : 'datang') }}">{{ $a->status }}</span></td>
                        <td>
                            <a href="{{ route('admin.agenda.edit', $a) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.agenda.destroy', $a) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $agendas->links() }}
    </div>
</div>
@endsection
