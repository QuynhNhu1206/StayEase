<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class phongtro extends Model
{
    use HasFactory;

    protected $table = "phongtro";
    protected $fillable = [
        'ma_phong',
        'id_danh_muc',
        'id_users',
        'ten_phong_tro',
        'dia_chi',
        'anh_phong',
        'mo_ta',
        'dien_tich',
        'gia_tien',
        'trang_thai',
        'so_luong_nguoi'
    ];

     public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

     public function danhmucs()
    {
        return $this->belongsTo(danhmuc::class, 'id_danh_muc', 'id');
    }
}
