<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Agenda;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::published();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            if ($request->category === 'Agenda') {
                $query->whereRaw('1 = 0');
            } else {
                $query->where('category', $request->category);
            }
        }

        $news = $query->latest('published_at')->paginate(9)->withQueryString();
        $categories = ['Kegiatan', 'Pengumuman', 'Prestasi', 'Berita', 'Agenda'];

        // Query Agenda
        $agendaQuery = Agenda::published();
        if ($request->filled('search')) {
            $search = $request->search;
            $agendaQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $showAgenda = empty($request->category) || $request->category === 'Agenda';
        $agendas = $showAgenda ? $agendaQuery->orderBy('date', 'asc')->get() : collect();

        if ($request->ajax()) {
            return view('berita.index', compact('news', 'categories', 'agendas', 'showAgenda'));
        }

        return view('berita.index', compact('news', 'categories', 'agendas', 'showAgenda'));
    }

    public function show($slug)
    {
        $news = News::published()->where('slug', $slug)->firstOrFail();
        $news->increment('views');

        // Berita Terbaru: maksimal 3 berita terbaru yang dipublikasikan (kecuali artikel aktif)
        $recentNews = News::published()
            ->where('id', '!=', $news->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        // Berita Terkait: artikel terkait berdasarkan kategori
        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->where('category', $news->category)
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($relatedNews->count() < 3) {
            $excludeIds = $relatedNews->pluck('id')->push($news->id)->toArray();
            $moreRelated = News::published()
                ->whereNotIn('id', $excludeIds)
                ->latest('published_at')
                ->take(3 - $relatedNews->count())
                ->get();
            $relatedNews = $relatedNews->concat($moreRelated);
        }

        return view('berita.show', compact('news', 'relatedNews', 'recentNews'));
    }
}
