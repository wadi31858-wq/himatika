<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = Program::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('division', 'like', "%{$search}%");
            });
        }

        $programs = $query->latest('date')->paginate(10)->withQueryString();
        return view('program-kerja', compact('programs'));
    }
}
