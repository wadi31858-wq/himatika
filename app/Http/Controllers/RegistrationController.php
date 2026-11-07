<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('pendaftaran.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:registrations,nim',
            'email' => 'required|email|max:255|unique:registrations,email',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'study_program' => 'nullable|string|max:255',
            'semester' => 'nullable|string|max:10',
            'reason' => 'required|string',
            'experience' => 'nullable|string',
            'skills' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('registrations', 'public');
        }

        Registration::create($validated);

        return redirect()->route('pendaftaran.index')->with('success', 'Pendaftaran berhasil dikirim! Silakan tunggu konfirmasi dari pengurus HIMATIKA UNUJA.');
    }

    public function cek(Request $request)
    {
        $registration = null;

        if ($request->filled('nim')) {
            $registration = Registration::where('nim', $request->nim)->first();
        }

        return view('pendaftaran.cek', compact('registration'));
    }
}
