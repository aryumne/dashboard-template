<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SampleRequestDestination extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('SR Destination')
            ->setDescriptionForEvent(function (string $eventName) {
                $srID = strtoupper($this->sample_request_id);
                return $eventName === 'created' ? "New Sample Destination has been created." : "Destination for sample request ID ($srID) has been $eventName";
            })->logOnly([
                'sample_request_id',
                'destination',
                'sample_req_id',
                'attention_to',
                'pair_qty',
                'left_qty',
                'right_qty',
                'comments',
            ])->logOnlyDirty();
    }

    public function sampleRequest(): BelongsTo
    {
        return $this->belongsTo(SampleRequest::class, 'sample_request_id', 'id');
    }
}
