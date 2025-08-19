<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hinhanhphong extends Model
{
    use HasFactory;
    protected $table = 'hinh_anh_phongs';

    protected $fillable = [
        'id_phong',
        'image_url'
    ];

}
