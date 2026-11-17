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
        $activeUnitKey = strtolower($request->query('unit', 'bpi'));
        if (in_array($activeUnitKey, ['publik', 'pr'])) {
            $activeUnitKey = 'publik_relasi';
        }
        $activeKelompok = strtolower($request->query('kelompok', 'putra'));
        if (!in_array($activeKelompok, ['putra', 'putri'])) {
            $activeKelompok = 'putra';
        }

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

        if ($request->filled('unit')) {
            $u = strtolower($request->unit);
            if ($u === 'bpi') {
                $query->where(function ($q) {
                    $q->whereIn('id', [1, 2, 3, 4, 10, 11, 13, 14])
                      ->orWhere('division', 'like', '%Pengurus Inti%');
                });
            } elseif ($u === 'keilmuan' || $u == '5') {
                $query->where(function ($q) {
                    $q->where('id', 5)->orWhere('division', 'like', '%Keilmuan%');
                });
            } elseif ($u === 'kominfo' || $u == '8') {
                $query->where(function ($q) {
                    $q->where('id', 8)->orWhere('division', 'like', '%Kominfo%');
                });
            } elseif ($u === 'kaderisasi' || $u == '6') {
                $query->where(function ($q) {
                    $q->where('id', 6)->orWhere('division', 'like', '%Kaderisasi%');
                });
            } elseif (in_array($u, ['publik_relasi', 'publik', 'pr', '7'])) {
                $query->where(function ($q) {
                    $q->where('id', 7)->orWhere('division', 'like', '%Publik Relasi%');
                });
            } elseif ($u === 'litbang' || $u == '9') {
                $query->where(function ($q) {
                    $q->where('id', 9)->orWhere('division', 'like', '%Litbang%');
                });
            }
        }

        $structures = $query->orderBy('order_num')->latest()->paginate(15)->withQueryString();

        $chartData = $this->getChartData();

        // Data Unit Pengelolaan Aktif (untuk kartu kelola unit di atas bagan)
        $unitDefinitions = [
            'bpi' => [
                'type' => 'bpi',
                'key' => 'bpi',
                'name' => 'Badan Pengurus Inti (BPI)',
                'icon' => 'fas fa-users-cog',
                'desc' => 'Pimpinan inti tertinggi kepengurusan harian HIMATIKA UNUJA.',
                'struct_id' => $activeKelompok === 'putri' ? 2 : 1,
            ],
            'keilmuan' => [
                'type' => 'divisi',
                'key' => 'keilmuan',
                'id' => 5,
                'name' => 'Divisi Keilmuan',
                'division_name' => 'Divisi Keilmuan',
                'search' => 'Keilmuan',
                'icon' => 'fas fa-graduation-cap',
                'desc' => 'Mengembangkan kapasitas akademik mahasiswa melalui kajian sains matematika.',
                'struct_id' => 5,
            ],
            'kominfo' => [
                'type' => 'divisi',
                'key' => 'kominfo',
                'id' => 8,
                'name' => 'Divisi Kominfo',
                'division_name' => 'Divisi Kominfo',
                'search' => 'Kominfo',
                'icon' => 'fas fa-bullhorn',
                'desc' => 'Mengelola ekosistem media komunikasi digital, konten kreatif, website dan medsos.',
                'struct_id' => 8,
            ],
            'kaderisasi' => [
                'type' => 'divisi',
                'key' => 'kaderisasi',
                'id' => 6,
                'name' => 'Divisi Kaderisasi',
                'division_name' => 'Divisi Kaderisasi',
                'search' => 'Kaderisasi',
                'icon' => 'fas fa-users-cog',
                'desc' => 'Mengawal pembinaan karakter kepemimpinan, proses kaderisasi dan orientasi.',
                'struct_id' => 6,
            ],
            'publik_relasi' => [
                'type' => 'divisi',
                'key' => 'publik_relasi',
                'id' => 7,
                'name' => 'Divisi Publik Relasi',
                'division_name' => 'Divisi Publik Relasi',
                'search' => 'Publik Relasi',
                'icon' => 'fas fa-handshake',
                'desc' => 'Membangun jejaring kolaborasi kampus, hubungan alumni, dan bakti sosial.',
                'struct_id' => 7,
            ],
            'litbang' => [
                'type' => 'divisi',
                'key' => 'litbang',
                'id' => 9,
                'name' => 'Divisi Litbang',
                'division_name' => 'Divisi Litbang',
                'search' => 'Litbang',
                'icon' => 'fas fa-flask',
                'desc' => 'Melaksanakan riset organisasi, survei aspirasi mahasiswa, dan evaluasi proker.',
                'struct_id' => 9,
            ],
        ];

        $currentUnit = $unitDefinitions[$activeUnitKey] ?? $unitDefinitions['bpi'];
        $unitStruct = OrganizationalStructure::find($currentUnit['struct_id']);

        // Data anggota unit
        $unitMembers = collect();
        $bpiPositions = [];

        if ($currentUnit['type'] === 'bpi') {
            $isPutri = $activeKelompok === 'putri';
            $bpiPositions = [
                'ketua' => [
                    'label' => 'Ketua Umum',
                    'action_title' => 'Tambah / Edit Ketua',
                    'model' => $isPutri ? $chartData['ketuaPutri'] : $chartData['ketuaPutra'],
                    'default_position' => $isPutri ? 'Ketua Umum Putri' : 'Ketua Umum Putra',
                ],
                'wakil' => [
                    'label' => 'Wakil Ketua Umum',
                    'action_title' => 'Tambah / Edit Wakil',
                    'model' => $isPutri ? $chartData['wakilPutri'] : $chartData['wakilPutra'],
                    'default_position' => $isPutri ? 'Wakil Ketua Umum Putri' : 'Wakil Ketua Umum Putra',
                ],
                'sekretaris' => [
                    'label' => 'Sekretaris',
                    'action_title' => 'Tambah / Edit Sekretaris',
                    'model' => $isPutri ? $chartData['sekretarisPutri'] : $chartData['sekretarisPutra'],
                    'default_position' => $isPutri ? 'Sekretaris Putri' : 'Sekretaris Putra',
                ],
                'bendahara' => [
                    'label' => 'Bendahara',
                    'action_title' => 'Tambah / Edit Bendahara',
                    'model' => $isPutri ? $chartData['bendaharaPutri'] : $chartData['bendaharaPutra'],
                    'default_position' => $isPutri ? 'Bendahara Putri' : 'Bendahara Putra',
                ],
            ];
        } else {
            // Divisi: ambil semua anggota divisi tersebut
            $search = $currentUnit['search'];
            $leaders = Member::where('division', 'like', "%{$search}%")
                ->where('kelompok', $activeKelompok)
                ->where(function ($q) {
                    $q->where('position', 'like', '%co%')
                      ->orWhere('position', 'like', '%kepala%')
                      ->orWhere('position', 'like', '%koordinator%');
                })
                ->orderBy('order_num')
                ->get();

            $staff = Member::where('division', 'like', "%{$search}%")
                ->where('kelompok', $activeKelompok)
                ->where(function ($q) {
                    $q->where('position', 'not like', '%co%')
                      ->where('position', 'not like', '%kepala%')
                      ->where('position', 'not like', '%koordinator%');
                })
                ->orderBy('order_num')
                ->get();

            $unitMembers = $leaders->concat($staff);
        }

        $leaders = $leaders ?? collect();
        $staff = $staff ?? collect();

        $unitChartPutra = ['total' => 0, 'leaders' => collect(), 'staff' => collect()];
        $unitChartPutri = ['total' => 0, 'leaders' => collect(), 'staff' => collect()];

        if ($currentUnit['type'] === 'divisi') {
            $unitChartPutra = $this->getDivisionChartData($currentUnit, 'putra');
            $unitChartPutri = $this->getDivisionChartData($currentUnit, 'putri');
        }

        $currentGroupPhoto = null;
        if ($unitStruct) {
            $photoCol = $activeKelompok === 'putri' ? 'group_photo_putri' : 'group_photo';
            $photoPath = $unitStruct->$photoCol ?: ($activeKelompok === 'putri' ? $unitStruct->group_photo : null);
            if ($photoPath && file_exists(public_path('storage/' . $photoPath))) {
                $currentGroupPhoto = asset('storage/' . $photoPath);
            }
        }

        return view('admin.struktur.index', array_merge(
            compact(
                'structures',
                'activeUnitKey',
                'activeKelompok',
                'currentUnit',
                'unitStruct',
                'unitMembers',
                'leaders',
                'staff',
                'unitChartPutra',
                'unitChartPutri',
                'currentGroupPhoto',
                'bpiPositions'
            ),
            $chartData
        ));
    }

    public function reorderMember(Request $request, Member $member)
    {
        $direction = $request->input('direction', 'up');
        $division = $member->division;
        $kelompok = $member->kelompok;

        // Ambil semua anggota non-leader dalam divisi & kelompok yang sama, terurut
        $staffMembers = Member::where('division', $division)
            ->where('kelompok', $kelompok)
            ->where(function ($q) {
                $q->where('position', 'not like', '%co%')
                  ->where('position', 'not like', '%kepala%')
                  ->where('position', 'not like', '%koordinator%');
            })
            ->orderBy('order_num')
            ->orderBy('id')
            ->get();

        $index = $staffMembers->search(fn($m) => $m->id === $member->id);

        if ($index !== false) {
            $swapWith = null;
            if ($direction === 'up' && $index > 0) {
                $swapWith = $staffMembers[$index - 1];
            } elseif ($direction === 'down' && $index < $staffMembers->count() - 1) {
                $swapWith = $staffMembers[$index + 1];
            }

            if ($swapWith) {
                $tempOrder = $member->order_num;
                $member->order_num = $swapWith->order_num;
                $swapWith->order_num = $tempOrder;

                if ($member->order_num === $swapWith->order_num) {
                    if ($direction === 'up') {
                        $member->order_num = max(0, $swapWith->order_num - 1);
                    } else {
                        $member->order_num = $swapWith->order_num + 1;
                    }
                }

                $member->save();
                $swapWith->save();

                ActivityLog::record(
                    'update',
                    "Mengubah urutan pengurus: \"{$member->name}\" ({$direction})",
                    $member
                );
            }
        }

        $unit = $request->input('unit', 'bpi');
        return redirect()->route('admin.struktur-organisasi.index', [
            'unit' => $unit,
            'kelompok' => $kelompok
        ])->with('success', 'Urutan anggota pengurus berhasil diperbarui.');
    }

    public function uploadGroupPhoto(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:organizational_structures,id',
            'kelompok' => 'required|in:putra,putri',
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $struktur = OrganizationalStructure::findOrFail($request->unit_id);
        $kelompok = $request->kelompok;

        $file = $request->file('photo');
        $filename = 'group_' . $kelompok . '_' . time() . '_' . $file->hashName();
        $dest = storage_path('app/public/structures');
        if (!File::isDirectory($dest)) {
            File::makeDirectory($dest, 0755, true);
        }
        $file->move($dest, $filename);

        $field = $kelompok === 'putri' ? 'group_photo_putri' : 'group_photo';
        if ($struktur->$field && file_exists(storage_path('app/public/' . $struktur->$field))) {
            @unlink(storage_path('app/public/' . $struktur->$field));
        }

        $struktur->$field = 'structures/' . $filename;
        $struktur->save();

        ActivityLog::record(
            'update',
            "Memperbarui foto bersama unit {$struktur->position} ({$kelompok})",
            $struktur
        );

        $unitKey = $request->input('unit', 'bpi');
        return redirect()->route('admin.struktur-organisasi.index', [
            'unit' => $unitKey,
            'kelompok' => $kelompok
        ])->with('success', 'Foto bersama unit berhasil diperbarui.');
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
     * Prepare division chart data (leaders & staff) for a specific division and group
     */
    private function getDivisionChartData(array $currentUnit, string $kelompok): array
    {
        $search = $currentUnit['search'] ?? '';
        $struct = OrganizationalStructure::find($currentUnit['struct_id'] ?? 0);

        // Ambil dari model Member
        $members = Member::where('division', 'like', "%{$search}%")
            ->where('kelompok', $kelompok)
            ->where('is_active', true)
            ->orderBy('order_num')
            ->get();

        // Fallback ke struct jika member kosong dan struct cocok dengan kelompok
        if ($members->isEmpty() && $struct) {
            $matches = false;
            if ($kelompok === 'putra' && in_array($struct->kelompok, ['putra', 'semua'])) {
                $matches = true;
            } elseif ($kelompok === 'putri' && $struct->kelompok === 'putri') {
                $matches = true;
            }

            if ($matches && !empty($struct->name)) {
                $members = collect([(object)[
                    'id' => $struct->id,
                    'is_structure' => true,
                    'name' => $struct->name,
                    'position' => $struct->position,
                    'photo' => $struct->photo,
                    'kelompok' => $struct->kelompok,
                    'order_num' => 1,
                    'is_active' => $struct->is_active,
                    'description' => $struct->description,
                ]]);
            }
        }

        if ($members->isEmpty()) {
            return [
                'total' => 0,
                'leaders' => collect(),
                'staff' => collect(),
            ];
        }

        // Leaders: jabatan kepala / co / koordinator atau order_num terendah
        $leaders = $members->filter(function($m) {
            $pos = strtolower($m->position ?? '');
            return str_contains($pos, 'kepala') || str_contains($pos, 'koordinator') || str_contains($pos, 'co ');
        })->values();

        if ($leaders->isEmpty()) {
            $minOrder = $members->min('order_num') ?? 1;
            $leaders = $members->filter(fn($m) => ($m->order_num ?? 1) == $minOrder)->values();
            if ($leaders->isEmpty()) {
                $leaders = collect([$members->first()]);
            }
        }

        $leaderIds = $leaders->pluck('id')->filter()->toArray();

        $staff = $members->reject(function($m) use ($leaderIds) {
            return in_array($m->id, $leaderIds);
        })->sortBy('order_num')->values();

        return [
            'total' => $members->count(),
            'leaders' => $leaders,
            'staff' => $staff,
        ];
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
