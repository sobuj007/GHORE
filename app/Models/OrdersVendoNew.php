<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersVendoNew extends Model
{
    use HasFactory;
    protected $guarded=['id','created_at','updated_at'];

    public function order()
    {
        return $this->belongsTo(OrdersNew::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function items()
    {
        return $this->hasMany(OrdersItems::class, 'vendor_id', 'vendor_id');
    }
    
    
}
