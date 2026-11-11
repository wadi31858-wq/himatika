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

        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->where('category', $news->category)
            ->take(3)->get();

        return view('berita.show', compact('news', 'relatedNews'));
    }
}
