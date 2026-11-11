<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'image',
        'caption',
        'alt_text',
        'order_num',
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
