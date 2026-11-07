<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'date', 'location', 'organizer', 'image', 'status'];

    protected $casts = [
        'date' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function (Activity $activity) {
            if (empty($activity->slug)) {
                $activity->slug = Str::slug($activity->title);
            }
        });
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
}
