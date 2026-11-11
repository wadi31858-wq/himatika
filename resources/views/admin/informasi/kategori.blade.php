@extends('layouts.admin')

@section('title', 'Kelola Kategori Informasi')
@section('page_title', 'Kelola Kategori Informasi')
@section('page_subtitle', 'Atur kategori berita, pengumuman, kegiatan, dan prestasi')

@section('content')
<div class="row g-4">
    <!-- Left: Add Category Form -->
    <div class="col-lg-4">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-plus-circle"></i> Tambah Kategori
                </h2>
            </div>

            <form action="{{ route('admin.informasi.kategori.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="informasi">

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required placeholder="Contoh: Liputan Khusus">
                    <div class="form-text">Nama kategori yang akan tampil pada filter dan badge informasi.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Nomor Urut</label>
                    <input type="number" name="order_num" class="form-control" value="{{ count($categories) + 1 }}" min="0">
                </div>

                <button type="submit" class="btn btn-him-primary w-100">
                    <i class="fas fa-save me-1"></i> Simpan Kategori
                </button>
            </form>
        </div>
    </div>

    <!-- Right: Category List -->
    <div class="col-lg-8">
        <div class="him-card">
            <div class="him-card-header">
                <h2 class="him-card-title">
                    <i class="fas fa-tags"></i> Daftar Kategori Informasi
                </h2>
                <span class="badge bg-primary-subtle text-primary">{{ count($categories) }} Kategori</span>
            </div>

            <div class="table-responsive">
                <table class="table table-him align-middle">
                    <thead>
                        <tr>
                            <th width="8%">Urut</th>
                            <th width="35%">Nama Kategori</th>
                            <th width="22%">Jumlah Konten</th>
                            <th width="35%" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                            @php $used = $counts[$cat->id] ?? 0; @endphp
                            <tr>
                                <td><span class="badge bg-light text-dark border">{{ $cat->order_num }}</span></td>
                                <td>
                                    <strong>{{ $cat->name }}</strong>
                                    <div class="small text-muted">{{ $cat->slug }}</div>
                                </td>
                                <td>
                                    <span class="badge {{ $used > 0 ? 'bg-info-subtle text-info' : 'bg-secondary-subtle text-secondary' }} px-3 py-2">
                                        <i class="fas fa-file-alt me-1"></i> {{ $used }} Konten
                                    </span>
                                </td>
                                <td class="text-end">
                                    <!-- Edit Button (trigger modal) -->
                                    <button type="button" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $cat->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <!-- Delete Button (trigger modal) -->
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $cat->id }}">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $cat->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered text-start">
                                            <div class="modal-content border-0 shadow">
                                                <form action="{{ route('admin.informasi.kategori.update', $cat) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold">Edit Kategori: {{ $cat->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Nama Kategori</label>
                                                            <input type="text" name="name" class="form-control" value="{{ $cat->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Nomor Urut</label>
                                                            <input type="number" name="order_num" class="form-control" value="{{ $cat->order_num }}" min="0">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-him-primary">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Modal with Replacement Option -->
                                    <div class="modal fade" id="deleteModal{{ $cat->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered text-start">
                                            <div class="modal-content border-0 shadow">
                                                <form action="{{ route('admin.informasi.kategori.destroy', $cat) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold text-danger">Hapus Kategori: {{ $cat->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @if($used > 0)
                                                            <div class="alert alert-warning">
                                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                                Kategori ini masih digunakan oleh <strong>{{ $used }} konten informasi</strong>.
                                                                Pilih kategori pengganti untuk memindahkan konten terkait:
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Pindahkan Konten Ke Kategori:</label>
                                                                <select name="replacement_category" class="form-select" required>
                                                                    <option value="">-- Pilih Kategori Pengganti --</option>
                                                                    @foreach($categories as $other)
                                                                        @if($other->id !== $cat->id)
                                                                            <option value="{{ $other->name }}">{{ $other->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        @else
                                                            <p class="mb-0">Yakin ingin menghapus kategori <strong>"{{ $cat->name }}"</strong>? Kategori ini tidak memiliki konten terkait.</p>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Ya, Hapus Kategori</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

