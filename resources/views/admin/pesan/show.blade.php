@extends('layouts.admin')
@section('title', 'Detail Pesan')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Detail Pesan</h4>
    <a href="{{ route('admin.pesan.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6"><strong>Nama:</strong> {{ $message->name }}</div>
            <div class="col-md-6"><strong>Email:</strong> {{ $message->email }}</div>
            <div class="col-md-6 mt-2"><strong>Subjek:</strong> {{ $message->subject }}</div>
            <div class="col-md-6 mt-2"><strong>Tanggal:</strong> {{ $message->created_at->format('d M Y H:i') }}</div>
        </div>
        <hr>
        <div class="p-3 bg-light rounded">
            {!! nl2br(e($message->message)) !!}
        </div>
        <div class="mt-3">
            <a href="mailto:{{ $message->email }}" class="btn btn-primary"><i class="fas fa-reply me-1"></i>Balas via Email</a>
            <form action="{{ route('admin.pesan.destroy', $message) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pesan ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger"><i class="fas fa-trash me-1"></i>Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection
