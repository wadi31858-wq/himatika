@extends('layouts.admin')

@section('title', 'Agenda')
@section('page_title', 'Kelola Agenda Kegiatan')
@section('page_subtitle', 'Jadwal acara, seminar, kompetisi, dan program kerja HIMATIKA')

@section('content')
<div class="him-card">
    <div class="him-card-header">
        <div>
            <h2 class="him-card-title">
                <i class="fas fa-calendar-alt"></i> Daftar Agenda Kegiatan
            </h2>
            <div class="d-flex gap-2 mt-1">
                <span class="badge bg-success-subtle text-success">{{ $counts['published'] }} Terbit</span>
                <span class="badge bg-warning-subtle text-warning-emphasis">{{ $counts['draft'] }} Draft</span>
                <span class="badge bg-light text-muted">Total: {{ $counts['total'] }}</span>
            </div>
        </div>
        <a href="{{ route('admin.agenda.create') }}" class="btn btn-him-primary">
            <i class="fas fa-plus"></i> Tambah Agenda Baru
        </a>
    </div>

    <!-- Filter & Search Toolbar -->
    <form method="GET" action="{{ route('admin.agenda.index') }}" class="row g-2 mb-4">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari judul atau lokasi..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Tahapan Acara</option>
                <option value="Akan Datang" {{ request('status') === 'Akan Datang' ? 'selected' : '' }}>Akan Datang</option>
                <option value="Berlangsung" {{ request('status') === 'Berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="pub_status" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Publikasi</option>
                <option value="published" {{ request('pub_status') === 'published' ? 'selected' : '' }}>Terbit (Published)</option>
                <option value="draft" {{ request('pub_status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-him-outline w-100">Filter</button>
        </div>
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-him align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Judul Agenda</th>
                    <th>Tanggal & Waktu</th>
                    <th>Lokasi</th>
                    <th>Tahapan</th>
                    <th>Publikasi</th>
                    <th class="text-end" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($agendas as $index => $a)
                <tr>
                    <td>{{ $agendas->firstItem() + $index }}</td>
                    <td>
                        <div class="fw-bold text-dark">{{ $a->title }}</div>
                        @if($a->registration_link)
                            <small><a href="{{ $a->registration_link }}" target="_blank" class="text-primary text-decoration-none"><i class="fas fa-link me-1"></i>Link Pendaftaran</a></small>
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold text-dark"><i class="far fa-calendar me-1 text-primary"></i>{{ $a->date->format('d M Y') }}</div>
                        <small class="text-muted"><i class="far fa-clock me-1"></i>{{ $a->time ?: '-' }}</small>
                    </td>
                    <td>
                        <span class="text-dark small"><i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $a->location ?: '-' }}</span>
                    </td>
                    <td>
                        @php
                            $stClass = match($a->status) {
                                'Akan Datang' => 'bg-info-subtle text-info',
                                'Berlangsung' => 'bg-primary-subtle text-primary',
                                'Selesai' => 'bg-secondary-subtle text-secondary',
                                default => 'bg-light text-dark'
                            };
                        @endphp
                        <span class="badge {{ $stClass }}">{{ $a->status }}</span>
                    </td>
                    <td>
                        @if($a->pub_status === 'published')
                            <span class="badge-status-published">Terbit</span>
                        @else
                            <span class="badge-status-draft">Draft</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('admin.agenda.edit', $a) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteConfirmModal" 
                                    data-action="{{ route('admin.agenda.destroy', $a) }}" 
                                    data-title="Agenda: {{ $a->title }}"
                                    title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-calendar-times fs-1 d-block mb-2 text-muted"></i>
                        Tidak ada agenda ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $agendas->links() }}
    </div>
</div>
@endsection
