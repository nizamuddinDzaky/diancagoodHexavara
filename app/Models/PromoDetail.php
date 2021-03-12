<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
