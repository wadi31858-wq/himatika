@extends('layouts.admin')

@section('title', 'Kelola Sejarah')
@section('page_title', 'Kelola Halaman Sejarah')
@section('page_subtitle', 'Sesuaikan naskah sejarah, foto pembuka, dan tautan dokumentasi sejarah')

@section('content')
<form action="{{ route('admin.tentang.sejarah.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Left: Form inputs -->
        <div class="col-lg-8">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-landmark text-primary"></i> Konten Halaman Sejarah
                    </h2>
                    <a href="{{ route('sejarah') }}" target="_blank" class="btn btn-sm btn-outline-info">
                        <i class="fas fa-external-link-alt me-1"></i> Lihat Publik
                    </a>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Judul Utama <span class="text-danger">*</span></label>
                    <input type="text" name="history_title" class="form-control" value="{{ old('history_title', $siteSettings['history_title'] ?? ($profile->title ? 'Sejarah ' . $profile->title : 'Sejarah HIMATIKA UNUJA')) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Subjudul / Pengantar Banner</label>
                    <input type="text" name="history_subtitle" class="form-control" value="{{ old('history_subtitle', $siteSettings['history_subtitle'] ?? 'Perjalanan panjang himpunan mahasiswa dalam mengabdi dan berkarya') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Isi Lengkap Sejarah <span class="text-danger">*</span></label>
                    
                    {{-- Visual Editor Container (Tanpa Input Kode HTML) --}}
                    <div class="visual-editor-container">
                        {{-- Editor Toolbar --}}
                        <div class="visual-editor-toolbar d-flex flex-wrap align-items-center gap-1 p-2 bg-light border border-bottom-0 rounded-top">
                            <button type="button" class="btn btn-sm btn-outline-secondary toolbar-btn" data-command="bold" title="Tebal (Ctrl+B)">
                                <i class="fas fa-bold"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary toolbar-btn" data-command="italic" title="Miring (Ctrl+I)">
                                <i class="fas fa-italic"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary toolbar-btn" data-command="underline" title="Garis Bawah (Ctrl+U)">
                                <i class="fas fa-underline"></i>
                            </button>
                            <div class="vr mx-1"></div>
                            <button type="button" class="btn btn-sm btn-outline-secondary toolbar-btn" data-command="formatBlock" data-value="p" title="Paragraf Normal">
                                <i class="fas fa-paragraph"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary toolbar-btn" data-command="formatBlock" data-value="h4" title="Sub-Judul (H4)">
                                <i class="fas fa-heading"></i>
                            </button>
                            <div class="vr mx-1"></div>
                            <button type="button" class="btn btn-sm btn-outline-secondary toolbar-btn" data-command="insertUnorderedList" title="Daftar Poin (Bullet List)">
                                <i class="fas fa-list-ul"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary toolbar-btn" data-command="insertOrderedList" title="Daftar Nomor (Numbered List)">
                                <i class="fas fa-list-ol"></i>
                            </button>
                            <div class="vr mx-1"></div>
                            <button type="button" class="btn btn-sm btn-outline-secondary toolbar-btn" data-command="undo" title="Urungkan (Undo)">
                                <i class="fas fa-undo"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary toolbar-btn" data-command="redo" title="Ulangi (Redo)">
                                <i class="fas fa-redo"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary toolbar-btn" data-command="removeFormat" title="Hapus Format">
                                <i class="fas fa-eraser"></i>
                            </button>
                        </div>

                        {{-- Editable Area --}}
                        <div id="sejarahVisualEditor" class="visual-editor-surface p-3 bg-white border rounded-bottom" contenteditable="true" spellcheck="false" style="min-height: 280px; max-height: 520px; overflow-y: auto; outline: none; line-height: 1.75; font-size: 0.95rem;">
                            {!! old('history_content', $profile->history ?? '<p>HIMATIKA merupakan lembaga kemahasiswaan yang tumbuh dan berkembang dari semangat mahasiswa dalam membangun persatuan yang berorientasikan nilai-nilai keislaman.</p><p>Dalam perkembangannya, HIMATIKA terus berikhtiar meningkatkan mutu keilmuan, kepemimpinan, dan jejaring pengabdian.</p>') !!}
                        </div>

                        {{-- Hidden field to submit to server --}}
                        <textarea name="history_content" id="history_content_hidden" class="d-none" required></textarea>
                    </div>
                    <div class="form-text mt-1 text-muted small">
                        <i class="fas fa-info-circle me-1 text-primary"></i> Editor visual aktif: Ketik atau tempel teks langsung. Gunakan tombol toolbar untuk memformat tebal, miring, paragraf, atau daftar tanpa perlu menulis kode HTML.
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark small">Teks Tombol Dokumentasi</label>
                        <input type="text" name="history_doc_text" class="form-control" value="{{ old('history_doc_text', $siteSettings['history_doc_text'] ?? 'Dokumentasi Sejarah') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark small">Tautan Dokumentasi Sejarah</label>
                        <input type="text" name="history_doc_url" class="form-control" value="{{ old('history_doc_url', $siteSettings['history_doc_url'] ?? route('galeri')) }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Photo upload -->
        <div class="col-lg-4">
            <div class="him-card">
                <div class="him-card-header">
                    <h2 class="him-card-title">
                        <i class="fas fa-image"></i> Foto Pembuka Sejarah
                    </h2>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Ganti Foto Pembuka</label>
                    <input type="file" name="history_image" class="form-control" accept="image/*">
                    <div class="form-text">Foto gedung, prasasti, atau momentum awal pendirian.</div>
                </div>

                @php $curHistImg = $siteSettings['history_image'] ?? $profile->image; @endphp
                @if($curHistImg)
                    <div class="rounded-3 overflow-hidden border p-1 bg-light mb-3">
                        <img src="{{ asset('storage/' . $curHistImg) }}" class="w-100 rounded" style="height: 180px; object-fit: cover;">
                        <div class="small text-muted p-1">Foto aktif saat ini</div>
                    </div>
                @endif

                <button type="submit" class="btn btn-him-primary w-100 py-2">
                    <i class="fas fa-save me-1"></i> Simpan Halaman Sejarah
                </button>
            </div>
        </div>
    </div>
</form>

@push('styles')
<style>
    .visual-editor-container {
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .visual-editor-toolbar {
        border-color: #E2E8F0 !important;
        background: #F8FAFC !important;
    }
    .toolbar-btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.82rem;
        color: #475569;
        border-color: #CBD5E1;
        background: #ffffff;
        border-radius: 6px;
    }
    .toolbar-btn:hover {
        background: #711C35;
        color: #ffffff;
        border-color: #711C35;
    }
    .visual-editor-surface {
        border-color: #E2E8F0 !important;
        color: #1E293B;
    }
    .visual-editor-surface:focus {
        border-color: #711C35 !important;
        box-shadow: 0 0 0 3px rgba(113, 28, 53, 0.12);
    }
    .visual-editor-surface p {
        margin-bottom: 0.85rem;
    }
    .visual-editor-surface ul,
    .visual-editor-surface ol {
        padding-left: 1.5rem;
        margin-bottom: 0.85rem;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editor = document.getElementById('sejarahVisualEditor');
    const hiddenInput = document.getElementById('history_content_hidden');
    if (!editor || !hiddenInput) return;

    const form = editor.closest('form');

    // Toolbar actions
    document.querySelectorAll('.toolbar-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const cmd = this.getAttribute('data-command');
            const val = this.getAttribute('data-value') || null;
            document.execCommand(cmd, false, val);
            editor.focus();
        });
    });

    // Populate hidden field initially
    hiddenInput.value = editor.innerHTML.trim();

    // Sync on input and on submit
    editor.addEventListener('input', function() {
        hiddenInput.value = editor.innerHTML.trim();
    });

    form.addEventListener('submit', function() {
        hiddenInput.value = editor.innerHTML.trim();
    });

    // Clean text paste handler
    editor.addEventListener('paste', function(e) {
        e.preventDefault();
        const text = (e.clipboardData || window.clipboardData).getData('text/plain');
        document.execCommand('insertText', false, text);
    });
});
</script>
@endpush
@endsection

