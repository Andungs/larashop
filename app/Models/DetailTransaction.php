<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailTransaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id', 'transaction_id'
    ];

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id', 'id');
    }

    public function transaction()
    {
        return $this->belongsTo(\App\Models\Transaction::class, 'transaction_id', 'id');
    }
}
