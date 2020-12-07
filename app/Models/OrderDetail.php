<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $guarded = [];

    public function variant()
    {
        return $this->belongsTo('App\ProductVariant', 'product_variant_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
