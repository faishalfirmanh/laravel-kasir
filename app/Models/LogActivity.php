<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_logActivity';
    protected $fillable = [
        'id_logActivity',
        'user_id',
        'tipe',
        'ip',
        'description',
        'lat',
        'long',
        'desc'
    ];
}
