<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeranjangKasir extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_keranjang_kasir';
    protected $fillable = [
        'product_jual_id',
        'jumlah_item_dibeli',
        'total_harga_item',
        'struck_id',
        'status'
    ];
}
