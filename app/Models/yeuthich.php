<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class yeuthich extends Model
{
    use HasFactory;

    protected $table = 'yeuthich';

    protected $fillable = [
        'id_phong',
        'id_users'
    ];
}
