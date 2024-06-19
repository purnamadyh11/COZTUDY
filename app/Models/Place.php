<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'latitude', 'longitude', 'description', 'price', 'status'];

    public function placeDetails()
    {
        return $this->hasMany(PlaceDetail::class);
    }
}
