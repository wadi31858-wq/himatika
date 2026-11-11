<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function index(Request $request)
    {
        $query = Download::published()->whereNotNull('website_url')->where('website_url', '!=', '');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('author_name', 'like', "%{$s}%")
                  ->orWhere('category', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%");
            });
        }

        $downloads = $query->orderBy('order_num')->latest()->paginate(9)->withQueryString();
        $totalWebsites = Download::published()->whereNotNull('website_url')->where('website_url', '!=', '')->count();

        return view('download', compact('downloads', 'totalWebsites'));
    }
}
