<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminSettingController extends Controller
{
    public function edit()
    {
        $profile = Profile::firstOrCreate([], [
            'title' => 'HIMATIKA FMIPA UNUJA',
            'campus_name' => 'Universitas Nurul Jadid',
            'email' => 'himatika@unuja.ac.id',
            'phone' => '+62 812-3456-7890',
            'footer_text' => 'Himpunan Mahasiswa Matematika (HIMATIKA) Fakultas MIPA Universitas Nurul Jadid Paiton Probolinggo.',
        ]);

        return view('admin.pengaturan.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'campus_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:500',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'footer_text' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,jpg,svg|max:1024',
        ]);

        $profile = Profile::firstOrCreate([]);
        $destination = storage_path('app/public/settings');
        if (!File::isDirectory($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        // Upload Logo
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            if ($profile->logo && file_exists(storage_path('app/public/' . $profile->logo))) {
                @unlink(storage_path('app/public/' . $profile->logo));
            }
            $file->move($destination, $filename);
            $validated['logo'] = 'settings/' . $filename;
        }

        // Upload Favicon
        if ($request->hasFile('favicon')) {
            $file = $request->file('favicon');
            $filename = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
            if ($profile->favicon && file_exists(storage_path('app/public/' . $profile->favicon))) {
                @unlink(storage_path('app/public/' . $profile->favicon));
            }
            $file->move($destination, $filename);
            $validated['favicon'] = 'settings/' . $filename;
        }

        $profile->update($validated);

        ActivityLog::record(
            'update',
            'Memperbarui identitas dan pengaturan website',
            $profile
        );

        return redirect()->route('admin.pengaturan.edit')->with('success', 'Pengaturan website berhasil diperbarui.');
    }
}

