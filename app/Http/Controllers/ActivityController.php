<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $activities = $query->latest('date')->paginate(9)->withQueryString();
        return view('kegiatan.index', compact('activities'));
    }

    public function show($slug)
    {
        $activity = Activity::where('slug', $slug)->firstOrFail();
        $galleries = $activity->galleries()->latest()->get();
        return view('kegiatan.show', compact('activity', 'galleries'));
    }
}
