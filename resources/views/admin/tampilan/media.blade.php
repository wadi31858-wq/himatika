@extends('layouts.admin')

@section('title', 'Pustaka Media')
@section('page_title', 'Pustaka Media Website')
@section('page_subtitle', 'Jelajahi seluruh berkas gambar dan dokumen yang telah diunggah ke server')

@section('content')
<div class="him-card">
    <div class="him-card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
            <h2 class="him-card-title mb-0">
                <i class="fas fa-photo-video text-primary"></i> Berkas Media Tersimpan
            </h2>
            <small class="text-muted">Total: <strong>{{ $totalFiles }}</strong> berkas di storage publik</small>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <form method="GET" action="{{ route('admin.tampilan.media') }}" class="row g-2 mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama berkas atau folder..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="type" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Jenis Berkas</option>
                <option value="image" {{ request('type') === 'image' ? 'selected' : '' }}>Foto & Gambar Saja</option>
                <option value="document" {{ request('type') === 'document' ? 'selected' : '' }}>Dokumen & Berkas File</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-him-outline w-100">Cari Berkas</button>
        </div>
    </form>

    <!-- Media Grid -->
    <div class="row g-3">
        @forelse($files as $file)
        <div class="col-6 col-sm-4 col-md-3 col-xl-2">
            <div class="card h-100 border shadow-sm rounded-3 overflow-hidden d-flex flex-column justify-content-between">
                <div class="position-relative bg-light d-flex align-items-center justify-content-center" style="height: 120px;">
                    @if($file['is_image'])
                        <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                    @else
                        <div class="text-center text-muted p-2">
                            <i class="fas fa-file-alt fs-1 text-primary mb-1"></i>
                            <div class="small fw-bold text-uppercase">{{ $file['ext'] }}</div>
                        </div>
                    @endif
                    <span class="position-absolute top-0 end-0 m-1 badge bg-dark bg-opacity-75" style="font-size: 0.65rem;">
                        {{ $file['size'] }}
                    </span>
                </div>

                <div class="p-2 flex-grow-1 d-flex flex-column justify-content-between">
                    <div>
                        <div class="small fw-semibold text-dark text-truncate" title="{{ $file['name'] }}">
                            {{ $file['name'] }}
                        </div>
                        <div class="text-muted" style="font-size: 0.7rem;">{{ $file['mtime'] }}</div>
                    </div>

                    <div class="d-flex gap-1 mt-2 pt-2 border-top">
                        <button type="button" class="btn btn-sm btn-outline-primary w-100 p-1" style="font-size: 0.72rem;" onclick="copyMediaUrl('{{ $file['url'] }}', this)">
                            <i class="fas fa-copy me-1"></i> Salin URL
                        </button>
                        <a href="{{ $file['url'] }}" target="_blank" class="btn btn-sm btn-outline-secondary p-1" style="font-size: 0.72rem;" title="Buka di tab baru">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="fas fa-folder-open fs-1 mb-2 d-block text-muted"></i>
            Tidak ada berkas media ditemukan.
        </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $files->links() }}
    </div>
</div>

<script>
function copyMediaUrl(url, btn) {
    navigator.clipboard.writeText(url).then(function() {
        const origHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check text-success"></i> Tersalin!';
        btn.classList.remove('btn-outline-primary');
        btn.classList.add('btn-success', 'text-white');
        setTimeout(function() {
            btn.innerHTML = origHtml;
            btn.classList.remove('btn-success', 'text-white');
            btn.classList.add('btn-outline-primary');
        }, 2000);
    }).catch(function() {
        prompt('Salin URL berkas berikut:', url);
    });
}
</script>
@endsection

