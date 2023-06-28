<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_roles',
        'name_role',
        'kategori',
        'toko',
        'user',
        'product',
        'kasir',
        'laporan',
        'log_activity'
    ];

    public function roleRelasiUser(){
        return $this->hasMany(User::class,'id_roles');
    }
}
