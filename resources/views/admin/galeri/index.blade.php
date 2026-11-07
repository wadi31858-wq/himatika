@extends('layouts.admin')
@section('title', 'Galeri')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Galeri</h4>
    <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Tambah</a>
</div>
<div class="row g-3">
    @forelse($galleries as $g)
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <img src="{{ asset('storage/'.$g->image) }}" alt="{{ $g->title }}" class="card-img-top" style="height:180px;object-fit:cover;">
            <div class="card-body p-2">
                <h6 class="card-title mb-1">{{ $g->title }}</h6>
                @if($g->activity)<small class="text-muted">{{ $g->activity->title }}</small>@endif
            </div>
            <div class="card-footer bg-transparent border-0 p-2 d-flex justify-content-end gap-1">
                <a href="{{ route('admin.galeri.edit', $g) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                <form action="{{ route('admin.galeri.destroy', $g) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5"><i class="fas fa-images fa-3x text-muted mb-3"></i><p class="text-muted">Belum ada foto.</p></div>
    @endforelse
</div>
<div class="mt-3">{{ $galleries->links() }}</div>
@endsection
