<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $news = $query->latest('published_at')->paginate(9)->withQueryString();
        $categories = News::select('category')->distinct()->pluck('category');

        if ($request->ajax()) {
            return response()->view('berita.index', compact('news', 'categories'));
        }

        return view('berita.index', compact('news', 'categories'));
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();
        $relatedNews = News::where('id', '!=', $news->id)
            ->where('category', $news->category)
            ->take(3)->get();

        return view('berita.show', compact('news', 'relatedNews'));
    }
}
