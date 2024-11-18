<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreOrder extends Model
{
    use HasFactory, HasUuids, HasAuthor, LogsActivity;

    protected $guarded = ['id', 'created_by'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Pre Order')
            ->setDescriptionForEvent(function (string $eventName) {
                $product_code = strtoupper($this->product_code);
                return $eventName === 'created' ? "New SR PO has been created." : "Pre Order with product code ($product_code) has been $eventName";
            })->logOnly([
                'product_code',
                'created_by',
                'sample_request_id',
                'price',
                'received_at',
                'material_req',
                'material_eta',
                'min_qty',
                'ball_qty',
                'min_ship_date',
                'ball_ship_date',
                'cutt_process',
                'second_process',
                'sw_process',
                'btm_process',
                'ass_process',
                'is_final',
                'factory_code',
            ])->logOnlyDirty();
    }

    public function sampleRequest(): BelongsTo
    {
        return $this->belongsTo(SampleRequest::class, 'sample_request_id', 'id');
    }
}
