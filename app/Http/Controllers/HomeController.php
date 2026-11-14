<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Activity;
use App\Models\News;
use App\Models\Agenda;
use App\Models\Member;
use App\Models\Program;
use App\Models\Achievement;
use App\Models\Gallery;
use App\Models\Profile;
use App\Models\OrganizationalStructure;
use App\Models\VisionMission;
use App\Models\SiteSetting;
use App\Models\Download;

class HomeController extends Controller
{
    public function index()
    {
        // Upcoming agendas (published only), fallback to latest published
        $agendas = Agenda::published()
            ->where('date', '>=', now()->startOfDay())
            ->orderBy('date')
            ->take(3)
            ->get();

        if ($agendas->isEmpty()) {
            $agendas = Agenda::published()->orderBy('date', 'desc')->take(3)->get();
        }

        $profile = Profile::first();

        // Check if Kaprodi data exists in members
        $kaprodi = Member::where('position', 'like', '%kaprodi%')
            ->orWhere('position', 'like', '%ketua prodi%')
            ->orWhere('position', 'like', '%ketua program studi%')
            ->first();

        // Organizational structures for preview
        $structures = OrganizationalStructure::where('is_active', true)->orderBy('order_num')->get();

        // Dynamic stats
        $statsPengurus = ($profile && $profile->stats_mode === 'manual' && $profile->hero_stats_pengurus)
            ? $profile->hero_stats_pengurus
            : (Member::where('is_active', true)->count() ?: 68);

        $statsBidang = ($profile && $profile->stats_mode === 'manual' && $profile->hero_stats_bidang)
            ? $profile->hero_stats_bidang
            : (OrganizationalStructure::whereNotNull('parent_id')->count() ?: 6);

        $statsBiro = ($profile && $profile->stats_mode === 'manual' && $profile->hero_stats_biro)
            ? $profile->hero_stats_biro
            : (OrganizationalStructure::whereNull('parent_id')->count() ?: 4);

        // Helper to resolve image URL with proper asset path and fallback
        $resolvePhoto = function ($path, $defaultPlaceholder) {
            if (empty($path)) {
                return asset($defaultPlaceholder);
            }
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return $path;
            }
            if (file_exists(public_path('storage/' . $path))) {
                return asset('storage/' . $path);
            }
            if (file_exists(public_path('images/' . $path))) {
                return asset('images/' . $path);
            }
            if (file_exists(public_path($path))) {
                return asset($path);
            }
            return asset('storage/' . $path);
        };

        // 5 Foto Terbaru di Pinggir Kiri Hero: Berita, Prestasi, Agenda, Kegiatan
        $latestNewsItem = News::published()->whereNotNull('thumbnail')->latest('published_at')->first()
            ?? News::published()->latest('published_at')->first();

        $latestAchievementItem = Achievement::whereNotNull('image')->latest('year')->latest('id')->first()
            ?? Achievement::latest('id')->first();

        $latestAgendaItem = Agenda::published()->whereNotNull('image')->latest('date')->first()
            ?? Agenda::published()->latest('date')->first()
            ?? Agenda::latest('id')->first();

        $latestActivityItem = Activity::whereNotNull('image')->latest('date')->latest('id')->first()
            ?? Activity::latest('date')->latest('id')->first();

        $secondNewsItem = News::published()->whereNotNull('thumbnail')
            ->when($latestNewsItem, fn($q) => $q->where('id', '!=', $latestNewsItem->id))
            ->latest('published_at')
            ->first()
            ?? Gallery::published()->whereNotNull('image')->latest('id')->first();

        // 4 Foto Profil/Dokumentasi Terbaru di Pinggir Kiri Hero
        $heroRecentPhotos = [];

        // 1. Logo HIMATIKA
        $logoPath = file_exists(public_path('storage/branding/logo_main_1794400336.jpeg'))
            ? asset('storage/branding/logo_main_1794400336.jpeg')
            : ($profile && $profile->logo && file_exists(public_path('storage/' . $profile->logo))
                ? asset('storage/' . $profile->logo)
                : asset('images/logo.png'));

        $heroRecentPhotos[] = [
            'category' => 'HIMATIKA',
            'badge'    => 'Logo',
            'title'    => 'HIMATIKA UNUJA',
            'photo'    => $logoPath,
            'url'      => route('profil'),
        ];

        // 2. Santriwati (News ID 9 / Khotmil Quran)
        $newsKhidmah = News::where('thumbnail', 'like', '%news_1794407889%')->first();
        if ($newsKhidmah) {
            $heroRecentPhotos[] = [
                'category' => 'Berita',
                'badge'    => 'Berita',
                'title'    => $newsKhidmah->title,
                'photo'    => asset('storage/' . $newsKhidmah->thumbnail),
                'url'      => route('berita.show', $newsKhidmah->slug ?? $newsKhidmah->id),
            ];
        }

        // 3. Kegiatan / Kader (News ID 6)
        $newsKader = News::where('thumbnail', 'like', '%news_1794402196%')->first();
        if ($newsKader) {
            $heroRecentPhotos[] = [
                'category' => 'Kegiatan',
                'badge'    => 'Kegiatan',
                'title'    => $newsKader->title,
                'photo'    => asset('storage/' . $newsKader->thumbnail),
                'url'      => route('berita.show', $newsKader->slug ?? $newsKader->id),
            ];
        }

        // 4. Suasana Belajar (News ID 5)
        $newsBelajar = News::where('thumbnail', 'like', '%suasana-belajar-madrasah%')->first();
        if ($newsBelajar) {
            $heroRecentPhotos[] = [
                'category' => 'Prestasi & Belajar',
                'badge'    => 'Pendidikan',
                'title'    => $newsBelajar->title,
                'photo'    => $resolvePhoto($newsBelajar->thumbnail, 'images/news/suasana-belajar-madrasah.jpg'),
                'url'      => route('berita.show', $newsBelajar->slug ?? $newsBelajar->id),
            ];
        }

        // Sumber data bagian "Berita & Informasi Terkini" Beranda:
        // Menggunakan sumber data yang sama dengan menu Informasi -> Semua kategori.
        // Menggabungkan konten terbit dari Kegiatan, Pengumuman, Prestasi, Berita (News) dan Agenda (agendas).
        $newsItems = News::published()
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->take(12)
            ->get();

        $agendaItems = Agenda::published()
            ->latest('date')
            ->take(12)
            ->get();

        $combinedNews = collect();

        foreach ($newsItems as $n) {
            $pubDate = $n->published_at ? Carbon::parse($n->published_at) : ($n->created_at ? Carbon::parse($n->created_at) : now());
            $combinedNews->push((object)[
                'id'            => $n->id,
                'type'          => 'news',
                'unique_key'    => 'news_' . $n->id,
                'category'      => $n->category ?: 'Berita',
                'title'         => $n->title,
                'slug'          => $n->slug,
                'url'           => route('berita.show', $n->slug ?: $n->id),
                'thumbnail'     => $n->thumbnail,
                'image'         => $n->thumbnail,
                'published_at'  => $pubDate,
                'date'          => $pubDate,
                'sort_timestamp'=> $pubDate->timestamp,
                'excerpt'       => $n->excerpt ?: Str::limit(strip_tags($n->content), 130),
                'content'       => $n->content,
                'views'         => $n->views ?? 0,
                'is_agenda'     => false,
            ]);
        }

        foreach ($agendaItems as $ag) {
            $agDate = $ag->date ? Carbon::parse($ag->date) : ($ag->created_at ? Carbon::parse($ag->created_at) : now());
            $combinedNews->push((object)[
                'id'            => $ag->id,
                'type'          => 'agenda',
                'unique_key'    => 'agenda_' . $ag->id,
                'category'      => 'Agenda',
                'title'         => $ag->title,
                'slug'          => null,
                'url'           => $ag->registration_link ?: route('agenda'),
                'thumbnail'     => $ag->image,
                'image'         => $ag->image,
                'published_at'  => $agDate,
                'date'          => $agDate,
                'sort_timestamp'=> $agDate->timestamp,
                'excerpt'       => Str::limit(strip_tags($ag->description), 130),
                'content'       => $ag->description,
                'views'         => null,
                'is_agenda'     => true,
            ]);
        }

        // Urutkan dari yang terbaru berdasarkan tanggal, pastikan unik, dan ambil 6 item
        $combinedNews = $combinedNews
            ->unique('unique_key')
            ->sortByDesc('sort_timestamp')
            ->values();

        // Jika admin memilih berita unggulan di pengaturan Beranda, prioritaskan tampil di kartu utama
        $featuredNewsId = SiteSetting::where('key', 'home_featured_news_id')->value('value');
        if ($featuredNewsId) {
            $featIndex = $combinedNews->search(fn($item) => $item->type === 'news' && $item->id == $featuredNewsId);
            if ($featIndex !== false) {
                $featItem = $combinedNews->pull($featIndex);
                $combinedNews->prepend($featItem);
            } else {
                $specificNews = News::published()->find($featuredNewsId);
                if ($specificNews) {
                    $pubDate = $specificNews->published_at ? Carbon::parse($specificNews->published_at) : ($specificNews->created_at ? Carbon::parse($specificNews->created_at) : now());
                    $combinedNews->prepend((object)[
                        'id'            => $specificNews->id,
                        'type'          => 'news',
                        'unique_key'    => 'news_' . $specificNews->id,
                        'category'      => $specificNews->category ?: 'Berita',
                        'title'         => $specificNews->title,
                        'slug'          => $specificNews->slug,
                        'url'           => route('berita.show', $specificNews->slug ?: $specificNews->id),
                        'thumbnail'     => $specificNews->thumbnail,
                        'image'         => $specificNews->thumbnail,
                        'published_at'  => $pubDate,
                        'date'          => $pubDate,
                        'sort_timestamp'=> $pubDate->timestamp,
                        'excerpt'       => $specificNews->excerpt ?: Str::limit(strip_tags($specificNews->content), 130),
                        'content'       => $specificNews->content,
                        'views'         => $specificNews->views ?? 0,
                        'is_agenda'     => false,
                    ]);
                }
            }
        }
        $combinedNews = $combinedNews->values()->take(6);

        // Galeri Jejak Langkah: ambil semua galeri terbit, jika ada sorotan album letakkan di urutan pertama
        $galleries = Gallery::published()->orderBy('order_num')->latest()->get();
        $featuredGalleryId = SiteSetting::where('key', 'home_featured_gallery_id')->value('value');
        if ($featuredGalleryId) {
            $featGalIndex = $galleries->search(fn($g) => $g->id == $featuredGalleryId);
            if ($featGalIndex !== false) {
                $featGal = $galleries->pull($featGalIndex);
                $galleries->prepend($featGal);
            }
        }

        // Visi dan Misi untuk kartu Tentang di Beranda
        $vm = VisionMission::first();
        $missions = [];
        if ($vm && !empty($vm->mission)) {
            $missions = is_array($vm->mission) ? $vm->mission : json_decode($vm->mission, true);
        }
        if (empty($missions)) {
            $missions = [
                'Meningkatkan kemampuan akademik dan non-akademik mahasiswa Matematika.',
                'Mendorong kreativitas dan inovasi dalam bidang matematika terapan.',
                'Membangun solidaritas antar mahasiswa Matematika.',
                'Menyelenggarakan kegiatan edukatif dan kompetitif.',
                'Membangun kerja sama dengan pihak internal dan eksternal kampus.'
            ];
        }

        // Karya Website Mahasiswa untuk section Berkarya di Beranda
        $websiteWorksQuery = Download::published()
            ->whereNotNull('website_url')
            ->where('website_url', '!=', '');

        $websiteWorks = (clone $websiteWorksQuery)
            ->orderBy('order_num')
            ->latest()
            ->take(3)
            ->get();

        $totalWebsiteWorks = (clone $websiteWorksQuery)->count();

        $latestWebsiteYear = (clone $websiteWorksQuery)
            ->whereNotNull('year')
            ->where('year', '!=', '')
            ->max('year');

        if (empty($latestWebsiteYear)) {
            $latestWorkWithDate = (clone $websiteWorksQuery)->latest('created_at')->first();
            $latestWebsiteYear = $latestWorkWithDate && $latestWorkWithDate->created_at 
                ? $latestWorkWithDate->created_at->format('Y') 
                : null;
        }

        $data = [
            'websiteWorks'       => $websiteWorks,
            'totalWebsiteWorks'  => $totalWebsiteWorks,
            'latestWebsiteYear'  => $latestWebsiteYear,
            'heroRecentPhotos' => $heroRecentPhotos,
            'kaprodi'          => $kaprodi,
            'structures'       => $structures,
            'vm'               => $vm,
            'missions'         => $missions,
            'activities'       => Activity::latest('date')->take(4)->get(),
            'programs'         => Program::latest()->take(3)->get(),
            'news'             => $combinedNews,
            'combinedNews'     => $combinedNews,
            'agendas'          => $agendas,
            'achievements'     => Achievement::latest('year')->take(4)->get(),
            'galleries'        => $galleries,
            'totalMembers'     => $statsPengurus,
            'totalBidang'      => $statsBidang,
            'totalBiro'        => $statsBiro,
            'totalActivities'  => Activity::count(),
            'totalNews'        => News::published()->count(),
            'totalAchievements'=> Achievement::count(),
            'profile'          => $profile,
        ];

        return view('home', $data);
    }
}
