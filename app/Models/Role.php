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
        'product',
        'kasir',
        'laporan'
    ];

}
