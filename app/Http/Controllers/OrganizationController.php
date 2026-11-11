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

        // 6 Jabatan Inti Putra & Putri + Kaprodi
        $kaprodi = OrganizationalStructure::find(12) ?? OrganizationalStructure::where('position', 'like', '%Kaprodi%')->first();
        $ketuaPutra = OrganizationalStructure::find(1) ?? OrganizationalStructure::where('position', 'like', '%Ketua Umum Putra%')->first();
        $ketuaPutri = OrganizationalStructure::find(2) ?? OrganizationalStructure::where('position', 'like', '%Ketua Umum Putri%')->first();
        $sekretarisPutra = OrganizationalStructure::find(3) ?? OrganizationalStructure::where('position', 'like', '%Sekretaris Putra%')->first();
        $sekretarisPutri = OrganizationalStructure::find(10) ?? OrganizationalStructure::where('position', 'like', '%Sekretaris Putri%')->first();
        $bendaharaPutra = OrganizationalStructure::find(11) ?? OrganizationalStructure::where('position', 'like', '%Bendahara Putra%')->first();
        $bendaharaPutri = OrganizationalStructure::find(4) ?? OrganizationalStructure::where('position', 'like', '%Bendahara Putri%')->first();

        // 5 Divisi HIMATIKA dalam urutan resmi yang ditentukan:
        // 1. Divisi Keilmuan
        // 2. Divisi Kaderisasi
        // 3. Divisi Publik Relasi
        // 4. Divisi Litbang
        // 5. Divisi Kominfo
        $divisiIds = [5, 6, 7, 9, 8];
        $divisiList = collect($divisiIds)->map(function ($id) {
            return OrganizationalStructure::find($id);
        })->filter();

        // Pre-build data pop-up modal divisi untuk JS
        $divisiData = [
            'keilmuan' => [
                'id' => 5,
                'name' => 'Divisi Keilmuan',
                'key' => 'keilmuan',
                'description' => 'Mengembangkan kapasitas akademik mahasiswa melalui kajian sains matematika murni dan terapan, tutorial sebaya, workshop matematika, serta pembinaan kompetisi olimpiade sains.',
                'detail_url' => route('struktur-organisasi.show', 5),
                'members' => Member::where('division', 'like', '%Keilmuan%')->get()->map(function($m) {
                    return [
                        'name' => $m->name,
                        'position' => $m->position,
                        'photo' => $m->photo ? asset('storage/' . $m->photo) : null,
                        'bio' => $m->bio ?? 'Pengurus Divisi Keilmuan HIMATIKA UNUJA.'
                    ];
                })
            ],
            'kaderisasi' => [
                'id' => 6,
                'name' => 'Divisi Kaderisasi',
                'key' => 'kaderisasi',
                'description' => 'Mengawal pembinaan karakter kepemimpinan, proses kaderisasi dan orientasi mahasiswa baru, upgrading kapasitas pengurus, serta penanaman integritas dan loyalitas organisasi.',
                'detail_url' => route('struktur-organisasi.show', 6),
                'members' => Member::where('division', 'like', '%Kaderisasi%')->get()->map(function($m) {
                    return [
                        'name' => $m->name,
                        'position' => $m->position,
                        'photo' => $m->photo ? asset('storage/' . $m->photo) : null,
                        'bio' => $m->bio ?? 'Pengurus Divisi Kaderisasi HIMATIKA UNUJA.'
                    ];
                })
            ],
            'publik_relasi' => [
                'id' => 7,
                'name' => 'Divisi Publik Relasi',
                'key' => 'publik_relasi',
                'description' => 'Membangun jejaring kolaborasi dan kemitraan eksternal kampus, menjalin hubungan erat dengan alumni, menyelenggarakan program bakti sosial, serta menjaga reputasi publik himpunan.',
                'detail_url' => route('struktur-organisasi.show', 7),
                'members' => Member::where('division', 'like', '%Publik Relasi%')->get()->map(function($m) {
                    return [
                        'name' => $m->name,
                        'position' => $m->position,
                        'photo' => $m->photo ? asset('storage/' . $m->photo) : null,
                        'bio' => $m->bio ?? 'Pengurus Divisi Publik Relasi HIMATIKA UNUJA.'
                    ];
                })
            ],
            'litbang' => [
                'id' => 9,
                'name' => 'Divisi Litbang',
                'key' => 'litbang',
                'description' => 'Melaksanakan riset organisasi, survei aspirasi mahasiswa, pemantauan dan evaluasi mutu program kerja berkala, serta merumuskan inovasi strategis pengembangan HIMATIKA.',
                'detail_url' => route('struktur-organisasi.show', 9),
                'members' => Member::where('division', 'like', '%Litbang%')->get()->map(function($m) {
                    return [
                        'name' => $m->name,
                        'position' => $m->position,
                        'photo' => $m->photo ? asset('storage/' . $m->photo) : null,
                        'bio' => $m->bio ?? 'Pengurus Divisi Litbang HIMATIKA UNUJA.'
                    ];
                })
            ],
            'kominfo' => [
                'id' => 8,
                'name' => 'Divisi Kominfo',
                'key' => 'kominfo',
                'description' => 'Mengelola ekosistem media komunikasi digital, produksi konten multimedia kreatif, pengelolaan website resmi dan media sosial, serta pusat informasi terkini HIMATIKA UNUJA.',
                'detail_url' => route('struktur-organisasi.show', 8),
                'members' => Member::where('division', 'like', '%Kominfo%')->get()->map(function($m) {
                    return [
                        'name' => $m->name,
                        'position' => $m->position,
                        'photo' => $m->photo ? asset('storage/' . $m->photo) : null,
                        'bio' => $m->bio ?? 'Pengurus Divisi Kominfo HIMATIKA UNUJA.'
                    ];
                })
            ],
        ];

        return view('struktur-organisasi', compact(
            'structures',
            'members',
            'kaprodi',
            'ketuaPutra',
            'ketuaPutri',
            'sekretarisPutra',
            'sekretarisPutri',
            'bendaharaPutra',
            'bendaharaPutri',
            'divisiList',
            'divisiData'
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
        $anggota = Member::where('division', 'like', '%' . $searchKey . '%')
            ->orWhere('position', 'like', '%' . $jabatan->position . '%')
            ->get();

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
