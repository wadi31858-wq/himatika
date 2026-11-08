<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'time',
        'start_time',
        'end_time',
        'location',
        'registration_link',
        'image',
        'status',      // e.g. Mendatang, Berlangsung, Selesai
        'pub_status',  // published, draft, archived
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function scopePublished($query)
    {
        return $query->where('pub_status', 'published');
    }
}
