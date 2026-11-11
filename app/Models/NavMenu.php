<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'label',
        'url',
        'icon',
        'order_num',
        'is_active',
    ];

    public function parent()
    {
        return $this->belongsTo(NavMenu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(NavMenu::class, 'parent_id')->orderBy('order_num');
    }
}
