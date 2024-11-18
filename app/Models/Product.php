<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory, HasUuids, HasAuthor, LogsActivity;

    protected $guarded = ['id', 'created_by'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('BOM')
            ->setDescriptionForEvent(function (string $eventName) {
                $colorwayID = strtoupper($this->colorway_identifier);
                return $eventName === 'created' ? "New BOM has been created." : "BOM with colorway ID ($colorwayID) has been $eventName";
            })->logOnly([
                'project_id',
                'created_by',
                'stage_id',
                'state_id',
                'bom_type',
                'is_looksee',
                'filename',
                'colorway_code',
                'colorway_identifier',
                'bom_colorway_desc',
                'bom_spec_name',
                'bom_uuid',
                'bom_identifier',
                'bom_pcc_identifier',
                'bom_pcc_name',
                'bom_production_factory',
                'bom_last_code',
                'status',
            ])->logOnlyDirty();
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function components(): HasMany
    {
        return $this->hasMany(Component::class, 'product_id', 'id');
    }

    public function logUploads(): HasMany
    {
        return $this->hasMany(ProductUploadLog::class, 'product_id', 'id');
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class, 'stage_id', 'identifier');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id', 'identifier');
    }

    public function sampleRequests(): HasMany
    {
        return $this->hasMany(SampleRequest::class, 'colorway_identifier', 'colorway_identifier')->where('sample_requests.stage_id', $this->stage_id);
    }

    public function purchaseOrders(): BelongsToMany
    {
        return $this->belongsToMany(PurchaseOrder::class, 'product_purchase_orders');
    }
}
