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
    ];
}
