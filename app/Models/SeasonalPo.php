<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeasonalPo extends Model
{
    use HasUuids, HasAuthor, HasFactory, LogsActivity;

    protected $guarded = ['id', 'created_by'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Seasonal PO')
            ->setDescriptionForEvent(function (string $eventName) {
                return $eventName === 'created' ? "New Seasonal PO has been created." : "The Seasonal PO has been $eventName";
            })->logOnly([
                'season_id',
                'min_ship_date',
                'ball_ship_date',
                'is_active',
            ])->logOnlyDirty();
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class, 'season_id', 'identifier');
    }

    public function preOrders(): HasMany
    {
        return $this->hasMany(PreOrder::class, 'season_id', 'season_id');
    }
}
