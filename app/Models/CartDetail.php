<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;
    protected $fillable = ['cart_id', 'place_id'];

    public function place()
    {
        return $this->hasOne(Place::class, 'id', 'place_id');
    }
}
