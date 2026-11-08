@extends('layouts.admin')

@section('title', 'Log Aktivitas')
@section('page_title', 'Audit Trail & Log Aktivitas')
@section('page_subtitle', 'Catatan riwayat seluruh tindakan administratif dan autentikasi pada sistem')

@section('content')
<div class="him-card">
    <div class="him-card-header">
        <h2 class="him-card-title">
            <i class="fas fa-history"></i> Riwayat Aktivitas Sistem
        </h2>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('admin.logs.index') }}" class="row g-2 mb-4">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari keterangan, admin, atau alamat IP..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="action" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Jenis Aksi</option>
                <option value="create" {{ request('action') === 'create' ? 'selected' : '' }}>Create (Tambah)</option>
                <option value="update" {{ request('action') === 'update' ? 'selected' : '' }}>Update (Edit)</option>
                <option value="delete" {{ request('action') === 'delete' ? 'selected' : '' }}>Delete (Hapus)</option>
                <option value="login" {{ request('action') === 'login' ? 'selected' : '' }}>Login (Masuk)</option>
                <option value="logout" {{ request('action') === 'logout' ? 'selected' : '' }}>Logout (Keluar)</option>
                <option value="status_change" {{ request('action') === 'status_change' ? 'selected' : '' }}>Perubahan Status</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-him-outline w-100">Filter</button>
        </div>
        @if(request()->hasAny(['search', 'action']))
            <div class="col-md-2">
                <a href="{{ route('admin.logs.index') }}" class="btn btn-light w-100">Reset</a>
            </div>
        @endif
    </form>

    <!-- Logs Table -->
    <div class="table-responsive">
        <table class="table table-him align-middle">
            <thead>
                <tr>
                    <th style="width: 170px;">Waktu & Tanggal</th>
                    <th style="width: 200px;">Administrator</th>
                    <th style="width: 120px;">Jenis Aksi</th>
                    <th>Deskripsi Aktivitas</th>
                    <th style="width: 140px;" class="text-end">Alamat IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td class="text-nowrap small text-muted">
                        <i class="far fa-clock me-1 text-primary"></i>
                        {{ $log->created_at->format('d M Y, H:i:s') }}
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                {{ strtoupper(substr($log->user_name ?: 'A', 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold text-dark small">{{ $log->user_name ?: 'Sistem' }}</div>
                                <div class="text-muted" style="font-size: 0.72rem;">ID: #{{ $log->user_id ?: '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @php
                            $badgeClass = match($log->action) {
                                'create' => 'bg-success-subtle text-success border border-success-subtle',
                                'update' => 'bg-primary-subtle text-primary border border-primary-subtle',
                                'delete' => 'bg-danger-subtle text-danger border border-danger-subtle',
                                'login' => 'bg-info-subtle text-info border border-info-subtle',
                                'logout' => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
                                'status_change' => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
                                default => 'bg-light text-dark'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }} text-uppercase" style="font-size: 0.72rem;">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="text-dark small">
                        {{ $log->description }}
                        @if($log->model_type && $log->model_id)
                            <div class="text-muted" style="font-size: 0.72rem;">Target: {{ class_basename($log->model_type) }} #{{ $log->model_id }}</div>
                        @endif
                    </td>
                    <td class="text-end font-monospace small text-muted">
                        {{ $log->ip_address ?: '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="fas fa-clipboard-list fs-1 d-block mb-2 text-muted"></i>
                        Tidak ada log aktivitas ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>
@endsection
