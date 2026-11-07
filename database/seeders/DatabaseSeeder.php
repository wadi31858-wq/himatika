<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\VisionMission;
use App\Models\OrganizationalStructure;
use App\Models\Member;
use App\Models\Program;
use App\Models\Activity;
use App\Models\News;
use App\Models\Agenda;
use App\Models\Achievement;
use App\Models\Download;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([AdminSeeder::class]);

        Profile::create([
            'title' => 'Profil HIMATIKA UNUJA',
            'content' => '<p>Himpunan Mahasiswa Matematika (HIMATIKA) Universitas Nahdlatul Ulama Jember adalah organisasi kemahasiswaan yang menaungi seluruh mahasiswa Program Studi Matematika.</p><p>HIMATIKA UNUJA berkomitmen untuk menciptakan lingkungan akademis yang kondusif, mendorong inovasi, serta membangun solidaritas antar mahasiswa Matematika.</p>',
            'motto' => 'Synchronized Growth, Reaching New Heights',
            'philosophy' => '<p>Lambang HIMATIKA merupakan simbol yang mengandung makna mendalam tentang identitas dan semangat organisasi:</p><ul><li><strong>Bentuk Perisai:</strong> Melambangkan perlindungan dan kekuatan dalam menjaga kehormatan organisasi</li><li><strong>Simbol Matematika:</strong> Melambangkan ilmu pasti sebagai inti dari Himpunan Mahasiswa Matematika</li><li><strong>Buku Terbuka:</strong> Melambangkan ilmu pengetahuan dan semangat belajar yang tidak pernah padam</li><li><strong>Torch/Obor:</strong> Melambangkan pencerahan dan semangat kepemimpinan</li><li><strong>Warna Hijau:</strong> Melambangkan kebijaksanaan, kepercayaan, dan profesionalisme</li><li><strong>Warna Emas:</strong> Melambangkan keunggulan dan prestasi</li></ul>',
            'mars' => '<p><strong>HIMATIKA UNUJA BERJAYA</strong></p><p>Himpunan Mahasiswa Matematika UNUJA<br>Berkarya bersama demi nama bangsa<br>Berinovasi dalam setiap langkah<br>Mengembangkan ilmu untuk negeri</p><p>Bersatu dalam semangat kekeluargaan<br>Berkontribusi untuk kemajuan bersama<br>HIMATIKA jaya, HIMATIKA berjaya<br>Selalu di hati selamanya</p>',
            'history' => '<p><strong>2020</strong> - HIMATIKA UNUJA didirikan oleh mahasiswa perdana Program Studi Matematika</p><p><strong>2021</strong> - Penyelenggaraan kegiatan perdana: Seminar Matematika Terapan</p><p><strong>2022</strong> - Perluasan divisi organisasi: penambahan Divisi Kominfo dan Minat Bakat</p><p><strong>2023</strong> - Pengukuhan kepengurusan periode pertama dan penyusunan AD/ART</p><p><strong>2024</strong> - Kerja sama dengan komunitas matematika regional dan nasional</p><p><strong>2025</strong> - Transformasi digital: peluncuran website resmi HIMATIKA</p><p><strong>2026</strong> - Periode kepengurusan baru dengan visi "Synchronized Growth, Reaching New Heights"</p>',
            'campus_name' => 'Universitas Nahdlatul Ulama Jember',
            'address' => 'Jl. KH Wahid Hasyim No. 170, Jember',
            'email' => 'himatika@unuja.ac.id',
            'phone' => '081234567890',
            'instagram' => '@himatika_unuja',
            'youtube' => 'HIMATIKA UNUJA',
            'tiktok' => '@himatika_unuja',
        ]);

        VisionMission::create([
            'vision' => 'Menjadi organisasi mahasiswa Matematika yang aktif, inovatif, kolaboratif, dan unggul dalam pengembangan ilmu matematika serta sumber daya mahasiswa.',
            'mission' => json_encode([
                'Meningkatkan kemampuan akademik dan non-akademik mahasiswa Matematika',
                'Mendorong kreativitas dan inovasi dalam bidang matematika terapan',
                'Membangun solidaritas antar mahasiswa Matematika',
                'Menyelenggarakan kegiatan edukatif dan kompetitif',
                'Membangun kerja sama dengan pihak internal dan eksternal kampus',
                'Mengembangkan potensi mahasiswa Matematika UNUJA',
            ]),
        ]);

        $ketua = OrganizationalStructure::create([
            'name' => 'Ahmad Rizki',
            'position' => 'Ketua Umum',
            'division' => 'Pengurus Inti',
        ]);

        OrganizationalStructure::create([
            'name' => 'Siti Nurhaliza',
            'position' => 'Wakil Ketua',
            'division' => 'Pengurus Inti',
            'parent_id' => $ketua->id,
        ]);

        $sekretaris = OrganizationalStructure::create([
            'name' => 'Budi Santoso',
            'position' => 'Sekretaris',
            'division' => 'Pengurus Inti',
            'parent_id' => $ketua->id,
        ]);

        OrganizationalStructure::create([
            'name' => 'Dewi Lestari',
            'position' => 'Bendahara',
            'division' => 'Pengurus Inti',
            'parent_id' => $ketua->id,
        ]);

        $wakil = OrganizationalStructure::where('position', 'Wakil Ketua')->first();

        OrganizationalStructure::create(['name' => 'Rina Sari', 'position' => 'Kepala Divisi', 'division' => 'Pendidikan', 'parent_id' => $wakil->id]);
        OrganizationalStructure::create(['name' => 'Fajar Nugroho', 'position' => 'Kepala Divisi', 'division' => 'PSDM', 'parent_id' => $wakil->id]);
        OrganizationalStructure::create(['name' => 'Maya Putri', 'position' => 'Kepala Divisi', 'division' => 'Humas', 'parent_id' => $sekretaris->id]);
        OrganizationalStructure::create(['name' => 'Andi Pratama', 'position' => 'Kepala Divisi', 'division' => 'Kominfo', 'parent_id' => $sekretaris->id]);
        OrganizationalStructure::create(['name' => 'Lestari Wulan', 'position' => 'Kepala Divisi', 'division' => 'Minat dan Bakat', 'parent_id' => $wakil->id]);

        $members = [
            ['name' => 'Ahmad Rizki', 'nim' => '2023001', 'position' => 'Ketua Umum', 'division' => 'Pengurus Inti', 'period' => '2025-2026', 'bio' => 'Mahasiswa aktif yang berkomitmen memajukan HIMATIKA UNUJA.'],
            ['name' => 'Siti Nurhaliza', 'nim' => '2023002', 'position' => 'Wakil Ketua', 'division' => 'Pengurus Inti', 'period' => '2025-2026', 'bio' => 'Aktif dalam kegiatan kemahasiswaan.'],
            ['name' => 'Budi Santoso', 'nim' => '2023003', 'position' => 'Sekretaris', 'division' => 'Pengurus Inti', 'period' => '2025-2026', 'bio' => 'Terorganisir dan teliti dalam Administrasi.'],
            ['name' => 'Dewi Lestari', 'nim' => '2023004', 'position' => 'Bendahara', 'division' => 'Pengurus Inti', 'period' => '2025-2026', 'bio' => 'Ahli pengelolaan keuangan organisasi.'],
            ['name' => 'Rina Sari', 'nim' => '2023005', 'position' => 'Kepala Divisi', 'division' => 'Pendidikan', 'period' => '2025-2026', 'bio' => 'Fokus pada kualitas pendidikan mahasiswa.'],
            ['name' => 'Fajar Nugroho', 'nim' => '2023006', 'position' => 'Kepala Divisi', 'division' => 'PSDM', 'period' => '2025-2026', 'bio' => 'Berpengalaman dalam pengembangan sumber daya manusia.'],
            ['name' => 'Maya Putri', 'nim' => '2023007', 'position' => 'Kepala Divisi', 'division' => 'Humas', 'period' => '2025-2026', 'bio' => 'Komunikatif dan aktif menjalin kerja sama.'],
            ['name' => 'Andi Pratama', 'nim' => '2023008', 'position' => 'Kepala Divisi', 'division' => 'Kominfo', 'period' => '2025-2026', 'bio' => 'Ahli teknologi informasi dan media digital.'],
            ['name' => 'Lestari Wulan', 'nim' => '2023009', 'position' => 'Kepala Divisi', 'division' => 'Minat dan Bakat', 'period' => '2025-2026', 'bio' => 'Aktif seni dan olahraga.'],
            ['name' => 'Eko Prasetyo', 'nim' => '2023010', 'position' => 'Staff', 'division' => 'Pendidikan', 'period' => '2025-2026', 'bio' => 'Staff divisi pendidikan.'],
        ];
        foreach ($members as $m) Member::create($m);

        Program::create(['title' => 'Workshop Matematika Terapan', 'division' => 'Pendidikan', 'description' => 'Workshop penerapan matematika dalam kehidupan sehari-hari dan industri.', 'date' => '2026-02-15', 'status' => 'Selesai']);
        Program::create(['title' => 'Seminar Statistika dan Data Sains', 'division' => 'Kominfo', 'description' => 'Seminar perkembangan statistika dan data sains modern.', 'date' => '2026-03-10', 'status' => 'Selesai']);
        Program::create(['title' => 'Bootcamp Python for Mathematics', 'division' => 'Pendidikan', 'description' => 'Bootcamp intensif pemrograman Python untuk matematika.', 'date' => '2026-04-20', 'status' => 'Sedang Berjalan']);
        Program::create(['title' => 'Math Challenge UNUJA 2026', 'division' => 'Pengurus Inti', 'description' => 'Kompetisi matematika tahunan antar mahasiswa.', 'date' => '2026-06-01', 'status' => 'Akan Datang']);
        Program::create(['title' => 'Bakti Sosial', 'division' => 'PSDM', 'description' => 'Bakti sosial untuk masyarakat sekitar kampus.', 'date' => '2026-05-15', 'status' => 'Akan Datang']);

        Activity::create(['title' => 'Workshop Python Dasar', 'slug' => 'workshop-python-dasar', 'description' => '<p>Workshop dasar-dasar pemrograman Python untuk mahasiswa matematika.</p>', 'date' => '2026-01-20', 'location' => 'Lab Komputer 1', 'organizer' => 'Divisi Pendidikan', 'status' => 'Selesai']);
        Activity::create(['title' => 'Seminar Data Sains', 'slug' => 'seminar-data-sains', 'description' => '<p>Seminar pengenalan data sains dan penerapannya.</p>', 'date' => '2026-02-10', 'location' => 'Auditorium', 'organizer' => 'Divisi Kominfo', 'status' => 'Selesai']);
        Activity::create(['title' => 'Lomba Matematika', 'slug' => 'lomba-matematika', 'description' => '<p>Lomba pemecahan masalah matematika antar mahasiswa.</p>', 'date' => '2026-03-15', 'location' => 'Ruang Kuliah A', 'organizer' => 'Divisi Pendidikan', 'status' => 'Selesai']);
        Activity::create(['title' => 'Bootcamp Machine Learning', 'slug' => 'bootcamp-machine-learning', 'description' => '<p>Bootcamp intensif machine learning selama 3 hari.</p>', 'date' => '2026-05-01', 'location' => 'Lab Komputer 1', 'organizer' => 'Divisi Pendidikan', 'status' => 'Sedang Berjalan']);
        Activity::create(['title' => 'Math Challenge 2026', 'slug' => 'math-challenge-2026', 'description' => '<p>Kompetisi matematika tahunan HIMATIKA UNUJA.</p>', 'date' => '2026-06-01', 'location' => 'Gedung Serbaguna', 'organizer' => 'Pengurus Inti', 'status' => 'Akan Datang']);

        News::create(['title' => 'Workshop Python Berhasil Diselenggarakan', 'slug' => 'workshop-python-berhasil', 'category' => 'Kegiatan', 'content' => '<p>Workshop Python dasar telah berhasil diselenggarakan pada tanggal 20 Januari 2026. Acara dihadiri oleh 30 mahasiswa Matematika UNUJA.</p>', 'author' => 'Admin HIMATIKA', 'published_at' => now()->subDays(10)]);
        News::create(['title' => 'Seminar Data Sains Resmi Dibuka', 'slug' => 'seminar-data-sains-dibuka', 'category' => 'Pengumuman', 'content' => '<p>Seminar Data Sains akan diselenggarakan pada bulan Februang mendatang.</p>', 'author' => 'Admin HIMATIKA', 'published_at' => now()->subDays(5)]);
        News::create(['title' => 'HIMATIKA Raih Juara 2 Lomba Matematika', 'slug' => 'himatika-juara-2-lomba-matematika', 'category' => 'Prestasi', 'content' => '<p>Tim HIMATIKA UNUJA berhasil meraih juara 2 dalam lomba matematika tingkat nasional.</p>', 'author' => 'Admin HIMATIKA', 'published_at' => now()->subDays(2)]);

        Agenda::create(['title' => 'Rapat Internal Pengurus', 'description' => 'Rapat bulanan seluruh pengurus HIMATIKA UNUJA.', 'date' => now()->addDays(7)->toDateString(), 'time' => '14:00 - 16:00', 'location' => 'Ruang Rapat', 'status' => 'Akan Datang']);
        Agenda::create(['title' => 'Workshop Machine Learning', 'description' => 'Workshop penerapan machine learning untuk data matematika.', 'date' => now()->addDays(14)->toDateString(), 'time' => '09:00 - 12:00', 'location' => 'Lab Komputer 1', 'status' => 'Akan Datang']);
        Agenda::create(['title' => 'Acara Buka Bersama', 'description' => 'Buka puasa bersama seluruh anggota HIMATIKA.', 'date' => now()->addDays(20)->toDateString(), 'time' => '17:00 - 20:00', 'location' => 'Kantin Kampus', 'status' => 'Akan Datang']);

        Achievement::create(['title' => 'Juara 2 Lomba Matematika', 'participant' => 'Tim HIMATIKA A', 'category' => 'Matematika', 'level' => 'Nasional', 'year' => '2026', 'rank' => 'Juara 2', 'description' => 'Lomba matematika tingkat nasional.']);
        Achievement::create(['title' => 'Juara 1 Olimpiade Matematika', 'participant' => 'Ahmad Rizki', 'category' => 'Matematika', 'level' => 'Universitas', 'year' => '2025', 'rank' => 'Juara 1', 'description' => 'Olimpiade matematika antar universitas.']);
        Achievement::create(['title' => 'Best Paper Award', 'participant' => 'Siti Nurhaliza', 'category' => 'Akademik', 'level' => 'Nasional', 'year' => '2025', 'rank' => 'Best Paper', 'description' => 'Penulisan artikel ilmiah terbaik di bidang matematika.']);

        Download::create(['title' => 'AD/ART HIMATIKA', 'description' => 'Anggaran Dasar dan Anggaran Rumah Tangga HIMATIKA UNUJA.', 'file' => 'ad-art-himatika.pdf']);
        Download::create(['title' => 'Pedoman Organisasi', 'description' => 'Pedoman keorganisasian HIMATIKA UNUJA.', 'file' => 'pedoman-organisasi.pdf']);
        Download::create(['title' => 'Formulir Keanggotaan', 'description' => 'Formulir pendaftaran keanggotaan HIMATIKA UNUJA.', 'file' => 'formulir-keanggotaan.pdf']);
    }
}
