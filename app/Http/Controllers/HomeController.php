<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
use App\Models\News;
use App\Models\Agenda;
use App\Models\Member;
use App\Models\Program;
use App\Models\Achievement;
use App\Models\Gallery;
use App\Models\Profile;
use App\Models\VisionMission;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil agenda mendatang, jika tidak ada ambil yang terbaru
        $agendas = Agenda::where('date', '>=', now()->startOfDay())->orderBy('date')->take(3)->get();
        if ($agendas->isEmpty()) {
            $agendas = Agenda::orderBy('date', 'desc')->take(3)->get();
        }

        $data = [
            'activities'       => Activity::latest('date')->take(3)->get(),
            'news'             => News::latest('published_at')->take(6)->get(),
            'agendas'          => $agendas,
            'achievements'     => Achievement::latest('year')->take(4)->get(),
            'galleries'        => Gallery::latest()->take(6)->get(),
            'totalMembers'     => Member::count(),
            'totalActivities'  => Activity::count(),
            'totalNews'        => News::count(),
            'totalAchievements'=> Achievement::count(),
            'profile'          => Profile::first(),
        ];

        return view('home', $data);
    }
}

