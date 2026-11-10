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

        $data = [
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
