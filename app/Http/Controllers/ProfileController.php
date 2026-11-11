<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Member;
use App\Models\VisionMission;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Profile::firstOrCreate([], [
            'title' => 'Profil HIMATIKA UNUJA',
            'content' => 'HIMATIKA FMIPA UNUJA adalah rumah bersama mahasiswa Matematika untuk belajar, berorganisasi, berkarya, dan bertumbuh melalui semangat kekeluargaan.',
            'motto' => 'Synchronized Growth, Reaching New Heights',
        ]);

        $vm = VisionMission::firstOrCreate([], [
            'vision' => '"Mewujudkan HIMATIKA 2026 sebagai rumah inklusif dan inovatif..."',
            'mission' => json_encode(['Membangun iklim internal yang suportif...'])
        ]);
        $mission = is_string($vm->mission) ? json_decode($vm->mission, true) : [];

        $kaprodi = Member::where('position', 'like', '%kaprodi%')
            ->orWhere('position', 'like', '%ketua program studi%')
            ->orWhere('position', 'like', '%pembina%')
            ->first();

        return view('profil', compact('profile', 'vm', 'mission', 'kaprodi'));
    }

    public function sejarah()
    {
        $profile = Profile::first();
        return view('sejarah', compact('profile'));
    }

    public function sambutan()
    {
        $profile = Profile::first();
        $kaprodi = Member::where('position', 'like', '%kaprodi%')
            ->orWhere('position', 'like', '%ketua program studi%')
            ->orWhere('position', 'like', '%pembina%')
            ->first();

        return view('sambutan', compact('profile', 'kaprodi'));
    }
}
