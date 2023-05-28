<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBeli extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_product_beli';
    protected $fillable  = [
        'harga_beli_custom',
        'harga_beli_custom',
        'nama_product_variant'
    ];

    public function getProduct()
    {
        return $this->belongsTo(Product::class,'product_id','id_product');
    }

    public function getProductJual()
    {
        return $this->hasOne(ProductJual::class,'product_beli_id','id_product_beli');
    }
}
