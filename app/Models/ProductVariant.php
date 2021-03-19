<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductVariant extends Model
{
    protected $guarded = [];
    protected $appends = ['status_label', 'promo_price'];
    
    public function getStatusLabelAttribute()
    {
        if ($this->status == 0) {
            return '<span class="badge badge-secondary">Draft</span>';
        }
        return '<span class="badge badge-success">Aktif</span>';
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value); 
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function image()
    {
        return $this->hasOne(ProductImage::class, 'product_variant_id');
    }

    public function promo_detail()
    {
        return $this->hasMany(PromoDetail::class, 'product_variant_id');
    }

    public function getPromoPriceAttribute()
    {
        if($this->promo_detail != "") {
            $promo_value = 0;

            foreach($this->promo_detail as $pd) {
                if($pd->promo->is_published == 1 && ((Carbon::now()->isBefore(Carbon::parse($pd->promo->end_date . $pd->promo->end_time))) && (Carbon::now()->isAfter(Carbon::parse($pd->promo->start_date . $pd->promo->start_time))))) {
                    if($pd->promo->value_type == 'percent') {
                        $promo_value += (($pd->promo->value / 100) * $this->attributes['price']);
                    } else {
                        $promo_value += $pd->promo->value;
                    }
                }
            }
            return $promo_value;
        } else {
            return 0;
        }
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
