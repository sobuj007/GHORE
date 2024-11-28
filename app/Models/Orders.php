<?php

namespace App\Models;

use App\Models\OrderProducts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',


    ];
     // Cast userreqtime to an array
    protected $casts = [
        'userreqtime' => 'array', 
        'order_date' => 'array',
        // 'agent_id' => 'array'
    ];
    
    // public function orderProducts()
    // {
    //     return $this->hasMany(OrderProducts::class);
    // }

    // public function agent()
    // {
    //     return $this->belongsTo(User::class, 'agent_id');
    // }

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }


    public function slot()
{
    return $this->belongsTo(Myslot::class, 'selected_slot');
}


public function orderProducts()
{
    return $this->hasMany(OrderProducts::class, 'order_id'); // Matches the column name in the database
}

public function payment()
{
    return $this->hasOne(Payment::class, 'order_id'); // Matches the column name in the database
}
}
