<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HopDong extends Model
{
    use HasFactory;

    protected $table = 'hopdongs';
    protected $fillable = [
        'ma_hop_dong',
        'id_chu_tro',
        'id_khach_thue',
        'id_phong',
        'ngay_ky',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'gia_thue',
        'tien_coc',
        'hinh_thuc_thanh_toan',
        'trang_thai',
        'noi_dung',
        'file_pdf',
        'file_word',
    ];
}
