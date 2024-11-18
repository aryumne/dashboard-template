<?php

namespace App\Models;

use App\Traits\HasIdentifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TdCode extends Model
{
    use HasFactory, HasIdentifier, SoftDeletes;
    const INITIAL = 'TDC';

    protected $fillable = ['identifier', 'name'];
}
