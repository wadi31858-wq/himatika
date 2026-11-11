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

        $heroRecentPhotos = [];

        if ($latestNewsItem) {
            $heroRecentPhotos[] = [
                'category' => 'Berita Terbaru',
                'badge'    => 'Berita',
                'title'    => $latestNewsItem->title,
                'photo'    => $resolvePhoto($latestNewsItem->thumbnail, 'images/news/news-1.jpg'),
                'url'      => route('berita.show', $latestNewsItem->slug ?? $latestNewsItem->id),
            ];
        }

        if ($latestAchievementItem) {
            $heroRecentPhotos[] = [
                'category' => 'Prestasi',
                'badge'    => 'Prestasi',
                'title'    => $latestAchievementItem->title,
                'photo'    => $resolvePhoto($latestAchievementItem->image, 'images/news/news-2.jpg'),
                'url'      => route('prestasi'),
            ];
        }

        if ($latestAgendaItem) {
            $heroRecentPhotos[] = [
                'category' => 'Agenda',
                'badge'    => 'Agenda',
                'title'    => $latestAgendaItem->title,
                'photo'    => $resolvePhoto($latestAgendaItem->image, 'images/news/news-5.jpg'),
                'url'      => route('agenda'),
            ];
        }

        if ($latestActivityItem) {
            $heroRecentPhotos[] = [
                'category' => 'Kegiatan',
                'badge'    => 'Kegiatan',
                'title'    => $latestActivityItem->title,
                'photo'    => $resolvePhoto($latestActivityItem->image, 'images/news/news-3.jpg'),
                'url'      => route('kegiatan.show', $latestActivityItem->slug ?? $latestActivityItem->id),
            ];
        }

        if ($secondNewsItem) {
            $isGal = $secondNewsItem instanceof Gallery;
            $photoPath = $isGal ? $secondNewsItem->image : ($secondNewsItem->thumbnail ?? $secondNewsItem->image);
            $heroRecentPhotos[] = [
                'category' => $isGal ? 'Dokumentasi' : 'Kabar Terkini',
                'badge'    => $isGal ? 'Galeri' : 'Berita',
                'title'    => $secondNewsItem->title,
                'photo'    => $resolvePhoto($photoPath, 'images/news/news-4.jpg'),
                'url'      => $isGal ? route('galeri') : route('berita.show', $secondNewsItem->slug ?? $secondNewsItem->id),
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
            ->values()
            ->take(6);

        $data = [
            'heroRecentPhotos' => $heroRecentPhotos,
            'kaprodi'          => $kaprodi,
            'structures'       => $structures,
            'activities'       => Activity::latest('date')->take(4)->get(),
            'programs'         => Program::latest()->take(3)->get(),
            'news'             => $combinedNews,
            'combinedNews'     => $combinedNews,
            'agendas'          => $agendas,
            'achievements'     => Achievement::latest('year')->take(4)->get(),
            'galleries'        => Gallery::published()->orderBy('order_num')->latest()->take(6)->get(),
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
