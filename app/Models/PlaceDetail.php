<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceDetail extends Model
{
    use HasFactory;
    protected $fillable = ['place_id','images','description'];

    // Define the inverse relationship to Place
    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
