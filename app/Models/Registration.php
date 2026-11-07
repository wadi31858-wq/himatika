<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nim',
        'email',
        'phone',
        'gender',
        'place_of_birth',
        'date_of_birth',
        'address',
        'study_program',
        'semester',
        'reason',
        'experience',
        'skills',
        'photo',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];
}
