<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationalStructure;
use App\Models\Member;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminOrganizationController extends Controller
{
    public function index(Request $request)
    {
        $query = OrganizationalStructure::with('parent');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('position', 'like', "%{$s}%")
                  ->orWhere('division', 'like', "%{$s}%");
            });
        }

        if ($request->filled('kelompok')) {
            $query->where('kelompok', $request->kelompok);
        }

        $structures = $query->orderBy('order_num')->latest()->paginate(15)->withQueryString();

        $chartData = $this->getChartData();

        return view('admin.struktur.index', array_merge(
            compact('structures'),
            $chartData
        ));
    }

    public function create()
    {
        $parents = OrganizationalStructure::orderBy('order_num')->orderBy('name')->get();
        return view('admin.struktur.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'division' => 'nullable|string|max:255',
            'kelompok' => 'required|string|in:putra,putri,semua',
            'period' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:organizational_structures,id',
            'order_num' => 'nullable|integer|min:0',
            'is_active' => 'required|boolean',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'group_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'group_photo_putri' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'struct_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/structures');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $validated['photo'] = 'structures/' . $filename;
        }

        if ($request->hasFile('group_photo')) {
            $file = $request->file('group_photo');
            $filename = 'group_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/structures/groups');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $validated['group_photo'] = 'structures/groups/' . $filename;
        }

        if ($request->hasFile('group_photo_putri')) {
            $file = $request->file('group_photo_putri');
            $filename = 'group_putri_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/structures/groups');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $validated['group_photo_putri'] = 'structures/groups/' . $filename;
        }

        $structure = OrganizationalStructure::create($validated);

        ActivityLog::record(
            'create',
            "Menambahkan struktur organisasi: \"{$structure->name}\" - {$structure->position}",
            $structure
        );

        return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Data struktur organisasi berhasil ditambahkan.');
    }

    public function edit(OrganizationalStructure $struktur)
    {
        $descendantIds = $this->getDescendantIds($struktur->id);
        $excludedIds = array_merge([$struktur->id], $descendantIds);
        $parents = OrganizationalStructure::whereNotIn('id', $excludedIds)
            ->orderBy('order_num')
            ->orderBy('name')
            ->get();

        return view('admin.struktur.edit', compact('struktur', 'parents'));
    }

    public function update(Request $request, OrganizationalStructure $struktur)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'division' => 'nullable|string|max:255',
            'kelompok' => 'required|string|in:putra,putri,semua',
            'period' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:organizational_structures,id',
            'order_num' => 'nullable|integer|min:0',
            'is_active' => 'required|boolean',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'group_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'group_photo_putri' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // Prevent setting parent to itself or its descendants (prevents circular hierarchy)
        if (!empty($validated['parent_id'])) {
            $excludedIds = array_merge([$struktur->id], $this->getDescendantIds($struktur->id));
            if (in_array((int)$validated['parent_id'], $excludedIds)) {
                return back()->withInput()->withErrors([
                    'parent_id' => 'Struktur tidak dapat memilih dirinya sendiri atau posisi bawahannya sebagai atasan (mencegah perulangan/loop hirarki).'
                ]);
            }
        }

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'struct_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/structures');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            if ($struktur->photo && file_exists(storage_path('app/public/' . $struktur->photo))) {
                @unlink(storage_path('app/public/' . $struktur->photo));
            }
            $file->move($destination, $filename);
            $validated['photo'] = 'structures/' . $filename;
        }

        if ($request->hasFile('group_photo')) {
            $file = $request->file('group_photo');
            $filename = 'group_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/structures/groups');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            if ($struktur->group_photo && file_exists(storage_path('app/public/' . $struktur->group_photo))) {
                @unlink(storage_path('app/public/' . $struktur->group_photo));
            }
            $file->move($destination, $filename);
            $validated['group_photo'] = 'structures/groups/' . $filename;
        }

        if ($request->hasFile('group_photo_putri')) {
            $file = $request->file('group_photo_putri');
            $filename = 'group_putri_' . time() . '_' . $file->hashName();
            $destination = storage_path('app/public/structures/groups');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            if ($struktur->group_photo_putri && file_exists(storage_path('app/public/' . $struktur->group_photo_putri))) {
                @unlink(storage_path('app/public/' . $struktur->group_photo_putri));
            }
            $file->move($destination, $filename);
            $validated['group_photo_putri'] = 'structures/groups/' . $filename;
        }

        $struktur->update($validated);

        ActivityLog::record(
            'update',
            "Memperbarui struktur organisasi: \"{$struktur->name}\"",
            $struktur
        );

        return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Data struktur organisasi berhasil diperbarui.');
    }

    public function destroy(OrganizationalStructure $struktur)
    {
        // Safe deletion check: has children or members?
        $hasChildren = OrganizationalStructure::where('parent_id', $struktur->id)->exists();
        $hasMembers = false;
        if (!empty($struktur->division)) {
            $hasMembers = Member::where('division', $struktur->division)->exists();
        } elseif (!empty($struktur->position)) {
            $hasMembers = Member::where('position', $struktur->position)->exists();
        }

        if ($hasChildren) {
            return redirect()->route('admin.struktur-organisasi.index')->with('error', 'Gagal menghapus: Struktur ini memiliki sub-divisi di bawahnya. Harap pindahkan atau hapus sub-divisi terlebih dahulu.');
        }

        if ($hasMembers) {
            return redirect()->route('admin.struktur-organisasi.index')->with('error', 'Gagal menghapus: Masih terdapat anggota/pengurus yang terdaftar di bidang/divisi ini.');
        }

        $title = $struktur->name;
        if ($struktur->photo && file_exists(storage_path('app/public/' . $struktur->photo))) {
            @unlink(storage_path('app/public/' . $struktur->photo));
        }
        if ($struktur->group_photo && file_exists(storage_path('app/public/' . $struktur->group_photo))) {
            @unlink(storage_path('app/public/' . $struktur->group_photo));
        }
        if ($struktur->group_photo_putri && file_exists(storage_path('app/public/' . $struktur->group_photo_putri))) {
            @unlink(storage_path('app/public/' . $struktur->group_photo_putri));
        }

        $struktur->delete();

        ActivityLog::record(
            'delete',
            "Menghapus struktur organisasi: \"{$title}\"",
            null
        );

        return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Struktur organisasi berhasil dihapus.');
    }

    /**
     * Recursively collect all descendant IDs for a given structure to prevent circular hierarchy loops.
     */
    private function getDescendantIds($structureId): array
    {
        $descendants = [];
        $childrenIds = OrganizationalStructure::where('parent_id', $structureId)->pluck('id')->toArray();
        foreach ($childrenIds as $childId) {
            $descendants[] = (int) $childId;
            $descendants = array_merge($descendants, $this->getDescendantIds($childId));
        }
        return $descendants;
    }

    /**
     * Prepare chart data identical to the public organization structure page
     */
    private function getChartData(): array
    {
        // Kaprodi / Pembina (Umum untuk Putra & Putri)
        $kaprodi = OrganizationalStructure::where('position', 'like', '%Kaprodi%')
            ->orWhere('position', 'like', '%Program Studi%')
            ->first() ?? OrganizationalStructure::find(12);

        // Inti Kepengurusan PUTRA
        $ketuaPutra = OrganizationalStructure::where('kelompok', 'putra')
            ->where('position', 'like', '%Ketua%')
            ->first() ?? OrganizationalStructure::find(1);

        $wakilPutra = OrganizationalStructure::where('kelompok', 'putra')
            ->where('position', 'like', '%Wakil%')
            ->first() ?? OrganizationalStructure::find(13);

        $sekretarisPutra = OrganizationalStructure::where('kelompok', 'putra')
            ->where('position', 'like', '%Sekretaris%')
            ->first() ?? OrganizationalStructure::find(3);

        $bendaharaPutra = OrganizationalStructure::where('kelompok', 'putra')
            ->where('position', 'like', '%Bendahara%')
            ->first() ?? OrganizationalStructure::find(11);

        // Inti Kepengurusan PUTRI
        $ketuaPutri = OrganizationalStructure::where('kelompok', 'putri')
            ->where('position', 'like', '%Ketua%')
            ->first() ?? OrganizationalStructure::find(2);

        $wakilPutri = OrganizationalStructure::where('kelompok', 'putri')
            ->where('position', 'like', '%Wakil%')
            ->first() ?? OrganizationalStructure::find(14);

        $sekretarisPutri = OrganizationalStructure::where('kelompok', 'putri')
            ->where('position', 'like', '%Sekretaris%')
            ->first() ?? OrganizationalStructure::find(10);

        $bendaharaPutri = OrganizationalStructure::where('kelompok', 'putri')
            ->where('position', 'like', '%Bendahara%')
            ->first() ?? OrganizationalStructure::find(4);

        // Konfigurasi 5 Divisi HIMATIKA
        $divisiDefs = [
            'keilmuan' => [
                'id' => 5,
                'key' => 'keilmuan',
                'name' => '1. Divisi Keilmuan',
                'clean_name' => 'Divisi Keilmuan',
                'icon' => 'fas fa-graduation-cap',
                'description' => 'Mengembangkan kapasitas akademik mahasiswa melalui kajian sains matematika murni dan terapan, tutorial sebaya, workshop matematika, serta pembinaan kompetisi olimpiade sains.',
                'search' => 'Keilmuan',
            ],
            'kaderisasi' => [
                'id' => 6,
                'key' => 'kaderisasi',
                'name' => '2. Divisi Kaderisasi',
                'clean_name' => 'Divisi Kaderisasi',
                'icon' => 'fas fa-users-cog',
                'description' => 'Mengawal pembinaan karakter kepemimpinan, proses kaderisasi dan orientasi mahasiswa baru, upgrading kapasitas pengurus, serta penanaman integritas dan loyalitas organisasi.',
                'search' => 'Kaderisasi',
            ],
            'publik_relasi' => [
                'id' => 7,
                'key' => 'publik_relasi',
                'name' => '3. Divisi Publik Relasi',
                'clean_name' => 'Divisi Publik Relasi',
                'icon' => 'fas fa-handshake',
                'description' => 'Membangun jejaring kolaborasi dan kemitraan eksternal kampus, menjalin hubungan erat dengan alumni, menyelenggarakan program bakti sosial, serta menjaga reputasi publik himpunan.',
                'search' => 'Publik Relasi',
            ],
            'litbang' => [
                'id' => 9,
                'key' => 'litbang',
                'name' => '4. Divisi Litbang',
                'clean_name' => 'Divisi Litbang',
                'icon' => 'fas fa-flask',
                'description' => 'Melaksanakan riset organisasi, survei aspirasi mahasiswa, pemantauan dan evaluasi mutu program kerja berkala, serta merumuskan inovasi strategis pengembangan HIMATIKA.',
                'search' => 'Litbang',
            ],
            'kominfo' => [
                'id' => 8,
                'key' => 'kominfo',
                'name' => '5. Divisi Kominfo',
                'clean_name' => 'Divisi Kominfo',
                'icon' => 'fas fa-bullhorn',
                'description' => 'Mengelola ekosistem media komunikasi digital, produksi konten multimedia kreatif, pengelolaan website resmi dan media sosial, serta pusat informasi terkini HIMATIKA UNUJA.',
                'search' => 'Kominfo',
            ],
        ];

        $divisiPutra = [];
        $divisiPutri = [];
        $divisiModalData = [
            'putra' => [],
            'putri' => []
        ];

        foreach ($divisiDefs as $key => $def) {
            $struct = OrganizationalStructure::find($def['id']);
            $divisionName = $struct?->position ?: $def['name'];
            $divisionDesc = $struct?->description ?: $def['description'];

            // Group photo per division (Putra & Putri)
            $groupPhotoPutra = $struct?->group_photo ? asset('storage/' . $struct->group_photo) : null;
            $groupPhotoPutri = $struct?->group_photo_putri
                ? asset('storage/' . $struct->group_photo_putri)
                : ($struct?->group_photo ? asset('storage/' . $struct->group_photo) : null);

            // Member PUTRA
            $membersPutra = Member::where('division', 'like', "%{$def['search']}%")
                ->where('kelompok', 'putra')
                ->where('is_active', true)
                ->orderBy('order_num')
                ->get();

            $leaderPutra = $membersPutra->firstWhere(function ($m) {
                return str_contains(strtolower($m->position), 'kepala') || str_contains(strtolower($m->position), 'co ');
            }) ?? $membersPutra->first();

            $divisiPutra[$key] = array_merge($def, [
                'structure' => $struct,
                'name' => $divisionName,
                'description' => $divisionDesc,
                'detail_url' => route('struktur-organisasi.show', $def['id']),
                'edit_url' => $struct ? route('admin.struktur-organisasi.edit', $struct->id) : route('admin.struktur-organisasi.index'),
                'group_photo' => $groupPhotoPutra,
                'members' => $membersPutra,
                'member_count' => $membersPutra->count(),
                'leader_name' => $leaderPutra?->name ?? ($struct?->name ?? 'Pengurus Putra'),
                'leader_position' => $leaderPutra?->position ?? 'Koordinator Divisi',
                'leader_photo' => $leaderPutra?->photo ? asset('storage/' . $leaderPutra->photo) : null,
            ]);

            $modalMembersPutra = $membersPutra->map(function ($m) use ($def) {
                return [
                    'name' => $m->name,
                    'position' => $m->position,
                    'photo' => $m->photo ? asset('storage/' . $m->photo) : null,
                    'bio' => $m->bio ?? "Pengurus {$def['clean_name']} HIMATIKA UNUJA Putra."
                ];
            })->values();

            if ($modalMembersPutra->isEmpty() && $struct && ($struct->kelompok === 'putra' || $struct->kelompok === 'semua') && $struct->name) {
                $modalMembersPutra->push([
                    'name' => $struct->name,
                    'position' => $struct->position,
                    'photo' => $struct->photo ? asset('storage/' . $struct->photo) : null,
                    'bio' => $struct->description ?: "Pengurus {$def['clean_name']} HIMATIKA UNUJA Putra."
                ]);
            }

            $divisiModalData['putra'][$key] = [
                'id' => $def['id'],
                'name' => $def['clean_name'] . ' (Putra)',
                'key' => $key,
                'description' => $divisionDesc,
                'detail_url' => route('struktur-organisasi.show', $def['id']),
                'edit_url' => $struct ? route('admin.struktur-organisasi.edit', $struct->id) : null,
                'leader_name' => $leaderPutra?->name ?? ($struct?->name ?? 'Pengurus Putra'),
                'leader_position' => $leaderPutra?->position ?? 'Koordinator Divisi',
                'members' => $modalMembersPutra
            ];

            // Member PUTRI
            $membersPutri = Member::where('division', 'like', "%{$def['search']}%")
                ->where('kelompok', 'putri')
                ->where('is_active', true)
                ->orderBy('order_num')
                ->get();

            $leaderPutri = $membersPutri->firstWhere(function ($m) {
                return str_contains(strtolower($m->position), 'kepala') || str_contains(strtolower($m->position), 'co ');
            }) ?? $membersPutri->first();

            $divisiPutri[$key] = array_merge($def, [
                'structure' => $struct,
                'name' => $divisionName,
                'description' => $divisionDesc,
                'detail_url' => route('struktur-organisasi.show', $def['id']),
                'edit_url' => $struct ? route('admin.struktur-organisasi.edit', $struct->id) : route('admin.struktur-organisasi.index'),
                'group_photo' => $groupPhotoPutri,
                'members' => $membersPutri,
                'member_count' => $membersPutri->count(),
                'leader_name' => $leaderPutri?->name ?? ($struct?->name ?? 'Pengurus Putri'),
                'leader_position' => $leaderPutri?->position ?? 'Koordinator Divisi',
                'leader_photo' => $leaderPutri?->photo ? asset('storage/' . $leaderPutri->photo) : null,
            ]);

            $modalMembersPutri = $membersPutri->map(function ($m) use ($def) {
                return [
                    'name' => $m->name,
                    'position' => $m->position,
                    'photo' => $m->photo ? asset('storage/' . $m->photo) : null,
                    'bio' => $m->bio ?? "Pengurus {$def['clean_name']} HIMATIKA UNUJA Putri."
                ];
            })->values();

            if ($modalMembersPutri->isEmpty() && $struct && ($struct->kelompok === 'putri' || $struct->kelompok === 'semua') && $struct->name) {
                $modalMembersPutri->push([
                    'name' => $struct->name,
                    'position' => $struct->position,
                    'photo' => $struct->photo ? asset('storage/' . $struct->photo) : null,
                    'bio' => $struct->description ?: "Pengurus {$def['clean_name']} HIMATIKA UNUJA Putri."
                ]);
            }

            $divisiModalData['putri'][$key] = [
                'id' => $def['id'],
                'name' => $def['clean_name'] . ' (Putri)',
                'key' => $key,
                'description' => $divisionDesc,
                'detail_url' => route('struktur-organisasi.show', $def['id']),
                'edit_url' => $struct ? route('admin.struktur-organisasi.edit', $struct->id) : null,
                'leader_name' => $leaderPutri?->name ?? ($struct?->name ?? 'Pengurus Putri'),
                'leader_position' => $leaderPutri?->position ?? 'Koordinator Divisi',
                'members' => $modalMembersPutri
            ];
        }

        // Catch any extra custom structures created by admin
        $standardIds = [12, 1, 2, 3, 4, 10, 11, 5, 6, 7, 8, 9];
        if ($kaprodi) $standardIds[] = $kaprodi->id;
        if ($ketuaPutra) $standardIds[] = $ketuaPutra->id;
        if ($ketuaPutri) $standardIds[] = $ketuaPutri->id;
        if ($sekretarisPutra) $standardIds[] = $sekretarisPutra->id;
        if ($sekretarisPutri) $standardIds[] = $sekretarisPutri->id;
        if ($bendaharaPutra) $standardIds[] = $bendaharaPutra->id;
        if ($bendaharaPutri) $standardIds[] = $bendaharaPutri->id;
        $standardIds = array_unique($standardIds);

        $extraStructures = OrganizationalStructure::whereNotIn('id', $standardIds)->orderBy('order_num')->get();

        return compact(
            'kaprodi',
            'ketuaPutra',
            'wakilPutra',
            'sekretarisPutra',
            'bendaharaPutra',
            'ketuaPutri',
            'wakilPutri',
            'sekretarisPutri',
            'bendaharaPutri',
            'divisiPutra',
            'divisiPutri',
            'divisiModalData',
            'extraStructures'
        );
    }
}
