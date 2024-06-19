<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = ['place_id','user_id','rating'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function place()
    {
        return $this->hasOne(Place::class, 'id', 'place_id');
    }
}
