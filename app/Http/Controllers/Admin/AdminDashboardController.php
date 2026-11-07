<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\News;
use App\Models\Activity;
use App\Models\Program;
use App\Models\Achievement;
use App\Models\Gallery;
use App\Models\Message;
use App\Models\Registration;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalMembers' => Member::count(),
            'totalNews' => News::count(),
            'totalActivities' => Activity::count(),
            'totalPrograms' => Program::count(),
            'totalAchievements' => Achievement::count(),
            'totalGalleries' => Gallery::count(),
            'totalMessages' => Message::count(),
            'totalRegistrations' => Registration::count(),
            'pendingRegistrations' => Registration::where('status', 'Menunggu')->count(),
            'unreadMessages' => Message::where('is_read', false)->count(),
            'recentMessages' => Message::latest()->take(5)->get(),
            'recentNews' => News::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', $data);
    }
}
