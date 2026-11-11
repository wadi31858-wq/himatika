<?php

namespace App\Http\Controllers;

use App\Models\OrganizationalStructure;
use App\Models\Member;

class OrganizationController extends Controller
{
    public function index()
    {
        $structures = OrganizationalStructure::with('children')->whereNull('parent_id')->get();
        $members = OrganizationalStructure::all();

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
            ->first();

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
            ->first();

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

        // Membangun data per-divisi untuk Putra dan Putri
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
                'name' => $divisionName,
                'description' => $divisionDesc,
                'detail_url' => route('struktur-organisasi.show', $def['id']),
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
                'name' => $divisionName,
                'description' => $divisionDesc,
                'detail_url' => route('struktur-organisasi.show', $def['id']),
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
                'leader_name' => $leaderPutri?->name ?? ($struct?->name ?? 'Pengurus Putri'),
                'leader_position' => $leaderPutri?->position ?? 'Koordinator Divisi',
                'members' => $modalMembersPutri
            ];
        }

        // Backward compatibility
        $divisiList = collect([5, 6, 7, 9, 8])->map(function ($id) {
            return OrganizationalStructure::find($id);
        })->filter();

        return view('struktur-organisasi', compact(
            'structures',
            'members',
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
            'divisiList'
        ));
    }

    public function show($id)
    {
        $jabatan = OrganizationalStructure::with(['children', 'parent'])->findOrFail($id);
        
        // Ambil beberapa jabatan terkait
        $terkait = collect();
        if ($jabatan->children->count() > 0) {
            $terkait = $jabatan->children;
        } elseif ($jabatan->parent_id) {
            $terkait = OrganizationalStructure::where('parent_id', $jabatan->parent_id)->where('id', '!=', $jabatan->id)->get();
        } else {
            $terkait = OrganizationalStructure::where('id', '!=', $jabatan->id)->take(4)->get();
        }

        // Siapkan data Tugas Utama, Program, dan Tugas Teknis yang spesifik per jabatan
        $roleData = $this->getRoleDetails($jabatan);

        // Anggota dalam jabatan / divisi ini
        $searchKey = $jabatan->division ?: $jabatan->position;
        $anggotaQuery = Member::where(function($q) use ($searchKey, $jabatan) {
            $q->where('division', 'like', '%' . $searchKey . '%')
              ->orWhere('position', 'like', '%' . $jabatan->position . '%');
        });
        if ($jabatan->kelompok && in_array($jabatan->kelompok, ['putra', 'putri'])) {
            $anggotaQuery->where('kelompok', $jabatan->kelompok);
        }
        $anggota = $anggotaQuery->get();

        if ($anggota->isEmpty() && $jabatan->name) {
            $anggota = collect([(object)[
                'name' => $jabatan->name,
                'position' => $jabatan->position,
                'photo' => $jabatan->photo,
                'bio' => $jabatan->description ?: 'Pengurus resmi HIMATIKA UNUJA.'
            ]]);
        }

        return view('struktur-detail', compact('jabatan', 'terkait', 'roleData', 'anggota'));
    }

    private function getRoleDetails($jabatan)
    {
        $pos = strtolower($jabatan->position ?? '');
        $div = strtolower($jabatan->division ?? '');

        if (str_contains($pos, 'ketua umum putra')) {
            return [
                'tugas_utama' => [
                    'Memimpin dan mengoordinasikan seluruh jajaran kepengurusan HIMATIKA Putra sesuai AD/ART.',
                    'Mengoordinasikan pelaksanaan program kerja serta agenda tiap divisi kepengurusan putra.',
                    'Mengambil keputusan strategis dalam rapat koordinasi dan musyawarah kemahasiswaan putra.',
                    'Menyampaikan laporan pertanggungjawaban kepengurusan putra pada musyawarah mahasiswa.'
                ],
                'program' => [
                    'Rapat Koordinasi Rutin Kepengurusan Putra',
                    'Monitoring & Evaluasi Kinerja Divisi Putra',
                    'Sinergi Program Bersama Formatur Kepengurusan Putri'
                ],
                'tugas_teknis' => [
                    'Pengambilan keputusan strategis arah gerak organisasi putra.',
                    'Representasi resmi kemahasiswaan Matematika putra.',
                    'Evaluasi berkala efektivitas program kerja pengurus.'
                ]
            ];
        }

        if (str_contains($pos, 'ketua umum putri')) {
            return [
                'tugas_utama' => [
                    'Memimpin dan mengoordinasikan seluruh jajaran kepengurusan HIMATIKA Putri sesuai AD/ART.',
                    'Mengoordinasikan program kerja serta aktivitas kemahasiswaan putri secara berkelanjutan.',
                    'Membangun iklim kekeluargaan, sinergi, dan integritas kepengurusan putri yang solid.',
                    'Menyampaikan laporan pertanggungjawaban kepengurusan putri pada forum resmi organisasi.'
                ],
                'program' => [
                    'Rapat Evaluasi Berkala Kepengurusan Putri',
                    'Program Pendampingan & Pembinaan Anggota Putri',
                    'Kolaborasi Strategis Kegiatan Terpadu Mahasiswa'
                ],
                'tugas_teknis' => [
                    'Pengambilan keputusan internal organisasi keputrian.',
                    'Representasi resmi kemahasiswaan Matematika putri.',
                    'Pengawasan berkala efektivitas divisi keputrian.'
                ]
            ];
        }

        if (str_contains($pos, 'sekretaris putra')) {
            return [
                'tugas_utama' => [
                    'Mengoordinasikan seluruh administrasi persuratan dan pengarsipan kepengurusan putra.',
                    'Menyusun notula dan dokumentasi resmi setiap rapat internal kepengurusan putra.',
                    'Mengelola data keanggotaan dan inventaris kesekretariatan organisasi putra.',
                    'Menyusun laporan administrasi berkala pertanggungjawaban kesekretariatan.'
                ],
                'program' => [
                    'Digitalisasi Pengarsipan & Database Anggota Putra',
                    'Penyusunan Standard Operating Procedure (SOP) Persuratan',
                    'Penerbitan Surat Keputusan & Dokumen Resmi'
                ],
                'tugas_teknis' => [
                    'Penomoran dan pengarsipan surat masuk dan surat keluar.',
                    'Penyusunan proposal kegiatan dan lembar pengesahan.',
                    'Pengelolaan arsip dokumen digital secara tertib.'
                ]
            ];
        }

        if (str_contains($pos, 'sekretaris putri')) {
            return [
                'tugas_utama' => [
                    'Mengoordinasikan administrasi persuratan dan ketertiban arsip kepengurusan putri.',
                    'Mendokumentasikan hasil musyawarah dan notulensi rapat kepengurusan putri.',
                    'Mengelola berkas kegiatan dan inventaris administrasi putri.',
                    'Menyusun laporan berkala administrasi kesekretariatan putri.'
                ],
                'program' => [
                    'Sistem Pengarsipan Dokumen Terpusat Putri',
                    'Standardisasi Format Proposal dan LPJ Keputrian',
                    'Pendataan Keaktifan Anggota Mahasiswi'
                ],
                'tugas_teknis' => [
                    'Registrasi dan pengarsipan surat dinas keputrian.',
                    'Penyusunan draft surat dan undangan kegiatan.',
                    'Penyimpanan rapi notulensi rapat kepengurusan.'
                ]
            ];
        }

        if (str_contains($pos, 'bendahara putra')) {
            return [
                'tugas_utama' => [
                    'Mengoordinasikan pengelolaan kas dan keuangan kepengurusan HIMATIKA Putra.',
                    'Menyusun rancangan anggaran pendapatan dan belanja kegiatan (RAPBK) putra.',
                    'Melakukan pencatatan pembukuan dan memvalidasi bukti transaksi pengeluaran.',
                    'Menyampaikan laporan keuangan berkala secara transparan dan akuntabel.'
                ],
                'program' => [
                    'Pengelolaan Kas Rutin HIMATIKA Putra',
                    'Pembukuan Keuangan Digital Transparan',
                    'Pengawasan & Verifikasi Anggaran Kegiatan'
                ],
                'tugas_teknis' => [
                    'Verifikasi kuitansi dan nota transaksi pengeluaran.',
                    'Rekapitulasi arus kas mingguan dan bulanan.',
                    'Penyusunan laporan pertanggungjawaban keuangan.'
                ]
            ];
        }

        if (str_contains($pos, 'bendahara putri')) {
            return [
                'tugas_utama' => [
                    'Mengoordinasikan kebendaharaan dan anggaran kegiatan kepengurusan HIMATIKA Putri.',
                    'Menyusun rencana anggaran dan memvalidasi kebutuhan dana program kerja keputrian.',
                    'Mencatat seluruh arus kas masuk dan keluar kepengurusan putri secara akuntabel.',
                    'Menyajikan laporan keuangan berkala pada rapat koordinasi keputrian.'
                ],
                'program' => [
                    'Manajemen Kas Terpadu Kepengurusan Putri',
                    'Sistem Pembukuan Anggaran Berkelanjutan',
                    'Penyusunan Laporan Pertanggungjawaban Finansial'
                ],
                'tugas_teknis' => [
                    'Penerimaan dan pencatatan kas rutin anggota mahasiswi.',
                    'Penyelarasan bukti kuitansi kegiatan dengan anggaran.',
                    'Penyusunan rekap kas bulanan yang transparan.'
                ]
            ];
        }

        if (str_contains($div, 'keilmuan') || str_contains($pos, 'keilmuan')) {
            return [
                'tugas_utama' => [
                    'Memfasilitasi peningkatan kompetensi akademik dan keilmuan mahasiswa matematika.',
                    'Menyelenggarakan kajian berkala seputar analisis matematika, aljabar, dan statistika.',
                    'Mempersiapkan delegasi mahasiswa untuk olimpiade matematika (ONMIPA/KNMIPA).',
                    'Menyediakan forum bimbingan belajar dan tutorial sebaya.'
                ],
                'program' => [
                    'Math Tutorial & Peer Learning',
                    'Workshop Pemrograman Matematika Terapan',
                    'Pelatihan Intensif Olimpiade Matematika'
                ],
                'tugas_teknis' => [
                    'Penyusunan modul dan bank soal tutorial.',
                    'Koordinasi jadwal bimbingan belajar mahasiswa.',
                    'Monitoring perkembangan capaian akademik anggota.'
                ]
            ];
        }

        if (str_contains($div, 'kaderisasi') || str_contains($pos, 'kaderisasi')) {
            return [
                'tugas_utama' => [
                    'Merancang dan melaksanakan alur kaderisasi mahasiswa baru Matematika UNUJA.',
                    'Menanamkan nilai-nilai kepemimpinan, integritas, dan solidaritas organisasi.',
                    'Mengevaluasi perkembangan keaktifan anggota dan calon pengurus.',
                    'Menyelenggarakan forum upgrading skill keorganisasian berkala.'
                ],
                'program' => [
                    'Orientasi Mahasiswa Baru (Ospek Jurusan)',
                    'Latihan Keterampilan Manajemen Mahasiswa (LKMM)',
                    'Upgrading & Team Building Pengurus'
                ],
                'tugas_teknis' => [
                    'Penyusunan kurikulum kaderisasi bertahap.',
                    'Pendampingan kelompok mahasiswa baru.',
                    'Penilaian keaktifan dan loyalitas kader.'
                ]
            ];
        }

        if (str_contains($div, 'publik relasi') || str_contains($pos, 'publik relasi')) {
            return [
                'tugas_utama' => [
                    'Membangun relasi kemitraan dengan lembaga internal dan eksternal kampus.',
                    'Mengoordinasikan kegiatan pengabdian masyarakat dan bakti sosial himpunan.',
                    'Memelihara jejaring komunikasi dengan Ikatan Alumni Matematika UNUJA.',
                    'Menjadi narahubung utama dalam kegiatan kolaboratif antar-himpunan.'
                ],
                'program' => [
                    'Math Care (Bakti Sosial & Pengabdian Masyarakat)',
                    'Kunjungan Studi Banding Lembaga Kemahasiswaan',
                    'Forum Silahturahmi & Sarasehan Alumni'
                ],
                'tugas_teknis' => [
                    'Penyusunan database kemitraan dan kontak alumni.',
                    'Distribusi undangan kemitraan dan kerja sama eksternal.',
                    'Koordinasi protokol penerimaan tamu himpunan.'
                ]
            ];
        }

        if (str_contains($div, 'litbang') || str_contains($pos, 'litbang')) {
            return [
                'tugas_utama' => [
                    'Melakukan evaluasi berkala terhadap efektivitas program kerja setiap divisi.',
                    'Menjaring aspirasi, saran, dan kritik konstruktif dari mahasiswa Matematika.',
                    'Melakukan riset organisasi untuk merumuskan inovasi dan arah kebijakan baru.',
                    'Menyusun rekomendasi perbaikan kinerja kepengurusan.'
                ],
                'program' => [
                    'Survei Kepuasan & Aspirasi Mahasiswa',
                    'Evaluasi Tengah Periode (Mid-Term Review)',
                    'Kajian Inovasi Pengembangan Program Kerja'
                ],
                'tugas_teknis' => [
                    'Penyusunan instrumen kuesioner evaluasi.',
                    'Pengolahan dan visualisasi data survei anggota.',
                    'Penyusunan laporan rekomendasi strategis organisasi.'
                ]
            ];
        }

        if (str_contains($div, 'kominfo') || str_contains($pos, 'kominfo')) {
            return [
                'tugas_utama' => [
                    'Mengelola seluruh saluran media komunikasi resmi HIMATIKA (website, Instagram, YouTube).',
                    'Memproduksi konten edukasi, visual, poster, dan infografis kegiatan yang kreatif.',
                    'Mendokumentasikan seluruh rangkaian acara dan arsip multimedia organisasi.',
                    'Mengembangkan sistem informasi dan publikasi digital kemahasiswaan.'
                ],
                'program' => [
                    'Optimalisasi Website & Portal Informasi HIMATIKA',
                    'Penerbitan Konten Edukasi "Math Fact & News"',
                    'Dokumentasi Multimedia & Liputan Kegiatan'
                ],
                'tugas_teknis' => [
                    'Desain feed, flyer, dan materi visual media sosial.',
                    'Pengelolaan artikel dan berita pada website resmi.',
                    'Arsip foto dan video liputan kegiatan himpunan.'
                ]
            ];
        }

        // Default / Pembina
        return [
            'tugas_utama' => [
                'Memberikan arahan strategis terhadap program kerja kepengurusan.',
                'Membimbing pelaksanaan kegiatan kemahasiswaan agar selaras dengan tridharma perguruan tinggi.',
                'Mendukung pengembangan prestasi akademik dan non-akademik mahasiswa Matematika.',
                'Mengevaluasi ketercapaian visi dan misi himpunan secara berkala.'
            ],
            'program' => [
                'Konsultasi & Pembinaan Berkala Kepengurusan',
                'Penyelarasan Program Akademik Program Studi & Himpunan'
            ],
            'tugas_teknis' => [
                'Pemberian disposisi dan rekomendasi kegiatan.',
                'Monitoring tata kelola organisasi kemahasiswaan.',
                'Pendampingan delegasi lomba dan kompetisi.'
            ]
        ];
    }
}
