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
        'total_kg',
    ];

    public function kategori(){
        return $this->belongsTo(Kategori::class,'kategori_id','id_kategori')->select('id_kategori','nama_kategori');
    }

}
