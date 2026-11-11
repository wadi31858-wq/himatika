@php
    $children = $groupedByParent->get($node->id, collect());
    $isPutra = ($node->kelompok === 'putra');
    $isPutri = ($node->kelompok === 'putri');
    $badgeClass = $isPutra ? 'bg-primary-subtle text-primary border border-primary-subtle' : ($isPutri ? 'bg-danger-subtle text-danger border border-danger-subtle' : 'bg-secondary-subtle text-secondary border');
    $borderAccent = $isPutra ? '#2563eb' : ($isPutri ? '#db2777' : '#711C35');
@endphp
<li class="him-tree-item" data-kelompok="{{ $node->kelompok }}">
    <div class="him-org-card shadow-sm" style="border-top: 3.5px solid {{ $borderAccent }};">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div class="him-org-avatar">
                @if($node->photo)
                    <img src="{{ asset('storage/' . $node->photo) }}" alt="{{ $node->name }}">
                @else
                    <i class="fas fa-user-circle text-muted fs-6"></i>
                @endif
            </div>
            <div class="text-start flex-grow-1" style="min-width: 0;">
                <span class="badge {{ $badgeClass }} py-0 px-1" style="font-size: 0.65rem;">
                    @if($isPutra) <i class="fas fa-mars me-1"></i>Putra
                    @elseif($isPutri) <i class="fas fa-venus me-1"></i>Putri
                    @else <i class="fas fa-users me-1"></i>Umum
                    @endif
                </span>
                @if($node->is_active)
                    <span class="badge bg-success-subtle text-success py-0 px-1" style="font-size: 0.60rem;">Aktif</span>
                @else
                    <span class="badge bg-secondary-subtle text-secondary py-0 px-1" style="font-size: 0.60rem;">Nonaktif</span>
                @endif
            </div>
        </div>

        <div class="him-org-card-title fw-bold text-dark text-truncate" title="{{ $node->position }}">
            {{ $node->position }}
        </div>
        <div class="him-org-card-name text-muted text-truncate" title="{{ $node->name }}" style="font-size: 0.78rem;">
            {{ $node->name }}
        </div>
        @if($node->division)
            <div class="him-org-card-div text-secondary text-truncate mt-1" style="font-size: 0.70rem;" title="{{ $node->division }}">
                <i class="fas fa-folder-open me-1 opacity-75"></i>{{ $node->division }}
            </div>
        @endif

        <div class="him-org-card-actions mt-2 pt-1 border-top d-flex justify-content-between align-items-center">
            <span class="text-muted" style="font-size: 0.68rem;" title="Urutan tampilan">#{{ $node->order_num ?? 0 }}</span>
            <a href="{{ route('admin.struktur-organisasi.edit', $node) }}" class="btn btn-sm btn-link p-0 text-decoration-none fw-semibold" style="font-size: 0.72rem; color: #711C35;" title="Edit Posisi / Atasan">
                <i class="fas fa-pencil-alt me-1"></i>Edit
            </a>
        </div>
    </div>

    @if($children->isNotEmpty())
        <ul class="him-tree-children">
            @foreach($children as $child)
                @include('admin.struktur._tree_node', ['node' => $child, 'groupedByParent' => $groupedByParent])
            @endforeach
        </ul>
    @endif
</li>
