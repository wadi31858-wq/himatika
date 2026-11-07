@extends('layouts.admin')
@section('title', 'Edit Profil')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit Profil</h4>
</div>

<ul class="nav nav-pills mb-4" id="profilTab">
    <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#tab-profil">Profil</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#tab-motto">Motto</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#tab-filosofi">Filosofi</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#tab-mars">Mars</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#tab-jejak">Jejak Langkah</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#tab-kontak">Kontak</a></li>
</ul>

<form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="tab-content">
        {{-- Tab Profil --}}
        <div class="tab-pane fade show active" id="tab-profil">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Profil</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $profile->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Isi Profil (HTML)</label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="8" required>{{ old('content', $profile->content) }}</textarea>
                        @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Gambar Profil</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @if($profile->image)<div class="mt-2"><img src="{{ asset('storage/'.$profile->image) }}" width="150" class="rounded"></div>@endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Logo HIMATIKA UNUJA</label>
                            <input type="file" name="logo" class="form-control" accept="image/*">
                            @if($profile->logo)<div class="mt-2"><img src="{{ asset('storage/'.$profile->logo) }}" width="100" class="rounded"></div>@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tab Motto --}}
        <div class="tab-pane fade" id="tab-motto">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Motto HIMATIKA UNUJA</label>
                        <input type="text" name="motto" class="form-control" value="{{ old('motto', $profile->motto) }}" placeholder="Contoh: Bersama Berkarya, Berinovasi, dan Mengembangkan Teknologi">
                    </div>
                </div>
            </div>
        </div>

        {{-- Tab Filosofi --}}
        <div class="tab-pane fade" id="tab-filosofi">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Filosofi Lambang (HTML)</label>
                        <textarea name="philosophy" class="form-control" rows="10">{{ old('philosophy', $profile->philosophy) }}</textarea>
                        <small class="text-muted">Gunakan tag HTML untuk format: &lt;p&gt;, &lt;ul&gt;, &lt;li&gt;, &lt;strong&gt;</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tab Mars --}}
        <div class="tab-pane fade" id="tab-mars">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Mars HIMATIKA UNUJA (HTML)</label>
                        <textarea name="mars" class="form-control" rows="12">{{ old('mars', $profile->mars) }}</textarea>
                        <small class="text-muted">Gunakan &lt;br&gt; untuk ganti baris, &lt;strong&gt; untuk tebal</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tab Jejak Langkah --}}
        <div class="tab-pane fade" id="tab-jejak">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Jejak Langkah / Riwayat (HTML)</label>
                        <textarea name="history" class="form-control" rows="12">{{ old('history', $profile->history) }}</textarea>
                        <small class="text-muted">Contoh: &lt;p&gt;&lt;strong&gt;2020&lt;/strong&gt; - Deskripsi kegiatan&lt;/p&gt;</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tab Kontak --}}
        <div class="tab-pane fade" id="tab-kontak">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Nama Kampus</label><input type="text" name="campus_name" class="form-control" value="{{ old('campus_name', $profile->campus_name) }}"></div>
                        <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $profile->email) }}"></div>
                        <div class="col-md-6"><label class="form-label">No. WhatsApp</label><input type="text" name="phone" class="form-control" value="{{ old('phone', $profile->phone) }}"></div>
                        <div class="col-md-6"><label class="form-label">Instagram</label><input type="text" name="instagram" class="form-control" value="{{ old('instagram', $profile->instagram) }}"></div>
                        <div class="col-md-6"><label class="form-label">YouTube</label><input type="text" name="youtube" class="form-control" value="{{ old('youtube', $profile->youtube) }}"></div>
                        <div class="col-md-6"><label class="form-label">TikTok</label><input type="text" name="tiktok" class="form-control" value="{{ old('tiktok', $profile->tiktok) }}"></div>
                        <div class="col-12"><label class="form-label">Alamat</label><textarea name="address" class="form-control" rows="2">{{ old('address', $profile->address) }}</textarea></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save me-1"></i>Simpan Semua Perubahan</button>
    </div>
</form>
@endsection
