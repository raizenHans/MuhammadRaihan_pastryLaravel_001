<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Untuk melacak Operator/Kasir yang melunasi transaksi
    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }
}