<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class AdminProfileController extends Controller
{
    public function edit()
    {
        $profile = Profile::firstOrCreate([], ['title' => '', 'content' => '']);
        return view('admin.profil.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'motto' => 'nullable|string',
            'philosophy' => 'nullable|string',
            'mars' => 'nullable|string',
            'history' => 'nullable|string',
            'campus_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'image' => 'nullable|file',
            'logo' => 'nullable|file',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Failed:', $e->errors());
            throw $e;
        }

        $profile = Profile::firstOrCreate([]);
        $destinationPath = storage_path('app/public/profile');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->hashName();
            $file->move($destinationPath, $filename);
            $validated['image'] = 'profile/' . $filename;
        }
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = $file->hashName();
            $file->move($destinationPath, $filename);
            $validated['logo'] = 'profile/' . $filename;
        }

        $profile->update($validated);

        return redirect()->route('admin.profil.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
