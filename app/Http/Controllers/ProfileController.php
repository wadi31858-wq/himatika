<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Member;
use App\Models\VisionMission;

class ProfileController extends Controller
{
    public function index()
    {
        return redirect()->route('home');
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
