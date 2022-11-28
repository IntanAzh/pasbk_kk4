<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'food_id',
        'user_id',
        'name',
        'alamat_order',
        'total_order',
        'total_harga',
        'date',
        'status',

    ];

    public function efood()
    {
        return $this->belongsTo(Efood::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
