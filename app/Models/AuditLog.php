<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'auditable_type',
        'auditable_id',
        'data',
        'ip_address',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
