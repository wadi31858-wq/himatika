<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspiration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nim',
        'email',
        'category',
        'title',
        'message',
        'status',
        'is_archived',
        'admin_reply',
        'admin_notes',
        'ip_address'
    ];

    protected $casts = [
        'status' => 'string',
    ];
}
