<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersNew extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function vendors()
    {
        return $this->hasMany(OrdersVendorNew::class);
    }

    public function items()
    {
        return $this->hasMany(OrdersItems::class);
    }
    // Define the relationship with Payment
    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id');
    }
    // Define the relationship with Payment
    public function payment()
    {
        return $this->hasMany(Payment::class, 'order_id');
    }
    // Relationship with the user who placed the order
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items2()
    {
        return $this->hasMany(OrdersItems::class, 'order_id'); // Assuming 'order_id' is the foreign key in OrdersItems
    }

    public function vendorOrders()
    {
        return $this->hasMany(OrdersVendorNew::class, 'order_id');
    }
}