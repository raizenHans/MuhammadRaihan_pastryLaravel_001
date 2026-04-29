<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $guarded = ['id'];

    /**
     * Relasi balik ke tabel users
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke tabel transaksi (seorang member bisa punya banyak riwayat transaksi)
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}