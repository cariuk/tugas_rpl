<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'id',
        'merk_id',
        'kategori',
        'model',
        'harga',
        'bobot',
        'cpu_score',
        'gpu_score',
        'deskripsi',
    ];

    protected $casts = [
        'deskripsi' => 'object',
    ];
}
