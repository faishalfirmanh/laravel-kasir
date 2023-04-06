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
        'harga_tiap_item',
        'total_harga_item',
        'struck_id',
        'status'
    ];

    public function productJual()
    {
        return $this->hasMany(ProductJual::class, 'id_product_jual', 'product_jual_id');
    }
}
