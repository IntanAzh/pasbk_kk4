<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class efood extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'harga',
        'stok_produk',
        'image',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
