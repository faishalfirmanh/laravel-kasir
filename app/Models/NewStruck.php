<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\KeranjangKasir;

class NewStruck extends Model
{
    use HasFactory;
    protected $table = 'new_strucks';
    //generate new struck, untuk cetak total harga
    protected $primaryKey = 'id_struck';
    protected $fillable = [
        'id_struck',
        'total_harga_dibayar',
        'pembeli_bayar',
        'kembalian',
        'keuntungan_bersih',
        'status', //0 generate, 1 tambah keranjang, 2 pembeli bayar, 3 selesai, 4 batal (cancel)
    ];

    public function listProducBuy()
    {
        return $this->hasMany(KeranjangKasir::class,'struck_id');
    }

    public function coba() //no finished
    {
        return $this->hasManyThrough(
            ProductJual::class,
            KeranjangKasir::class,
            'struck_id',
            'id_product_jual',
            );
    }
}
