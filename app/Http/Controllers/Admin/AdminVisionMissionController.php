<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisionMission;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AdminVisionMissionController extends Controller
{
    public function edit()
    {
        $vm = VisionMission::firstOrCreate([], ['vision' => '', 'mission' => '[]']);
        
        $missionList = [];
        if (is_array($vm->mission)) {
            $missionList = $vm->mission;
        } elseif (is_string($vm->mission)) {
            $decoded = json_decode($vm->mission, true);
            $missionList = is_array($decoded) ? $decoded : preg_split('/\r\n|\r|\n/', $vm->mission);
        }

        $missionText = implode("\n", array_filter(array_map('trim', $missionList)));

        return view('admin.visi-misi.edit', compact('vm', 'missionText'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'vision' => 'required|string',
            'mission_text' => 'required|string',
        ]);

        $lines = preg_split('/\r\n|\r|\n/', $validated['mission_text']);
        $cleaned = array_values(array_filter(array_map('trim', $lines)));

        $vm = VisionMission::firstOrCreate([]);
        $vm->update([
            'vision' => $validated['vision'],
            'mission' => json_encode($cleaned),
        ]);

        ActivityLog::record(
            'update',
            'Memperbarui Visi & Misi HIMATIKA',
            $vm
        );

        return redirect()->route('admin.visi-misi.edit')->with('success', 'Visi & Misi berhasil diperbarui.');
    }
}
