<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Mengizinkan semua kolom diisi kecuali ID
    protected $guarded = ['id'];

    // Menyembunyikan data sensitif saat data di-return sebagai JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Konversi tipe data otomatis
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relasi One-to-One ke tabel members.
     * Hanya berlaku jika user ini memiliki role 'customer' dan sudah mendaftar member.
     */
    public function memberProfile()
    {
        return $this->hasOne(Member::class);
    }
}