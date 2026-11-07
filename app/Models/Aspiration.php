<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspiration extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'nim', 'email', 'category', 'title', 'message', 'status', 'admin_reply'];

    protected $casts = [
        'status' => 'string',
    ];
}
