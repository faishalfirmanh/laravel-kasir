<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coba extends Model
{
    use HasFactory;
    protected $table = 'coba';

    protected $fillable = [
        'tanggal',
        'tempat',
        'nama_peminjam',
        'departement',
        'jabatan',
        'tujuan',
        'keperluan',
        'catatan_kusus',
        'driver',
        'tanggal_pinjam',
        'tanggal_pengembalian',
        'manager',
        'hrd'
    ];
}
