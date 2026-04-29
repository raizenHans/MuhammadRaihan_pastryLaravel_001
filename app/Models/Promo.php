<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $guarded = ['id'];

    public function carts()
    {
        return $this->morphMany(Cart::class, 'productable');
    }

    public function transactionDetails()
    {
        return $this->morphMany(TransactionDetail::class, 'productable');
    }
}