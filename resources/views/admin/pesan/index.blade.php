@extends('layouts.admin')

@section('title', 'Pesan Masuk')
@section('page_title', 'Kotak Masuk Pesan')
@section('page_subtitle', 'Pesan dan pertanyaan yang dikirim melalui formulir kontak website')

@section('content')
<div class="him-card">
    <div class="him-card-header">
        <h2 class="him-card-title">
            <i class="fas fa-envelope-open-text"></i> Daftar Pesan Masuk
        </h2>
    </div>

    <div class="table-responsive">
        <table class="table table-him align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Pengirim</th>
                    <th>Email</th>
                    <th>Subjek</th>
                    <th>Waktu Masuk</th>
                    <th class="text-end" style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $index => $m)
                <tr class="{{ !$m->is_read ? 'bg-primary-subtle' : '' }}">
                    <td>{{ $messages->firstItem() + $index }}</td>
                    <td class="fw-bold text-dark">
                        {{ $m->name }}
                        @if(!$m->is_read)
                            <span class="badge bg-danger ms-1" style="font-size: 0.65rem;">Baru</span>
                        @endif
                    </td>
                    <td>{{ $m->email }}</td>
                    <td class="text-dark">{{ $m->subject }}</td>
                    <td class="small text-muted text-nowrap">{{ $m->created_at->format('d M Y, H:i') }}</td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('admin.pesan.show', $m) }}" class="btn btn-sm btn-outline-primary" title="Buka Pesan">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteConfirmModal" 
                                    data-action="{{ route('admin.pesan.destroy', $m) }}" 
                                    data-title="Pesan dari {{ $m->name }}"
                                    title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-envelope-open fs-1 d-block mb-2 text-muted"></i>
                        Tidak ada pesan masuk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $messages->links() }}
    </div>
</div>
@endsection
