<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductJual extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_product_jual';

    protected $fillable = [
        'product_id ',
        'start_kg',
        'end_kg',
        'price_sell',
        'id_product_beli'
    ];

    public function productName(){
        return $this->belongsTo(Product::class,'product_id','id_product');
    }

    public function productBeliKulak(){
        return $this->belongsTo(ProductBeli::class,'product_beli_id');
    }
}
