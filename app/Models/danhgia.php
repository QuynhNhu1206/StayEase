<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class danhgia extends Model
{
    use HasFactory;

    protected $table = 'danhgias';

    protected $fillable =  [
        'id_phong',
        'id_users',
        'reply',
        'noi_dung',
        'danh_gia_sao'
    ];
}
