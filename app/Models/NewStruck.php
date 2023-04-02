<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewStruck extends Model
{
    use HasFactory;
    //generate new struck, untuk cetak total harga
    protected $primaryKey = 'id_struck';
    protected $fillable = [
        'total_harga_dibayar',
        'pembeli_bayar',
        'kembalian',
        'keuntungan_bersih'
    ];
}
