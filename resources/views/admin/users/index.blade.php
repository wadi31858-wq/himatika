@extends('layouts.admin')

@section('title', 'Kelola Admin')
@section('page_title', 'Kelola Akun Administrator')
@section('page_subtitle', 'Manajemen akun yang memiliki hak akses penuh ke panel admin HIMATIKA')

@section('content')
<div class="him-card">
    <div class="him-card-header">
        <div>
            <h2 class="him-card-title">
                <i class="fas fa-user-shield"></i> Daftar Akun Admin
            </h2>
            <small class="text-muted">Total Admin Aktif: <strong>{{ $totalActive }}</strong> akun</small>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-him-primary">
            <i class="fas fa-plus"></i> Tambah Admin Baru
        </a>
    </div>

    <!-- Filter & Search Toolbar -->
    <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2 mb-4">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama, email, atau telepon..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-him-outline w-100">
                Filter
            </button>
        </div>
        @if(request()->hasAny(['search', 'status']))
            <div class="col-md-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-light w-100">Reset</a>
            </div>
        @endif
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-him align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama & Email</th>
                    <th>No. Telepon</th>
                    <th>Status Akun</th>
                    <th>Terdaftar</th>
                    <th class="text-end" style="width: 170px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $u)
                <tr>
                    <td>{{ $users->firstItem() + $index }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="admin-avatar">
                                @if($u->avatar)
                                    <img src="{{ asset('storage/' . $u->avatar) }}" alt="{{ $u->name }}">
                                @else
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <div class="fw-bold text-dark">{{ $u->name }}
                                    @if($u->id === auth()->id())
                                        <span class="badge bg-primary-subtle text-primary ms-1" style="font-size: 0.68rem;">Anda</span>
                                    @endif
                                </div>
                                <div class="small text-muted">{{ $u->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="text-dark small">{{ $u->phone ?: '-' }}</span>
                    </td>
                    <td>
                        @if($u->is_active)
                            <span class="badge bg-success-subtle text-success">
                                <i class="fas fa-check-circle me-1"></i> Aktif
                            </span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">
                                <i class="fas fa-ban me-1"></i> Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="small text-muted">
                        {{ $u->created_at->format('d M Y') }}
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            <!-- Toggle Status Button -->
                            <form action="{{ route('admin.users.toggle-status', $u) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $u->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}" 
                                        title="{{ $u->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}"
                                        {{ ($u->is_active && $totalActive <= 1) ? 'disabled title="Tidak dapat menonaktifkan admin terakhir"' : '' }}>
                                    <i class="fas {{ $u->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                </button>
                            </form>

                            <!-- Edit Button -->
                            <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-outline-primary" title="Edit Akun">
                                <i class="fas fa-pencil-alt"></i>
                            </a>

                            <!-- Delete Button (Protected for self and last active admin) -->
                            @if($u->id !== auth()->id() && !($u->is_active && $totalActive <= 1))
                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteConfirmModal" 
                                        data-action="{{ route('admin.users.destroy', $u) }}" 
                                        data-title="Akun Admin {{ $u->name }} ({{ $u->email }})"
                                        title="Hapus Akun">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            @else
                                <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="Akun ini diproteksi dari penghapusan">
                                    <i class="fas fa-lock"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        Tidak ada akun admin yang sesuai dengan pencarian.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
