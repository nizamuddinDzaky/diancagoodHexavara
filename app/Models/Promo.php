<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promo extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['status_label', 'status'];

    public function details() 
    {
        return $this->hasMany(PromoDetail::class);
    }

    public function getStatusLabelAttribute()
    {
        if (Carbon::now()->isBefore(Carbon::parse($this->start_date . $this->start_time))) {
            return '<span class="badge badge-secondary">Belum Mulai</span>';
        } elseif ((Carbon::now()->isBefore(Carbon::parse($this->end_date . $this->end_time))) && (Carbon::now()->isAfter(Carbon::parse($this->start_date . $this->start_time)))) {
            return '<span class="badge badge-primary">Sedang Berlangsung</span>';
        } elseif (Carbon::now()->isAfter(Carbon::parse($this->end_date . $this->end_time))) {
            return '<span class="badge badge-dark">Selesai</span>';
        }
    }

    public function getStatusAttribute()
    {
        if (Carbon::now()->isBefore(Carbon::parse($this->start_date . $this->start_time))) {
            return 0;
        } elseif ((Carbon::now()->isBefore(Carbon::parse($this->end_date . $this->end_time))) && (Carbon::now()->isAfter(Carbon::parse($this->start_date . $this->start_time)))) {
            return 1;
        } elseif (Carbon::now()->isAfter(Carbon::parse($this->end_date . $this->end_time))) {
            return 2;
        }
    }
}
