<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $guarded = ['id'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Akan otomatis mengambil model Pastry, Drink, atau Promo
    public function productable()
    {
        return $this->morphTo();
    }
}