<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersItems extends Model
{
    use HasFactory;
    protected $guarded=["id","created_at","updated_at"];
    
     public function order()
    {
        return $this->belongsTo(OrdersNew::class, 'order_id'); // Foreign key is 'order_id', not 'orders_new_id'
    }

    public function order2()
    {
        return $this->belongsTo(OrdersNew::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function serviceProduct()
    {
        return $this->belongsTo(ServiceProduct::class);
    }
    public function serviceProduct2()
    {
        return $this->belongsTo(ServiceProduct::class, 'service_product_id'); // Assuming 'service_product_id' is the foreign key
    }
    public function vendoNews()
    {
        return $this->hasOne(OrdersVendoNews::class, 'foreign_key', 'actual_key');
    }
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
public function items2()
{
    return $this->belongsTo(ServiceProduct::class, 'product_id');
}
// public function vendorOrders()
// {
//     return $this->belongsTo(OrdersVendoNews::class, 'vendor_order_id');
// }
public function payment()
{
    return $this->hasOne(Payment::class, 'product_id');
}



}
