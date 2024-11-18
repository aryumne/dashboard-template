<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SampleRequest extends Model
{
    use HasFactory, HasUuids, HasAuthor, LogsActivity;

    protected $guarded = ['id', 'created_by'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Sample Request')
            ->setDescriptionForEvent(function (string $eventName) {
                $colorwayID = strtoupper($this->colorway_identifier);
                return $eventName === 'created' ? "New Sample has been created." : "Sample for colorway ID ($colorwayID) has been $eventName";
            })->logOnly([
                'season_id',
            'dev_style_id',
            'stage_id',
                'dev_style_name',
                'colorway_identifier',
                'is_looksee',
                'type',
                'sample_product_id',
                'stage_name',
                'purpose',
                'size',
                'pair_qty_total',
                'left_qty_total',
                'right_qty_total',
                'lab_qty',
                'loss_qty',
                'product_code',
                'creator',
                'factory_code',
                'stn',
                'material_req',
                'material_eta',
                'cutt_process',
                'second_process',
                'sw_process',
                'btm_process',
                'ass_process',
                'status',
                'sample_requested_at',
                'mo_id',
                'remarks',
                'estimated_ship_date',
            ])->logOnlyDirty();
    }

    public function destinations(): HasMany
    {
        return $this->hasMany(SampleRequestDestination::class, 'sample_request_id', 'id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'dev_style_id', 'bom_dev_style_id')->where('projects.season_id', $this->season_id);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'colorway_identifier', 'colorway_identifier')->where('products.stage_id', $this->stage_id);
    }

    public function preOrder(): HasOne
    {
        return $this->hasOne(PreOrder::class, 'sample_request_id', 'id');
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class, 'season_id', 'identifier');
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class, 'stage_id', 'identifier');
    }

    public function commerce(): HasOne
    {
        return $this->hasOne(Commerce::class, 'sample_request_id', 'id');
    }

}
