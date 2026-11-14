<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSlider;
use App\Models\SiteSetting;
use App\Models\Profile;

class HeroSliderSeeder extends Seeder
{
    public function run(): void
    {
        if (SiteSetting::get('hero_slider_seeded') !== '1') {
            $existingPhoto = 'news/news_1794407889_gb5rjeODz5yqGHUwbWhGZ34Odvvpuo9LrKyJBBhM.png';
            if (!file_exists(public_path('storage/' . $existingPhoto))) {
                $profile = Profile::first();
                if ($profile && $profile->image && file_exists(public_path('storage/' . $profile->image))) {
                    $existingPhoto = $profile->image;
                }
            }
            HeroSlider::create([
                'image' => $existingPhoto,
                'title' => 'Pengurus HIMATIKA UNUJA',
                'alt_text' => 'Pengurus HIMATIKA FMIPA Universitas Nurul Jadid',
                'caption' => 'Pengurus HIMATIKA Periode 2026',
                'order_num' => 1,
                'is_active' => true,
            ]);
            SiteSetting::set('hero_slider_interval', '5', 'hero');
            SiteSetting::set('hero_slider_autoplay', '1', 'hero');
            SiteSetting::set('hero_slider_seeded', '1', 'system');
        }
    }
}
