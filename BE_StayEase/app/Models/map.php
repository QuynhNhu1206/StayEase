<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class map extends Model
{
    use HasFactory;

    protected $table = 'map';
    protected $fillable = [
        'ma_map',
        'dia_chi',
        'quan_huyen',
        'kinh_do',
        'vi_do',
        'tinh_tp',
        'xa_phuong'
    ];
}
