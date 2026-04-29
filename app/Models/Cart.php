<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = ['id'];

    public function productable()
    {
        return $this->morphTo();
    }
}