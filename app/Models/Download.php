<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'author_name',
        'website_url',
        'file',
        'file_size',
        'file_type',
        'preview_image',
        'year',
        'order_num',
        'status',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
