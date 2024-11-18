<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commerce extends Model
{
    use HasUuids, HasAuthor, HasFactory, LogsActivity;

    protected $guarded = ['id', 'created_by'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Commerce')
            ->setDescriptionForEvent(function (string $eventName) {
                $srID = strtoupper($this->sample_request_id);
                return $eventName === 'created' ? "New Commerce has been created." : "Commerce for sample request ID ($srID) has been $eventName";
            })->logOnly([
                'created_by',
                'sample_request_id',
                'pre_rfc_tooling_target',
                'pre_rfc_tooling_actual',
                'pre_rfc_upper_target',
                'pre_rfc_upper_actual',
                'rfc_tooling_target',
                'rfc_tooling_actual',
                'rfc_tooling_cfm',
                'rfc_upper_target',
                'rfc_upper_actual',
                'rfc_upper_cfm',
                'ext_trial_target',
                'ext_trial_actual',
                'ext_trial_cfm',
                'aset_mold',
                'mold_cfm',
                'css_cfm',
                'sf_trial_target',
                'sf_trial_actual',
                'shoe_cfm',
                'fsr_trial_target',
                'fsr_trial_actual',
                'fsr_trial_cfm',
                'ipw_target',
            ])->logOnlyDirty();
    }

    public function sampleRequest(): BelongsTo
    {
        return $this->belongsTo(SampleRequest::class, 'sample_request_id', 'id');
    }
}
