<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Activity as SpatieActivity;

class ActivityLog extends SpatieActivity
{
    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}
