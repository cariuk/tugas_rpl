<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected $with = ['merk'];

    public function merk(): BelongsTo
    {
        return $this->belongsTo(Merk::class);
    }
}
