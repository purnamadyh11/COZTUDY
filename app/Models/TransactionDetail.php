<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_id',
        'place_id',
        'qty',
        'sub_total',
        'status'
    ];

    public function place()
    {
        return $this->hasOne(Place::class, 'id', 'place_id');
    }
}
