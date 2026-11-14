<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisionMission;
use App\Models\SiteSetting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AdminVisionMissionController extends Controller
{
    public function edit()
    {
        $defaultMissions = [
            'Meningkatkan kemampuan akademik dan non-akademik mahasiswa Matematika.',
            'Mendorong kreativitas dan inovasi dalam bidang matematika terapan.',
            'Membangun solidaritas antar mahasiswa Matematika.',
            'Menyelenggarakan kegiatan edukatif dan kompetitif.',
            'Membangun kerja sama dengan pihak internal dan eksternal kampus.',
            'Mengembangkan potensi mahasiswa Matematika UNUJA.'
        ];

        $vm = VisionMission::firstOrCreate([], [
            'vision' => 'Menjadi organisasi mahasiswa Matematika yang aktif, inovatif, kolaboratif, dan unggul dalam pengembangan ilmu matematika serta sumber daya mahasiswa.',
            'mission' => json_encode($defaultMissions)
        ]);

        $missionList = [];
        if (is_array($vm->mission)) {
            $missionList = $vm->mission;
        } elseif (is_string($vm->mission)) {
            $decoded = json_decode($vm->mission, true);
            $missionList = is_array($decoded) ? $decoded : preg_split('/\r\n|\r|\n/', $vm->mission);
        }

        if (empty($missionList)) {
            $missionList = $defaultMissions;
        }

        $missionList = array_values(array_filter(array_map('trim', $missionList)));
        $missionText = implode("\n", $missionList);

        $bannerTitle = SiteSetting::get('vm_banner_title', 'Visi dan Misi');
        $bannerSubtitle = SiteSetting::get('vm_banner_subtitle', 'Arah dan tujuan pengembangan HIMATIKA UNUJA.');
        $visionTitle = SiteSetting::get('vm_vision_title', 'Visi HIMATIKA UNUJA');
        $missionTitle = SiteSetting::get('vm_mission_title', 'Misi HIMATIKA UNUJA');
        $isVisible = SiteSetting::get('vm_is_visible', '1');

        return view('admin.visi-misi.edit', compact(
            'vm',
            'missionList',
            'missionText',
            'bannerTitle',
            'bannerSubtitle',
            'visionTitle',
            'missionTitle',
            'isVisible'
        ));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'vm_banner_title' => 'required|string|max:255',
            'vm_banner_subtitle' => 'nullable|string|max:500',
            'vm_vision_title' => 'nullable|string|max:255',
            'vision' => 'required|string',
            'vm_mission_title' => 'nullable|string|max:255',
            'mission_items' => 'nullable|array',
            'mission_items.*' => 'nullable|string|max:500',
            'mission_text' => 'nullable|string',
            'vm_is_visible' => 'nullable|boolean',
        ]);

        // Process mission items
        $cleanedMissions = [];
        if (!empty($request->mission_items) && is_array($request->mission_items)) {
            $cleanedMissions = array_values(array_filter(array_map('trim', $request->mission_items), fn($s) => $s !== ''));
        } elseif (!empty($validated['mission_text'])) {
            $lines = preg_split('/\r\n|\r|\n/', $validated['mission_text']);
            $cleanedMissions = array_values(array_filter(array_map('trim', $lines), fn($s) => $s !== ''));
        }

        if (empty($cleanedMissions)) {
            $cleanedMissions = ['Meningkatkan kemampuan akademik dan non-akademik mahasiswa Matematika.'];
        }

        $vm = VisionMission::firstOrCreate([]);
        $vm->update([
            'vision' => $validated['vision'],
            'mission' => json_encode($cleanedMissions),
        ]);

        // Save site settings
        SiteSetting::set('vm_banner_title', $validated['vm_banner_title'], 'visi_misi');
        SiteSetting::set('vm_banner_subtitle', $validated['vm_banner_subtitle'] ?? '', 'visi_misi');
        SiteSetting::set('vm_vision_title', $validated['vm_vision_title'] ?? 'Visi HIMATIKA UNUJA', 'visi_misi');
        SiteSetting::set('vm_mission_title', $validated['vm_mission_title'] ?? 'Misi HIMATIKA UNUJA', 'visi_misi');
        SiteSetting::set('vm_is_visible', $request->has('vm_is_visible') ? '1' : '0', 'visi_misi');

        // Sinkronkan ke kartu Visi Beranda agar admin cukup input sekali
        SiteSetting::set('home_visi_summary', $validated['vision'], 'home_tentang');

        ActivityLog::record(
            'update',
            'Memperbarui Halaman Visi & Misi Organisasi',
            $vm
        );

        return redirect()->route('admin.visi-misi.edit')->with('success', 'Pengaturan Visi dan Misi berhasil disimpan.');
    }
}
