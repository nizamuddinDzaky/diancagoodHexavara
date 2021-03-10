<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Customer extends Authenticatable
{
    use Notifiable;
    protected $guarded = [];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function district()
    {
        return $this->belongsTo('App\District', 'district_id');
    }

    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function bankaccount()
    {
        return $this->hasMany(BankAccount::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'customer_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'customer_id');
    }
}
