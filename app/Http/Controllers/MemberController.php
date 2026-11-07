<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('division', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        $members = $query->latest()->paginate(12)->withQueryString();
        return view('pengurus', compact('members'));
    }
}
