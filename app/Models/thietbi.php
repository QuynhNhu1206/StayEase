<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thietbi extends Model
{
    use HasFactory;
    protected $table = 'thietbi';

    protected $fillable = [
        'id_phong',
        'ten_thiet_bi',
        'so_luong_thiet_bi',
        'trang_thai'
    ];
}
