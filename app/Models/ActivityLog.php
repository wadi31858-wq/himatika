<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'action',
        'model_type',
        'model_id',
        'description',
        'ip_address',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper to log an admin action easily
     */
    public static function record(string $action, ?string $description = null, $model = null): self
    {
        $user = auth()->user();
        return self::create([
            'user_id'     => $user?->id,
            'user_name'   => $user?->name ?? 'Admin',
            'action'      => $action,
            'model_type'  => $model ? get_class($model) : null,
            'model_id'    => $model?->id ?? null,
            'description' => $description,
            'ip_address'  => request()->ip(),
            'user_agent'  => substr(request()->userAgent() ?? '', 0, 255),
        ]);
    }
}

