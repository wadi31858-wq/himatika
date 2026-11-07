<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $query = Achievement::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('participant', 'like', "%{$search}%");
            });
        }

        $achievements = $query->latest('year')->paginate(12)->withQueryString();
        $categories = Achievement::select('category')->distinct()->pluck('category');

        return view('prestasi', compact('achievements', 'categories'));
    }
}
