<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminProfileController extends Controller
{
    public function edit()
    {
        $profile = Profile::firstOrCreate([], ['title' => 'HIMATIKA FMIPA UNUJA', 'content' => '']);
        return view('admin.profil.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'motto' => 'nullable|string|max:255',
            'philosophy' => 'nullable|string',
            'mars' => 'nullable|string',
            'history' => 'nullable|string',
            'campus_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
        ]);

        $profile = Profile::firstOrCreate([]);
        $destinationPath = storage_path('app/public/profile');
        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'profile_' . time() . '_' . $file->hashName();
            if ($profile->image && file_exists(storage_path('app/public/' . $profile->image))) {
                @unlink(storage_path('app/public/' . $profile->image));
            }
            $file->move($destinationPath, $filename);
            $validated['image'] = 'profile/' . $filename;
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            if ($profile->logo && file_exists(storage_path('app/public/' . $profile->logo))) {
                @unlink(storage_path('app/public/' . $profile->logo));
            }
            $file->move($destinationPath, $filename);
            $validated['logo'] = 'profile/' . $filename;
        }

        $profile->update($validated);

        ActivityLog::record(
            'update',
            'Memperbarui Profil HIMATIKA (Profil, Motto, Filosofi, Mars, Sejarah)',
            $profile
        );

        return redirect()->route('admin.profil.edit')->with('success', 'Profil HIMATIKA berhasil diperbarui.');
    }
}
