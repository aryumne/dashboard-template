<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeneralSetting extends Model
{
    use HasUuids, HasFactory, LogsActivity;

    protected $fillable = ['brand_name', 'brand_logo', 'keywords', 'shord_desc'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('web identity')
            ->setDescriptionForEvent(fn (string $eventName) => "This brand information has been {$eventName}")
            ->logOnly([
                'brand_name',
                'brand_logo',
                'keywords',
                'shord_desc'
            ])->logOnlyDirty();
    }
}
