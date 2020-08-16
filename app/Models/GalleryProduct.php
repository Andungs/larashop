<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class GalleryProduct extends Model
{
    protected $fillable = [
        'photo', 'product_id', 'is_default'
    ];

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id', 'id');
    }
}
