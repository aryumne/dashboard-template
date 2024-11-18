<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorPurchaseOrder extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['supplier_name', 'purchase_order_id'];
}
