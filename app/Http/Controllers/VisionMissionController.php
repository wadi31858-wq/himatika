<?php

namespace App\Http\Controllers;

use App\Models\VisionMission;

class VisionMissionController extends Controller
{
    public function index()
    {
        $vm = VisionMission::first();
        $mission = [];
        if ($vm && !empty($vm->mission)) {
            $mission = is_array($vm->mission) ? $vm->mission : json_decode($vm->mission, true);
        }
        if (empty($mission)) {
            $mission = [
                'Meningkatkan kemampuan akademik dan non-akademik mahasiswa Matematika.',
                'Mendorong kreativitas dan inovasi dalam bidang matematika terapan.',
                'Membangun solidaritas antar mahasiswa Matematika.',
                'Menyelenggarakan kegiatan edukatif dan kompetitif.',
                'Membangun kerja sama dengan pihak internal dan eksternal kampus.',
                'Mengembangkan potensi mahasiswa Matematika UNUJA.'
            ];
        }

        return view('visi-misi', compact('vm', 'mission'));
    }
}
