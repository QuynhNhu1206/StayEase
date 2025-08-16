<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hopdong extends Model
{
    use HasFactory;

    protected $table = 'hopdongs';
    protected $fillable = [
        'id_phong',
        'id_users',
        'ten_hop_dong',
        'start_date',
        'end_date',
        'tien_coc',
        'trang_thai',
        'file_hop_dong'
    ];
}
