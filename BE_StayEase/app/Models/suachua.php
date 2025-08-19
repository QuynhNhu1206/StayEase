<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class suachua extends Model
{
    use HasFactory;
    protected $table = 'suachuarequest';

    protected $fillable = [
        'id_phong',
        'id_users',
        'userName',
        'issue',
        'status',
        'approved'
    ];
}
