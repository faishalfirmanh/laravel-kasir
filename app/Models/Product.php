<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_product';
    protected $fillable  = [
        'nama_product',
        'kategori_id',
        'harga_beli',
        'is_kg',
        'total_kg',
        'pcs',
        'expired'
    ];

    public function kategori(){
        return $this->belongsTo(Kategori::class,'kategori_id','id_kategori')->select('id_kategori','nama_kategori');
    }

    public function priceSellProduct(){
        return $this->hasMany(ProductJual::class,'product_id','id_product');
    }

}
