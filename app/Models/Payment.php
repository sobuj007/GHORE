<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    // Define the relationship with OrdersNew
    public function order()
    {
        return $this->belongsTo(OrdersNew::class, 'order_id');
    }
}
