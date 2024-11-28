<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{   protected $guarded = ['id','created_at','updated_at'];

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
