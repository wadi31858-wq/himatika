<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        $data = [
            'heroRecentPhotos' => $heroRecentPhotos,
            'kaprodi'          => $kaprodi,
            'structures'       => $structures,
            'activities'       => Activity::latest('date')->take(4)->get(),
            'programs'         => Program::latest()->take(3)->get(),
            'news'             => News::published()->latest('published_at')->take(6)->get(),
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
