<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisionMission;
use Illuminate\Http\Request;

class AdminVisionMissionController extends Controller
{
    public function edit()
    {
        $vm = VisionMission::firstOrCreate([], ['vision' => '', 'mission' => '']);
        $mission = is_string($vm->mission) ? json_decode($vm->mission, true) : [];
        return view('admin.visi-misi.edit', compact('vm', 'mission'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'vision' => 'required|string',
            'mission' => 'required|array|min:1',
        ]);

        $validated['mission'] = json_encode($validated['mission']);

        $vm = VisionMission::firstOrCreate([]);
        $vm->update($validated);

        return redirect()->route('admin.visi-misi.edit')->with('success', 'Visi & Misi berhasil diperbarui.');
    }
}
