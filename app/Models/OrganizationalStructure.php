<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationalStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'division',
        'kelompok',
        'period',
        'order_num',
        'is_active',
        'parent_id',
        'photo',
        'group_photo',
        'group_photo_putri',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(OrganizationalStructure::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(OrganizationalStructure::class, 'parent_id');
    }

    /**
     * Associated members in this division
     */
    public function members()
    {
        return $this->hasMany(Member::class, 'division', 'division');
    }
}
