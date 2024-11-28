<?php

namespace App\Models;

use App\Models\Orders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderProducts extends Model
{
    use HasFactory;
    use HasFactory;

    protected $guarded = ['id'];

    // public function order()
    // {
    //     return $this->belongsTo(Orders::class);
    // }

    // public function serviceProduct()
    // {
    //     return $this->belongsTo(ServiceProduct::class, 'service_product_id');
    // }

    // public function selectedSlot()
    // {
    //     return $this->belongsTo(Appointmentslot::class, 'selected_slot');
    // }
    public function order()
    {
        return $this->belongsTo(Orders::class);
    }

    public function serviceProduct()
    {
        return $this->belongsTo(ServiceProduct::class);
    }

    public function selectedSlot()
    {
        return $this->belongsTo(Appointmentslot::class, 'selected_slot');
    }
    public function serviceProduct2()
    {
        return $this->belongsTo(ServiceProduct::class, 'service_product_id'); // Ensure this matches your database schema
    }
}
