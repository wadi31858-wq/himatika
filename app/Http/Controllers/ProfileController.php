<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Member;
use App\Models\VisionMission;
use App\Models\OrganizationalStructure;

class ProfileController extends Controller
{
    public function index()
    {
        return redirect()->route('home');
    }

    public function tentang()
    {
        $profile = Profile::first();
        $kaprodi = Member::where('position', 'like', '%kaprodi%')
            ->orWhere('position', 'like', '%ketua program studi%')
            ->orWhere('position', 'like', '%pembina%')
            ->first();

        $vm = VisionMission::first();
        $missions = [];
        if ($vm && !empty($vm->mission)) {
            $missions = is_array($vm->mission) ? $vm->mission : json_decode($vm->mission, true);
        }
        if (empty($missions)) {
            $missions = [
                'Menyelenggarakan kegiatan penguatan kompetensi akademik dan keahlian teknologi komputasi modern.',
                'Mendorong kreativitas riset dan inkubasi karya digital website serta rekayasa perangkat lunak.',
                'Membangun solidaritas, profesionalisme, dan integritas kepemimpinan sivitas akademika Informatika.',
                'Menyelenggarakan program pengabdian masyarakat dan literasi digital berbasis nilai-nilai kepesantrenan.',
                'Memperluas jejaring kemitraan strategis dengan institusi teknologi, perguruan tinggi, dan alumni.'
            ];
        }

        $structures = OrganizationalStructure::where('is_active', true)->orderBy('order_num')->get();

        $statsPengurus = Member::where('is_active', true)->count() ?: 68;
        $statsBidang = OrganizationalStructure::whereNotNull('parent_id')->count() ?: 6;
        $statsBiro = OrganizationalStructure::whereNull('parent_id')->count() ?: 4;

        return view('tentang', compact(
            'profile',
            'kaprodi',
            'vm',
            'missions',
            'structures',
            'statsPengurus',
            'statsBidang',
            'statsBiro'
        ));
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
