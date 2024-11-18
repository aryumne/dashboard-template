<?php

namespace App\Models;

use App\Models\User;
use App\Models\Stage;
use App\Models\State;
use App\Models\Season;
use App\Models\TdCode;
use App\Models\Product;
use App\Models\Category;
use App\Models\BaseModel;
use App\Traits\HasAuthor;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Project extends Model
{
    use HasFactory, HasUuids, HasAuthor, LogsActivity;

    protected $guarded = ['id', 'created_by'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('project')
            ->setDescriptionForEvent(function (string $eventName) {
                $devStylename = strtoupper($this->bom_dev_style_name);
                return $eventName === 'created' ? "New project has been created." : "Project with dev style name ($devStylename) has been $eventName";
            })->logOnly([
                'category_id',
                'season_id',
                'td_code_id',
                'stage_id',
                'state_id',
                'bom_whq_dev',
                'market',
                'gender',
                'status',
                'base_model_id',
                'bom_style_number',
                'bom_dev_style_name',
                'bom_dev_style_id',
                'assigned_to',
                'created_by'
            ])->logOnlyDirty();
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_members', 'project_id', 'user_id', 'id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'identifier');
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class, 'season_id', 'identifier');
    }

    public function baseModel(): BelongsTo
    {
        return $this->belongsTo(BaseModel::class, 'base_model_id', 'identifier');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function developer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to', 'id');
    }

    public function tdCode(): BelongsTo
    {
        return $this->belongsTo(TdCode::class, 'td_code_id', 'identifier');
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class, 'stage_id', 'identifier');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id', 'identifier');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'project_id', 'id')->latest();
    }

    public function logUploads(): HasMany
    {
        return $this->hasMany(ProductUploadLog::class, 'project_id', 'id');
    }

    // public function sampleRequests(): HasManyThrough
    // {
    //     return $this->hasManyThrough(SampleRequest::class, Product::class, 'project_id', 'colorway_identifier', 'id', 'colorway_identifier');
    // }

    public function sampleRequests(): HasMany
    {
        return $this->hasMany(SampleRequest::class, 'dev_style_id', 'bom_dev_style_id')->where('sample_requests.season_id', $this->season_id);
    }

    public function components(): HasMany
    {
        return $this->hasMany(Component::class, 'product_id', 'id');
    }

    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class, 'project_id', 'id');
    }
}
