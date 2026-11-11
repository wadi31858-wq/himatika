<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nim',
        'position',
        'division',
        'kelompok',
        'photo',
        'period',
        'bio',
        'is_active',
        'order_num'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
