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

class PurchaseOrder extends Model
{
    use HasFactory, HasUuids, HasAuthor, LogsActivity;

    protected $guarded = ['id', 'created_by'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Purchase Order')
            ->setDescriptionForEvent(function (string $eventName) {
                return $eventName === 'created' ? "New Purchase Order has been created." : "Purchase Order has been $eventName";
            })->logOnly([
                'counter',
                'purchase_number',
            'receiver',
            'receiver_pic',
                'etd',
                'eta',
                'stage_id',
                'project_id',
                'created_by',
            ])->logOnlyDirty();
    }


    public function items(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class, 'purchase_order_id', 'id')->orderBy('bom_ids', 'ASC')->orderBy('material_name', 'ASC');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_purchase_orders');
    }

    public function vendors(): HasMany
    {
        return $this->hasMany(VendorPurchaseOrder::class, 'purchase_order_id', 'id');
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class, 'stage_id', 'identifier');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
