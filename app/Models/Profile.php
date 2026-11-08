<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'content', 'motto', 'philosophy', 'mars', 'history',
        'image', 'logo', 'campus_name', 'address', 'email',
        'phone', 'instagram', 'youtube', 'tiktok',
        'hero_badge', 'hero_tagline', 'hero_title', 'hero_desc',
        'hero_image_alt', 'hero_btn_primary_text', 'hero_btn_primary_url',
        'hero_btn_secondary_text', 'hero_btn_secondary_url',
        'hero_stats_pengurus', 'hero_stats_bidang', 'hero_stats_biro',
        'stats_mode', 'facebook', 'favicon', 'meta_description', 'footer_text',
    ];
}
