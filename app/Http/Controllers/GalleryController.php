<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::published()->with('activity');

        if ($request->filled('activity_id')) {
            $query->where('activity_id', $request->activity_id);
        }

        $galleries = $query->orderBy('order_num')->latest()->paginate(9)->withQueryString();
        $activities = \App\Models\Activity::latest('date')->get();

        return view('galeri', compact('galleries', 'activities'));
    }

    public function show($id)
    {
        $galeri = Gallery::published()->with('activity')->findOrFail($id);
        return view('galeri.show', compact('galeri'));
    }
}
