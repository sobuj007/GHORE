<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function serviceProducts()
    {
        return $this->belongsToMany(ServiceProduct::class, 'service_product_location', 'location_id', 'service_product_id');
    }
    
    
    
}
