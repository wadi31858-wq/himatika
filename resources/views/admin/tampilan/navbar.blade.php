@extends('layouts.admin')

@section('title', 'Kelola Menu Navbar')
@section('page_title', 'Kelola Menu & Submenu Navbar')
@section('page_subtitle', 'Atur susunan navigasi utama, tautan, dropdown submenu, dan status aktif')

@section('content')
<div class="row g-4">
    <!-- Left: Menus List -->
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="him-card-title mb-0">
                        <i class="fas fa-bars text-primary"></i> Struktur Menu Navigasi
                    </h2>
                    <small class="text-muted">Total menu utama: <strong>{{ $menus->count() }}</strong></small>
                </div>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-info">
                    <i class="fas fa-external-link-alt me-1"></i> Pratinjau Website
                </a>
            </div>

            <div class="list-group list-group-flush">
                @forelse($menus as $menu)
                <div class="list-group-item p-3 border rounded-3 mb-2 bg-light">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white p-2 rounded border text-primary" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                <i class="{{ $menu->icon ?: 'fas fa-link' }}"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">
                                    {{ $menu->label }}
                                    @if($menu->children->isNotEmpty())
                                        <span class="badge bg-primary-subtle text-primary ms-1">Dropdown ({{ $menu->children->count() }} submenu)</span>
                                    @endif
                                </div>
                                <div class="small text-muted font-monospace">{{ $menu->url }}</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <span class="badge {{ $menu->is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                {{ $menu->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editMenuModal{{ $menu->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('admin.tampilan.navbar.destroy', $menu) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus menu ini beserta seluruh submenunya?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Submenus list if any -->
                    @if($menu->children->isNotEmpty())
                    <div class="mt-3 ps-4 border-start border-2 border-primary">
                        <div class="small fw-semibold text-muted mb-2">Daftar Submenu:</div>
                        @foreach($menu->children as $sub)
                        <div class="d-flex align-items-center justify-content-between p-2 bg-white rounded border mb-1">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-level-up-alt fa-rotate-90 text-muted small"></i>
                                <span class="fw-semibold text-dark small">{{ $sub->label }}</span>
                                <span class="text-muted small font-monospace">({{ $sub->url }})</span>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <button type="button" class="btn btn-sm btn-link text-primary p-0 px-1" data-bs-toggle="modal" data-bs-target="#editMenuModal{{ $sub->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.tampilan.navbar.destroy', $sub) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus submenu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0 px-1">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Edit Modal Submenu -->
                        <div class="modal fade" id="editMenuModal{{ $sub->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.tampilan.navbar.update', $sub) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Submenu: {{ $sub->label }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Label Submenu</label>
                                                <input type="text" name="label" class="form-control" value="{{ $sub->label }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">URL / Rute</label>
                                                <input type="text" name="url" class="form-control" value="{{ $sub->url }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Menu Induk (Parent)</label>
                                                <select name="parent_id" class="form-select">
                                                    @foreach($menus as $p)
                                                        <option value="{{ $p->id }}" {{ $sub->parent_id == $p->id ? 'selected' : '' }}>{{ $p->label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="row g-2 mb-3">
                                                <div class="col-6">
                                                    <label class="form-label fw-semibold">Urutan</label>
                                                    <input type="number" name="order_num" class="form-control" value="{{ $sub->order_num }}">
                                                </div>
                                                <div class="col-6 d-flex align-items-end">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeSub{{ $sub->id }}" {{ $sub->is_active ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="activeSub{{ $sub->id }}">Aktifkan</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Edit Modal Parent Menu -->
                <div class="modal fade" id="editMenuModal{{ $menu->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.tampilan.navbar.update', $menu) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Menu: {{ $menu->label }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Label Menu</label>
                                        <input type="text" name="label" class="form-control" value="{{ $menu->label }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">URL / Rute Tautan</label>
                                        <input type="text" name="url" class="form-control" value="{{ $menu->url }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Kelas Ikon FontAwesome</label>
                                        <input type="text" name="icon" class="form-control" value="{{ $menu->icon }}" placeholder="fas fa-home">
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <label class="form-label fw-semibold">Urutan</label>
                                            <input type="number" name="order_num" class="form-control" value="{{ $menu->order_num }}">
                                        </div>
                                        <div class="col-6 d-flex align-items-end">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeMenu{{ $menu->id }}" {{ $menu->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label" for="activeMenu{{ $menu->id }}">Aktifkan</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-bars fs-1 mb-2 d-block text-muted"></i>
                    Belum ada menu navbar yang tersimpan.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right: Add Menu Form -->
    <div class="col-lg-4">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-plus-circle text-primary"></i> Tambah Item Menu
                </h2>
            </div>

            <form action="{{ route('admin.tampilan.navbar.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Label Menu <span class="text-danger">*</span></label>
                    <input type="text" name="label" class="form-control" required placeholder="Contoh: Galeri atau Riset">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">URL / Tautan <span class="text-danger">*</span></label>
                    <input type="text" name="url" class="form-control" required placeholder="/galeri atau https://...">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Menu Induk (Opsional)</label>
                    <select name="parent_id" class="form-select">
                        <option value="">-- Menu Utama Tingkat Atas --</option>
                        @foreach($menus as $p)
                            <option value="{{ $p->id }}">{{ $p->label }} (Jadikan Submenu)</option>
                        @endforeach
                    </select>
                    <div class="form-text">Pilih menu induk jika ingin menjadikannya dropdown submenu.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Ikon FontAwesome</label>
                    <input type="text" name="icon" class="form-control" placeholder="Contoh: fas fa-photo-video">
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark">Urutan Tampil</label>
                        <input type="number" name="order_num" class="form-control" value="0" min="0">
                    </div>
                    <div class="col-6 d-flex align-items-end">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="newActive" checked>
                            <label class="form-check-label fw-semibold small" for="newActive">Langsung Aktif</label>
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-top">
                    <button type="submit" class="btn btn-him-primary w-100">
                        <i class="fas fa-save me-1"></i> Simpan Item Menu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

