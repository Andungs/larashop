<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    public function detailTransaction()
    {
        return $this->hasMany(\App\Models\Transaction::class, 'transaction_id', 'id');
    }
}
