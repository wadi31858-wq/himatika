<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use Illuminate\Http\Request;

class AspirationController extends Controller
{
    public function index()
    {
        return view('aspirasi.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'category' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Aspiration::create($validated);

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi berhasil dikirim! Terima kasih atas partisipasi Anda.');
    }

    public function cek(Request $request)
    {
        $aspirations = collect();

        if ($request->filled('nim')) {
            $aspirations = Aspiration::where('nim', $request->nim)->latest()->get();
        }

        return view('aspirasi.cek', compact('aspirations'));
    }
}
