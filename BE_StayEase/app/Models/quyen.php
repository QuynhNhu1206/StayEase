<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quyen extends Model
{
    use HasFactory;

    protected $table = 'quyens';
    protected $fillable = [
        'id',
        'ten_quyen',
        'trang_thai'
    ];
}
