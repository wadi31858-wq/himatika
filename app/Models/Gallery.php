<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'alt_text',
        'description',
        'activity_id',
        'status',
        'order_num',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
