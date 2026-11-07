<?php

namespace App\Http\Controllers;

use App\Models\VisionMission;

class VisionMissionController extends Controller
{
    public function index()
    {
        $vm = VisionMission::first();
        $mission = $vm ? json_decode($vm->mission, true) : [];
        return view('visi-misi', compact('vm', 'mission'));
    }
}
