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
            'nim' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'category' => 'nullable|string|max:100',
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:3000',
        ]);

        $ip = $request->ip();

        // Anti-spam flood protection: limit to 1 per 30 seconds per IP
        $recentSubmission = Aspiration::where('ip_address', $ip)
            ->where('created_at', '>=', now()->subSeconds(30))
            ->exists();

        if ($recentSubmission) {
            return back()->withInput()->with('error', 'Mohon tunggu sejenak sebelum mengirimkan aspirasi kembali.');
        }

        $validated['ip_address'] = $ip;
        $validated['status'] = 'Baru';

        Aspiration::create($validated);

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi Anda berhasil dikirim dan akan segera ditinjau oleh pengurus HIMATIKA. Terima kasih!');
    }

    public function cek(Request $request)
    {
        $aspirations = collect();

        if ($request->filled('nim')) {
            // Only select public-safe fields (exclude admin_notes and ip_address)
            $aspirations = Aspiration::where('nim', $request->nim)
                ->select(['id', 'name', 'nim', 'category', 'title', 'message', 'status', 'admin_reply', 'created_at'])
                ->latest()
                ->get();
        }

        return view('aspirasi.cek', compact('aspirations'));
    }
}
