<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointmentslot extends Model
{
    use HasFactory;
    protected $guarded = [
         'id', 'created_at', 'updated_at'
    ];

    public function myslot()
    {
        return $this->belongsTo(Myslot::class, 'slot_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
     // Define the relationship with the Myslot model
    public function myslot2()
    {
        return $this->belongsTo(Myslot::class, 'slot_id');
    }
}
