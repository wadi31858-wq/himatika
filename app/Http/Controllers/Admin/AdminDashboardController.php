<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\News;
use App\Models\Agenda;
use App\Models\Gallery;
use App\Models\Download;
use App\Models\Aspiration;
use App\Models\Message;
use App\Models\User;
use App\Models\ActivityLog;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalNews' => News::count(),
            'newsPublished' => News::where('status', 'published')->count(),
            'newsDraft' => News::where('status', 'draft')->count(),

            'totalAgendas' => Agenda::count(),
            'agendaPublished' => Agenda::where('pub_status', 'published')->count(),
            'agendaDraft' => Agenda::where('pub_status', 'draft')->count(),

            'totalMembers' => Member::count(),
            'activeMembers' => Member::where('is_active', true)->count(),

            'totalGalleries' => Gallery::count(),
            'totalDownloads' => Download::count(),

            'totalAspirations' => Aspiration::count(),
            'aspirasiBaru' => Aspiration::where('status', 'Baru')->count(),
            'aspirasiDiproses' => Aspiration::where('status', 'Diproses')->count(),
            'aspirasiSelesai' => Aspiration::where('status', 'Selesai')->count(),

            'totalMessages' => Message::count(),
            'unreadMessages' => Message::where('is_read', false)->count(),

            'totalAdmins' => User::count(),
            'activeAdmins' => User::where('is_active', true)->count(),

            'recentNews' => News::latest('published_at')->take(4)->get(),
            'recentAspirations' => Aspiration::latest()->take(5)->get(),
            'recentLogs' => ActivityLog::latest()->take(8)->get(),
        ];

        return view('admin.dashboard', $data);
    }
}
