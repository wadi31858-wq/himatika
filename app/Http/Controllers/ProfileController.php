<?php

namespace App\Http\Controllers;

use App\Models\Profile;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Profile::firstOrCreate([], [
            'title' => 'Rumah bersama<br>mahasiswa Matematika<br>UNUJA sejak 1997.',
            'content' => 'HIMATIKA FMIPA UNUJA adalah rumah bersama mahasiswa Matematika untuk belajar, berorganisasi, berkarya, dan bertumbuh melalui semangat kekeluargaan.',
            'motto' => 'Synchronized Growth, Reaching New Heights',
        ]);

        $vm = \App\Models\VisionMission::firstOrCreate([], [
            'vision' => '"Mewujudkan HIMATIKA 2026 sebagai rumah inklusif dan inovatif..."',
            'mission' => json_encode(['Membangun iklim internal yang suportif...'])
        ]);
        $mission = is_string($vm->mission) ? json_decode($vm->mission, true) : [];

        return view('profil', compact('profile', 'vm', 'mission'));
    }
}
